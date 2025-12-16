<?php

declare(strict_types=1);

?>
<div class="input-group"
    wire:ignore
    x-data={lookup:{}}
    x-init="() => {
        new AddressAutocomplete('.google-address-lookup', (result, raw) => {
            @this.set('lookup', result)
        });
    }"
    {{ $attributes }}
    >
    <input
        x-data
        x-on:address:list:refresh.window="$('.google-address-lookup').val('')"
        x-on:keydown.enter.prevent
        wire:ignore.self
        wire:loading.attr="readonly"
        autocomplete="google-lookup"
        class="form-control google-address-lookup"
        required
        type="search"
    >
</div>
