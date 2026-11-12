<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

/*
 * Pagina CMS a un livello (/{locale}/{slug}): il contenuto viene da
 * config/local/laravelpizza/database/content/pages/{slug}.json. PageSlugMiddleware risponde 404
 * se la pagina non esiste; gli alias (es. /it/login -> /it/auth/login) stanno in config/local/laravelpizza/seo.php.
 */
name('pages.view');
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $slug;
};

?>

<x-layouts.app>
    @volt('pages.view')
        <div>
            <x-page side="content" :slug="$slug" />
        </div>
    @endvolt
</x-layouts.app>
