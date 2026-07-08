<x-filament-panels::page>
     <form wire:submit="completion">
         {{ $this->completionForm }}

        {{-- Filament v4: replaced deprecated component with a simple submit button --}}
        <x-filament::button type="submit">
            {{ __('Run completion') }}
        </x-filament::button>

     </form>
 </x-filament-panels::page>
