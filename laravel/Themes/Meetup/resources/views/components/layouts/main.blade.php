<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <script>
        (function(){var d=document.documentElement;try{var v=localStorage.getItem('theme_dark');if(v==='false')d.classList.remove('dark');else d.classList.add('dark');}catch(e){d.classList.add('dark');}})();
    </script>
    <x-metatags>
        {{-- Meetup Theme Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        
    </x-metatags>
    <body class="font-sans antialiased bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white transition-colors duration-200">
        {{ $slot }}
    </body>
</html>
