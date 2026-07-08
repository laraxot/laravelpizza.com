<x-filament::page>
    <div class="fi-header">
        <h3 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
            {!! $this->record->msg('titolo') !!}
        </h3>
    </div>

    <div class="space-y-6">
        

        {{ $this->infolist  }}

        {{ $this->form }}

        <div class="flex items-center gap-x-3">
             <x-filament::button
                color="gray"
                tag="a"
                :href="static::$resource::getUrl('index')"
            >
                Back
            </x-filament::button>

             <x-filament::button
                type="button"
                wire:click="save()"
            >
                Salva
            </x-filament::button>
        </div>

        @if($this->record->msg('legenda'))
             <div class="fi-section p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <h3 class="text-lg font-medium tracking-tight text-gray-950 dark:text-white border-b pb-2 mb-4">Legenda</h3>
                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    {!! $this->record->msg('legenda') !!}
                </div>
            </div>
        @endif
    </div>
</x-filament::page>