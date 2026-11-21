<x-layouts.main>
    
    <x-section slug="header"/>
    
    <main id="main-content">
        {{ $slot }}
    </main>
   
    <x-section slug="footer"/>
<<<<<<< .merge_file_38qu0Q

    {{-- Assistente AI: solo utenti collegati e con un fornitore AI configurato (story 7-5) --}}
    @auth
        <x-ui.assistant />
    @endauth

=======
   
>>>>>>> .merge_file_V3rWM7
</x-layouts.main>
