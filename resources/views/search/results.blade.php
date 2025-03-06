
<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Search Results for "#{{ $query }}"</h1>
            <p class="text-gray-600">{{ $posts->count() }} {{ Str::plural('result', $posts->count()) }} found</p>
        </div>

        @if($posts->count() > 0)
            <div class="space-y-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <!-- Post Author Info -->
                            <div class="flex items-center mb-4">
                                <img class="h-10 w-10 rounded-full object-cover mr-4"
                                     src="{{ Storage::url($post->user->profile_picture) }}"
                                     alt="{{ $post->user->name }}">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $post->user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h2>
                            <p class="text-gray-700 mb-4">{{ $post->content }}</p>

                            <!-- Post Image -->
                            @if($post->image)
                                <div class="mb-4">
                                    <img src="{{ Storage::url($post->image) }}"
                                         alt="Post image"
                                         class="w-full h-auto rounded-lg">
                                </div>
                            @endif

                            <!-- Post Links -->
                            @if($post->links)
                                <div class="mb-4 text-amber-600 hover:text-amber-700">
                                    <a href="{{ $post->links }}" target="_blank" class="flex items-center">
                                        <i class="fas fa-link mr-2"></i>
                                        <span class="truncate">{{ $post->links }}</span>
                                    </a>
                                </div>
                            @endif

                            <!-- Hashtags -->
                            @if($post->hashtags)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(explode(',', $post->hashtags) as $tag)
                                        @php $tag = trim($tag); @endphp
                                        <a href="{{ route('search.hashtags', ['query' => $tag]) }}"
                                           class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm hover:bg-amber-200">
                                            #{{ $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Post Actions -->
                            <div class="flex items-center justify-between space-x-4 mt-4 text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <button onclick="toggleLike({{$post->id}})" data-post-id="{{$post->id}}"
                                            class="like-button flex items-center space-x-2 hover:text-amber-600">
                                        <i class="far fa-heart like-icon"></i>
                                        <span class="likes-count">{{$post->likes->count()}}</span>
                                    </button>
                                    <button onclick="toggleCommentSection({{ $post->id }})" data-post-id="{{$post->id}}"
                                            class="comment-button flex items-center space-x-2 hover:text-amber-600">
                                        <i class="far fa-comment"></i>
                                        <span class="comments-count">{{$post->comments->count()}}</span>
                                    </button>
                                </div>
                                <button class="flex items-center space-x-2 hover:text-amber-600">
                                    <i class="far fa-share-square"></i>
                                    <span>Share</span>
                                </button>
                            </div>

                            <!-- Comments Section -->
                            <div class="mt-6 border-t border-gray-100 pt-4 hidden" id="comments-container-{{$post->id}}">
                                <!-- Comment Form -->
                                <form id="commentForm-{{$post->id}}" class="mb-4" onsubmit="submitComment(event, {{$post->id}})">
                                    <div class="flex items-start space-x-3">
                                        <img src="{{ Storage::url(Auth::user()->profile_picture) }}"
                                             class="h-8 w-8 rounded-full object-cover">
                                        <div class="flex-1">
                                            <textarea name="content"
                                                      placeholder="Write a comment..."
                                                      class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500"
                                                      rows="2"></textarea>
                                            <div class="flex justify-end mt-2">
                                                <button type="submit"
                                                        class="px-4 py-1 bg-amber-600 text-white rounded-md hover:bg-amber-700 text-sm">
                                                    Post Comment
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Comments List -->
                                <div class="space-y-4">
                                    @foreach($post->comments->sortByDesc('created_at') as $comment)
                                        <div class="flex gap-3" id="comment-{{$comment->id}}">
                                            <img src="{{ Storage::url($comment->user->profile_picture) }}"
                                                 class="h-8 w-8 rounded-full object-cover">
                                            <div class="flex-1">
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <h4 class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                    </div>
                                                    <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                                                </div>
                                                @if(Auth::id() == $comment->user_id)
                                                    <div class="flex gap-2 mt-1">
                                                        <button onclick="deleteComment({{$comment->id}})"
                                                                class="text-xs text-gray-500 hover:text-red-600">
                                                            Delete
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-search text-gray-400 text-4xl mb-3"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-1">No results found</h3>
                <p class="text-gray-600">Try different Hahtag or browse all posts</p>
                <a href="{{ route('feeds') }}" class="mt-4 inline-block px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
                    Back to Feed
                </a>
            </div>
        @endif
    </div>
</x-app-layout>

<!-- script -->
{{-- <script>


    // Post Modal
    function openPostModal() {
        document.getElementById('postModal').classList.remove('hidden');
    }

    function closePostModal() {
        document.getElementById('postModal').classList.add('hidden');
    }

    function toggleBold() {
        const titleInput = document.getElementById('title');
        if (titleInput.style.fontWeight === 'bold') {
            titleInput.style.fontWeight = 'normal';
        } else {
            titleInput.style.fontWeight = 'bold';
        }
    }

    // Preview uploaded image
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.classList.add('mt-1', 'rounded-md', 'max-h-32', 'mx-auto', 'overflow-scroll');
                const container = document.querySelector('.space-y-1');
                container.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });

    /*
    ****** delete post
    */
    function deletePost(postId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/post/${postId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }


    window.addEventListener('click', function(e) {
        const deleteModal = document.getElementById('deleteModal');
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    })


    /*
    ****** toggle the comment section
    */
    function toggleCommentSection(postId) {
        const container = document.getElementById(`comments-container-${postId}`);
        container.classList.toggle('hidden');
    }
    /*
    ****** Comment a post
    */
    function submitComment(e, postId) {
        e.preventDefault();

        try {
            const form = document.getElementById(`commentForm-${postId}`);
            const auth_user = document.querySelector('meta[name="user-id"]').content;
            if (!form) {
                throw new Error('Comment form not found');
            }

            const textarea = form.querySelector('textarea[name="content"]');
            if (!textarea) {
                throw new Error('Comment textarea not found');
            }

            const content = textarea.value.trim();
            if (!content) {
                alert('Please write a comment before submitting');
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!token) {
                throw new Error('CSRF token not found');
            }


            fetch(`/post/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ comment: content, user_id: auth_user})
            })
            .then(async response => {
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {


                    const commentsList = form.closest('.mt-6')?.querySelector('.space-y-4');
                    if (!commentsList) {
                        throw new Error('Comments list container not found');
                    }

                    const button = document.querySelector(`.comment-button[data-post-id="${postId}"]`);
                    const commentCount = button.querySelector('.comments-count');
                    commentCount.textContent = data.comment.count;

                    const newComment = `
                        <div class="flex gap-3" id="comment-${data.comment.id}">
                            <img src= '/storage/${data.comment.user.profile_picture}'
                                class="h-8 w-8 rounded-full object-cover">
                            <div class="flex-1">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex justify-between items-center mb-1">
                                        <h4 class="text-sm font-medium text-gray-900">${data.comment.user.name}</h4>
                                        <p class="text-xs text-gray-500">Just now</p>
                                    </div>
                                    <p class="text-sm text-gray-700">${data.comment.comment}</p>
                                </div>
                                <div class="flex gap-2 mt-1">
                                    <button onclick="deleteComment(${data.comment.id})"
                                        class="text-xs text-gray-500 hover:text-red-600">
                                        Delete
                                    </button>

                                </div>
                            </div>
                        </div>
                    `;


                    commentsList.insertAdjacentHTML('afterbegin', newComment);
                    form.reset();
                }
            })
            .catch(error => {
                console.error('Error details:', error);
            })


        } catch (error) {
            console.error('Critical error:', error);
        }
    }

    /*
    ****** delete a comment
    */

    function deleteComment(commentId) {
        if (!confirm('Are you sure you want to delete this comment?')) {
            return;
        }
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!token) {
            throw new Error('CSRF token not found');
        }
        fetch(`/post/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
        }).then(async response => {
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
            }
            return response.json();
        }).then(data => {
            if (data.success) {
                const commentElement = document.querySelector(`#comment-${commentId}`);
                if (commentElement) {
                    commentElement.remove();
                }else{
                    alert('lahcen ouirghane');
                }
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Failed to delete comment. Please try again.');
        });
    }

    /*
    ****** Like a post
    */
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.like-button').forEach(button => {
            const postId = button.dataset.postId;
            checkLikeStatus(postId);
        });
    });
    async function toggleLike(postId) {
        try {
            const response = await fetch(`/post/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            console.log(data);


            if (data.success) {
                const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                const icon = button.querySelector('.like-icon');
                const count = button.querySelector('.likes-count');

                // Update like count
                count.textContent = data.likesCount;

                // Update icon state
                if (data.isLiked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-red-600');
                } else {
                    icon.classList.remove('fas', 'text-red-600');
                    icon.classList.add('far');
                }
            }
        } catch (error) {
            console.error('Error toggling like:', error);
        }
    }

    async function checkLikeStatus(postId) {
            try {
                const response = await fetch(`/post/${postId}/check-like`);
                const data = await response.json();

                const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                const icon = button.querySelector('.like-icon');

                if (data.isLiked) {
                    icon.classList.add('fas', 'text-red-600');
                }
            } catch (error) {
                console.error('Error checking like status:', error);
            }
        }

    /*
    ****** Send connection request
    */t
    async function sendConnectionRequest(userId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!token) {
                    throw new Error('CSRF token not found');
                }

                const response = await fetch(`/post/connections/send/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                console.log(data);


                if (data.success) {

                    const button = document.querySelector(`.connect-button[data-user-id="${userId}"]`);

                    if (button) {
                        button.innerHTML = `
                            <i class="fas fa-clock"></i>
                            <span class="text-sm">Pending</span>
                        `;
                        button.disabled = true;
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }
            } catch (error) {
                console.error('Error sending connection request:', error);
                alert('Failed to send connection request. Please try again.');
            }
        }

    /*
    ****** check connection status
    */
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.connect-button').forEach(button => {
            const userId = button.dataset.userId;
            checkConnectionStatus(userId);
        });
    });

    async function checkConnectionStatus(userId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!token) {
                    throw new Error('CSRF token not found');
                }

                const response = await fetch(`/post/connections/status/${userId}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                const button = document.querySelector(`.connect-button[data-user-id="${userId}"]`);

                if (button && data.status) {
                    switch (data.status) {
                        case 'pending':
                            button.innerHTML = `
                                <i class="fas fa-clock"></i>
                                <span class="text-sm">Pending</span>
                            `;
                            button.disabled = true;
                            button.classList.add('opacity-50', 'cursor-not-allowed');
                            break;
                        case 'accepted':
                            button.innerHTML = `
                                <i class="fas fa-user-check"></i>
                                <span class="text-sm">Connected</span>
                            `;
                            button.disabled = true;
                            button.classList.add('opacity-70', 'cursor-not-allowed');
                            break;
                        case 'rejected':
                            button.innerHTML = `
                                <i class="fas fa-user-plus"></i>
                                <span class="text-sm">Connect</span>
                            `;
                            break;
                    }
                }
            } catch (error) {
                console.error('Error checking connection status:', error);
            }
}

</script> --}}
