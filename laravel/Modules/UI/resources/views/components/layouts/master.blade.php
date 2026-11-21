<?php

declare(strict_types=1);
?>
{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout

  PTVX: niente cms::head/foot. Owner = UI. Styles in head, Scripts a fine body.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        {{-- OBBLIGATORIO in <head> --}}
        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        {{ $slot }}

        @livewire('notifications')

        {{-- OBBLIGATORIO a fine <body> --}}
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
