<?php

declare(strict_types=1);

?>
<x-layouts.main>
    <x-ui.marketing.header />

    <!-- Page Heading -->
    @if (isset($header))
        <header class="mb-6 bg-white shadow-sm border-b border-gray-100 dark:border-gray-800 dark:bg-gray-900/40">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Contenuto principale -->
    <div class="mx-auto py-6 max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>

    <!-- Breadcrumb opzionale -->
    @if (isset($breadcrumb))
        <div class="bg-gray-50 dark:bg-gray-800/30 py-3 border-t border-gray-100 dark:border-gray-800">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <nav class="flex text-sm text-gray-500 dark:text-gray-400">
                    {{ $breadcrumb }}
                </nav>
            </div>
        </div>
    @endif
</x-layouts.main>
