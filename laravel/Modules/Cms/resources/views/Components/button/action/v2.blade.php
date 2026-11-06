<?php

declare(strict_types=1);

?>
<button {{ $attributes->merge($attrs) }} {{-- data-bs-toggle="offcanvas" --}}>
        {{-- <i class="{{ $link->icon }}"></i> --}}
        {!! $icon !!}
</button>
{{--
{!! $action->btnHtml() !!}
--}}
