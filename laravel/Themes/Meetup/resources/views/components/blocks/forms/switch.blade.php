@props([
    'type' => 'text',
    'variant' => 'default',
    'size' => 'md',
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'placeholder' => null,
    'value' => null,
    'name' => null,
    'id' => null,
    'label' => null,
    'help-text' => null,
    'error' => null,
    'success' => null,
    'addon-left' => null,
    'addon-right' => null,
    'icon-left' => null,
    'icon-right' => null,
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'searchable' => false,
    'rows' => 3,
    'cols' => null,
    'maxlength' => null,
    'minlength' => null,
    'accept' => null,
    'max-size' => null,
    'allowed-types' => null,
    'preview' => false,
    'checked' => false,
    'href' => null,
    'link-text' => null,
    'position' => null,
    'duration' => null,
])

@php
    $sizes = [
        'xs' => 'h-4 w-7',
        'sm' => 'h-5 w-9',
        'md' => 'h-6 w-11',
        'lg' => 'h-7 w-14',
        'xl' => 'h-8 w-16'
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    
    $baseClasses = "relative inline-flex {$sizeClasses} items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2";
    
    if ($checked) {
        $switchClasses = "{$baseClasses} bg-blue-600";
    } else {
        $switchClasses = "{$baseClasses} bg-gray-200";
    }
    
    if ($disabled) {
        $switchClasses .= ' opacity-50 cursor-not-allowed';
    }
    
    if ($error) {
        $switchClasses .= ' focus:ring-red-500';
    }
@endphp

<div class="space-y-1">
    <div class="flex items-start">
        <button 
            type="button"
            role="switch"
            aria-checked="{{ $checked ? 'true' : 'false' }}"
            {{ $attributes->merge(['class' => $switchClasses]) }}
            @if($disabled) disabled @endif
            @if($error) aria-invalid="true" aria-describedby="{{ $id ?? $name }}-error" @endif
            @if($help-text) aria-describedby="{{ $id ?? $name }}-help" @endif
        >
            <span class="sr-only">{{ $label ?? 'Toggle' }}</span>
            
            <span 
                class="inline-block {$sizeClasses} transform rounded-full bg-white transition-transform"
                :class="{ 'translate-x-5': checked, 'translate-x-0': !checked }"
            ></span>
        </button>
        
        @if($label)
            <div class="ml-3 text-sm">
                <label 
                    for="{{ $id ?? $name }}" 
                    class="font-medium text-gray-700 cursor-pointer"
                >
                    {{ $label }}
                    @if($required)
                        <span class="text-red-500 ml-1">*</span>
                    @endif
                </label>
                
                @if($help-text)
                    <p id="{{ $id ?? $name }}-help" class="text-gray-500 mt-1">
                        {{ $help-text }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    @if($error)
        <p id="{{ $id ?? $name }}-error" class="text-sm text-red-600" role="alert">
            {{ $error }}
        </p>
    @endif

    <!-- Hidden input for form submission -->
    <input 
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="{{ $value }}"
        class="sr-only"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        @if($required) required @endif
    >
</div> 