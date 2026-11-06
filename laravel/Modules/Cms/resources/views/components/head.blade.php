<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @head
    <style>[x-cloak] { display: none !important; }</style>
    <script>
        if (typeof Storage !== 'undefined' && localStorage.getItem('dark_mode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
    @livewireStyles
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/Two')
    @stack('head')
    @stack('styles')
</head>
