<?php

declare(strict_types=1);

?>
@props(['data'])

@php
$items = $data['items'] ?? [];
$alignment = $data['alignment'] ?? 'start';
$gap = $data['gap'] ?? 4;
$locale = app()->getLocale();

$alignmentClasses = [
    'start' => 'justify-start',
    'center' => 'justify-center',
    'end' => 'justify-end'
];

$gapClasses = [
    2 => 'space-x-2',
    3 => 'space-x-3',
    4 => 'space-x-4',
    5 => 'space-x-5',
    6 => 'space-x-6',
    8 => 'space-x-8'
];

$buttonClasses = [
    'primary' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700',
    'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50',
    'outline' => 'border-primary-600 text-primary-600 bg-transparent hover:bg-primary-50',
    'link' => 'text-primary-600 hover:text-primary-900 underline',
    'default' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700'
];

$containerClasses = 'flex items-center ' .
                   ($alignmentClasses[$alignment] ?? $alignmentClasses['start']) . ' ' .
                   ($gapClasses[$gap] ?? $gapClasses[4]);
@endphp

<div class="{{ $containerClasses }}">
    @foreach($items as $item)
        @php
            $type = $item['type'] ?? 'button';
            $style = $item['style'] ?? 'default';
            $label = is_array($item['label']) ? ($item['label'][$locale] ?? '') : ($item['label'] ?? '');
            $url = is_array($item['url']) ? ($item['url'][$locale] ?? '#') : ($item['url'] ?? '#');
            $icon = $item['icon'] ?? null;
            $target = $item['target'] ?? '_self';
        @endphp

        <a href="{{ $url }}"
           target="{{ $target }}"
           @class([
               'inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500',
               $buttonClasses[$style] ?? $buttonClasses['default'],
               'gap-2' => $icon
           ])>
            @if($icon)
                <x-dynamic-component :component="$icon" class="w-5 h-5" />
            @endif
            {{ $label }}
        </a>
    @endforeach
</div>
