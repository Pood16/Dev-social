
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
       <div class="h-16 flex justify-between items-center">
            <!-- Left side - Logo -->
            <div class="flex-shrink-0">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-code text-amber-500 text-2xl"></i>
                    <span class="text-gray-900 font-bold text-xl">DevConnect</span>
                </div>
            </div>

            <!-- Middle - Search bar -->
            <div class="hidden md:block flex-grow max-w-md mx-4">
                <form action="{{ route('search.hashtags') }}" method="GET" class="flex w-full">
                    <input type="text" name="query" placeholder="Search hashtags"
                        class="w-full border border-gray-300 rounded-l-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                        value="{{ request()->query('query') }}">
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-2 rounded-r-md cursor-pointer">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Right side - Navigation icons -->
            <div class="flex items-center space-x-4">
                <!-- Home -->
                <a href="{{ route('feeds') }}" class="text-gray-500 hover:text-amber-600 transition-colors">
                    <i class="fas fa-home text-xl"></i>
                </a>

                <!-- Messages -->
                <div class="relative">
                    <a href="{{ route('chat.index') }}" class="text-gray-500 hover:text-amber-600 transition-colors">
                        <i class="fas fa-comment-alt text-xl"></i>
                    </a>
                    <!-- Unread message badge -->
                    <span id="unread-messages-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center" style="display: none;">0</span>
                </div>

                <!-- Connections -->
                <div class="relative">
                    <a href="{{ route('connections') }}" class="text-gray-500 hover:text-amber-600 transition-colors">
                        <i class="fas fa-user-friends text-xl"></i>
                    </a>
                    <!-- Connection requests badge -->
                    <span id="connection-requests-badge" class="absolute -top-1 -right-1 bg-amber-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center" style="display: none;">0</span>
                </div>

                <!-- Notifications -->
                <x-notification/>

                <!-- Mobile search button (visible on small screens) -->
                <button type="button" onclick="toggleMobileSearch()" class="md:hidden text-gray-500 hover:text-amber-600 transition-colors">
                    <i class="fas fa-search text-xl"></i>
                </button>

                <!-- Create Post Button -->
                <button type="button" onclick="openPostModal()"
                    class="hidden sm:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 cursor-pointer">
                    <i class="fas fa-plus mr-2"></i> Create Post
                </button>

                <!-- User menu -->
                <div class="relative">
                    <button type="button"
                        onclick="toggleDropdown()"
                        class="cursor-pointer flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                        id="user-menu-button">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{Storage::url(Auth::user()->profile_picture) ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9UdkG68P9AHESMfKJ-2Ybi9pfnqX1tqx3wQ&s'}}"
                            alt="User avatar">
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdown-menu"
                        class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="user-menu-button">
                        <!-- Profile Link -->
                        <a href="{{ route('profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            role="menuitem">
                            Profile
                        </a>

                        <!--Divider -->
                        <div class="border-t border-gray-100 my-1"></div>

                        <!-- Logout Button -->
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
    // Toggle user dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    }

    // Toggle notifications dropdown
    function toggleNotificationsDropdown() {
        const dropdown = document.getElementById('notifications-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Toggle mobile search
    function toggleMobileSearch() {
        const searchBar = document.getElementById('mobile-search');
        searchBar.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    window.addEventListener('click', function(e) {
        // User dropdown
        const userDropdown = document.getElementById('dropdown-menu');
        const userButton = document.getElementById('user-menu-button');
        if (userDropdown && userButton && !userButton.contains(e.target) && !userDropdown.contains(e.target)) {
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
