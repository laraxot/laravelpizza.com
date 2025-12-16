<?php

declare(strict_types=1);

?>
@props([
    'section' => null,
    'name' => null,
    'blocks' => [],
    'class' => '',
    'id' => null
])

<section {{ $attributes->merge([
    'class' => 'section '.($section?->slug ?? '').' '.$class,
    'id' => $id ?? ($section?->slug ?? '')
]) }}>
    @if($name)
        <h2 class="section-title">{{ $name }}</h2>
    @endif

    @if($blocks)
        <div class="section-blocks">
            @foreach($blocks as $block)
                @if(isset($block->view, $block->data))
                    @include($block->view, $block->data)
                @elseif(isset($block['type'], $block['data']))
                    <x-dynamic-component
                        :component="'cms::blocks.'.$block['type']"
                        :data="$block['data']"
                    />
                @endif
            @endforeach
        </div>
    @endif
</section>
