@props(['title' => null, 'description' => null])
<x-layouts.main :title="$title" :description="$description">

    <x-section slug="header"/>

    {{-- Messaggio dopo un redirect (es. "Account eliminato"): session()->flash('status_message', ...) --}}
    @if(session('status_message'))
        <div role="status" class="bg-green-700 px-4 py-3 text-center text-sm font-medium text-white">{{ session('status_message') }}</div>
    @endif

    <main id="main-content">
        {{ $slot }}
    </main>

    <x-section slug="footer"/>

    {{-- Assistente AI: solo utenti collegati e con un fornitore AI configurato (story 7-5) --}}
    @auth
        <x-ui.assistant />
    @endauth

</x-layouts.main>
