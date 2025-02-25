<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
  <div class="relative min-h-screen flex">
    <div class="flex flex-col sm:flex-row items-center md:items-start sm:justify-center md:justify-start flex-auto min-w-0 bg-white">
      <!-- Left Panel -->
      <div class="sm:w-1/2 xl:w-2/5 h-full hidden md:flex flex-auto items-center justify-start p-10 overflow-hidden bg-indigo-900 text-white bg-no-repeat bg-cover relative" style="background-image: url(https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80);">
        <div class="absolute bg-gradient-to-b from-indigo-900 to-purple-900 opacity-75 inset-0 z-0"></div>
        <div class="absolute right-0 w-16 min-h-screen" style="border-top: 60rem solid #fff; border-left: 25rem solid transparent;"></div>
        <div class="w-full max-w-md z-10">
          <div class="sm:text-4xl xl:text-5xl font-bold leading-tight mb-6">Create Your Account</div>
          <div class="sm:text-sm xl:text-md text-gray-200 font-normal">
            Join our community today and unlock exclusive features. Our platform provides you with powerful tools to manage your projects, connect with like-minded individuals, and stay updated with the latest trends in your industry.
          </div>
        </div>

        <!-- Animated Background Circles -->
        <ul class="absolute top-0 left-0 w-full h-full overflow-hidden" style="list-style: none;">
          <li class="absolute block w-20 h-20 bg-white bg-opacity-20 rounded-full" style="left: 25%; width: 80px; height: 80px; bottom: -150px; animation: animate 25s linear infinite;"></li>
          <li class="absolute block w-5 h-5 bg-white bg-opacity-20 rounded-full" style="left: 10%; width: 20px; height: 20px; bottom: -150px; animation: animate 12s linear 2s infinite;"></li>
          <li class="absolute block w-5 h-5 bg-white bg-opacity-20 rounded-full" style="left: 70%; width: 20px; height: 20px; bottom: -150px; animation: animate 25s linear 4s infinite;"></li>
          <li class="absolute block w-15 h-15 bg-white bg-opacity-20 rounded-full" style="left: 40%; width: 60px; height: 60px; bottom: -150px; animation: animate 18s linear infinite;"></li>
          <li class="absolute block w-5 h-5 bg-white bg-opacity-20 rounded-full" style="left: 65%; width: 20px; height: 20px; bottom: -150px; animation: animate 25s linear infinite;"></li>
          <li class="absolute block w-28 h-28 bg-white bg-opacity-20 rounded-full" style="left: 75%; width: 110px; height: 110px; bottom: -150px; animation: animate 25s linear 3s infinite;"></li>
          <li class="absolute block w-36 h-36 bg-white bg-opacity-20 rounded-full" style="left: 35%; width: 150px; height: 150px; bottom: -150px; animation: animate 25s linear 7s infinite;"></li>
          <li class="absolute block w-6 h-6 bg-white bg-opacity-20 rounded-full" style="left: 50%; width: 25px; height: 25px; bottom: -150px; animation: animate 45s linear 15s infinite;"></li>
          <li class="absolute block w-4 h-4 bg-white bg-opacity-20 rounded-full" style="left: 20%; width: 15px; height: 15px; bottom: -150px; animation: animate 35s linear 2s infinite;"></li>
          <li class="absolute block w-36 h-36 bg-white bg-opacity-20 rounded-full" style="left: 85%; width: 150px; height: 150px; bottom: -150px; animation: animate 11s linear infinite;"></li>
        </ul>
      </div>

      <!-- Right Panel - Registration Form -->
      <div class="md:flex md:items-center md:justify-center w-full sm:w-auto md:h-full md:w-2/5 xl:w-2/5 p-8 md:p-10 lg:p-14 sm:rounded-lg md:rounded-none bg-white">
        <div class="max-w-md w-full space-y-8">
          <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Register</h2>
            <p class="mt-2 text-sm text-gray-500">Create your account to get started</p>
          </div>





          <!-- Registration Form -->
          <form class="mt-8 space-y-6" action="{{route('register')}}" method="POST">

            @csrf
            <!-- Full Name Input -->
            <div class="relative">
              <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Full Name</label>
              <input class="w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500" type="text" placeholder="Lahcen ouirghane" name="name" required>
              <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Input -->
            <div class="relative">
              <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Email Address</label>
              <input class="w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500" type="text" placeholder="lahcen@email.com" name="email" required>
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password Input -->
            <div class="mt-8 content-center">
              <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Password</label>
              <input class="w-full content-center text-base px-4 py-2 border-b rounded-2xl border-gray-300 focus:outline-none focus:border-indigo-500" type="password" placeholder="********" name="password" required>
              <p class="text-xs text-gray-400 mt-1 ml-3">Password must be at least 8 characters with 1 uppercase letter and 1 number</p>
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>


            <div>
              <button type="submit" class="w-full flex justify-center bg-gradient-to-r from-indigo-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-indigo-600 text-gray-100 p-4 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                Create Account
              </button>
            </div>

            <p class="flex flex-col items-center justify-center mt-10 text-center text-md text-gray-500">
              <span>Already have an account?</span>
              <a href="{{route('login')}}" class="text-indigo-500 hover:text-indigo-600 no-underline hover:underline cursor-pointer transition ease-in duration-300">Sign in</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <style>
    @keyframes animate {
      0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
      }
      100% {
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
      }
    }
  </style>
</body>
</html>
