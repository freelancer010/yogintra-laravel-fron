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
    <body class="font-sans text-slate-800 antialiased bg-[#f5f7f8]">
        <div class="min-h-screen flex items-center justify-center px-4 py-10">
            <div class="w-full sm:max-w-md overflow-hidden rounded-xl border border-slate-200 bg-white px-7 py-8 shadow-xl shadow-slate-300/40 sm:px-8" style="border-top: 4px solid #1a73e8;">
                <div class="mb-7 border-b border-slate-200 pb-6 text-center">
                    <x-application-logo class="mx-auto" style="height: 68px; width: auto; max-width: 260px;" />
                    <h1 class="mt-5 text-xl font-semibold text-slate-800">Sign in to your account</h1>
                    <p class="mt-1 text-sm text-slate-500">Use your YogIntra administrator credentials.</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
