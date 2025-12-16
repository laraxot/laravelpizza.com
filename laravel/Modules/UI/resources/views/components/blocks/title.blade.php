<?php

declare(strict_types=1);

?>
@props(['text', 'level'])
@if($level != null)
    <{{ $level }}>{{ $text }}</{{ $level }}>
@else
    {{ $text }}
@endif
