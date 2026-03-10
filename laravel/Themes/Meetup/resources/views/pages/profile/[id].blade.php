<?php
declare(strict_types=1);

use Livewire\Volt\Component;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('profile.view');
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $id = '';

    public ?object $item = null;

    public function mount(ResolvePageAction $resolvePageAction, string $id): void
    {
        $this->id = $id;
        $resolved = $resolvePageAction->execute('profile', $id);
        $this->item = $resolved->item;
    }
};
?>

<x-layouts.app>
    @volt('profile.view')
        @include('pub_theme::components.blocks.profile.detail', [
            'item' => $this->item,
            'slug0' => $this->id,
        ])
    @endvolt
</x-layouts.app>
