<?php

declare(strict_types=1);

?>
@php
    /** @var \Illuminate\Database\Eloquent\Model|array $record */
    $record = $getRecord();

    $parts = [];

    $fullAddress = data_get($record, 'full_address');
    if (is_string($fullAddress) && $fullAddress !== '') {
        $fullAddress = str_replace(' - ', '<br/>', $fullAddress);
        $parts[] = $fullAddress;
    } else {
        foreach (['address', 'city', 'province', 'postal_code', 'country'] as $field) {
            $value = data_get($record, $field);
            if (is_string($value) && $value !== '') {
                $parts[] = $value;
            }
        }
    }
@endphp

<div class="flex flex-col text-sm leading-tight">
    @if (count($parts) === 0)
        <br/><span class="text-gray-400">-</span>
    @else
        <span>{!! implode(', ', $parts) !!}</span>
    @endif
</div>
