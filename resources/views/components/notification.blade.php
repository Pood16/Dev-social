<div id="notification-bell-container" class="relative">
    <button id="notification-bell-button" class="relative p-1 text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0h-6"/>
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span id="notification-unread-indicator" class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
        @endif
    </button>

    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 transition-all duration-100">
        <div class="max-h-96 overflow-y-auto" id="notification-list">
        <!-- notifications here -->
        </div>

        <div id="mark-all-container" class="hidden border-t border-gray-100 mt-2">
            <button id="mark-all-read" class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-50">
                Mark all as read
            </button>
        </div>
    </div>
</div>
<script>
    // Elements
    const bellContainer = document.getElementById('notification-bell-container');
    const bellButton = document.getElementById('notification-bell-button');
    const dropdown = document.getElementById('notification-dropdown');
    const notificationList = document.getElementById('notification-list');
    const markAllContainer = document.getElementById('mark-all-container');
    const markAllReadButton = document.getElementById('mark-all-read');

    let notifications = [];
    let isOpen = false;

    bellButton.addEventListener('click', () => {
        if (isOpen) {
            hideDropdown();
        } else {
            showDropdown();
            fetchNotifications();
        }
    });

    document.addEventListener('click', (event) => {
        if (!bellContainer.contains(event.target) && isOpen) {
            hideDropdown();
        }
    });

    markAllReadButton.addEventListener('click', markAllAsRead);

    function showDropdown() {
        dropdown.classList.remove('hidden');
        dropdown.classList.add('block');
        isOpen = true;
    }

    function hideDropdown() {
        dropdown.classList.add('hidden');
        dropdown.classList.remove('block');
        isOpen = false;
    }

    function fetchNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                notifications = data;
                renderNotifications();
            });
    }

    function renderNotifications() {
        notificationList.innerHTML = '';

        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="px-4 py-3 text-sm text-gray-500">
                    No notifications
                </div>
            `;
            markAllContainer.classList.add('hidden');
            return;
        }

        markAllContainer.classList.remove('hidden');

        let unreadCount = 0;
        notifications.forEach(notification => {
            const notificationEl = document.createElement('div');
            notificationEl.className = `px-4 py-3 hover:bg-gray-50 ${!notification.read_at ? 'bg-blue-50' : ''}`;

            if (!notification.read_at) {
                unreadCount++;
            }

            notificationEl.innerHTML = `
                <p class="text-sm text-gray-900">${notification.data.user_name}  ${notification.data.message}</p>
                <p class="text-xs text-gray-500 mt-1">${formatDate(notification.created_at)}</p>
            `;

            notificationList.appendChild(notificationEl);
        });

        if (unreadCount === 0) {
            const unreadIndicator = document.getElementById('notification-unread-indicator');
            if (unreadIndicator) {
                unreadIndicator.remove();
            }
        } else {
            const unreadIndicator = document.getElementById('notification-unread-indicator');
            if (!unreadIndicator) {
                // Create and append the unread indicator if it doesn't exist
                const newUnreadIndicator = document.createElement('span');
                newUnreadIndicator.id = 'notification-unread-indicator';
                newUnreadIndicator.className = 'absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500';
                bellContainer.appendChild(newUnreadIndicator);
            }
        }
    }

    function markAllAsRead() {
        fetch('/notifications/mark-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(() => {
            notifications.forEach(notification => {
                notification.read_at = new Date().toISOString();
            });
            renderNotifications();

            const unreadIndicator = document.getElementById('notification-unread-indicator');
            if (unreadIndicator) {
                unreadIndicator.remove();
            }
        });
    }

    function formatDate(date) {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
</script>
