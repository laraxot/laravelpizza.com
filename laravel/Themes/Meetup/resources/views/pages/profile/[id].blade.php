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
        // Profilo pubblico = utente: un id che non corrisponde a nessuno è un 404, non una pagina "utente anonimo".
        $this->item = $resolved->item ?? \Modules\User\Models\User::query()->with('profile')->find($id);
        abort_if($this->item === null, 404);

        // <title> della pagina: il nome della persona (il layout viene reso dopo questo componente)
        $name = $this->item instanceof \Illuminate\Database\Eloquent\Model ? $this->item->getAttribute('name') : null;
        if (is_string($name) && trim($name) !== '') {
            request()->attributes->set(\Modules\Cms\Actions\ResolvePageMetaAction::TITLE, trim($name));
        }
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
