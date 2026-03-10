<?php

declare(strict_types=1);

?>
@php
    $disableNewRecordCreation = $disableNewRecordCreation ?? false;
    $disableNewChildRecordCreation = $disableNewChildRecordCreation ?? false;
    $disableRecordDeletion = $disableRecordDeletion ?? false;
    $disableRecordEdit = $disableRecordEdit ?? false;
    $disableRecordsSorting = $disableRecordsSorting ?? false;
@endphp

<x-filament-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    class="filament-navigation"
>
    <div wire:key="navigation-items-wrapper">
        <div
            class="space-y-2"
            x-data="navigationSortableContainer({
                statePath: @js($getStatePath())
            })"
            data-sortable-container
        >

            @forelse ($getState() as $uuid => $item)
                <x-ui::nav-item
                    :statePath="$getStatePath() . '.' . $uuid"
                    :item="$item"
                    :$disableNewChildRecordCreation
                    :$disableRecordEdit
                    :$disableRecordDeletion
                    :$disableRecordsSorting
                />
            @empty
                <div @class([
                    'w-full bg-white rounded-lg border border-gray-300 px-3 py-2 text-left',
                    'dark:bg-gray-700 dark:border-gray-600',
                ])>
                    {{ __('ui::filament-navigation.items.empty') }}
                </div>
            @endforelse
        </div>
    </div>

    @if (!$disableNewRecordCreation)
    <div class="flex justify-end">
        <x-filament::button wire:click="createItem" type="button" size="sm">
            {{ __('ui::filament-navigation.items.add-item') }}
        </x-filament::button>
    </div>
    @endif
</x-filament-forms::field-wrapper>
