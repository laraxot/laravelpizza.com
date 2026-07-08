<?php

declare(strict_types=1);

?>
<x-mail::layout>
{{-- Header --}}
<x-slot:header>
    <x-mail::header :url="config('app.url')">
        {{-- config('app.name') --}}
        {{--  lo mette 2 volte
        <x-filament-panels::logo />
        --}}
        <div style="text-align: center; padding: 20px;">
            <img src="{{ asset($logo) }}"  style="height: 50px;">
        </div>

    </x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
