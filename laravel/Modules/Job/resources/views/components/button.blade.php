<?php

declare(strict_types=1);

?>
<x-job::icon-button :attributes="\Filament\Support\prepare_inherited_attributes($attributes)" :dark-mode="config('tables.dark_mode')">
    {{ $slot }}
</x-job::icon-button>
