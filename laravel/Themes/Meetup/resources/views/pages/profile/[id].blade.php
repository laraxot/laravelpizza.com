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

    public array $data = [];

    public function mount(ResolvePageAction $resolvePageAction, string $id): void
    {
        $this->id = $id;
        $resolved = $resolvePageAction->execute('profile', $id);
        $this->item = $resolved->item;
        $this->data = [
            'container0' => 'profile',
            'slug0' => $this->id,
            'item' => $this->item,
        ];
    }
};
?>

<x-layouts.app>
    @volt('profile.view')
        <x-page
            side="content"
            slug="profile.view"
            :data="$this->data"
        />
    @endvolt
</x-layouts.app>
