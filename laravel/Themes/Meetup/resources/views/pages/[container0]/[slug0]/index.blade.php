<?php
declare(strict_types=1);

use Livewire\Volt\Component;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Modules\Meetup\Models\Event;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $container0 = '';

    public string $slug0 = '';

    public string $pageSlug = '';

    public array $data = [];

    public function mount(ResolvePageAction $resolvePageAction, string $container0, string $slug0): void
    {
        $this->container0 = $container0;
        $this->slug0 = $slug0;
        $this->pageSlug = $this->container0.'.view';
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
            'item' => null,
            'event' => null,
        ];

        $resolved = $resolvePageAction->execute($this->container0, $this->slug0);

        if ($resolved->pageSlug !== '') {
            $this->pageSlug = $resolved->pageSlug;
        }

        if ($resolved->item !== null) {
            $this->data['item'] = $resolved->item;

            if ($resolved->item instanceof Event) {
                $this->data['event'] = $resolved->item;
            }
        }
    }
};
?>

<x-layouts.app>
    @volt('container0.view')
        <x-page
            side="content"
            :slug="$this->pageSlug"
            :data="$this->data"
        />
    @endvolt
</x-layouts.app>
