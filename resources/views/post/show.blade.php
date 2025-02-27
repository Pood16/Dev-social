<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
                    <a href="{{ route('feeds') }}"
                        class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

                <!-- Edit Form -->
                <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <div class="flex gap-2 mb-2">
                            <button type="button" onclick="toggleBold()"
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">
                                <i class="fas fa-bold"></i>
                            </button>
                        </div>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $post->title) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        <textarea name="content" id="content" rows="4" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('content', $post->content) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="links" class="block text-sm font-medium text-gray-700 mb-2">URL Link</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400"></i>
                            </div>
                            <input type="url" name="links" id="links"
                                value="{{ old('links', $post->links) }}"
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
                                value="{{ old('hashtags', $post->hashtags) }}"
                                placeholder="tech, programming, webdev"
                                class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Separate hashtags with commas</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        @if($post->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($post->image) }}"
                                    alt="Current post image"
                                    class="max-h-48 rounded-lg">
                            </div>
                        @endif

                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Update Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500">
                                        <span>Upload a new file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('feeds') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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
                    preview.classList.add('mt-2', 'rounded-lg', 'max-h-48', 'mx-auto');
                    const container = document.querySelector('.space-y-1');
                    // Remove existing preview if any
                    const existingPreview = container.querySelector('img');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    container.appendChild(preview);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
