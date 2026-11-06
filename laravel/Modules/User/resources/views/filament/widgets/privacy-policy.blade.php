<?php

declare(strict_types=1);
?>
<x-filament::section>
    <x-slot name="heading">
        {{ __('user::profile.privacy_policy.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('user::profile.privacy_policy.description') }}
    </x-slot>

    <div class="prose dark:prose-invert max-w-none" v-html="terms"></div>
</x-filament::section>