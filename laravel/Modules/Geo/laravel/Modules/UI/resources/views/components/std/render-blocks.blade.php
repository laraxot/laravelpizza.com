<?php

declare(strict_types=1);

?>
@props(['blocks'])

@foreach ($blocks as $block)
    {{-- OBSOLETE
    <x-render-block :block="$block" />
    --}}
@endforeach
