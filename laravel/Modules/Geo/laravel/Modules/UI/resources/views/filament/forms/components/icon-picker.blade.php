<?php

declare(strict_types=1);

?>
{{--
<x-filament-forms::field-wrapper :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()"
    :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="{ state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }} }" class="flex items-center space-x-4">

            <button type="button" x-on:click="state = @js($color)"
                class="rounded-full w-8 h-8 border border-gray-300 appearance-none inline-flex items-center justify-center"
                x-bind:class="{
                    'ring-2 ring-gray-300 ring-offset-2': state === @js($color),
                }"
                style="background: {{ $color }}" title="{{ $label }}">
                <span class="sr-only">
                    {{ $label }}
                </span>

                <span x-show="state === @js($color)" x-cloak>
                    <x-heroicon-o-check class="w-4 h-4 text-gray-400" />
                </span>
            </button>

    </div>
</x-filament-forms::field-wrapper>
--}}
