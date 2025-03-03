<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">My Connections</h2>

                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button
                            class="tab-button active border-amber-500 text-amber-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            All Connections
                        </button>
                    </nav>
                </div>

                <!-- Connection Lists -->
                <div id="all-connections" class="tab-content">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Connected Since
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($connections as $connection)
                                    @php
                                        $otherUser = $connection->sender_id === Auth::id() ? $connection->receiver: $connection->sender;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ $otherUser->profile_picture ? asset('storage/' . $otherUser->profile_picture) : asset('images/default-avatar.png') }}"
                                                        alt="{{ $otherUser->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $otherUser->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $connection->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                                   ($connection->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                   'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($connection->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $connection->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($connection->receiver_id === Auth::id() && $connection->status === 'pending')
                                                <button onclick="acceptRequest({{ $connection->id }})"
                                                    class="text-green-600 hover:text-green-900 mr-3">
                                                    Accept
                                                </button>
                                                <button onclick="rejectRequest({{ $connection->id }})"
                                                    class="text-red-600 hover:text-red-900">
                                                    Reject
                                                </button>
                                            @elseif($connection->status === 'accepted')
                                                <button onclick="removeConnection({{ $connection->id }})"
                                                    class="text-red-600 hover:text-red-900">
                                                    Remove
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        // accept connection request
        function acceptRequest(connectionId) {

            if (!confirm('Are you sure you want to accept this connection request?')) return;

            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch(`/connections/accept/${connectionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to accept request. Please try again.');
            });
        }

        // reject connection request
        function rejectRequest(connectionId) {

            if (!confirm('Are you sure you want to reject this connection request?')) return;

            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch(`/connections/reject/${connectionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to reject request. Please try again.');
            });
        }

        // remove connection
        function removeConnection(connectionId) {

            if (!confirm('Are you sure you want to remove this connection?')) return;

            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch(`/connections/destroy/${connectionId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to remove connection. Please try again.');
            });
        }

        function showTab(tabName) {
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => {
                button.classList.remove('border-amber-500', 'text-amber-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            const activeButton = document.querySelector(`[onclick="showTab('${tabName}')"]`);
            activeButton.classList.remove('border-transparent', 'text-gray-500');
            activeButton.classList.add('border-amber-500', 'text-amber-600');
        }
    </script>
</x-app-layout>
