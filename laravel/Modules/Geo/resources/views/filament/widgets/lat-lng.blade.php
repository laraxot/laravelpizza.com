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
                <span class="text-sm">{{ __('geo::lat_lng.widget.locating.label') }}</span>
            </div>
        </template>
        <template x-if="!loading">
            <div>
                {{ __('geo::lat_lng.widget.heading.title') }} <br/>
                {{ __('geo::lat_lng.widget.latitude.label') }}:{{ $lat }}<br/>
                {{ __('geo::lat_lng.widget.longitude.label') }}:{{ $lng }}<br/>
                <template x-if="$wire.err_code">
                    <span>{{ __('geo::lat_lng.widget.error_code.label') }}:{{ $err_code }}<br/>{{ __('geo::lat_lng.widget.error_message.label') }}:{{ $err_message }}<br/></span>
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
