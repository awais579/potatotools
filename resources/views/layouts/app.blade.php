<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PotatoTools - Fast, practical online calculators')</title>
    <meta name="description" content="@yield('description', 'Simple and accurate conversion tools for everyday practical needs.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="PotatoTools">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'PotatoTools')))">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('description', 'Simple and accurate conversion tools for everyday practical needs.')))">
    <meta property="og:url" content="@yield('canonical', url()->current())">

    @stack('head')
    <style>
        .pt-link-arrow {
            transition: color 0.2s ease;
        }

        .pt-link-arrow .pt-link-arrow-icon {
            display: inline-block;
            transform: translateX(0);
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        .pt-link-arrow:hover .pt-link-arrow-icon,
        .pt-link-arrow:focus-visible .pt-link-arrow-icon {
            transform: translateX(6px);
        }

        .pt-tool-card {
            cursor: pointer;
            transition: box-shadow 0.22s ease, border-color 0.22s ease,
                background-color 0.22s ease;
        }

        .pt-tool-card:hover,
        .pt-tool-card:focus-within {
            border-color: #e7c79a;
            background-color: #fffdf9;
            box-shadow: 0 10px 24px rgba(32, 24, 16, 0.12),
                0 0 0 1px rgba(198, 134, 45, 0.12);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <div class="relative">
        @include('components.navbar')
        <main>
            @yield('content')
        </main>
        @include('components.footer')
    </div>

    @stack('scripts')
</body>
</html>
