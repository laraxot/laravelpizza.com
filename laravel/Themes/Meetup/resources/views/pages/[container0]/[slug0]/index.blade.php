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

    public ?object $item = null;

    public ?Event $event = null;

    public array $data = [];

    public function mount(ResolvePageAction $resolvePageAction, string $container0, string $slug0): void
    {
        $this->container0 = $container0;
        $this->slug0 = $slug0;
        $this->pageSlug = $this->container0.'.view';

        $resolved = $resolvePageAction->execute($this->container0, $this->slug0);

        $this->pageSlug = $resolved->pageSlug;
        $this->item = $resolved->item;

        if ($this->item instanceof Event) {
            $this->event = $this->item;
        }

        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
            'item' => $this->item,
            'event' => $this->event,
        ];
    }
};
?>

<x-layouts.app>
    @volt('container0.view')
        <x-page
            side="content"
            :slug="$pageSlug"
            :data="$data"
        />
    @endvolt
</x-layouts.app>
