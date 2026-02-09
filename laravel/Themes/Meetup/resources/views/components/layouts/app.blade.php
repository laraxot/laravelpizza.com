<x-layouts.main>
    
    <x-section slug="header"/>
    
    <main id="main-content">
        {{ $slot }}
    </main>
   
    <x-section slug="footer"/>
   
</x-layouts.main>
