<?php

declare(strict_types=1);

?>
@props(['widget'])
<div>
    @php
        $canRenderWidget = class_exists($widget)
            && (! method_exists($widget, 'canView') || $widget::canView());
    @endphp

    @if($canRenderWidget)
        @livewire($widget, $block->data)
    @endif
</div>
