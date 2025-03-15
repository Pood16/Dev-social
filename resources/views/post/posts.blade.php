

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="space-y-6">
            @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Post Header -->
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('user.profile', $post->user->id) }}">
                                <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/profile-avatar.png') }}"
                                    class="h-10 w-10 rounded-full object-cover">
                            </a>
                            <div>
                                <a href="{{ route('user.profile', $post->user->id) }}" class="font-medium text-gray-900 hover:text-amber-600">
                                    {{ $post->user->name }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Post Actions  -->
                        <div class="relative">
                            @if($post->user_id === Auth::id())
                                <div class="relative">
                                    <button id="dropdownButton-{{ $post->id }}" onclick=" toggleEllipsDropdown({{ $post->id }})"
                                        class="text-gray-400 hover:text-amber-600 transition-colors cursor-pointer">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-{{ $post->id }}"
                                        class="hidden absolute right-0 mt-2 w-36 bg-white rounded-md shadow-lg z-10 py-1">
                                        <a href="{{ route('post.show', $post) }}"
                                            class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                            <i class="fas fa-edit mr-2"></i> Edit Post
                                        </a>
                                        <button onclick="deletePost({{ $post->id }})"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                            <i class="fas fa-trash mr-2"></i> Delete Post
                                        </button>
                                    </div>
                                </div>
                            @else
                            <button onclick="sendConnectionRequest({{ $post->user->id }})"
                                class="text-gray-400 hover:text-amber-600 transition-colors flex items-center space-x-1 connect-button"
                                data-user-id="{{ $post->user->id }}">
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

                        <!-- Links  -->
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

                        <!-- Post Image  -->
                        @if($post->image)
                            <div class="mb-4 ">
                                <img src="{{ Storage::url($post->image) }}"
                                    alt="Post image"
                                    class="w-full rounded-lg">
                            </div>
                        @endif

                        <!-- Hashtags -->
                        @if($post->hashtags)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach(explode(',', $post->hashtags) as $tag)
                                    @php $tag = trim($tag);@endphp
                                        <a href="{{ route('search.hashtags', ['query' => $tag]) }}"
                                            class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm hover:bg-amber-200">
                                            #{{ $tag }}
                                        </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Post Actions -->
                        <div class="flex items-center justify-between space-x-4 mt-4 text-gray-500">
                            <!-- left side -->
                            <div class="flex items-center space-x-2">
                                <button onclick="toggleLike({{$post->id}})" data-post-id="{{$post->id}}" class="like-button flex items-center space-x-2 hover:text-amber-600">
                                    <i class="far fa-heart like-icon"></i>
                                    <span class="likes-count">{{$post->likes->count()}}</span>
                                </button>
                                <button onclick="toggleCommentSection({{ $post->id }})" data-post-id="{{$post->id}}" class="comment-button flex items-center space-x-2 hover:text-amber-600">
                                    <i class="far fa-comment"></i>
                                    <span class="comments-count">{{$post->comments->count()}}</span>

                                </button>
                            </div>
                            <!-- right side -->
                            <div class="relative">
                                <button onclick="toggleShareDropdown({{ $post->id }})" class="flex items-center space-x-2 hover:text-amber-600">
                                    <i class="far fa-share-square"></i>
                                    <span>Share</span>
                                </button>
                                <div id="share-dropdown-{{ $post->id }}" class="hidden absolute right-0 bottom-10 w-48 bg-white rounded-md shadow-lg z-10 py-1">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('post.show', $post)) }}" target="_blank" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fab fa-facebook-f mr-3 text-blue-600"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('post.show', $post)) }}&text={{ urlencode($post->title) }}" target="_blank" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fab fa-twitter mr-3 text-blue-400"></i> Twitter
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('post.show', $post)) }}" target="_blank" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fab fa-linkedin-in mr-3 text-blue-700"></i> LinkedIn
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('post.show', $post)) }}" target="_blank" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fab fa-whatsapp mr-3 text-green-500"></i> WhatsApp
                                    </a>
                                    <button onclick="copyToClipboard('{{ route('post.show', $post) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class="fas fa-link mr-3 text-gray-500"></i> Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="mt-6 border-t border-gray-100 pt-4 hidden" id="comments-container-{{$post->id}}">
                            <!-- Comment Form -->
                            <form onsubmit="submitComment(event, {{ $post->id }})" id="commentForm-{{$post->id}}" class="mb-4">
                                @csrf
                                <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg transition-all">
                                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/profile-avatar.png') }}"
                                        class="h-9 w-9 rounded-full object-cover border border-gray-200 shadow-sm">
                                    <div class="flex-1 relative">
                                        <textarea name="content" rows="1"
                                            class="py-2 px-3 w-full rounded-lg border border-gray-200 shadow-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm transition-all placeholder-gray-400 resize-none"
                                            placeholder="Add a comment..."></textarea>
                                    </div>
                                    <button id="submit-comment" type="submit"
                                        class="px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-1 shadow-sm">
                                        <i class="fas fa-paper-plane text-xs"></i>
                                        <span>Post</span>
                                    </button>
                                </div>
                            </form>

                            <!-- Comments List -->
                            <div class="space-y-4">
                                @foreach($post->comments as $comment)
                                    <div class="flex gap-3" id="comment-{{ $comment->id }}">
                                        <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : asset('images/profile-avatar.png') }}"
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


    <script>
        // Ellipsis menu
        function toggleEllipsDropdown(postId) {
            const dropdown = document.getElementById(`dropdown-${postId}`);
            dropdown.classList.toggle('hidden');

            document.addEventListener('click', function closeDropdown(e) {
                if (!e.target.closest(`#dropdownButton-${postId}`) &&
                    !e.target.closest(`#dropdown-${postId}`)) {
                    dropdown.classList.add('hidden');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
            // Share dropdown
    function toggleShareDropdown(postId) {
        const dropdown = document.getElementById(`share-dropdown-${postId}`);
        dropdown.classList.toggle('hidden');

        document.addEventListener('click', function closeDropdown(e) {
            if (!e.target.closest(`#share-dropdown-${postId}`) &&
                !e.target.closest(`button[onclick="toggleShareDropdown(${postId})"]`)) {
                dropdown.classList.add('hidden');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const notification = document.createElement('div');
            notification.textContent = 'Link copied to clipboard!';
            notification.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded-lg text-sm';
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 2000);
        });
    }
    </script>


