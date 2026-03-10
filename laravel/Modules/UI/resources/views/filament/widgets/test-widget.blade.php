<?php

declare(strict_types=1);

?>
{{--
<div>
    @foreach ($widgets as $widget)
        @livewire($widget['class'], $widget['properties'])
    @endforeach

</div>
--}}
{{--
<x-filament::section icon="heroicon-o-user" collapsible>
    AAAAAAAA



--}}
<x-filament-widgets::widget>
    <x-filament::section collapsible>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="col-span-1">
                @livewire($widgets[0]['class'], $widgets[0]['properties'])

            </div>
            <div class="col-span-1">
                @livewire($widgets[1]['class'], $widgets[1]['properties'])<br />
                @livewire($widgets[2]['class'], $widgets[2]['properties'])
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
