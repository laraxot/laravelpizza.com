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
        'xs' => 'h-3 w-3',
        'sm' => 'h-4 w-4',
        'md' => 'h-4 w-4',
        'lg' => 'h-5 w-5',
        'xl' => 'h-6 w-6'
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    
    $baseClasses = "rounded border-gray-300 text-blue-600 focus:ring-blue-500 {$sizeClasses}";
    
    if ($error) {
        $inputClasses = "{$baseClasses} border-red-300 focus:ring-red-500";
    } else {
        $inputClasses = $baseClasses;
    }
    
    if ($disabled) {
        $inputClasses .= ' opacity-50 cursor-not-allowed';
    }
@endphp

<div class="space-y-1">
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input 
                type="checkbox"
                name="{{ $name }}"
                id="{{ $id ?? $name }}"
                value="{{ $value }}"
                {{ $attributes->merge(['class' => $inputClasses]) }}
                @if($checked) checked @endif
                @if($disabled) disabled @endif
                @if($required) required @endif
                @if($error) aria-invalid="true" aria-describedby="{{ $id ?? $name }}-error" @endif
                @if($help-text) aria-describedby="{{ $id ?? $name }}-help" @endif
            >
        </div>
        
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
</div> 