<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        {{-- Meetup Theme Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @verbatim
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "Laravel Pizza Meetups",
          "description": "Community of Laravel developers who meet for pizza and knowledge sharing",
          "url": "https://laravelpizza.com"
        }
        </script>
        @endverbatim
    </x-metatags>
    <body class="font-sans antialiased bg-slate-900 text-white">
        {{-- Navigation --}}
        <x-navigation />

        {{-- Main Content --}}
        <main id="main-content">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <x-footer />

        @livewireScripts
    </body>
</html>
