<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    <div class="space-y-6">
        @foreach($blocks as $block)
            <x-render.block :block="$block" />
        @endforeach
    </div>
</x-filament-panels::page>
