<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>DevConnect - Profile</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <script src="https://cdn.tailwindcss.com"></script>
      <script>
        tinymce.init({
            selector: '#postContent',
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
        });
    </script>
   </head>
   <body class="theme-light theme-transition bg-gray-50" id="root">
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

      <div class="min-h-screen flex flex-col">
         <!-- Navigation -->
         <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
               <div class="flex justify-between h-16">
                  <div class="flex">
                     <div class="flex-shrink-0 flex items-center">
                        <span class="text-amber-500 font-bold text-xl">DevConnect</span>
                     </div>
                     <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="#" class="border-amber-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Profile </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Feed </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Connections </a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Jobs </a>
                     </div>
                  </div>
                  <div class="flex items-center">
                     <div class="flex-shrink-0">
                        <button type="button" class="relative inline-flex items-center p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none">
                           <span class="sr-only">Notifications</span>
                           <i class="fas fa-bell"></i>
                           <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-amber-500"></span>
                        </button>
                     </div>
                     <div class="ml-3 relative">
                        <div>
                           <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500" id="user-menu-button">
                              <span class="sr-only">Open user menu</span>
                              <img class="h-8 w-8 rounded-full" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9UdkG68P9AHESMfKJ-2Ybi9pfnqX1tqx3wQ&s" alt="User avatar">
                           </button>
                        </div>
                     </div>
                     <div class="ml-3">
                        <button id="theme-toggle" class="p-2 text-gray-500 rounded-lg">
                           <i class="fas fa-moon"></i>
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </nav>
         <!-- Profile Header -->
         <div class="relative">
            <!-- Cover Photo -->
            <div class="relative w-full h-64 border-5 overflow-hidden rounded-lg">
                <!-- Cover Image -->

                @empty($user->cover_picture)
                    <img src="https://codetheweb.blog/assets/img/posts/css-advanced-background-images/cover.jpg" alt="Cover Picture" class="w-full h-full object-cover">
                @else
                    <img src="{{Storage::url($user->cover_picture)}}" alt="Cover Picture" class="w-full h-full object-cover">
                @endempty

                <!-- Form for Uploading New Cover -->
                <form action="{{ route('profile.cover') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-end justify-end p-4">
                    @csrf
                    <!-- Styled File Input -->
                    <input type="file" name="cover_image" id="cover_image" class="hidden" onchange="this.form.submit()">
                    <label for="cover_image" class="cursor-pointer bg-white p-2 rounded shadow-md hover:bg-gray-100 focus:outline-none">
                        <i class="fas fa-camera text-gray-600 mr-2"></i>Edit cover photo
                    </label>
                </form>
            </div>
            <!-- Profile Info -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
               <div class="-mt-24 sm:-mt-32 sm:flex sm:items-end sm:space-x-5">
                  <div class="relative group">
                    <form action="{{route('profile.self')}}" method="POST" enctype="multipart/form-data" class="relative w-fit">
                        @csrf

                        <!-- Profile Picture Container -->
                        <div class="h-32 w-32 sm:h-40 sm:w-40 rounded-full ring-4 ring-white overflow-hidden bg-white relative">

                            @empty($user->profile_picture)
                                <img src="https://static.vecteezy.com/system/resources/thumbnails/006/487/917/small_2x/man-avatar-icon-free-vector.jpg" alt="Cover Picture" class="w-full h-full object-cover">
                            @else
                                <img src="{{Storage::url($user->profile_picture)}}" alt="Cover Picture" class="w-full h-full object-cover">
                            @endempty

                            <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile picture" class="object-cover w-full h-full">

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
         <div class="border-b border-gray-200 bg-white mt-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
               <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                  <a href="#" class="border-amber-500 text-amber-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"> Overview </a>
                  <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"> Posts </a>
                  <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"> Projects </a>
                  <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"> Skills </a>
                  <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"> Connections </a>
               </nav>
            </div>
         </div>
         <!-- Profile Content -->
         <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
               <!-- Left Column -->
               <div class="lg:col-span-1">
                  <!-- About Me -->
                  <div class="bg-white shadow rounded-lg p-6 mb-6">
                     <h2 class="text-lg font-medium text-gray-900 mb-4">About</h2>
                     <p class="text-gray-600 mb-4">{{$user->bio??'try to add a bio'}} </p>
                     <div class="border-t border-gray-200 pt-4 mt-2">
                        <dl class="divide-y divide-gray-200">
                           <div class="py-3 flex justify-between">
                              <dt class="text-sm font-medium text-gray-500">Location</dt>
                              <dd class="text-sm text-gray-900">Nador, idawtanan</dd>
                           </div>
                           <div class="py-3 flex justify-between">
                              <dt class="text-sm font-medium text-gray-500">Work</dt>
                              <dd class="text-sm text-gray-900">TechForward Inc.</dd>
                           </div>
                           <div class="py-3 flex justify-between">
                              <dt class="text-sm font-medium text-gray-500">GitHub</dt>
                              <dd class="text-sm text-amber-600 hover:text-amber-700">
                                 <a href="{{$user->github_url}}" class="flex items-center" target="_blank">
                                    <i class="fab fa-github mr-1"></i> {{$user->name}} </a>
                              </dd>
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
                  <!-- Skills -->
                  <div class="bg-white shadow rounded-lg p-6 mb-6">
                     <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Skills</h2>
                        <button class="text-sm text-amber-600 hover:text-amber-700">
                           <i class="fas fa-plus mr-1"></i> Add
                        </button>
                     </div>
                     <div class="flex flex-wrap gap-2">
                        @php
                        $languages = Str::of($user->language)->explode(',');
                    @endphp

                    @foreach($languages as $lan)
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm">{{ trim($lan) }}</span>
                    @endforeach

                     </div>
                  </div>
                  <!-- Connections -->
                  <div class="bg-white shadow rounded-lg p-6">
                     <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Connections</h2>
                        <a href="#" class="text-sm text-amber-600 hover:text-amber-700">See all</a>
                     </div>
                     <div class="grid grid-cols-3 gap-4 min-w-1/3">
                        <div class="text-center">
                           <div class="relative group">
                              <img class="h-16 w-16 rounded-full mx-auto" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9UdkG68P9AHESMfKJ-2Ybi9pfnqX1tqx3wQ&s" alt="Connection 1">
                              <div class="absolute inset-0 rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-300"></div>
                           </div>
                           <p class="mt-2 text-xs text-gray-500">Alex Kim</p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Right Column -->
               <div class="lg:col-span-2">
                  <!-- Create Post -->
                  <div class="bg-white shadow rounded-lg p-6 mb-6">
                     <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                           <img class="h-12 w-12 rounded-full" src="{{ Storage::url($user->profile_picture) }}" alt="User avatar" class="w-full h-full object-fit">
                        </div>
                        <div class="min-w-0 flex-1">

                            {{-- create post form --}}
                            <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <textarea id="postContent" name="content" class="w-full h-32 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="Share your knowledge or ask a question..."></textarea>

                                <div class="mt-3 flex justify-between">
                                    <div class="flex space-x-3 items-center">
                                        <div class="relative">
                                            <input type="file" id="imageInput" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                            <button type="button" class="flex items-center text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-image mr-1"></i>
                                                <span class="text-sm">Image</span>
                                            </button>
                                        </div>

                                        <div class="relative">
                                            <input type="text" id="imageLink" name="image_link" class="hidden absolute top-0 left-0 -mt-10 w-64 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="Or paste image URL here">
                                            <button type="button" id="toggleLinkInput" class="flex items-center text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-link mr-1"></i>
                                                <span class="text-sm">Link</span>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">Post</button>
                                </div>
                            </form>
                            {{-- end create post form --}}


                        </div>
                     </div>
                  </div>
                  <!-- Projects -->
                  <div class="bg-white shadow rounded-lg p-6 mb-6">
                     <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Featured Projects</h2>
                        <button class="text-sm text-amber-600 hover:text-amber-700">
                           <i class="fas fa-plus mr-1"></i> Add Project
                        </button>
                     </div>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Project 1 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition duration-300">
                           <div class="h-40 bg-gray-100 flex items-center justify-center">
                              <img src="/api/placeholder/400/250" alt="Project 1" class="w-full h-full object-cover">
                           </div>
                           <div class="p-4">
                              <div class="flex justify-between items-start">
                                 <h3 class="text-md font-medium text-gray-900">E-Commerce Platform</h3>
                                 <div class="flex space-x-1">
                                    <a href="#" class="text-gray-400 hover:text-amber-500">
                                       <i class="fab fa-github"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-amber-500">
                                       <i class="fas fa-external-link-alt"></i>
                                    </a>
                                 </div>
                              </div>
                              <p class="mt-2 text-sm text-gray-500">A full-stack e-commerce solution with React, Node.js and Stripe integration.</p>
                              <div class="mt-3 flex flex-wrap gap-2">
                                 <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">React</span>
                                 <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Node.js</span>
                                 <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">MongoDB</span>
                              </div>
                           </div>
                        </div>
                        <!-- Project 2 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition duration-300">
                           <div class="h-40 bg-gray-100 flex items-center justify-center">
                              <img src="/api/placeholder/400/251" alt="Project 2" class="w-full h-full object-cover">
                           </div>
                           <div class="p-4">
                              <div class="flex justify-between items-start">
                                 <h3 class="text-md font-medium text-gray-900">Code Compiler</h3>
                                 <div class="flex space-x-1">
                                    <a href="#" class="text-gray-400 hover:text-amber-500">
                                       <i class="fab fa-github"></i>
                                    </a>
                                    <a href="#" class="text-gray-400 hover:text-amber-500">
                                       <i class="fas fa-external-link-alt"></i>
                                    </a>
                                 </div>
                              </div>
                              <p class="mt-2 text-sm text-gray-500">An online code editor and compiler supporting multiple programming languages.</p>
                              <div class="mt-3 flex flex-wrap gap-2">
                                 <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">TypeScript</span>
                                 <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">Docker</span>
                                 <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">WebSockets</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Latest Posts -->
                  <div class="bg-white shadow rounded-lg p-6">
                     <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Latest Posts</h2>
                        <a href="#" class="text-sm text-amber-600 hover:text-amber-700">View all</a>
                     </div>
                     <!-- Post 1 -->
                     <div class="mb-8 border-b border-gray-200 pb-8">
                        <div class="flex items-center mb-4">
                           <img class="h-10 w-10 rounded-full mr-3" src="/api/placeholder/400/400" alt="User avatar">
                           <div>
                              <h3 class="text-sm font-medium text-gray-900">Sarah Connor</h3>
                              <p class="text-xs text-gray-500">2 days ago</p>
                           </div>
                        </div>
                        <div>
                           <p class="text-gray-800 mb-4">Just launched a new open-source library for handling WebSocket connections in React applications. Check it out! #React #WebSockets</p>
                           <div class="bg-gray-50 p-4 rounded-lg mb-4">
                              <pre class="text-sm overflow-x-auto">
																					<code>import { createWebSocketProvider } from 'react-ws-hooks';

const App = () => {
  return (
    &lt;WebSocketProvider url="wss://example.com/socket"&gt;
      &lt;YourComponent /&gt;
    &lt;/WebSocketProvider&gt;
  );
};</code>
																				</pre>
                           </div>
                           <div class="flex items-center justify-between">
                              <div class="flex items-center space-x-4">
                                 <button class="flex items-center text-gray-500 hover:text-amber-500">
                                    <i class="far fa-heart mr-1"></i>
                                    <span>42</span>
                                 </button>
                                 <button class="flex items-center text-gray-500 hover:text-gray-700">
                                    <i class="far fa-comment mr-1"></i>
                                    <span>12</span>
                                 </button>
                                 <button class="flex items-center text-gray-500 hover:text-gray-700">
                                    <i class="far fa-share-square mr-1"></i>
                                 </button>
                              </div>
                              <button class="text-gray-500 hover:text-gray-700">
                                 <i class="fas fa-ellipsis-h"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                     <!-- Post 2 -->
                     <div>
                        <div class="flex items-center mb-4">
                           <img class="h-10 w-10 rounded-full mr-3" src="/api/placeholder/400/400" alt="User avatar">
                           <div>
                              <h3 class="text-sm font-medium text-gray-900">Sarah Connor</h3>
                              <p class="text-xs text-gray-500">1 week ago</p>
                           </div>
                        </div>
                        <div>
                           <p class="text-gray-800 mb-4">Exploring performance optimizations in React. Here's a quick tip: always use React.memo() for components that receive the same props but render frequently.</p>
                           <div class="rounded-lg overflow-hidden mb-4">
                              <img src="/api/placeholder/600/300" alt="Post image" class="w-full">
                           </div>
                           <div class="flex items-center justify-between">
                              <div class="flex items-center space-x-4">
                                 <button class="flex items-center text-amber-500">
                                    <i class="fas fa-heart mr-1"></i>
                                    <span>124</span>
                                 </button>
                                 <button class="flex items-center text-gray-500 hover:text-gray-700">
                                    <i class="far fa-comment mr-1"></i>
                                    <span>28</span>
                                 </button>
                                 <button class="flex items-center text-gray-500 hover:text-gray-700">
                                    <i class="far fa-share-square mr-1"></i>
                                 </button>
                              </div>
                              <button class="text-gray-500 hover:text-gray-700">
                                 <i class="fas fa-ellipsis-h"></i>
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>




<!-- Simple JavaScript to toggle the image link input -->
<script>
    document.getElementById('toggleLinkInput').addEventListener('click', function() {
        const linkInput = document.getElementById('imageLink');
        linkInput.classList.toggle('hidden');
    });
</script>
