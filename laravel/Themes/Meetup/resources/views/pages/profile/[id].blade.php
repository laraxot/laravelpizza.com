<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Modules\Cms\Actions\ResolvePageMetaAction;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use Modules\Cms\Models\Page;
use Modules\User\Models\User;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

/*
 * /{lingua}/profile/{id}
 *
 * 1. Sotto-pagina CMS del contenitore "profile": pages/profile/edit.json -> slug "profile.edit" -> /profile/edit.
 *    Il middleware del JSON (es. "auth") lo applica PageSlugMiddleware.
 * 2. Altrimenti {id} è un utente: profilo pubblico (pages/profile/view.json, slug "profile.view"); id sconosciuto = 404.
 *
 * Convenzione e motivazioni: Modules/Cms/docs/cms-subpages-folders.md
 */
name('profile.view');
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $id = '';

    public string $pageSlug = 'profile.view';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(string $id): void
    {
        $this->id = $id;

        if (Page::query()->where('slug', 'profile.'.$id)->exists()) {
            $this->pageSlug = 'profile.'.$id;
            $this->data = ['container0' => 'profile', 'slug0' => $id];

            return;
        }

        $user = User::query()->with('profile')->find($id);
        // Un account eliminato dal titolare (deleted_at, dati anonimizzati) non ha più un profilo pubblico.
        abort_if($user === null || $user->deleted_at !== null, 404);

        $this->data = ['container0' => 'profile', 'slug0' => $id, 'item' => $user];

        // <title> della pagina: il nome della persona (il layout viene reso dopo questo componente)
        $name = trim((string) $user->name);
        if ($name !== '') {
            request()->attributes->set(ResolvePageMetaAction::TITLE, $name);
        }
    }
};
?>

<x-layouts.app>
    @volt('profile.view')
        <div>
            <x-page side="content" :slug="$this->pageSlug" :data="$this->data" />
        </div>
    @endvolt
</x-layouts.app>
