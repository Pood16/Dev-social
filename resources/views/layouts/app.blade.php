<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user-id" content="{{ auth()->user()->id ?? ''}}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('js/post-interactions.js') }}"></script>
        <!-- Pusher  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="{{ asset('js/pusher-notification.js') }}"></script>
        <style>
            .toast-info .toast-message {
                display: flex;
                align-items: center;
            }
            .toast-info .toast-message i {
                margin-right: 10px;
            }
            .toast-info .toast-message .notification-content {
                display: flex;
                flex-direction: row;
                align-items: center;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- The nav bar -->
        @include('layouts.navigation')
        <!-- Display messages -->
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
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>


        <!-- pusher notification -->

    </body>
</html>
