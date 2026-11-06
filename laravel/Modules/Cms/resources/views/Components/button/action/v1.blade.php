<?php

declare(strict_types=1);

?>
@if (isset($attrs['onclick']))
    <button {{ $attributes->merge($attrs) }} {{-- data-bs-toggle="offcanvas" --}}>
        {{-- <i class="{{ $link->icon }}"></i> --}}
        {!! $icon !!}
    </button>
@else
    <a {{ $attributes->merge($attrs) }} {{-- data-bs-toggle="offcanvas" --}}>
        {{-- <i class="{{ $link->icon }}"></i> --}}
        {!! $icon !!}
    </a>
@endif
