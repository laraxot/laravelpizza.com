<?php
declare(strict_types=1);

use Livewire\Volt\Component;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Modules\Cms\Models\Page;
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

        // Eventi: solo quelli visibili all'utente corrente (pubblicati, o bozze/pending del proprietario).
        // Un evento inesistente o non visibile restituisce 404 (PRD FR-7), senza passare dal resolver generico
        // che ignora scope e soft delete.
        if ($this->container0 === 'events') {
            $user = auth()->user();
            $this->item = Event::query()
                ->visibleTo($user instanceof \Modules\User\Models\User ? $user : null)
                ->where('slug', $this->slug0)
                ->first();

            if ($this->item === null) {
                // Sotto-pagine CMS del contenitore eventi (es. events/my.json → slug "events-my").
                $cmsSlug = collect([$this->container0.'.'.$this->slug0, $this->container0.'-'.$this->slug0])
                    ->first(fn (string $slug): bool => Page::query()->where('slug', $slug)->exists());

                abort_if($cmsSlug === null, 404);
                $this->pageSlug = $cmsSlug;
            }
        }

        // Se non ancora risolto, usa l'azione generica (contenitori diversi da "events")
        if ($this->item === null && $this->container0 !== 'events') {
            $resolved = $resolvePageAction->execute($this->container0, $this->slug0);
            $this->pageSlug = $resolved->pageSlug;
            $this->item = $resolved->item;
        }

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
    <div>
        <x-page
            side="content"
            :slug="$this->pageSlug"
            :data="$this->data"
        />
    </div>
    @endvolt
</x-layouts.app>
