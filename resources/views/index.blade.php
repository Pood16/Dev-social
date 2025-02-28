<x-app-layout>


<!-- Posts Feed Section -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="space-y-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Post Header -->
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-avatar.png') }}"
                            class="h-10 w-10 rounded-full object-cover">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $post->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Post Actions Dropdown -->
                    <div class="relative">
                        @if($post->user_id === Auth::id())
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('post.show', $post) }}"
                                    class="text-gray-400 hover:text-amber-600 transition-colors cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deletePost({{ $post->id }})"
                                    class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @else
                            <button onclick="connectWithUser({{ $post->user_id }})"
                                class="text-gray-400 hover:text-amber-600 transition-colors flex items-center space-x-1">
                                <i class="fas fa-user-plus"></i>
                                <span class="text-sm">Connect</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Post Content -->
                <div class="px-4 pb-4">
                    <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-700 mb-4">{{ $post->content }}</p>

                    <!-- Links (if exists) -->
                    @if($post->links)
                        <div class="mb-4">
                            <a href="{{ $post->links }}"
                            target="_blank"
                            class="text-amber-600 hover:text-amber-700 flex items-center gap-2">
                                <i class="fas fa-link"></i>
                                <span>{{ $post->links }}</span>
                            </a>
                        </div>
                    @endif

                    <!-- Post Image (if exists) -->
                    @if($post->image)
                        <div class="mb-4">
                            <img src="{{ Storage::url($post->image) }}"
                                alt="Post image"
                                class="w-full rounded-lg">
                        </div>
                    @endif

                    <!-- Hashtags -->
                    @if($post->hashtags)
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach(explode(',', $post->hashtags) as $tag)
                                <a href=""
                                    class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm hover:bg-amber-200">
                                    #{{ trim($tag) }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Post Actions -->
                    <div class="flex items-center space-x-4 mt-4 text-gray-500">
                        <button onclick="toggleLike({{$post->id}})" data-post-id="{{$post->id}}" class="like-button flex items-center space-x-2 hover:text-amber-600">
                            <i class="far fa-heart like-icon"></i>
                            <span class="likes-count">{{$post->likes->count()}}</span>
                        </button>

                        <button class="flex items-center space-x-2 hover:text-amber-600">
                            <i class="far fa-comment"></i>
                            <span>Comment</span>
                        </button>
                        <button class="flex items-center space-x-2 hover:text-amber-600">
                            <i class="far fa-share-square"></i>
                            <span>Share</span>
                        </button>
                    </div>
                    <!-- Comments Section -->
                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <!-- Comment Form -->
                        <form onsubmit="submitComment(event, {{ $post->id }})" id="commentForm-{{$post->id}}" class="mb-4">
                            @csrf
                            <div class="flex gap-3 items-center">
                                <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                                    class="h-8 w-8 rounded-full object-cover">
                                <div class="flex-1">
                                    <textarea name="content" rows="2"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm"
                                        placeholder="Write a comment..."></textarea>
                                </div>
                                <button id="submit-comment" type="submit"
                                    class="px-5 py-2 bg-amber-600 text-white text-sm font-medium rounded-md hover:bg-amber-700">
                                    Comment
                                </button>
                            </div>
                        </form>

                        <!-- Comments List -->
                        <div class="space-y-4">
                            @foreach($post->comments as $comment)
                                <div class="flex gap-3" id="comment-{{ $comment->id }}">
                                    <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : asset('images/default-avatar.png') }}"
                                        class="h-8 w-8 rounded-full object-cover">
                                    <div class="flex-1">
                                        <div class="bg-gray-50 rounded-lg p-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                            <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                                        </div>
                                        @if($comment->user_id === Auth::id())
                                        <div class="flex gap-2 mt-1">
                                            <button onclick="deleteComment({{ $comment->id }})"
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
        @empty
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-500">No posts yet</p>
            </div>
        @endforelse

        {{-- <!-- Pagination -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div> --}}
    </div>
</div>


<!-- Post Creation Modal -->
<div id="postModal" class="fixed inset-0 hidden overflow-y-auto">
    <!-- Modal backdrop -->
    <div class="absolute inset-0 bg-gray-900 opacity-70"></div>

    <!-- Modal content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Create New Post</h3>
                    <button onclick="closePostModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <div class="flex gap-2 mb-2">
                            <button type="button" onclick="toggleBold()"
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="fas fa-bold"></i>
                            </button>
                        </div>
                        <input type="text" name="title" id="title" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        <textarea name="content" id="content" rows="4" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="links" class="block text-sm font-medium text-gray-700 mb-2">URL Link</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400"></i>
                            </div>
                            <input type="url" name="links" id="links"
                                placeholder="https://example.com"
                                class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Add a link to your project or related content</p>
                    </div>

                    <div class="mb-4">
                        <label for="hashtags" class="block text-sm font-medium text-gray-700 mb-2">Hashtags</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400"></i>
                            </div>
                            <input type="text" name="hashtags" id="hashtags"
                                placeholder="tech, programming, webdev"
                                class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Separate hashtags with commas</p>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closePostModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md">
                            Create Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Post Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 hidden overflow-y-auto">
    <!-- Modal backdrop -->
    <div class="absolute inset-0 bg-gray-900 opacity-70"></div>

    <!-- Modal content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Delete Post</h3>
                    <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-6">
                    <p class="text-gray-600">Are you sure you want to delete this post? This action cannot be undone.</p>
                </div>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                            Delete Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- start script -->
<script>
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
    // delete post
    function deletePost(postId) {
        // Set up the form action
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/post/${postId}`;

        // Show the modal
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const deleteModal = document.getElementById('deleteModal');
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    })

    // add comment
    function submitComment(e, postId) {
        e.preventDefault();

        try {
            const form = document.getElementById(`commentForm-${postId}`);
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

            // Show loading state
            const submitButton = form.querySelector('#submit-comment');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            // submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';

            fetch(`/post/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ comment: content })
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
                // Show error message to user
                const errorMessage = document.createElement('div');
                errorMessage.className = 'text-sm text-red-600 mt-2';
                errorMessage.textContent = 'Failed to post comment. Please try again.';
                form.appendChild(errorMessage);
                setTimeout(() => errorMessage.remove(), 3000);
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });

        } catch (error) {
            console.error('Critical error:', error);
            alert('Something went wrong. Please refresh the page and try again.');
        }
    }

// delete comment

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
            // Remove the comment element from DOM
            const commentElement = document.querySelector(`#comment-${commentId}`);
            if (commentElement) {
                commentElement.remove();
            }else{
                alert('lahcen ouirghane');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete comment. Please try again.');
    });
}

// likes
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
                    icon.style.fill = 'currentColor';
                }
            } catch (error) {
                console.error('Error checking like status:', error);
            }
        }

</script>
</x-app-layout>

