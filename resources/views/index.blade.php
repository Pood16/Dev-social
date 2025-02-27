<x-app-layout>
<!-- Post Creation Modal -->
<div id="postModal" class="fixed inset-0 hidden">
    <!-- Modal backdrop -->
    <div class="absolute inset-0 bg-gray-900 opacity-70"></div>

    <!-- Modal content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Create New Post</h3>
                    <button onclick="closePostModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
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
                        <label for="hashtags" class="block text-sm font-medium text-gray-700 mb-2">Hashtags</label>
                        <input type="text" name="hashtags" id="hashtags"
                            placeholder="Enter hashtags separated by commas"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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

<!-- Posts Feed Section -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="space-y-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Post Header -->
                <div class="p-4 flex items-center space-x-4">
                    <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('images/default-avatar.png') }}"
                        class="h-10 w-10 rounded-full object-cover">
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $post->user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Post Content -->
                <div class="px-4 pb-4">
                    <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-700 mb-4">{{ $post->content }}</p>

                    <!-- Post Image (if exists) -->
                    @if($post->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $post->image) }}"
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
                        <button class="flex items-center space-x-2 hover:text-amber-600">
                            <i class="far fa-heart"></i>
                            <span>Like</span>
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
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-500">No posts yet</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>

<!-- Add this script section at the end -->
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
                preview.classList.add('mt-2', 'rounded-md', 'max-h-48', 'mx-auto');
                const container = document.querySelector('.space-y-1');
                container.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</x-app-layout>

