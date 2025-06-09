<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Yogintra'))</title>

        <!-- FAVICON -->
        <link href="{{ asset($app_setting->fevicon) }}" rel="shortcut icon" type="image/png">
        <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon">
        <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="72x72">
        <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="114x114">
        <link href="{{ asset($app_setting->fevicon) }}" rel="apple-touch-icon" sizes="144x144">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">    
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text" style="border-top:4px solid #007bff">
                <div class="flex justify-center mb-5">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </div>
                <hr class="mb-5">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
