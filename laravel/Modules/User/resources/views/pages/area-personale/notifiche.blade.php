<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('area-personale.notifiche');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(): void
    {
        $this->redirect(LaravelLocalization::localizeURL('/notifications'));
    }
};
?>

<x-layouts.app>
    @volt('area-personale.notifiche')
        <main id="main-container" class="container py-4 py-lg-5" aria-hidden="true"></main>
    @endvolt
</x-layouts.app>
