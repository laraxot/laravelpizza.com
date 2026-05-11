<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <div x-data="{ loading: false }" x-init="loading = true; getLocation()">
        <template x-if="loading">
            <div class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm">Recupero posizione...</span>
            </div>
        </template>
        <template x-if="!loading">
            <div>
                Lat-lng <br/>
                lat:{{ $lat }}<br/>
                lng:{{ $lng }}<br/>
                <template x-if="$wire.err_code">
                    <span>err_code:{{ $err_code }}<br/>err_message:{{ $err_message }}<br/></span>
                </template>
            </div>
        </template>
    </div>
</x-filament-widgets::widget>

@script
<script>
    $wire.$on('location-loaded', () => {
        $el.__x.$data.loading = false;
    });

    navigator.geolocation.getCurrentPosition(
        function success(pos) {
            $wire.set('lat', pos.coords.latitude);
            $wire.set('lng', pos.coords.longitude);
            $wire.dispatch('location-loaded');
        },
        function error(err) {
            $wire.set('err_code', err.code);
            $wire.set('err_message', err.message);
            $wire.dispatch('location-loaded');
            console.log(err);
        }
    );
</script>
@endscript
