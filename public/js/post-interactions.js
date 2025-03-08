




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

