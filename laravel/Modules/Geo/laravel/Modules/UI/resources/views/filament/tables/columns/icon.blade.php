<?php

declare(strict_types=1);

?>
@php
    $icon = $getState();
@endphp

<div class="filament-icon-picker-icon-column px-4 py-3">
    @if($icon)
        <x-icon class="h-6" name="{{ $icon }}" />
    @endif
</div>
