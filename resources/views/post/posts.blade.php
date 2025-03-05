

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

                        <!-- Post Actions  -->
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
                           <!-- filepath: /c:/laravel_Projects/dev-social/resources/views/index.blade.php -->
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
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach(explode(',', $post->hashtags) as $tag)
                                    <a href="#"
                                        class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm hover:bg-amber-200">
                                        #{{ trim($tag) }}
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
                            <button class="flex items-center space-x-2 hover:text-amber-600">
                                <i class="far fa-share-square"></i>
                                <span>Share</span>
                            </button>
                        </div>
                        <!-- Comments Section -->
                        <div class="mt-6 border-t border-gray-100 pt-4 hidden" id="comments-container-{{$post->id}}">
                            <!-- Comment Form -->
                            <form onsubmit="submitComment(event, {{ $post->id }})" id="commentForm-{{$post->id}}" class="mb-4">
                                @csrf
                                <div class="flex gap-3 items-center">
                                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                                        class="h-8 w-8 rounded-full object-cover">
                                    <div class="flex-1">
                                        <textarea name="content" rows="2"
                                            class="p-1 w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm"
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


