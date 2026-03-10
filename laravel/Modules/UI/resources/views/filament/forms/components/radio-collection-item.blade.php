<?php

declare(strict_types=1);

?>
{{-- resources/views/forms/components/radio-collection-item.blade.php --}}
{{-- Template di esempio per un item - personalizzalo secondo le tue esigenze --}}
<div class="flex items-center">
    @if(isset($item->image))
        <img src="{{ $item->image }}" alt="{{ $item->name ?? '' }}" class="w-10 h-10 rounded-full mr-3">
    @endif
    
    <div>
        <div class="font-medium text-gray-900 dark:text-white">
            {{ $item->name ?? $item->title ?? 'N/A' }}
        </div>
        
        @if(isset($item->description))
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $item->description }}
            </div>
        @endif
        
        @if(isset($item->price))
            <div class="text-sm font-semibold text-primary-600 dark:text-primary-400">
                €{{ number_format($item->price, 2) }}
            </div>
        @endif
    </div>
</div>
