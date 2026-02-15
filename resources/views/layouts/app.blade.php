<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'CRM') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen">

        {{-- Top Navigation --}}
        @include('layouts.navigation')

        {{-- Page Heading (يدعم Breeze header slot + يدعم yield لو تبغاه لاحقًا) --}}
        @isset($header)
            <header class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-6 py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content: يدعم صفحات x-app-layout (slot) + صفحات @extends (yield) --}}
        <main>
            @isset($slot)
                {{ $slot }}
            @endisset

            @yield('content')
        </main>

    </div>
</body>
</html>
