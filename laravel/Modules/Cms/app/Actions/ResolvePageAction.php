<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\ResolvePageData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\QueueableAction\QueueableAction;

/**
 * Class ResolvePageAction.
 *
 * Risolve il contenuto da renderizzare per le rotte Folio [container0]/[slug0].
 * Segue la logica di priorità:
 * 1. Tentativo di caricamento di un modello dinamico (es. Event).
 * 2. Verifica se esiste una pagina CMS con slug esatto (container.slug).
 * 3. Fallback a una pagina CMS generica (container.view).
 */
class ResolvePageAction
{
    use QueueableAction;

    public function execute(string $container0, string $slug0): ResolvePageData
    {
        // 1. Tenta il caricamento di un modello dinamico
        $item = $this->loadDynamicModel($container0, $slug0);

        if ($item !== null) {
            return new ResolvePageData(
                renderMode: 'model',
                item: $item,
                pageSlug: '' // Non serve per il mode 'model'
            );
        }

        // 2. Verifica se esiste una pagina CMS con slug esatto
        $fullSlug = $container0.'.'.$slug0;
        if (PageModel::where('slug', $fullSlug)->exists()) {
            return new ResolvePageData(
                renderMode: 'cms',
                item: null,
                pageSlug: $fullSlug
            );
        }

        // 3. Fallback a container.view
        $viewSlug = $container0.'.view';
        if (PageModel::where('slug', $viewSlug)->exists()) {
            return new ResolvePageData(
                renderMode: 'cms',
                item: null,
                pageSlug: $viewSlug
            );
        }

        // 4. Fallback finale allo slug completo (mostrerà 404 o placeholder nel componente x-page)
        return new ResolvePageData(
            renderMode: 'cms',
            item: null,
            pageSlug: $fullSlug
        );
    }

    private function loadDynamicModel(string $container0, string $slug0): ?object
    {
        // Mappature note (Priority 1)
        $knownMappings = [
            'events' => 'Modules\\Meetup\\Models\\Event',
        ];

        if (isset($knownMappings[$container0])) {
            $modelClass = $knownMappings[$container0];

            return $this->queryModel($modelClass, $slug0);
        }

        // Mappature da config (Priority 2)
        $modelMap = config('xra.container0_model_map', []);
        if (is_array($modelMap) && isset($modelMap[$container0])) {
            $modelClass = $modelMap[$container0];
            if (is_string($modelClass)) {
                return $this->queryModel($modelClass, $slug0);
            }
        }

        // Convenzioni (Priority 3)
        $singular = rtrim($container0, 's');
        $possibleModels = [
            'Modules\\'.ucfirst($container0).'\\Models\\'.ucfirst($singular),
            'App\\Models\\'.ucfirst($singular),
        ];

        foreach ($possibleModels as $modelClass) {
            $item = $this->queryModel($modelClass, $slug0);
            if ($item !== null) {
                return $item;
            }
        }

        return null;
    }

    private function queryModel(string $modelClass, string $slug): ?object
    {
        if (class_exists($modelClass) && method_exists($modelClass, 'where')) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */
            $query = $modelClass::where('slug', $slug);

            return $query->first();
        }

        return null;
    }
}
