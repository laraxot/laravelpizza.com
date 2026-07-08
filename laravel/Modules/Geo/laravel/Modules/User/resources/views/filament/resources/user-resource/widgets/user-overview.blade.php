<?php

declare(strict_types=1);

?>
<x-filament::widget>
    <x-filament::card>
        {{-- Widget content --}}
        @php
            // Debug information if needed
            // dddx([
            //     'get_defined_vars()' => get_defined_vars(),
            //     '$this' => $this,
            //     'get_class_methods' => get_class_methods($this),
            // ]);
        @endphp
        {{ $record->name ?? 'Utente' }}
    </x-filament::card>
</x-filament::widget>
