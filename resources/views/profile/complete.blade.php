<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Complete Your Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-md w-full z-10">
        <div class="container w-9/12 mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-code text-amber-500 text-2xl"></i>
                    <span class="text-gray-900 font-bold text-xl">DevConnect</span>
                </div>

                {{-- <div class="flex items-center space-x-4">
                    <a href="#" class="text-amber-500 font-medium">
                        <i class="fas fa-user-circle mr-1"></i>
                        Profile
                    </a>
                </div> --}}
            </div>
        </div>
    </nav>
        <!-- success message  -->
        @if(session('success'))
          <div class="bg-green-100 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded-r relative mb-3 shadow-2xl">
              <span class="block sm:inline">{{ session('success') }}</span>
              <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                  <svg class="fill-current h-4 w-4 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 8.586l-4.95-4.95a1 1 0 10-1.414 1.415L8.586 10l-4.95 4.95a1 1 0 101.414 1.415L10 11.414l4.95 4.95a1 1 0 101.415-1.414L11.414 10l4.95-4.95a1 1 0 10-1.414-1.415L10 8.586z" clip-rule="evenodd"/>
                  </svg>
              </button>
          </div>
        @endif
      <!-- error message  -->
      @if(session('error'))
          <div class="bg-green-100 border-l-4 border-red-400 text-red-700 px-4 py-2 rounded-r relative mb-3 shadow-2xl">
              <span class="block sm:inline">{{ session('error') }}</span>
              <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                  <svg class="fill-current h-4 w-4 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 8.586l-4.95-4.95a1 1 0 10-1.414 1.415L8.586 10l-4.95 4.95a1 1 0 101.414 1.415L10 11.414l4.95 4.95a1 1 0 101.415-1.414L11.414 10l4.95-4.95a1 1 0 10-1.414-1.415L10 8.586z" clip-rule="evenodd"/>
                  </svg>
              </button>
          </div>
      @endif

      <!-- error message  -->
      @if ($errors->any())
          <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-2 rounded-r flex">
              <ul class="mt-1 ml-6 list-disc text-red-700">
                  @foreach ($errors->all() as $error)
                      <li class="mt-1">{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
    <!-- Profile Form Section -->
    <section class="py-12 px-4">
        <div class="container w-9/12 mx-auto">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-400 to-amber-600 px-6 py-4 text-white">
                    <h1 class="text-2xl font-bold">Update Your Profile</h1>
                    <p>Tell the community about yourself and your technical expertise</p>
                </div>

                <form class="p-6" action="{{route('profile.update')}}" method="POST">
                    @csrf

                    <!-- Cover Image Upload -->
                    <div class="relative w-full h-64 border-5 overflow-hidden rounded-lg">
                        <!-- Cover Image -->
                        @empty($user->cover_picture)
                            <img src="https://codetheweb.blog/assets/img/posts/css-advanced-background-images/cover.jpg" alt="Cover Picture" class="w-full h-full object-cover">
                        @else
                            <img src="{{Storage::url($user->cover_picture)}}" alt="Cover Picture" class="w-full h-full object-cover">
                        @endempty
                    </div>

                    <!-- Profile Section -->
                    <div class="flex flex-col md:flex-row gap-8 mb-8 mt-10">
                        <!-- Profile Image Upload -->
                        <div class="relative group">
                                <!-- Profile Picture Container -->
                                <div class="h-32 w-32 sm:h-40 sm:w-40 rounded-full ring-4 ring-white overflow-hidden bg-white relative">
                                    @empty($user->profile_picture)
                                        <img src="https://static.vecteezy.com/system/resources/thumbnails/006/487/917/small_2x/man-avatar-icon-free-vector.jpg" alt="Cover Picture" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{Storage::url($user->profile_picture)}}" alt="Cover Picture" class="w-full h-full object-cover">
                                    @endempty
                                    <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile picture" class="object-cover w-full h-full">
                                </div>
                          </div>

                        <!-- Full Name & Bio -->
                        <div class="w-full md:w-2/3">
                            <div class="mb-6">
                                <label for="fullName" class="block text-gray-700 font-medium mb-2">Full Name*</label>
                                <input value="{{$user->name}}" type="text" id="fullName" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition-colors duration-300" placeholder="e.g., John Doe" name="name" required>
                            </div>

                            <div class="mb-6">
                                <label for="bio" class="block text-gray-700 font-medium mb-2">Bio*</label>
                                <textarea id="bio" rows="3" class="w-full px-2 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition-colors duration-300" name="bio" placeholder="Tell us about yourself, your experience, and what you're passionate about..." required>
                                    {{$user->bio ?? 'no bio yet, try to express yourself'}}
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Details -->
                    <div class="mb-6">
                        <label for="languages" class="block text-gray-700 font-medium mb-2">Programming Languages*</label>
                        <input value="{{$user->language ?? 'no programming languages to display try to add some'}}" type="text" id="languages" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition-colors duration-300" name="language" placeholder="e.g., JavaScript, Python, Java (comma separated)" required>
                        <p class="text-gray-500 text-sm mt-1">Enter the programming languages you're proficient in, separated by commas</p>
                    </div>

                    <div class="mb-8">
                        <label for="githubUrl" class="block text-gray-700 font-medium mb-2">GitHub URL</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                <i class="fab fa-github"></i>
                            </span>
                            <input value="{{$user->github_url ?? 'no link added'}}" name="github_url" type="url" id="githubUrl" class="flex-grow px-4 py-3 rounded-r-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition-colors duration-300" placeholder="https://github.com/username">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{route('profile')}}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-8 rounded-lg shadow-md transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50">
                        Cancel
                    </a>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-3 px-8 rounded-lg shadow-md transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                            Complete Profile
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-8 text-gray-600">
                <p>Need help setting up your profile? <a href="#" class="text-amber-500 hover:text-amber-600">Check our guide</a></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <i class="fas fa-code text-amber-400 text-xl"></i>
                    <span class="text-white font-bold">DevConnect</span>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition-colors duration-300">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition-colors duration-300">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-amber-400 transition-colors duration-300">Help</a>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-4 pt-4 text-center md:text-left">
                <p class="text-gray-400">© 2025 DevConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Profile image upload preview
        document.querySelector('.group').addEventListener('click', function() {
            document.getElementById('profile-upload').click();
        });

        document.getElementById('profile-upload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('profile-preview');
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.classList.remove('hidden');
                    document.querySelector('.group .fa-user').classList.add('hidden');
                }

                reader.readAsDataURL(file);
            }
        });

        // Cover image upload preview
        document.querySelector('.border-dashed').addEventListener('click', function() {
            document.getElementById('cover-upload').click();
        });

        document.getElementById('cover-upload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('cover-preview');
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
