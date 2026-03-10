<?php

declare(strict_types=1);

?>
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'mr-2 text-sm font-medium text-gray-700'
            : 'mr-2 text-sm font-medium text-gray-500 hover:text-gray-600';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
