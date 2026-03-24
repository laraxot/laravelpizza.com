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
<<<<<<< HEAD
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
=======
        @foreach($blocks as $index => $block)
            @php
                $blockType = (string) data_get($block, 'type', 'content');
                $delayStep = (($index % 5) + 1);
            @endphp

            @php
                $isEnabled = $block->enabled ?? true;
            @endphp

            @if($isEnabled)
            <section
                class="reveal-kinetic kinetic-delay-{{ $delayStep }} page-block page-block-{{ str_replace('_', '-', $blockType) }}"
                data-kinetic-block
                data-block-index="{{ $index }}"
                data-block-type="{{ $blockType }}"
            >
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
                    @php
                        $viewParams = [];
                        foreach (($block->data['params'] ?? []) as $paramKey => $paramValue) {
                            $resolvedKey = str_ends_with($paramKey, '_key') ? substr($paramKey, 0, -4) : $paramKey;
                            if (str_ends_with($paramKey, '_key') && is_string($paramValue)) {
                                $parts = explode('.', $paramValue);
                                $val = $data;
                                foreach ($parts as $part) {
                                    $val = is_array($val) ? ($val[$part] ?? null) : (is_object($val) ? ($val->{$part} ?? null) : null);
                                }
                                $viewParams[$resolvedKey] = $val;
                            } else {
                                $viewParams[$resolvedKey] = $paramValue;
                            }
                        }
                        // Merge resolved params with data and block data, giving priority to resolved params
                        $mergedParams = array_merge($data, $block->data, $viewParams);
                    @endphp
                    @include($block->view, $mergedParams)
                @endif
            </section>
>>>>>>> c79a39e1e (.)
            @endif
        @endforeach
    </div>
@endif
