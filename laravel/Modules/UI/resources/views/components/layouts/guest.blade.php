<?php

declare(strict_types=1);

?>
<x-layouts.main>
    <div class="flex min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <x-ui.logo class="h-12 w-auto" />
            </div>
            @if(isset($title))
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $title }}
            </h2>
            @endif
            @if(isset($subtitle))
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                {{ $subtitle }}
            </p>
            @endif
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100 dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts.main>
