<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alışveriş Sayfası</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-gray-800 p-4">
    <div class="flex justify-between items-center">
        <a href="#" class="text-white text-xl font-bold">Alışveriş</a>
        <div class="space-x-6">
            <a href="#" class="text-white">Ana Sayfa</a>
            <a href="#" class="text-white">Ürünler</a>
            <a href="#" class="text-white">İletişim</a>
        </div>
    </div>
</nav>

<!-- Carousel -->

<!-- Ürünler -->
<section class="py-10">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-semibold mb-6">Popüler Ürünler</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Ürün 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://www.vasajans.com/wp-content/uploads/2020/10/Urun-Cekimi-4-1024x683.jpg" alt="Ürün 1" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold">Ürün 1</h3>
                    <p class="text-gray-600">Ürün açıklaması burada yer alacak.</p>
                    <button class="bg-blue-500 text-white py-2 px-4 mt-4 rounded-lg">Sepete Ekle</button>
                </div>
            </div>
            <!-- Ürün 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://www.solutionajans.com/wp-content/uploads/2023/11/5.png" alt="Ürün 2" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold">Ürün 2</h3>
                    <p class="text-gray-600">Ürün açıklaması burada yer alacak.</p>
                    <button class="bg-blue-500 text-white py-2 px-4 mt-4 rounded-lg">Sepete Ekle</button>
                </div>
            </div>
            <!-- Ürün 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://www.lumosajans.com/wp-content/uploads/2023/02/ankara-urun-fotograf-cekimi-4.jpg" alt="Ürün 3" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold">Ürün 3</h3>
                    <p class="text-gray-600">Ürün açıklaması burada yer alacak.</p>
                    <button class="bg-blue-500 text-white py-2 px-4 mt-4 rounded-lg">Sepete Ekle</button>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://www.vasajans.com/wp-content/uploads/2020/10/Urun-Cekimi-4-1024x683.jpg" alt="Ürün 1" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold">Ürün 1</h3>
                    <p class="text-gray-600">Ürün açıklaması burada yer alacak.</p>
                    <button class="bg-blue-500 text-white py-2 px-4 mt-4 rounded-lg">Sepete Ekle</button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Reklam Alanı -->
<section class="bg-gray-800 text-white py-10">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold mb-6">İndirimli Ürünler İçin Tıklayın!</h2>
        <button class="bg-red-500 py-2 px-6 rounded-lg">Hemen Alışverişe Başla</button>
    </div>
</section>

</body>
</html>
