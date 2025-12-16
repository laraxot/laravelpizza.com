<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Livewire\Volt\Component;
use Modules\Tenant\Services\TenantService;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;


name('home');
middleware(PageSlugMiddleware::class);

new class extends Component {};

?>

<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" />
        </div>
    @endvolt
</x-layouts.app>
