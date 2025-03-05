<x-app-layout>


<!-- Posts Feed  -->
@include('post.posts')

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


<!-- script -->
<script>


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

        // send connection request
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

        // check initial connection status
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.connect-button').forEach(button => {
                const userId = button.dataset.userId;
                // console.log(userId);
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

</script>
</x-app-layout>

