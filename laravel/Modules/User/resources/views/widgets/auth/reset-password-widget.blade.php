<?php

declare(strict_types=1);

?>
@php
    $form = $getForm();
@endphp

<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold tracking-tight">
            {{ __('user::auth.reset-password.title') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('user::auth.reset-password.subtitle') }}
        </p>
    </div>

    <form wire:submit="resetPassword" class="space-y-6">
        {{ $form }}

        <div>
            <x-filament::button
                type="submit"
                class="w-full"
            >
                {{ __('user::auth.reset-password.submit') }}
            </x-filament::button>
        </div>
    </form>
</div>
