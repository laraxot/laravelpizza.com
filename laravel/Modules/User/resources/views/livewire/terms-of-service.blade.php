<?php

declare(strict_types=1);

?>
<div>
    @if ($text != null)
        <div>
            <x-filament::input.checkbox
                wire:click="testfunction"
                wire:model="accepted"
            />
            {{ $text }}
        </div>
    @endif
</div>
