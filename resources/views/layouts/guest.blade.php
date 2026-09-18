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
    <body class="font-sans text-slate-800 antialiased bg-[#f4f8f8]">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center px-4 py-10 overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-br from-[#123e49] via-[#176f79] to-[#39a6a0]"></div>
            <div class="absolute -top-20 -right-20 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-32 -left-20 h-72 w-72 rounded-full bg-[#9ed9ce]/35 blur-3xl"></div>
            <div class="relative w-full sm:max-w-md overflow-hidden rounded-2xl border border-white/80 bg-white/95 px-7 py-8 shadow-2xl shadow-[#123e49]/20 backdrop-blur sm:px-9">
                <div class="mb-7 text-center">
                    <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-[#f0faf9] ring-1 ring-[#cbe9e6]">
                        <x-application-logo class="h-16 w-16" />
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-[#174650]">Welcome back</h1>
                    <p class="mt-2 text-sm text-slate-500">Sign in to manage your YogIntra account.</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
