<?php

declare(strict_types=1);

?>
{{-- Page Component --}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null,
    'container0' => '',
    'slug0' => ''
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            {{-- BlockData è già gestito --}}
            @include($block->view, array_merge($block->data, ['container0' => $container0, 'slug0' => $slug0]))
        @endforeach
    </div>
@endif
