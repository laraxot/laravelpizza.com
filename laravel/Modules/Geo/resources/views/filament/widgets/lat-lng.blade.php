<?php

declare(strict_types=1);

?>
{{--
    Posizione del browser. Tutta la logica sta nel componente Alpine: prima chiamava una funzione globale getLocation()
    mai definita e leggeva $el.__x.$data (API di Alpine 2), due errori JavaScript a ogni apertura della pagina.
--}}
<x-filament-widgets::widget>
    <div
        x-data="{
            loading: true,
            init() {
                if (! navigator.geolocation) {
                    this.loading = false;

                    return;
                }
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        $wire.set('lat', pos.coords.latitude);
                        $wire.set('lng', pos.coords.longitude);
                        this.loading = false;
                    },
                    (err) => {
                        $wire.set('err_code', err.code);
                        $wire.set('err_message', err.message);
                        this.loading = false;
                    },
                );
            },
        }"
    >
        <div x-show="loading" class="flex items-center gap-2">
            <x-filament::loading-indicator class="h-5 w-5 text-primary-500" />
            <span class="text-sm">{{ __('geo::lat_lng.widget.locating.label') }}</span>
        </div>
        <div x-show="! loading" x-cloak>
            {{ __('geo::lat_lng.widget.heading.title') }} <br/>
            {{ __('geo::lat_lng.widget.latitude.label') }}: {{ $lat }}<br/>
            {{ __('geo::lat_lng.widget.longitude.label') }}: {{ $lng }}<br/>
            @if ($err_code !== null)
                <span>{{ __('geo::lat_lng.widget.error_code.label') }}: {{ $err_code }}<br/>{{ __('geo::lat_lng.widget.error_message.label') }}: {{ $err_message }}<br/></span>
            @endif
        </div>
    </div>
</x-filament-widgets::widget>
