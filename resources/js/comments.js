

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


