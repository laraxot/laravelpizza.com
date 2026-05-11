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
            aria-label="{{ __('geo::coordinate-picker.search_placeholder') }}"
            aria-autocomplete="list"
            aria-controls="coordinate-picker-search-results"
            :aria-expanded="showResults"
            class="fi-input block w-full border-none bg-white py-1.5 pl-10 pr-3 text-sm text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus-within:ring-2 focus-within:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/20 dark:focus-within:ring-primary-500 rounded-lg"
        >
        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4">
            <!-- <img src="{{-- asset('modules/geo/svg/magnifying-glass.svg') --}}" alt="search" class="w-4 h-4"> -->
            <x-heroicon-o-magnifying-glass class="w-4 h-4" />
        </div>
        <div x-show="isSearching" class="absolute right-3 top-1/2 -translate-y-1/2">
            <x-filament::loading-indicator class="h-4 w-4" />
        </div>
    </div>

    <ul
        x-show="showResults"
        @click.away="showResults = false"
        id="coordinate-picker-search-results"
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
