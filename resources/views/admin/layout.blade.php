<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6393908257919272"
     crossorigin="anonymous"></script>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex-1">
            @include('admin.partials.topbar')

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
