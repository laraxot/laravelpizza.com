<?php

declare(strict_types=1);

?>
{{--
/**
 * ContactColumn View - Rendering contatti con icone Heroicon
 * 
 * Utilizza ContactTypeEnum per icone, colori e etichette centralizzate
 * Supporta accessibilità WCAG 2.1 AA con ARIA roles e labels
 * 
 * @var \Illuminate\Database\Eloquent\Model $record
 * @var array $contacts - Array di contatti dal helper getContactsForColumn()
 * 
 * @author Laraxot Team
 * @version 2.0 - REFACTOR COMPLETO
 * @since 2025-08-01
 */
--}}

@php
    use Modules\Notify\Enums\ContactTypeEnum;
    
    $record = $getRecord();
    // Ottieni i contatti dal helper del modello
    $contacts = method_exists($record, 'getContactsForColumn') 
        ? $record->getContactsForColumn() 
        : [];
@endphp

@if(empty($contacts))
    <span class="text-gray-400 text-sm italic" role="status" aria-label="Nessun contatto">
        Nessun contatto
    </span>
@else
    <div class="flex flex-wrap gap-2 items-center" role="list" aria-label="Lista contatti">
        @foreach($contacts as $contact)
            @php
                try {
                    $enumCase = ContactTypeEnum::from($contact['type']);
                    $iconName = $enumCase->getIcon();
                    $colorClass = $enumCase->getColor();
                    $label = $enumCase->getLabel();
                    $ariaLabel = $label . ': ' . $contact['value'];
                } catch (ValueError $e) {
                    // Fallback per tipi non riconosciuti
                    continue;
                }
            @endphp
            
            <div role="listitem" class="inline-flex items-center {{ $colorClass }} transition-colors duration-200">
                @if($contact['href'] ?? false)
                    {{-- Link cliccabile per contatti interattivi --}}
                    <a 
                        href="{{ $contact['href'] }}" 
                        class="inline-flex items-center {{ $colorClass }} hover:underline group"
                        title="{{ $ariaLabel }}"
                        aria-label="{{ $ariaLabel }}"
                        @if($contact['type'] === 'whatsapp') target="_blank" rel="noopener noreferrer" @endif
                    >
                        <x-filament::icon 
                            :name="$iconName" 
                            class="w-4 h-4 flex-shrink-0" 
                            aria-hidden="true"
                        />
                        <span class="ml-1 text-xs font-medium hidden sm:inline-block group-hover:underline">
                            {{ Str::limit($contact['value'], 15) }}
                        </span>
                    </a>
                @else
                    {{-- Non-clickable contact (like fax) --}}
                    <span 
                        class="inline-flex items-center {{ $colorClass }}"
                        title="{{ $ariaLabel }}"
                        aria-label="{{ $ariaLabel }}"
                    >
                        <x-filament::icon 
                            :name="$iconName" 
                            class="w-4 h-4 flex-shrink-0" 
                            aria-hidden="true"
                        />
                        <span class="ml-1 text-xs font-medium hidden sm:inline-block">
                            {{ Str::limit($contact['value'], 15) }}
                        </span>
                    </span>
                @endif
            </div>
        @endforeach
    </div>
@endif
                    
                    <span class="ml-1 text-xs font-medium group-hover:underline">
                        {{ $contact['display_value'] ?? $contact['value'] }}
                    </span>
                </a>
            @else
                {{-- Contatto non cliccabile (es. fax) --}}
                <div class="inline-flex items-center {{ $enumCase->getColor() }}"
                     role="listitem"
                     aria-label="{{ $enumCase->getLabel() }}: {{ $contact['value'] }}"
                     title="{{ $contact['value'] }}">
                    
                    @svg($enumCase->getIcon(), 'w-4 h-4 flex-shrink-0', ['aria-hidden' => 'true'])
                    
                    <span class="ml-1 text-xs font-medium">
                        {{ $contact['display_value'] ?? $contact['value'] }}
                    </span>
                </div>
            @endif
        @endif
    @empty
        <span class="text-gray-400 text-sm italic" 
              role="status" 
              aria-label="{{ __('notify::contact-column.aria_labels.no_contacts') }}">
            {{ __('notify::contact-column.no_contacts') }}
        </span>
    @endforelse
</div>
