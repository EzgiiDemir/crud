@extends('layouts.app')

@section('content')
@php
    $settings = json_decode(Auth::user()->settings, true) ?? ['notifications' => 'enabled', 'theme' => 'light'];
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const theme = "{{ $settings['theme'] }}";
        // Sayfa yüklendiğinde, kullanıcının seçtiği temayı uygula
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.add('light-theme');
        }

        // Tema seçeneği değiştiğinde sayfayı güncelle
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

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h3>Settings</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="notifications" class="form-label">Email Notifications:</label>
                            <select id="notifications" name="notifications" class="form-control">
                                <option value="enabled" {{ $settings['notifications'] == 'enabled' ? 'selected' : '' }}>Enabled</option>
                                <option value="disabled" {{ $settings['notifications'] == 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="theme" class="form-label">Theme:</label>
                            <select id="theme" name="theme" class="form-control">
                                <option value="light" {{ Auth::user()->theme === 'light' ? 'selected' : '' }}>Light</option>
                                <option value="dark" {{ Auth::user()->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Save Settings</button>
                            <a href="{{ route('account') }}" class="btn btn-secondary">Back to Profile</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Koyu tema için stiller */
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
@endsection
