<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg max-w-lg text-center">
    <h1 class="text-3xl font-bold text-blue-600 mb-4">Welcome to Ezgi's Products</h1>
    <h3 class="text-xl text-gray-700 mb-6">Discover Our Products</h3>
    <p class="text-gray-600 mb-6">You can create, update, delete, and manage your products and processes. Follow the button below to get started!</p>
    <a href="{{ route('create') }}" class="bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600 transition duration-300">
        Explore Products
    </a>
</div>

</body>
</html>
