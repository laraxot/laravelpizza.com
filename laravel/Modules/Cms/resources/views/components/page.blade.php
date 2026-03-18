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

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            @if(isset($block->data['component']))
                @php
                    $livewireParams = [];
                    foreach (($block->data['params'] ?? []) as $paramKey => $paramValue) {
                        $resolvedKey = str_ends_with($paramKey, '_key') ? substr($paramKey, 0, -4) : $paramKey;
                        if (str_ends_with($paramKey, '_key') && is_string($paramValue)) {
                            $parts = explode('.', $paramValue);
                            $val = $data;
                            foreach ($parts as $part) {
                                $val = is_array($val) ? ($val[$part] ?? null) : (is_object($val) ? ($val->{$part} ?? null) : null);
                            }
                            $livewireParams[$resolvedKey] = $val;
                        } else {
                            $livewireParams[$resolvedKey] = $paramValue;
                        }
                    }
                @endphp
                @livewire($block->data['component'], $livewireParams)
            @else
                @include($block->view, array_merge($data, $block->data))
            @endif
        @endforeach
    </div>
@endif
