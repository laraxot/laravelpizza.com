<?php
    declare(strict_types=1);
    $record = $getRecord();
?>

<div class="flex flex-wrap gap-3">
    @foreach ($contact_types as $contact_type)
        @php
            $contact_value = $record->{$contact_type->value};
        @endphp

        @if ($contact_value)
       

            <div class="inline-flex items-center gap-1">

                {{-- Icona del contatto --}}
                <x-filament::icon 
                    :icon="$contact_type->getIcon()" 
                    class="h-5 w-5 text-gray-600"
                />

                {{-- Valore --}}
                <span class="text-sm font-medium">
                    {{ $contact_value }}
                </span>
            </div>
           
        @endif
    @endforeach
</div>
