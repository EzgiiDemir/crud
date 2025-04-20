<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ezgi's Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>


    <style>
        .dark-theme {
            background-color: #121212;
            color: #ffffff;
        }

        .dark-theme .card {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .dark-theme .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
        }

        /* Açık tema için stiller */
        .light-theme {
            background-color: #ffffff;
            color: #000000;
        }

        .light-theme .card {
            background-color: #f8f9fa;
            color: #000000;
        }

        .light-theme .form-control {
            background-color: #ffffff;
            color: #000000;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body class="{{ Auth::check() ? Auth::user()->theme : 'dark' }} {{ Auth::check() ? 'text-orange-600' : '' }}">
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <div class="text-xl font-bold"><img src="{{ asset('images/kitten.png') }}" alt="Kitten" style="max-width: 50px;"></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-orange-600" href="{{ route('login') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange-600" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange-600" href="{{ route('products.market') }}">Market</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange-600" href="{{ route('fee_calculator') }}">Fee Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-orange-600" href="{{ route('payment') }}">Payment</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-orange-600" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-orange-600" href="{{ route('account') }}">My Account</a></li>
                            <li><a class="dropdown-item text-orange-600" href="{{ route('settings') }}">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-orange-600" style="background: none; border: none; color: inherit;">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="text-orange-600">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @php
    $settings = Auth::check()
        ? (json_decode(Auth::user()->settings, true) ?? ['notifications' => 'enabled', 'theme' => 'light'])
        : ['notifications' => 'enabled', 'theme' => 'light'];
    @endphp

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const theme = "{{ $settings['theme'] }}";
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.add('light-theme');
        }

        document.getElementById("theme").addEventListener("change", function () {
            if (this.value === 'light') {
                document.body.classList.remove("dark-theme");
                document.body.classList.add("light-theme");
            } else {
                document.body.classList.remove("light-theme");
                document.body.classList.add("dark-theme");
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>
