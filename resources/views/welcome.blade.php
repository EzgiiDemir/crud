<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME</title>
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

    <!-- Sayfa İçeriği -->
    <div class="flex flex-col items-center justify-center min-h-screen mt-8 space-y-8">

        <!-- Welcome Bölümü -->
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full text-center mx-5">
            <h1 class="text-3xl font-bold text-orange-600 mb-4">Welcome to Ezgi's Products</h1>
            <h3 class="text-xl text-gray-700 mb-6">Discover Our Products</h3>
            <p class="text-gray-600 mb-6">You can create, update, delete, and manage your products and processes. Follow the button below to get started!</p>
            <a href="{{ route('register') }}" class="bg-orange-500 text-white py-2 px-6 rounded-full hover:bg-orange-600 transition duration-300">
                Sign in
            </a>
        </div>

        <!-- Register Form Bölümü -->
        <div class="mx-5 bg-gradient-to-b from-white to-gray-100 p-6 rounded-xl shadow-lg max-w-md sm:max-w-sm md:max-w-lg w-full">
            <div class="text-2xl font-extrabold text-orange-600 text-center mb-6">Register</div>
            <form class="space-y-4" method="POST" action="{{ route('register') }}">
                @csrf
                <input required class="w-full bg-white border border-transparent rounded-xl p-4 shadow-md focus:border-orange-400 focus:outline-none" type="text" name="name" id="name" placeholder="Name">
                <input required class="w-full bg-white border border-transparent rounded-xl p-4 shadow-md focus:border-orange-400 focus:outline-none" type="email" name="email" id="email" placeholder="E-mail">
                <input required class="w-full bg-white border border-transparent rounded-xl p-4 shadow-md focus:border-orange-400 focus:outline-none" type="password" name="password" id="password" placeholder="Password">
                <input class="w-full py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg shadow-md hover:scale-105 transition-transform" type="submit" value="Register">
            </form>
            <span class="text-center block mt-4 text-sm">
                <a href="#">Learn user licence agreement</a>
            </span>
        </div>
    </div>

    <!-- Footer -->
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
