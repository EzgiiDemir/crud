@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<div class="flex flex-col items-center justify-center min-h-screen font-sans antialiased">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg text-center">
      <h1 class="text-2xl font-bold text-orange-600 mb-4 flex items-center justify-center" id="welcomeMessage">
      Welcome Back, {{ strtoupper(Auth::user()->name ?? 'Guest') }}
         <img src="{{ asset('images/nature.png') }}" alt="Lily" style="max-width: 50px; margin-left: 10px;">
       </h1>
       <p class="text-gray-600 mb-6">As a registered user, you can add, update, delete, and manage products. Explore the platform to start managing your content efficiently.</p>
       <a href="{{ route('create') }}" class="bg-orange-500 text-white py-2 px-6 rounded-full hover:bg-orange-600 transition duration-300">Explore Products</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg text-center mt-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Why Use Ezgi's Products?</h2>
        <p class="text-gray-600 mb-4">Our platform provides an easy and efficient way to manage your products, track updates, and store all your data securely.</p>
        <p class="text-gray-600">Join thousands of users who trust our system for their business needs.</p>
    </div>
</div>
@endsection
