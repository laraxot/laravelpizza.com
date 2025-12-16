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
use Modules\Cms\Models\Page;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

/** @var array */
//$middleware=TenantService::config('middleware');
//$base_middleware=Arr::get($middleware,'base',[]);

$base_middleware=[];

name('pages.view');
/*
if(isset($slug)){
    $middleware=Page::getMiddlewareBySlug($slug);
    middleware($middleware);
}
*/
middleware(PageSlugMiddleware::class);



new class extends Component
{
    public string $slug;

   
};

?>

<x-layouts.public>
    @volt('pages.view')
    <div>
        <x-page side="content" :slug="$slug" />
    </div>
    @endvolt
</x-layouts.public>
