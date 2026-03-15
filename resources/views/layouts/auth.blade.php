<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PotatoTools')</title>
    <meta name="description" content="@yield('description', 'Simple and practical online tools.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="PotatoTools">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'PotatoTools')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('description', 'Simple and practical online tools.')))">
    <meta property="og:url" content="@yield('canonical', url()->current())">

    @stack('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-potato-beige">
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
