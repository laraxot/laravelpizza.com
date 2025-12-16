<?php

declare(strict_types=1);

?>
@props(['widget'])
<div>
    {{--  
    <x-dynamic-component :component="$widget" />
    --}}
    
    @livewire($widget, $block->data)
</div>
