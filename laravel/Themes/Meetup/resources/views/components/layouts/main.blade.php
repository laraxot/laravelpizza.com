<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags />
    <body class="font-sans antialiased bg-slate-900 text-white">
        {{ $slot }}
        @livewireScripts
    </body>
</html>
