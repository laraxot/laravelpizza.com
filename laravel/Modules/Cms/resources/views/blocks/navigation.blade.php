<?php

declare(strict_types=1);

?>
@props(['data'])

@php
$items = $data['items'] ?? [];
$alignment = $data['alignment'] ?? 'start';
$orientation = $data['orientation'] ?? 'horizontal';
$locale = app()->getLocale();

$alignmentClasses = [
    'start' => 'justify-start',
    'center' => 'justify-center',
    'end' => 'justify-end'
];

$orientationClasses = [
    'horizontal' => 'flex space-x-4',
    'vertical' => 'flex flex-col space-y-2'
];

$buttonClasses = [
    'primary' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700',
    'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50',
    'default' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700'
];

$navClasses = $orientationClasses[$orientation] . ' ' . $alignmentClasses[$alignment];
@endphp

<nav class="{{ $navClasses }}">
    @foreach($items as $item)
        @php
            $type = $item['type'] ?? 'link';
            $label = is_array($item['label']) ? ($item['label'][$locale] ?? '') : ($item['label'] ?? '');
            $url = is_array($item['url']) ? ($item['url'][$locale] ?? '#') : ($item['url'] ?? '#');
            $hasChildren = isset($item['children']) && is_array($item['children']) && count($item['children']) > 0;
            $buttonStyle = $type === 'button' ? ($item['style'] ?? 'default') : 'default';
        @endphp

        @if($type === 'dropdown' && $hasChildren)
            <div class="relative group">
                <button class="flex items-center px-3 py-2 text-gray-700 hover:text-gray-900">
                    {{ $label }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="absolute left-0 hidden pt-2 group-hover:block z-50">
                    <div class="bg-white border rounded-md shadow-lg min-w-[200px]">
                        @foreach($item['children'] as $child)
                            @php
                                $childLabel = is_array($child['label']) ? ($child['label'][$locale] ?? '') : ($child['label'] ?? '');
                                $childUrl = is_array($child['url']) ? ($child['url'][$locale] ?? '#') : ($child['url'] ?? '#');
                                $childType = $child['type'] ?? 'link';
                                $style = $child['style'] ?? 'default';
                            @endphp
                            <a href="{{ $childUrl }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ $childLabel }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @elseif($type === 'button')
            <a href="{{ $url }}"
               class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium {{ $buttonClasses[$buttonStyle] }}">
                {{ $label }}
            </a>
        @else
            <a href="{{ $url }}"
               class="px-3 py-2 text-gray-700 hover:text-gray-900">
                {{ $label }}
            </a>
        @endif
    @endforeach
</nav>
