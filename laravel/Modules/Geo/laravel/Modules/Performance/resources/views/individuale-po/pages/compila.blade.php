<x-filament::page>
    @include($view.'.head')
    
	
    
    
    <table class="w-full border-collapse border border-gray-300" style=" ">
        <tr style="border-bottom: 1px solid #e0e0e0; ">
			<td class="border border-gray-300 px-4 py-2">
                <b>Criterio</b>
            </td>   
            <td class="border border-gray-300 px-4 py-2">
                <b>Descrizione</b>
            </td>   

            
            <td class="border border-gray-300 px-4 py-2">
                <b>Valutazione</b>
            </td>   
            <td class="border border-gray-300 px-4 py-2">
                <b>Peso</b>
            </td>   
        </tr>
		@foreach($record->getCriteriOptionsRoot() as $root)
		<tr style="border-bottom: 1px solid #e0e0e0; ">
			<td class="border border-gray-300 px-4 py-2">
                <div class="flex whitespace-normal " >
                    <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white  "style="" >
                        {!! $root->txt !!}
                    </span>
                </div>
			</td>
            <td class="border border-gray-300 px-4 py-2">
                <table class="w-full border-collapse border border-gray-300">
                    @php   
                    
                        $sons=$root->sons()->where('option_type', $root->option_type)->ordered()->get();
                    @endphp
                @foreach($sons as $son)
                    <tr style="border-bottom: 1px solid #e0e0e0; ">
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex whitespace-normal max-w-max" >
                                <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white  "style="" >
                                    {!! $son->txt !!}
                                </span>
                            </div>
                        </td>
                         <td class="border border-gray-300 px-4 py-2">
                            <div class="flex whitespace-normal max-w-max " >
                                <span class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white "style="" >
                                    {!! $son->txt1 !!}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </table>



            </td>
            <td class="border border-gray-300 px-4 py-2">
                {{-- $root->value --}}
                <x-filament::input.wrapper  :valid="! $errors->has('data.'.$root->value)">
                    <x-filament::input
                        type="text"
                        wire:model.live="data.{{  $root->value }}"
                    />
                </x-filament::input.wrapper>
                @error('data.'.$root->value) 
                <x-filament::section>
                    <span class="text-danger-600 hover:text-danger-700" style="" >
                        {{ $message }}
                    </span>
                </x-filament::section>
               @enderror
            </td>

            <td class="border border-gray-300 px-4 py-2">
                &nbsp;{{ $record->getPeso($root->value) }}
            </td>
		</tr>
		@endforeach
        <tr>
            <td class="border border-gray-300 px-4 py-2">
                &nbsp;
            </td>
            <td class="border border-gray-300 px-4 py-2">
                <label>
                    <x-filament::input.checkbox wire:model="excellence" />
                    <span>
                        Eccellente ?
                    </span>
                </label>
            </td>
            <td class="border border-gray-300 px-4 py-2">
                <b>Totale</b>
            </td>
            <td class="border border-gray-300 px-4 py-2">
                {{ $totale }}
                 <x-filament::icon-button
                        icon="heroicon-o-arrow-path"
                        wire:click="recalculate()"
                        label="Ricalcola"
                        tooltip="Ricalcola"
                    >
                    ricalcola
                </x-filament::icon-button>
            </td>
        </tr>
	</table>
    

    @if ($errors->any())
    <div class="text-danger-600 hover:text-danger-700">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    
   <x-filament::tabs>
     <x-filament::tabs.item>
        <x-filament::icon-button
            icon="heroicon-o-arrow-uturn-left"
            wire:click="back()"
            label="Torna alla lista"
            tooltip="Torna alla lista"
        >
        Back
        </x-filament::icon-button>
    </x-filament::tabs.item>
    <x-filament::tabs.item>
        <x-filament::icon-button
            icon="fas-save"
            wire:click="save()"
            label="Conferma"
            tooltip="Conferma"
        >
        Conferma
        </x-filament::icon-button>
    </x-filament::tabs.item>
    </x-filament::tabs>
    <br /><br />
    <br />
    <br />
    <br />
    {{--  
    <pre>{{  print_r($data,true) }}</pre>
    --}}
</x-filament::page>
