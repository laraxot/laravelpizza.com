@props([
    'id' => 'accordion-' . uniqid(),
    'flush' => false,
])

<div 
    class="accordion{{ $flush ? ' accordion-flush' : '' }}" 
    id="{{ $id }}"
    {{ $attributes }}
>
    {{ $slot }}
</div>
