<x-app-layout>
    <!-- success message  -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-400 text-green-700 px-4 py-2 rounded-r relative mb-3 shadow-2xl">
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <svg class="fill-current h-4 w-4 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 8.586l-4.95-4.95a1 1 0 10-1.414 1.415L8.586 10l-4.95 4.95a1 1 0 101.414 1.415L10 11.414l4.95 4.95a1 1 0 101.415-1.414L11.414 10l4.95-4.95a1 1 0 10-1.414-1.415L10 8.586z" clip-rule="evenodd" />
            </svg>
        </button>
        </div>
    @endif

    <div class="min-h-screen flex flex-col">
      <!-- Profile Header -->
      <div class="relative">

        <!-- Cover Photo -->
        <div class="relative w-full h-64 overflow-hidden rounded">
          <!-- Cover Image -->
          @empty($user->cover_picture)
           <img src="https://codetheweb.blog/assets/img/posts/css-advanced-background-images/cover.jpg" alt="Cover Picture" class="w-full h-full object-cover">
          @else
           <img src="{{Storage::url($user->cover_picture)}}" alt="Cover Picture" class="w-full h-full object-cover">
          @endempty
          <!-- Form for Uploading New Cover -->
          <form action="{{ route('profile.cover') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-end justify-end p-4"> @csrf
            <!-- Styled File Input -->
            <input type="file" name="cover_image" id="cover_image" class="hidden" onchange="this.form.submit()">
            <label for="cover_image" class="cursor-pointer bg-white p-2 rounded shadow-md hover:bg-gray-100 focus:outline-none">
              <i class="fas fa-camera text-gray-600 mr-2"></i>Edit cover photo </label>
          </form>
        </div>

        <!-- Profile Info -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
          <div class="-mt-24 sm:-mt-32 sm:flex sm:items-end sm:space-x-5">
            <div class="relative group">
              <form action="{{route('profile.self')}}" method="POST" enctype="multipart/form-data" class="relative w-fit"> @csrf
                <!-- Profile Picture Container -->
                <div class="h-32 w-32 sm:h-40 sm:w-40 rounded-full ring-4 ring-white overflow-hidden bg-white relative"> @empty($user->profile_picture) <img src="https://static.vecteezy.com/system/resources/thumbnails/006/487/917/small_2x/man-avatar-icon-free-vector.jpg" alt="Cover Picture" class="w-full h-full object-cover"> @else <img src="{{Storage::url($user->profile_picture)}}" alt="Cover Picture" class="w-full h-full object-cover"> @endempty <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile picture" class="object-cover w-full h-full">
                  <!-- Hidden File Input -->
                  <input type="file" name="profile_image" id="profile_image" class="hidden" onchange="this.form.submit()">
                  <!-- Upload Button -->
                  <label for="profile_image" class="absolute bottom-4 right-4 text-center bg-gray-50 p-2 shadow-md cursor-pointer hover:bg-gray-100 w-10 h-10 rounded-full">
                    <i class="fas fa-camera text-gray-600"></i>
                  </label>
                </div>
              </form>
            </div>
            <div class="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
              <div class="sm:hidden md:block mt-6 min-w-0 flex-1">
                <h1 class="text-2xl font-bold text-gray-900 truncate">{{$user->name}}</h1>
                {{-- <p class="text-gray-500">Full Stack Developer</p> --}}
              </div>
              <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                <a href="{{route('profile.edit')}}" type="button" class="inline-flex justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                  <i class="fas fa-pen -ml-1 mr-2"></i>
                  <span>Edit profile</span>
                </a>
              </div>
            </div>
          </div>
          <div class="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
            <h1 class="text-2xl font-bold text-gray-900 truncate">{{$user->name}}</h1>
            <p class="text-gray-500">Full Stack Developer</p>
          </div>
        </div>
      </div>

      <!-- Profile Navigation -->

      <!-- Profile Content -->
      <div class="py-8 w-10/12 mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Column 1 -->
          <div class="lg:col-span-1">
            <!-- About Me -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
              <h2 class="text-lg font-medium text-gray-900 mb-4">About</h2>
              <p class="text-gray-600 mb-4">{{$user->bio??'try to add a bio'}} </p>
              <div class="border-t border-gray-200 pt-4 mt-2">
                <dl class="divide-y divide-gray-200">
                    <div class="py-3 flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">GitHub</dt>
                        <dd class="text-sm text-amber-600 hover:text-amber-700">
                          <a href="{{$user->github_url}}" class="flex items-center" target="_blank">
                            <i class="fab fa-github mr-1"></i> {{$user->name}}
                          </a>
                        </dd>
                    </div>
                  <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                    <dd class="text-sm text-gray-900">Nador, idawtanan</dd>
                  </div>
                  <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Work</dt>
                    <dd class="text-sm text-gray-900">TechForward Inc.</dd>
                  </div>
                  <div class="py-3 flex justify-between">
                    <dt class="text-sm font-medium text-gray-500">Website</dt>
                    <dd class="text-sm text-amber-600 hover:text-amber-700">
                      <a href="#">sarahconnor.dev</a>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Column 2-->
          <div class="lg:col-span-1">
            <!-- Skills -->
            <div class="bg-white shadow-2xl rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                  <h2 class="text-lg font-medium text-gray-900">Skills</h2>
                  <button class="text-sm text-amber-600 hover:text-amber-700">
                    <i class="fas fa-plus mr-1"></i> Add </button>
                </div>
                <div class="flex flex-wrap gap-2">
                    @empty($user->language)
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">No Languages added</span>
                    @else
                        @foreach(explode(',', $user->language) as $lan)
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">{{ trim($lan) }}</span>
                        @endforeach
                    @endempty
                </div>
              </div>
          </div>

          <!-- Column 3-->
          <div class="lg:col-span-1">
            <!-- Connections -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                  <h2 class="text-lg font-medium text-gray-900">Connections</h2>
                  <a href="#" class="text-sm text-amber-600 hover:text-amber-700">See all</a>
                </div>
                <div class="grid grid-cols-3 gap-4 min-w-1/3">
                  <div class="text-center">
                    <div class="relative group">
                      <img class="h-16 w-16 rounded-full mx-auto object-cover" src="{{Storage::url($user->profile_picture)}}" alt="Connection 1">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">{{$user->name}}</p>
                  </div>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </x-app-layout>

