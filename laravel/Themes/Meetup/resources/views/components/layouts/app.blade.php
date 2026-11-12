@props(['title' => null, 'description' => null])
<x-layouts.main :title="$title" :description="$description">

    <x-section slug="header"/>

    <main id="main-content">
        {{ $slot }}
    </main>

    <x-section slug="footer"/>

</x-layouts.main>
