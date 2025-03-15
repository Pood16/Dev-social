<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full z-10">
        <div class="container w-10/12 mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-code text-amber-600 text-2xl"></i>
                    <span class="text-gray-900 font-bold text-xl">DevConnect</span>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{route('login')}}" class="md:inline-block text-gray-700 hover:text-amber-600 transition-colors duration-300">Login</a>
                    <a href="{{route('register')}}" class="bg-amber-500 hover:bg-amber-600 text-white rounded-lg px-5 py-2 transition-colors duration-300">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-28 pb-20 bg-gradient-to-br from-amber-100 to-white">
        <div class="container w-10/12 mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2 mb-10 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4">
                        Connect, Collaborate, <span class="text-amber-500">Code</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Join the community where developers share knowledge, collaborate on projects, and advance their careers.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{route('register')}}" class="bg-amber-500 hover:bg-amber-600 text-white text-center rounded-lg px-6 py-3 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                            Create Account
                        </a>
                    </div>
                </div>

                <!-- Image Container -->
                <div class="w-full lg:w-1/2 h-[500px] relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl shadow-2xl transform rotate-2 group-hover:rotate-3 transition-transform duration-500"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-white to-amber-50 rounded-xl shadow-2xl transform -rotate-1 group-hover:-rotate-2 transition-transform duration-500"></div>

                    <img
                        src="{{ asset('images/dev-hero.jpeg') }}"
                        alt="Developer Collaboration"
                        class="absolute inset-0 w-full h-full rounded-xl object-cover shadow-2xl border-4 border-white transform group-hover:scale-105 transition-transform duration-500 z-10"
                    />

                    <!-- Decorative Element -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-yellow-400 opacity-20 rounded-full blur-xl group-hover:opacity-30 transition-opacity duration-500"></div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
