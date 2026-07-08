<?php

declare(strict_types=1);

?>
<div class="dark-mode-switcher-widget">
    <button 
        x-data="{ darkMode: {{ $darkMode ? 'true' : 'false' }} }"
        @click="
            darkMode = !darkMode;
            $dispatch('darkModeUpdated', { darkMode: darkMode });
            $wire.toggleDarkMode();
        "
        class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
        :class="{ 'bg-emerald-600': darkMode, 'bg-gray-200': !darkMode }"
        aria-label="Toggle dark mode"
    >
        <template x-if="darkMode">
            <x-heroicon-o-moon class="w-5 h-5 text-white" />
        </template>
        <template x-if="!darkMode">
            <x-heroicon-o-sun class="w-5 h-5 text-gray-700" />
        </template>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestione dell'evento darkModeUpdated
    Livewire.on('darkModeUpdated', (data) => {
        const { darkMode } = data;
        
        // Aggiorna il tema del documento
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Salva la preferenza nel localStorage
        localStorage.setItem('dark_mode', darkMode ? 'true' : 'false');
    });
    
    // Inizializza il tema al caricamento della pagina
    const savedDarkMode = localStorage.getItem('dark_mode');
    if (savedDarkMode === 'true') {
        document.documentElement.classList.add('dark');
    } else if (savedDarkMode === 'false') {
        document.documentElement.classList.remove('dark');
    }
});
</script>
