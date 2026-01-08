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
    $variants = [
        'default' => [
            'border' => 'border-gray-300',
            'focus' => 'focus:border-blue-500 focus:ring-blue-500',
            'error' => 'border-red-300 focus:border-red-500 focus:ring-red-500',
            'success' => 'border-green-300 focus:border-green-500 focus:ring-green-500'
        ]
    ];

    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-3 text-base',
        'xl' => 'px-6 py-4 text-lg'
    ];

    $variantClasses = $variants[$variant] ?? $variants['default'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    
    $baseClasses = "block w-full rounded-lg border transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 {$sizeClasses}";
    
    if ($error) {
        $inputClasses = "{$baseClasses} {$variantClasses['error']}";
    } elseif ($success) {
        $inputClasses = "{$baseClasses} {$variantClasses['success']}";
    } else {
        $inputClasses = "{$baseClasses} {$variantClasses['border']} {$variantClasses['focus']}";
    }
    
    if ($disabled) {
        $inputClasses .= ' opacity-50 cursor-not-allowed bg-gray-100';
    }
    
    if ($readonly) {
        $inputClasses .= ' bg-gray-50';
    }
    
    // Aggiungi padding per icone
    if ($icon-left) {
        $inputClasses .= ' pl-10';
    }
    
    if ($icon-right) {
        $inputClasses .= ' pr-10';
    }
@endphp

<div class="space-y-1">
    @if($label)
        <label 
            for="{{ $id ?? $name }}" 
            class="block text-sm font-medium text-gray-700"
        >
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($addon-left)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $addon-left }}</span>
            </div>
        @endif

        @if($icon-left)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-dynamic-component :component="$icon-left" class="h-5 w-5 text-gray-400" />
            </div>
        @endif

        <input 
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => $inputClasses]) }}
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
            @if($error) aria-invalid="true" aria-describedby="{{ $id ?? $name }}-error" @endif
            @if($help-text) aria-describedby="{{ $id ?? $name }}-help" @endif
        >

        @if($addon-right)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $addon-right }}</span>
            </div>
        @endif

        @if($icon-right)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-dynamic-component :component="$icon-right" class="h-5 w-5 text-gray-400" />
            </div>
        @endif
    </div>

    @if($error)
        <p id="{{ $id ?? $name }}-error" class="text-sm text-red-600" role="alert">
            {{ $error }}
        </p>
    @endif

    @if($success)
        <p class="text-sm text-green-600">
            {{ $success }}
        </p>
    @endif

    @if($help-text)
        <p id="{{ $id ?? $name }}-help" class="text-sm text-gray-500">
            {{ $help-text }}
        </p>
    @endif
</div> 