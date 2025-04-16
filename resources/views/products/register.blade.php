<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-orange-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Sol taraf: Marka -->
            <div class="text-xl font-bold"><img src="{{ asset('images/kitten.png') }}" alt="Kitten" style="max-width: 50px;"></div>

            <!-- Sağ taraf: Linkler -->
            <div class="space-x-6">
                <a href="#" class="hover:text-gray-200 transition">Contact</a>
                <a href="#" class="hover:text-gray-200 transition">About</a>
            </div>
        </div>
    </nav>
    <div class="flex flex-col items-center justify-center min-h-screen space-y-8">
<div class="max-w-sm w-full bg-gradient-to-t from-white via-white to-gray-100 rounded-3xl p-8 border-4 border-white shadow-lg">
    <div class="text-center font-extrabold text-3xl text-orange-600 mb-4 ">Sign in</div>

    <form class="space-y-4" method="POST" action="{{ route('login') }}">
        @csrf
        <input required class="w-full bg-white border border-transparent rounded-xl p-4 shadow-md focus:border-orange-400 focus:outline-none" type="email" name="email" id="email" placeholder="E-mail" value="{{ old('email') }}">
        @if($errors->has('email'))
    <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
@endif

        <input required class="w-full bg-white border border-transparent rounded-xl p-4 shadow-md focus:border-orange-400 focus:outline-none" type="password" name="password" id="password" placeholder="Password"  value="{{ old('password') }}">
        @if($errors->has('password'))
    <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
@endif

        <input class="w-2/3 mx-auto block bg-orange-500  to-orange-500 text-white font-bold py-2 rounded-xl shadow-md transform transition-transform duration-200 hover:scale-105" type="submit" value="Login"  value="{{ old('login') }}">
        @if($errors->has('login'))
    <span class="text-red-500 text-sm block text-center">{{ $errors->first('login') }}</span>
@endif

        <span class="block text-center text-sm mt-2"><a href="#" class="text-orange-600">Forgot Password?</a></span>
    </form>

    <div class="mt-6 text-center">
        <span class="block text-sm text-gray-600">Or Sign in with</span>

        <div class="flex justify-center gap-4 mt-3">
            <button class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center shadow-lg transition-transform duration-200 transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 488 512"><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path></svg>
            </button>
            <button class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center shadow-lg transition-transform duration-200 transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"></path></svg>
            </button>
            <button class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center shadow-lg transition-transform duration-200 transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>
            </button>
        </div>
    </div>

    <span class="block text-center text-xs mt-4"><a href="#" class="text-center block mt-4 text-sm">Learn user licence agreement</a></span>
</div>
</div>
<footer class="bg-orange-800 text-white p-4 mt-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-sm">&copy; 2025 Ezgi Company</div>
            <div class="space-x-6">
                <a href="#" class="hover:text-gray-200 transition">Privacy Policy</a>
                <a href="#" class="hover:text-gray-200 transition">Terms of Service</a>
            </div>
        </div>
    </footer>

</body>
</html>
