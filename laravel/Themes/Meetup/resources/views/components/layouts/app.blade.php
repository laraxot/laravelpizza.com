<x-layouts.main>
    <x-section slug="header" tpl="v1" />
    <div class="bg-slate-900 text-white min-h-screen">
        {{ $slot }}
    </div>
    <x-section slug="footer" />
</x-layouts.main>
