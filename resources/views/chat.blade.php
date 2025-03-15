<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto py-4 h-[calc(100vh-90px)]">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full">
                <!-- Header -->
                <div class="bg-orange-300 hover:bg-orange-400 text-white p-4 text-center">
                    <h1 class="text-xl font-medium">CONVERSATION</h1>
                </div>

                <div class="flex h-[calc(100%-64px)]">
                    <!-- Left sidebar - Connections -->
                    <div class="w-1/3 border-r bg-white overflow-hidden flex flex-col">
                        <!-- Search bar -->
                        <div class="p-4 border-b flex items-center">
                            <div class="bg-gray-100 rounded-full flex items-center px-3 py-2 flex-grow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" placeholder="Search" class="bg-transparent border-none focus:outline-none ml-2 w-full">
                            </div>
                            <button class="bg-orange-300 hover:bg-orange-400 rounded-full w-8 h-8 flex items-center justify-center ml-2 text-white font-bold">
                                +
                            </button>
                        </div>

                        <!-- Connections list -->
                        <div class="overflow-y-auto flex-grow" id="connections-list">
                            @forelse($connections as $connection)
                                @php
                                    $otherUser = $connection->other_user;
                                    // Calculate time display
                                    $timeDisplay = "Yesterday";
                                    if ($loop->first) {
                                        $timeDisplay = "1 hour";
                                    } else if ($loop->index < 3) {
                                        $timeDisplay = "5 hours";
                                    } else if ($loop->index < 5) {
                                        $timeDisplay = "1 day";
                                    }
                                @endphp
                                <div class="p-4 hover:bg-gray-50 cursor-pointer connection-item border-b"
                                    data-user-id="{{ $otherUser->id }}"
                                    data-user-name="{{ $otherUser->name }}"
                                    data-user-photo="{{ $otherUser->profile_picture ? Storage::url($otherUser->profile_picture) : asset('images/default-avatar.png')}}">
                                    <div class="flex items-start">
                                        <div class="relative flex-shrink-0">
                                            <img src="{{ $otherUser->profile_picture ? Storage::url($otherUser->profile_picture) : asset('images/default-avatar.png') }}"
                                                class="w-10 h-10 rounded-full object-cover" alt="">
                                        </div>
                                        <div class="ml-3 flex-grow">
                                            <div class="flex justify-between">
                                                <span class="font-medium text-gray-900">{{ $otherUser->name }}</span>
                                                <span class="text-xs text-gray-400">{{ $timeDisplay }}</span>
                                            </div>
                                            <p class="text-sm text-gray-500 truncate mt-1">
                                                <!-- Truncated message preview -->
                                                Qualis eripiut perferendis ex est...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-gray-500">No connections found. Create or accept a connection to start chatting.</div>
                            @endforelse

                            @if(count($connections) > 0 && count($connections) < 10)
                                <div class="px-4 py-3 flex items-center">
                                    <div class="flex items-center">
                                        <!-- Group avatar display with overlapping images -->
                                        <div class="flex -space-x-2">
                                            <img src="{{ asset('images/default-avatar.png') }}" class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                            <img src="{{ asset('images/default-avatar.png') }}" class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                            <img src="{{ asset('images/default-avatar.png') }}" class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                            <img src="{{ asset('images/default-avatar.png') }}" class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                        </div>
                                        <span class="ml-2 text-xs text-gray-500">12 more</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Chat content area -->
                    <div class="w-2/3 flex flex-col bg-gray-50">
                        <!-- Chat header is always visible -->
                        <div class="bg-white p-4 border-b" id="chat-header">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ asset('images/default-avatar.jpg') }}" alt="Avatar"
                                        class="w-10 h-10 rounded-full object-cover" id="chat-user-avatar">
                                    <div class="ml-3">
                                        <h2 class="font-medium text-gray-900" id="chat-user-name">Select a connection</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Messages container -->
                        <div class="flex-1 p-4 overflow-y-auto" id="messages-container">
                            <div class="flex items-center justify-center h-full text-gray-500" id="empty-state">
                                Select a connection to start chatting!
                            </div>
                        </div>

                        <!-- Message input -->
                        <div class="bg-white border-t p-3 hidden" id="message-input-container">
                            <form id="message-form" class="flex items-center">
                                <textarea id="message-input"
                                    class="border border-gray-300 rounded-full py-2 px-4 focus:outline-none flex-1 resize-none"
                                    rows="1" placeholder="Type a message..."></textarea>
                                <button type="submit" class="bg-indigo-600 text-white rounded-full w-10 h-10 flex items-center justify-center ml-2 hover:bg-indigo-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ Auth::id() }};
            let currentRecipientId = null;

            const connectionsList = document.getElementById('connections-list');
            const messagesContainer = document.getElementById('messages-container');
            const emptyState = document.getElementById('empty-state');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const messageInputContainer = document.getElementById('message-input-container');
            const chatUserName = document.getElementById('chat-user-name');
            const chatUserAvatar = document.getElementById('chat-user-avatar');

            // Make connection items clickable
            document.querySelectorAll('.connection-item').forEach(item => {
                item.addEventListener('click', function() {
                    currentRecipientId = this.dataset.userId;

                    // Update header
                    chatUserName.textContent = this.dataset.userName;
                    chatUserAvatar.src = this.dataset.userPhoto;

                    // Clear previous messages
                    messagesContainer.innerHTML = '';

                    // Hide empty state and show message input
                    emptyState.style.display = 'none';
                    messageInputContainer.classList.remove('hidden');

                    // Load messages
                    loadMessages(currentRecipientId);

                    // Highlight the selected connection
                    document.querySelectorAll('.connection-item').forEach(element => {
                        element.classList.remove('bg-indigo-50');
                    });
                    this.classList.add('bg-indigo-50');
                });
            });

            // Handle sending a message
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!currentRecipientId || !messageInput.value.trim()) return;

                const msgText = messageInput.value.trim();

                // Reset input
                messageInput.value = '';
                messageInput.style.height = 'auto';

                // Optimistically display the outgoing message
                appendMessage({
                    id: 'temp-' + Date.now(),
                    from_user_id: userId,
                    message: msgText,
                    created_at: new Date().toISOString(),
                    pending: true
                }, true);

                // Send to server
                fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ recipient_id: currentRecipientId, message: msgText })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Message sent:', data);
                })
                .catch(err => {
                    console.error('Send error:', err);
                });
            });

            // Load messages from server
            function loadMessages(recipientId) {
                console.log('Loading messages for recipient:', recipientId);

                // Show loading indicator
                messagesContainer.innerHTML = '<div class="flex justify-center py-4"><div class="animate-spin rounded-full h-6 w-6 border-t-2 border-indigo-500"></div></div>';

                fetch(`{{ url('chat/messages') }}/${recipientId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch messages');
                    }
                    return response.json();
                })
                .then(messages => {
                    // Clear messages container
                    messagesContainer.innerHTML = '';

                    if (!messages || messages.length === 0) {
                        messagesContainer.innerHTML = `<p class="text-center text-gray-500 py-4">No messages yet. Say hello!</p>`;
                    } else {
                        messages.forEach(message => {
                            const isSentByMe = (message.from_user_id == userId);
                            appendMessage(message, isSentByMe);
                        });
                    }
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(err => {
                    console.error('Load error:', err);
                    messagesContainer.innerHTML = `<p class="text-center text-red-500 py-4">Failed to load messages.</p>`;
                });
            }

            // Display a single message in UI
            function appendMessage(message, isSent) {
                const msgElement = document.createElement('div');
                msgElement.className = `flex mb-4 ${isSent ? 'justify-end' : 'justify-start'}`;

                // Handle both direct message objects and broadcast data structure
                const msgText = message.message;
                const msgId = message.id;
                const msgTime = message.created_at;
                const time = formatTime(msgTime);

                // Create message HTML with avatars for received messages
                if (isSent) {
                    msgElement.innerHTML = `
                        <div class="flex items-end">
                            <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg rounded-br-none max-w-xs">
                                <p>${escapeHTML(msgText)}</p>
                            </div>
                            <img src="{{ asset('images/default-avatar.jpg') }}" alt="You"
                                class="w-8 h-8 rounded-full object-cover ml-2">
                        </div>
                    `;
                } else {
                    msgElement.innerHTML = `
                        <div class="flex items-end">
                            <img src="${chatUserAvatar.src}" alt="${chatUserName.textContent}"
                                class="w-8 h-8 rounded-full object-cover mr-2">
                            <div class="bg-white shadow px-4 py-2 rounded-lg rounded-bl-none max-w-xs">
                                <p>${escapeHTML(msgText)}</p>
                            </div>
                        </div>
                    `;
                }

                messagesContainer.appendChild(msgElement);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Escape HTML to prevent XSS
            function escapeHTML(str) {
                return str
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Format time from ISO string
            function formatTime(isoString) {
                const date = new Date(isoString);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            // Auto-resize textarea
            messageInput.addEventListener('input', () => {
                messageInput.style.height = 'auto';
                messageInput.style.height = (messageInput.scrollHeight) + 'px';
            });

            // Keep Pusher/Echo setup unchanged
            if (window.Pusher) {
                Pusher.logToConsole = true;
                console.log('Pusher is loaded and configured');
            }

            if (window.Echo) {
                window.Echo.connector.pusher.connection.bind('connected', () => {
                    console.log('✓ Successfully connected to Pusher!');
                });

                window.Echo.connector.pusher.connection.bind('error', (err) => {
                    console.error('✗ Pusher connection error:', err);
                });

                console.log('Attempting to subscribe to chat.' + userId);
                window.console.log('Attempting to subscribe to chat.' + userId);
                window.Echo.private(`chat.${userId}`)
                    .listen('.new.message', data => {
                        console.log('Received new message:', data);

                        // If we're chatting with this sender, append it
                        if (currentRecipientId == data.from_user_id) {
                            // Use the correct data structure from broadcastWith()
                            appendMessage({
                                id: data.id,
                                from_user_id: data.from_user_id,
                                to_user_id: data.to_user_id,
                                message: data.message,
                                created_at: data.created_at
                            }, false);
                        } else {
                            // Optional: Show notification for messages from others
                            console.log(`New message from ${data.user?.name || 'someone'} while chatting with someone else`);

                            // You could add code here to show a notification dot on the user's avatar in the sidebar
                            const connectionItem = document.querySelector(`.connection-item[data-user-id="${data.from_user_id}"]`);
                            if (connectionItem) {
                                // Add a notification indicator
                                const notificationDot = document.createElement('span');
                                notificationDot.className = 'absolute -top-1 -right-1 bg-red-500 rounded-full w-3 h-3';

                                // Add to the image container if it doesn't already have a notification
                                const imageContainer = connectionItem.querySelector('.relative');
                                if (imageContainer && !imageContainer.querySelector('.bg-red-500')) {
                                    imageContainer.appendChild(notificationDot);
                                }
                            }
                        }
                    });
            } else {
                console.error('Echo is not defined. Pusher may not be configured correctly.');
            }
        });
    </script>
</x-app-layout>
