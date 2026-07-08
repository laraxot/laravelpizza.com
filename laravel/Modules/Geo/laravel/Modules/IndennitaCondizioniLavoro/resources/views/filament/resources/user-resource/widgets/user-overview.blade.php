lament::widget>
    <x-filament::card>
        {{-- Widget content --}}
        @php
            /*
            dddx([
                'get_defined_vars()'=>get_defined_vars(),
                '$this'=>$this,
                'get_class_methods'=>get_class_methods($this),
            ]);
            */
        @endphp
        {{ $record?->id }}
    </x-filament::card>
</x-filament::widget>
