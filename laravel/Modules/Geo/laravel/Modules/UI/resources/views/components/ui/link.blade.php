<?php

declare(strict_types=1);

?>
<a
    {{ $attributes->except('wire:navigate') }}
    wire:navigate
>
{{ $slot }}
</a>
