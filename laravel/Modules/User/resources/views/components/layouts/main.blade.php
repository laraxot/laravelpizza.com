<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="- La piattaforma">
        <meta name="keywords" content="">
        <meta name="author" content="il progetto">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Used to add dark mode right away, adding here prevents any flicker -->
        <script>
            if (typeof(Storage) !== "undefined") {
                if(localStorage.getItem('dark_mode') && localStorage.getItem('dark_mode') == 'true'){
                    document.documentElement.classList.add('dark');
                }
            }
        </script>

        <!-- Styles -->
        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'],'themes/One')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <title>{{ $title ?? '-' }}</title>
    </head>
    <body>
        <div>
            <!-- Contenuto principale -->
            <main>
                {{ $slot }}
            </main>

          
        </div>

        <!-- Notifiche e Script -->
        <livewire:toast />
        @livewire('notifications')
        @filamentScripts
        @vite(['resources/js/app.js'],'themes/One')
    </body>
</html>
