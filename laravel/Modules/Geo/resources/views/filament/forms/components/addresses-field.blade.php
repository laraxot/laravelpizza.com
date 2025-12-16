<?php

declare(strict_types=1);

?>
{{--
    Vista per il componente AddressesField.
    
    Questo componente renderizza un campo per la gestione di indirizzi multipli
    con logica avanzata per visibilità condizionale e gestione del campo primario.
--}}

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div class="filament-forms-addresses-field-component">
        {{-- Informazioni di aiuto per l'utente --}}
        @if (count($getChildComponentContainer()) > 0)
            <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            {{ trans('geo::addresses.field.help.title') }}
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>{{ trans('geo::addresses.field.help.description') }}</p>
                            @if ($field->doesManagePrimary())
                                <p class="mt-1">{{ trans('geo::addresses.field.help.primary_note') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Container dei componenti figlio (Repeater) --}}
        {{ $getChildComponentContainer() }}
    </div>
</x-dynamic-component>
