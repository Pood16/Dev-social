<!-- Navigation -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
       <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex items-center space-x-2">
                <i class="fas fa-code text-amber-500 text-2xl"></i>
                <span class="text-gray-900 font-bold text-xl">DevConnect</span>
            </div>
            <div class="hidden sm:ml-6 sm:flex items-center sm:space-x-8">
                <a href="{{route('feeds')}}" class="{{request()->routeIs('feeds') ? "border-b-2 border-amber-500" : "border-transparent hover:border-gray-300" }} text-gray-900  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Feed </a>
                <a href="{{route('connections')}}" class="{{request()->routeIs('connections') ? "border-b-2 border-amber-500" : "border-transparent hover:border-gray-300" }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Connections </a>
                <a href="{{route('profile')}}" class="{{request()->routeIs('profile') ? "border-b-2 border-amber-500" : "border-transparent hover:border-gray-300" }} text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium"> Profile </a>
                <a href="{{route('chat.index')}}" class="{{request()->routeIs('chat') ? "border-b-2 border-amber-500" : "border-transparent hover:border-gray-300" }} text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium"> Messanger </a>

            </div>
          </div>
        <!-- search icon -->
        <div class="hidden sm:ml-6 sm:flex items-center sm:space-x-8">
            <form action="{{ route('search.hashtags') }}" method="GET" class="flex items-center">
                <input type="text" name="query" placeholder="Search hashtags"
                       class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                       value="{{ request()->query('query') }}">
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-2 rounded-md ml-2 cursor-pointer">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <!-- right side -->
        <div class="flex items-center">
            <!-- Post Button -->
            <div class="flex-shrink-0 mr-4">
                <button type="button" onclick="openPostModal()"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 cursor-pointer">
                   <i class="fas fa-plus mr-2"></i> Create Post
                </button>
            </div>

            <!-- notifications -->

            <x-notification/>

            <!-- end -->
            <div class="ml-3 relative">
                <div>
                    <button type="button"
                        onclick="toggleDropdown()"
                        class="cursor-pointer max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                        id="user-menu-button">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{Storage::url(Auth::user()->profile_picture) ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9UdkG68P9AHESMfKJ-2Ybi9pfnqX1tqx3wQ&s'}}"
                            alt="User avatar">
                    </button>
                </div>

                <!-- Dropdown menu -->
                <div id="dropdown-menu"
                    class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="user-menu-button">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="cursor-pointer block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
          </div>
       </div>
    </div>
</nav>


<script>


    // logout dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    }

    // notifications list
    function toggleNotificationsDropdown() {
        const dropdown = document.getElementById('notifications-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdowns
    window.addEventListener('click', function(e) {

        // User dropdown
        const userDropdown = document.getElementById('dropdown-menu');
        const userButton = document.getElementById('user-menu-button');
        if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.add('hidden');
        }

        // Notifications dropdown
        const notifDropdown = document.getElementById('notifications-dropdown');
        const notifButton = document.getElementById('notification-menu-button');
        if (notifDropdown && notifButton && !notifButton.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.add('hidden');
        }
    });

</script>
