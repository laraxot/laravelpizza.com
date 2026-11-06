<?php

declare(strict_types=1);
?>
<div>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('user::terms_of_service.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('user::terms_of_service.description') }}
        </x-slot>

        <div class="prose dark:prose-invert max-w-none">
            {{ $terms }}
        </div>
    </x-filament::section>
</div>