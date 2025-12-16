<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    <form wire:submit="submit" class="space-y-6">
        {{ $this->form }}
        
        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Stato del form:</h3>
            <pre class="bg-white dark:bg-gray-900 p-4 rounded text-sm overflow-x-auto">{{ json_encode($this->data, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </form>
</x-filament-panels::page>
