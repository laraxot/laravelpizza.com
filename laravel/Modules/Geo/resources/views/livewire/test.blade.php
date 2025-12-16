<?php

declare(strict_types=1);

?>
<div>
{{ Theme::add('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js') }}
    {{ __FILE__ }}{{ __LINE__ }}
    <form wire:submit.prevent="createAddress">
    <div class="form-group" >
        <x-geo::google-address-lookup wire:model.lazy="lookup" />
    </div>
    <div class="form-group">
        <button
            type="submit"
            class="btn btn-outline-secondary"
            wire:submit.prevent="createAddress">{{__('Add Address')}}</button>
    </div>
    </form>
</div>
