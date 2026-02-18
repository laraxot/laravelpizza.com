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
    'slug0' => '',
    'data' => []
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @include('cms::components.page-content', [
            'blocks' => $blocks,
            'data' => array_merge(['container0' => $container0, 'slug0' => $slug0], $data)
        ])
    </div>
@endif
