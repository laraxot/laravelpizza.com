<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget >
    Lat-lng <br/>
    lat:{{ $lat }}<br/>
    lng:{{ $lng }}<br/>
    err_code:{{ $err_code }}<br/>
    err_message:{{ $err_message }}<br/>



@script
<script>

    navigator.geolocation.getCurrentPosition(
        function success(pos) {
            @this.set('lat',pos.coords.latitude);
            @this.set('lng',pos.coords.longitude);

        },
        function error(err) {
            @this.set('err_code',err.code);
            @this.set('err_message',err.message);
            console.log(err);
        }
    );
    </script>
@endscript

</x-filament-widgets::widget >
