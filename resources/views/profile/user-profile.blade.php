<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <!-- Profile Header Section -->
        <div class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Profile Picture -->
                    <div class="flex-shrink-0">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.png') }}"
                            alt="{{ $user->name }}" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg">
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-grow">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $user->bio ?? 'No bio available' }}</p>

                        <!-- Skills/Languages -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if($user->language)
                                @foreach(explode(',', $user->language) as $lan)
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">{{ trim($lan) }}</span>
                                @endforeach
                            @else
                                <span class="text-gray-500 text-sm">No skills listed</span>
                            @endif
                        </div>
                    </div>


                    @if(!$isOwnProfile)
                        <div class="mt-4 md:mt-0">
                            <button onclick="sendConnectionRequest({{ $user->id }})"
                                class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors flex items-center gap-2 connect-button"
                                data-user-id="{{ $user->id }}">
                                <i class="fas fa-user-plus"></i>
                                <span>Connect</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col lg:flex-row gap-6">
            <!-- Left Sidebar - About & Projects -->
            <div class="w-full lg:w-1/3 space-y-6">
                <!-- About Section -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">About</h2>
                    <p class="text-gray-600 mb-4">{{ $user->bio ?? 'No bio information available' }}</p>

                    @if($user->github_url)
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fab fa-github"></i>
                            <a href="{{ $user->github_url }}" target="_blank" class="text-amber-600 hover:text-amber-700">
                                GitHub Profile
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Projects Section -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Projects</h2>
                    <div class="space-y-4">
                        @forelse($user->projects ?? [] as $project)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700">{{ $project->title }}</span>
                                <div class="flex space-x-2">
                                    @if($project->url)
                                        <a href="{{ $project->url }}" target="_blank"
                                           class="text-amber-600 hover:text-amber-700">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                    @if($project->lien_git)
                                        <a href="{{ $project->lien_git }}" target="_blank"
                                           class="text-gray-600 hover:text-gray-700">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No projects added yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Side - Posts -->
            <div class="w-full lg:w-2/3">
                <h2 class="text-xl font-bold mb-6">Posts</h2>
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
                                                                <i class="fas fa-trash"></i> Delete
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
                            <p class="text-gray-500">This user hasn't posted anything yet.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
