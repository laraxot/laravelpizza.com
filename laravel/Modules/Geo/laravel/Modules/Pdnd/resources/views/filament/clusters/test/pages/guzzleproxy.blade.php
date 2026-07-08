resources/views/filament/pages/guzzle-proxy-test.blade.php --}}
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Form per la configurazione --}}
        {{ $this->form }}
        
        <x-filament::actions :actions="$this->getFormActions()" />

        
        
       
    </div>
</x-filament-panels::page>