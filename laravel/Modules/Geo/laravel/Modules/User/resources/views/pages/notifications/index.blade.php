<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('notifications');
middleware(['web', 'auth']);

?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('user::notifications_center.page.meta_title.label') }}
    </x-slot>

    <main id="main-container" class="container py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <header class="cmp-heading mb-4">
                    <h1 class="title-xxxlarge">{{ __('user::notifications_center.page.title.label') }}</h1>
                    <p class="subtitle-small mb-0">
                        {{ __('user::notifications_center.page.description.label') }}
                    </p>
                </header>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        @livewire(\Modules\User\Filament\Widgets\Auth\NotificationsCenterWidget::class)
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
