<?php

declare(strict_types=1);

?>
<div>
    <button
        type="button"
        class="flex items-center justify-center w-10 h-10 p-2 rounded-md focus:outline-none"
        wire:click="toggleDarkMode"
        aria-label="{{ $darkMode ? 'Disattiva modalità scura' : 'Attiva modalità scura' }}"
    >
        @if ($darkMode)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        @endif
    </button>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('darkModeUpdated', (event) => {
                const darkMode = event.darkMode;
                document.cookie = `dark_mode=${darkMode}; path=/; max-age=31536000`;

                if (darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });

            // Imposta la modalità scura iniziale in base al cookie
            const darkMode = {{ $darkMode ? 'true' : 'false' }};
            if (darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
</div>
