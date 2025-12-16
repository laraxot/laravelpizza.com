<?php

declare(strict_types=1);

?>
{{-- resources/views/forms/components/radio-collection.blade.php --}}
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="space-y-2">
        @foreach($getOptions() as $option)
            @php
                $optionValue = data_get($option, $getValueKey());
                $optionId = $getId() . '-' . $optionValue;
                $isSelected = $getState() == $optionValue;
            @endphp
            
            <div class="relative flex items-start">
                <div class="flex items-center h-5">
                    <input
                        id="{{ $optionId }}"
                        name="{{ $getId() }}"
                        type="radio"
                        value="{{ $optionValue }}"
                        wire:model.live="{{ $getStatePath() }}"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                        {{ $isSelected ? 'checked' : '' }}
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label 
                        for="{{ $optionId }}" 
                        class="block cursor-pointer font-medium text-gray-700 dark:text-gray-300"
                    >
                        @include($getItemView(), ['item' => $option])
                    </label>
                </div>
            </div>
        @endforeach
        
        {{-- Error display --}}
        @error($getStatePath())
            <div class="text-red-500 text-sm mt-2 flex items-center bg-red-50 dark:bg-red-900/20 p-3 rounded-lg border border-red-200 dark:border-red-800">
                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>
</x-dynamic-component>
