<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
final class ResolvePageAction
{
    use QueueableAction;

    public function execute(string $container0, string $slug0): ResolvePageData
    {
        // 1. Tenta il caricamento di un modello dinamico
        $item = $this->loadDynamicModel($container0, $slug0);

        if (null !== $item) {
            return new ResolvePageData(
                renderMode: 'model',
                item: $item,
                pageSlug: $container0.'.view'
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
        if ('profile' === $container0) {
            return $this->resolvePublicProfileItem($slug0);
        }

        // Mappature note (Priority 1)
        $knownMappings = [
            'events' => 'Modules\\Meetup\\Models\\Event',
            'predicts' => 'Modules\\Predict\\Models\\Predict',
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
            if (null !== $item) {
                return $item;
            }
        }

        return null;
    }

    private function queryModel(string $modelClass, string $identifier): ?object
    {
        if (class_exists($modelClass) && is_subclass_of($modelClass, Model::class)) {
            /** @var Model $model */
            $model = app($modelClass);
            $candidateKeys = array_values(array_unique([
                $model->getRouteKeyName(),
                'slug',
                'id',
                'uuid',
                'user_id',
                'user_name',
            ]));

            foreach ($candidateKeys as $key) {
                foreach ($this->buildCandidateQueries($model) as $query) {
                    try {
                        $item = $query->where($key, $identifier)->first();
                    } catch (\Throwable) {
                        continue;
                    }

                    if (null !== $item) {
                        return $item;
                    }
                }
            }

            foreach ($candidateKeys as $key) {
                try {
                    $row = $model->getConnection()
                        ->table($model->getTable())
                        ->where($key, $identifier)
                        ->first();
                } catch (\Throwable) {
                    continue;
                }

                if (null !== $row) {
                    /** @var array<string, mixed> $attributes */
                    $attributes = (array) $row;

                    return $model->newFromBuilder($attributes);
                }
            }
        }

        return null;
    }

    /**
     * @return array<int, \Illuminate\Database\Eloquent\Builder<Model>>
     */
    private function buildCandidateQueries(Model $model): array
    {
        $queries = [$model->newQuery()];

        try {
            $queries[] = $model->newQueryWithoutScopes();
        } catch (\Throwable) {
        }

        $usesSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($model), true);

        if ($usesSoftDeletes) {
            foreach ($queries as $index => $query) {
                try {
                    $queries[] = (clone $query)->withTrashed();
                } catch (\Throwable) {
                    unset($queries[$index]);
                }
            }
        }

        return array_values($queries);
    }

    private function resolvePublicProfileItem(string $identifier): ?object
    {
        $userClass = 'Modules\\User\\Models\\User';
        $user = $this->queryModel($userClass, $identifier);
        if (null !== $user) {
            return $user;
        }

        $profileClasses = [
            'Modules\\Meetup\\Models\\Profile',
            'Modules\\User\\Models\\Profile',
        ];

        foreach ($profileClasses as $profileClass) {
            $profile = $this->queryModel($profileClass, $identifier);
            if (null !== $profile) {
                return $profile;
            }
        }

        return null;
    }
}
