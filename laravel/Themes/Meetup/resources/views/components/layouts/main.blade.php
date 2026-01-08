<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        {{-- Meetup Theme Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        
    </x-metatags>
    <body class="font-sans antialiased bg-slate-900 text-white">
        {{ $slot }}
    </body>
</html>
