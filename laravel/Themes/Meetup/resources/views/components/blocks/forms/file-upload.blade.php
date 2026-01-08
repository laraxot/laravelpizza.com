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
    $baseClasses = "block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors";
    
    if ($error) {
        $inputClasses = "{$baseClasses} border-red-300 focus:border-red-500 focus:ring-red-500";
    } elseif ($success) {
        $inputClasses = "{$baseClasses} border-green-300 focus:border-green-500 focus:ring-green-500";
    } else {
        $inputClasses = "{$baseClasses} border-gray-300 focus:border-blue-500 focus:ring-blue-500";
    }
    
    if ($disabled) {
        $inputClasses .= ' opacity-50 cursor-not-allowed';
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
        <input 
            type="file"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            accept="{{ $accept }}"
            {{ $attributes->merge(['class' => $inputClasses]) }}
            @if($multiple) multiple @endif
            @if($disabled) disabled @endif
            @if($required) required @endif
            @if($error) aria-invalid="true" aria-describedby="{{ $id ?? $name }}-error" @endif
            @if($help-text) aria-describedby="{{ $id ?? $name }}-help" @endif
            @if($max-size) data-max-size="{{ $max-size }}" @endif
            @if($allowed-types) data-allowed-types="{{ $allowed-types }}" @endif
        >
    </div>

    @if($preview)
        <div id="{{ $id ?? $name }}-preview" class="mt-2 grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            <!-- Preview area for selected files -->
        </div>
    @endif

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

    @if($max-size || $allowed-types)
        <div class="mt-1 text-xs text-gray-500">
            @if($max-size)
                <p>Dimensione massima: {{ $max-size }}</p>
            @endif
            @if($allowed-types)
                <p>Tipi consentiti: {{ $allowed-types }}</p>
            @endif
        </div>
    @endif
</div>

@if($preview)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('{{ $id ?? $name }}');
    const preview = document.getElementById('{{ $id ?? $name }}-preview');
    
    input.addEventListener('change', function(e) {
        preview.innerHTML = '';
        
        if (this.files) {
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                const previewItem = document.createElement('div');
                previewItem.className = 'relative';
                
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" alt="${file.name}" class="h-20 w-20 object-cover rounded-lg">
                            <p class="text-xs text-gray-500 mt-1 truncate">${file.name}</p>
                        `;
                    } else {
                        previewItem.innerHTML = `
                            <div class="h-20 w-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-o-document class="h-8 w-8 text-gray-400" />
                            </div>
                            <p class="text-xs text-gray-500 mt-1 truncate">${file.name}</p>
                        `;
                    }
                };
                
                reader.readAsDataURL(file);
                preview.appendChild(previewItem);
            });
        }
    });
});
</script>
@endif 