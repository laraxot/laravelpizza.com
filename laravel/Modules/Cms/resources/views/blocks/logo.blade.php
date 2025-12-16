<?php

declare(strict_types=1);

?>
@props(['block'])

@php
$type = $block->data['type'] ?? 'both';
$text = $block->data['text'] ?? '';
$image = $block->data['image'] ?? '';
$alt = $block->data['alt'] ?? '';
$width = $block->data['width'] ?? 'auto';
$height = $block->data['height'] ?? 'auto';
$url = $block->data['url'] ?? '/';
@endphp

<a href="{{ $url }}" class="flex items-center">
    @if($type !== 'text')
        <img
            src="{{ $image }}"
            alt="{{ $alt }}"
            width="{{ $width }}"
            height="{{ $height }}"
            class="h-8 w-auto"
        />
    @endif

    @if($type !== 'image')
        <span class="ml-2 text-xl font-bold text-gray-900">
            {{ $text }}
        </span>
    @endif
</a>
