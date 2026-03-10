<?php

declare(strict_types=1);

?>
@php
    $record = $getRecord();

@endphp

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-1 p-1">
    @foreach ($column->getStateActions() as $action)
        {{ $action }}
    @endforeach
</div>
