<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ Volt automaticamente lega i parametri della route!
    public string $container0;
    public string $slug0 = '';
    public array $data = [];

    public function mount(): void
    {
        // Pagina CMS inesistente: 404 invece di una pagina vuota con solo header e footer (es. /it/dashboard)
        abort_if(\Modules\Cms\Models\Page::findUniqueBySlug($this->container0) === null, 404);
    }
};
?>

<x-layouts.app>
    @volt('container0')
    <div>
        <x-page side="content" :slug="$container0" />
    </div>
    @endvolt
</x-layouts.app>
