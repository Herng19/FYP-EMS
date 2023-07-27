<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FYP-EMS') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/fyp-ems_icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Font Awesome Icon --}}
        <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css" >
        <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased flex min-h-screen">
        <x-side-navbar />
        {{-- seperation line --}}
        <div class="h-auto my-8 mx-2 border-l opacity-60 rounded-lg"></div>
        <div class="min-h-screen w-full">
            <!-- Page Heading -->
            <div class="flex max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 justify-between items-center">
                @if (isset($header))
                    <header>
                        <div class="">
                            {{ $header }}
                        </div>
                    </header>
                @endif                    
                @include('navigation-menu')
            </div>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
