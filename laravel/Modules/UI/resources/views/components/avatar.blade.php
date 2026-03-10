<?php

declare(strict_types=1);

?>
@props([
    'user' => null,
    'size' => 'md',
    'class' => '',
])

@php
$sizes = [
    'sm' => 'w-8 h-8',
    'md' => 'w-10 h-10',
    'lg' => 'w-12 h-12',
    'xl' => 'w-16 h-16',
];

$sizeClass = $sizes[$size] ?? $sizes['md'];

// Determina l'avatar da utilizzare
$hasCustomAvatar = $user && $user->profile_photo_url;
$gender = $user && $user->gender ? $user->gender : 'male';
@endphp

<div {{ $attributes->merge(['class' => 'relative inline-flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 ' . $sizeClass . ' ' . $class]) }}>
    @if($hasCustomAvatar)
        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full" />
    @else
        <img
            src="{{ asset('images/avatars/' . $gender . '.svg') }}"
            alt="{{ $user ? $user->name : 'Avatar' }}"
            class="w-2/3 h-2/3 text-gray-600 dark:text-gray-300"
        />
    @endif
</div>
