{{-- Reusable Alpine contract:
     expects: searchQuery, searchAddress(), showResults, searchResults, selectSearchResult(), isSearching --}}
<div class="relative items-center gap-2" x-show="!isFullscreen">
    <div class="relative group">
        <input
            type="text"
            x-model="searchQuery"
            @input.debounce.500ms="searchAddress()"
            @keydown.escape="showResults = false"
            placeholder="{{ __('geo::coordinate-picker.search_placeholder') }}"
            class="fi-input block w-full border-none bg-white py-1.5 pl-10 pr-3 text-sm text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus-within:ring-2 focus-within:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/20 dark:focus-within:ring-primary-500 rounded-lg"
        >
        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <div x-show="isSearching" class="absolute right-3 top-1/2 -translate-y-1/2">
            <x-filament::loading-indicator class="h-4 w-4" />
        </div>
    </div>

    <ul
        x-show="showResults"
        @click.away="showResults = false"
        class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10"
    >
        <template x-for="res in searchResults" :key="res.place_id">
            <li
                    @click="selectSearchResult(res)"
                    class="cursor-pointer px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-white/5"
            >
                <span x-text="res.display_name"></span>
            </li>
        </template>
    </ul>
</div>
