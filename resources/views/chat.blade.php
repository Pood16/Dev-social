<x-app-layout>
<div class="flex h-[calc(100vh-90px)] bg-gray-50 w-11/12 mx-auto">
    <!-- Connections sidebar  -->
    <div class="w-1/3 bg-white border-r border-gray-200 flex flex-col">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Connections</h2>
            <div class="mt-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                    placeholder="Search connections...">
            </div>
        </div>

        <!-- Connections list -->
        <div class="flex-1 overflow-y-auto p-2" id="connections-list">
            @forelse($connections as $connection)
                @php
                    $connectionUser = $connection->sender_id == Auth::id() ? $connection->receiver : $connection->sender;
                    $isActive = $loop->first;
                @endphp

                <div class="flex items-center p-3 {{ $isActive ? 'bg-amber-50' : 'hover:bg-gray-50' }} rounded-lg mb-2 cursor-pointer connection-item"
                     data-user-id="{{ $connectionUser->id }}" data-user-name="{{ $connectionUser->name }}">
                    <div class="relative">
                        <img src="{{ $connectionUser->profile_picture ? Storage::url($connectionUser->profile_picture) : asset('images/default-avatar.png') }}"
                             alt="{{ $connectionUser->name }}"
                             class="h-12 w-12 rounded-full object-cover {{ $isActive ? 'border-2 border-amber-500' : '' }}">
                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-gray-400 rounded-full border-2 border-white user-status"></span>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between items-center">
                            <h3 class="text-sm font-medium text-gray-900">{{ $connectionUser->name }}</h3>
                            {{-- <span class="text-xs text-gray-500 last-message-time">-</span> --}}
                        </div>
                        <p class="text-xs text-gray-500 truncate last-message-preview">No messages yet</p>
                        <span class="hidden unread-badge ml-1 px-1.5 py-0.5 bg-amber-600 text-white rounded-full text-xs">0</span>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <p>No connections found.</p>
                    <p class="mt-2 text-sm">Connect with other developers to start chatting!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Chat content  -->
    <div class="w-2/3 flex flex-col bg-gray-50">
        <!-- Chat header -->
        <div class="p-4 border-b border-gray-200 bg-white flex items-center">
            <div class="flex items-center">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-900">Alex Johnson</h3>
                    <p class="text-xs text-gray-500">Online</p>
                </div>
            </div>
            <div class="ml-auto flex space-x-2">
                <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-video"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
        </div>

        <!-- Chat messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            <!-- Date separator -->
            <div class="flex justify-center">
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Today</span>
            </div>

            <!-- Received message -->
            <div class="flex items-end">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="h-8 w-8 rounded-full mr-2">
                <div class="bg-white rounded-lg rounded-bl-none p-3 shadow-sm max-w-[70%]">
                    <p class="text-gray-800 text-sm">Hey, how's the project coming along?</p>
                    <span class="text-xs text-gray-500 mt-1 block">10:30 AM</span>
                </div>
            </div>

            <!-- Sent message -->
            <div class="flex items-end justify-end">
                <div class="bg-amber-600 text-white rounded-lg rounded-br-none p-3 shadow-sm max-w-[70%]">
                    <p class="text-sm">It's going well! Just working on the final touches.</p>
                    <span class="text-xs opacity-80 mt-1 block">10:32 AM</span>
                </div>
            </div>

            <!-- Received message -->
            <div class="flex items-end">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="h-8 w-8 rounded-full mr-2">
                <div class="bg-white rounded-lg rounded-bl-none p-3 shadow-sm max-w-[70%]">
                    <p class="text-gray-800 text-sm">Great! Do you think we can finish by tomorrow?</p>
                    <span class="text-xs text-gray-500 mt-1 block">10:35 AM</span>
                </div>
            </div>

            <!-- Sent messages -->
            <div class="flex items-end justify-end">
                <div class="bg-amber-600 text-white rounded-lg rounded-br-none p-3 shadow-sm max-w-[70%]">
                    <p class="text-sm">Definitely. I'm almost done with the frontend.</p>
                    <span class="text-xs opacity-80 mt-1 block">10:36 AM</span>
                </div>
            </div>

            <div class="flex items-end justify-end mt-2">
                <div class="bg-amber-600 text-white rounded-lg rounded-br-none p-3 shadow-sm max-w-[70%]">
                    <p class="text-sm">What about the API integration? Any issues there?</p>
                    <span class="text-xs opacity-80 mt-1 block">10:36 AM</span>
                </div>
            </div>

            <!-- Received message with image -->
            <div class="flex items-end">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="h-8 w-8 rounded-full mr-2">
                <div class="bg-white rounded-lg rounded-bl-none p-3 shadow-sm max-w-[70%]">
                    <p class="text-gray-800 text-sm mb-2">API is working perfectly. Here's a screenshot of the dashboard:</p>
                    <img src="https://via.placeholder.com/300x150" alt="Screenshot" class="rounded-lg w-full">
                    <span class="text-xs text-gray-500 mt-1 block">10:40 AM</span>
                </div>
            </div>

            <!-- Typing indicator -->
            <div class="flex items-end">
                <img src="https://via.placeholder.com/40" alt="User Avatar" class="h-8 w-8 rounded-full mr-2">
                <div class="bg-gray-100 rounded-full p-3 px-4">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message input area -->
        <div class="p-4 border-t border-gray-200 bg-white">
            <div class="flex items-center">
                <button class="p-2 text-gray-500 hover:text-amber-600">
                    <i class="fas fa-paperclip"></i>
                </button>
                <div class="flex-1 mx-2">
                    <textarea rows="1" class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"
                        placeholder="Type a message..."></textarea>
                </div>
                <button class="p-2 rounded-full bg-amber-600 text-white hover:bg-amber-700 flex items-center justify-center w-10 h-10">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
