{{-- Laraxot Architecture: Smart Layout Delegation --}}
@auth
    {{-- Authenticated: use dashboard layout with sidebar --}}
    <x-layouts.app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts.app.sidebar>
@else
    {{-- Guest: use public layout --}}
    <x-layouts.public>
        {{ $slot }}
    </x-layouts.public>
@endauth
