<?php

declare(strict_types=1);

?>
<div>
    @if (count($providers))
        <div class="relative flex items-center justify-center text-center mb-">
            <div class="absolute border-t border-gray-200 w-full h-px"></div>
            <p
                class="inline-block relative bg-white text-sm p-2 rounded-full font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-100">
                {{ __('user::auth.login-via') }}
            </p>
        </div>

        <div class="grid @if (count($providers) > 1) grid-cols-2 @endif gap-4">
            @foreach ($providers as $key => $provider)
                <x-filament::button class="mt-3" color="gray" :icon="$provider['icon'] ?? null" tag="a" :href="route('socialite.oauth.redirect', $key)">
                    {{ $provider['label'] }}
                </x-filament::button>
            @endforeach
        </div>
    @else
        <span></span>
    @endif
</div>
