<?php

declare(strict_types=1);

?>
{{-- Page Component --}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null,
    'data' => [],
])

@if (!empty($blocks))
    @foreach ($blocks as $block)
        {{-- BlockData ha già gestito tutto: vista, dati, fallback --}}
        {{-- Salta i blocchi non attivi --}}
        @if (property_exists($block, 'active') && !$block->active)
            @continue
        @endif
        @include($block->view, array_merge($data, $block->data, ['data' => $block->data]))
    @endforeach
@endif
