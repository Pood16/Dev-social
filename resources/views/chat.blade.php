<x-app-layout>
    <div class="container mx-auto py-4 h-[calc(100vh-90px)]">
        <div class="flex border rounded shadow h-full">
            <!-- My Connections -->
            <div class="w-1/3 border-r overflow-y-auto" id="connections-panel">
                <h2 class="text-lg font-bold p-4">Your Connections</h2>
                <div id="connections-list">
                    @forelse($connections as $connection)
                        @php
                            $otherUser = $connection->other_user;
                        @endphp
                        <button class="w-full p-3 hover:bg-gray-100 flex items-center cursor-pointer connection-item"
                            data-user-id="{{ $otherUser->id }}"
                            data-user-name="{{ $otherUser->name }}"
                            data-user-photo="{{ $otherUser->profile_picture ? Storage::url($otherUser->profile_picture) : asset('images/default-avatar.png')}}">
                            <img src="{{ $otherUser->profile_picture ? Storage::url($otherUser->profile_picture) : asset('images/default-avatar.png') }}"
                                class="w-10 h-10 rounded-full object-cover mr-3" alt="">
                            <span class="font-medium">{{ $otherUser->name }}</span>
                        </button>
                    @empty
                        <p class="p-4 text-gray-500">No connections found. Create or accept a connection to start chatting.</p>
                    @endforelse
                </div>
            </div>

            <!-- Conversation body -->
            <div class="w-2/3 flex flex-col">
                <!-- Header -->
                <div class="border-b p-4 flex items-center" id="chat-header">
                    <img src="{{ asset('images/default-avatar.jpg') }}" alt="Avatar"
                        class="w-10 h-10 rounded-full object-cover mr-3" id="chat-user-avatar">
                    <div>
                        <h2 class="font-bold" id="chat-user-name">Select a connection</h2>
                        <small class="text-gray-500" id="chat-user-status">---</small>
                    </div>
                </div>

                <!-- Messages container -->
                <div class="flex-1 p-4 overflow-y-auto" id="messages-container">
                    <div class="flex items-center justify-center h-full text-gray-500" id="empty-state">
                        Select a connection to start chatting!
                    </div>
                </div>

                <!-- Message input -->
                <div class="border-t p-3 hidden" id="message-input-container">
                    <form id="message-form" class="flex items-center">
                        <textarea id="message-input"
                            class="border border-gray-300 rounded mr-2 p-2 focus:outline-none flex-1 resize-none"
                            rows="1" placeholder="Type a message..."></textarea>
                        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                            Send
                        </button>
                    </form>
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
            const chatUserStatus = document.getElementById('chat-user-status');
            const chatUserAvatar = document.getElementById('chat-user-avatar');


            connectionsList.addEventListener('click', function(event) {

                const connectionItem = event.target.closest('.connection-item');

                if (!connectionItem) return;

                // console.log('Connection clicked:', connectionItem.dataset.userName);

                currentRecipientId = connectionItem.dataset.userId;

                // Update header
                chatUserName.textContent = connectionItem.dataset.userName;
                chatUserStatus.textContent = 'Online';
                chatUserAvatar.src = connectionItem.dataset.userPhoto;

                // Clear previous messages
                messagesContainer.innerHTML = '';

                // Hide empty state and show message input
                emptyState.style.display = 'none';
                messageInputContainer.classList.remove('hidden');

                // Load messages
                loadMessages(currentRecipientId);

                // Highlight the selected connection
                document.querySelectorAll('.connection-item').forEach(item => {
                    item.classList.remove('bg-amber-50');
                });
                connectionItem.classList.add('bg-amber-50');
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
                messagesContainer.innerHTML = '<div class="flex justify-center py-4"><div class="animate-spin rounded-full h-6 w-6 border-t-2 border-amber-500"></div></div>';

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
                msgElement.className = `flex mb-2 ${isSent ? 'justify-end' : 'justify-start'}`;

                // Handle both direct message objects and broadcast data structure
                const msgText = message.message;
                const msgId = message.id;
                const msgTime = message.created_at;
                const time = formatTime(msgTime);

                // Basic HTML for sent vs received
                if (isSent) {
                    msgElement.innerHTML = `
                        <div class="bg-amber-600 text-white p-2 rounded-lg rounded-br-none max-w-xs">
                            <p>${escapeHTML(msgText)}</p>
                            <div class="text-xs text-right opacity-70 mt-1">${time}</div>
                        </div>
                    `;
                } else {
                    msgElement.innerHTML = `
                        <div class="bg-white border p-2 rounded-lg rounded-bl-none max-w-xs shadow-sm">
                            <p>${escapeHTML(msgText)}</p>
                            <div class="text-xs text-gray-500 text-right mt-1">${time}</div>
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

            if (window.Pusher) {
                Pusher.logToConsole = true;
                console.log('Pusher is loaded and configured');
            }
            // Listen for incoming messages via Pusher/Echo
            // Add connection diagnostics
            if (window.Echo) {
                // Add connection debugging
                window.Echo.connector.pusher.connection.bind('connected', () => {
                    console.log('✓ Successfully connected to Pusher!');
                });

                window.Echo.connector.pusher.connection.bind('error', (err) => {
                    console.error('✗ Pusher connection error:', err);
                });

                console.log('Attempting to subscribe to chat.' + userId);
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
                        }
                    });
            } else {
                console.error('Echo is not defined. Pusher may not be configured correctly.');
            }

            // Auto-resize textarea
            messageInput.addEventListener('input', () => {
                messageInput.style.height = 'auto';
                messageInput.style.height = (messageInput.scrollHeight) + 'px';
            });
        });
    </script>
</x-app-layout>
