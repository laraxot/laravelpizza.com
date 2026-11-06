<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;
use Modules\Cms\Datas\ResolvePageData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\QueueableAction\QueueableAction;

/**
 * Class ResolvePageAction.
 *
 * Risolve il contenuto da renderizzare per le rotte Folio [container0]/[slug0].
 * Segue la logica di priorità:
 * 1. Tentativo di caricamento di un modello dinamico: solo `blog`/`events` (contenuti pubblicati) e i contenitori
 *    elencati in `cms.config.container0_models` (DCP-283, C-04). Nessun modello arbitrario dall'URL.
 * 2. Verifica se esiste una pagina CMS con slug esatto (container.slug).
 * 3. Fallback a una pagina CMS generica (container.view).
 */
final class ResolvePageAction
{
    use QueueableAction;

    private const string BLOG_COMPOSER = 'Modules\\Blog\\View\\Composers\\ThemeComposer';

    private const string BLOG_ARTICLE = 'Modules\\Blog\\Models\\Article';

    /**
     * Container0 => metodo del ThemeComposer del modulo Blog che restituisce solo i contenuti pubblicati.
     */
    private const array BLOG_PUBLISHED_FINDERS = [
        'blog' => 'findPublishedPostBySlug',
        'events' => 'findPublishedEventBySlug',
    ];

    public function execute(string $container0, string $slug0): ResolvePageData
    {
        $item = $this->loadDynamicModel($container0, $slug0);

        if ($item !== null) {
            return new ResolvePageData(
                renderMode: 'model',
                item: $item,
                pageSlug: $container0.'.view'
            );
        }

        $fullSlug = $container0.'.'.$slug0;
        if (PageModel::where('slug', $fullSlug)->exists()) {
            return new ResolvePageData(
                renderMode: 'cms',
                item: null,
                pageSlug: $fullSlug
            );
        }

        $viewSlug = $container0.'.view';
        if (PageModel::where('slug', $viewSlug)->exists()) {
            return new ResolvePageData(
                renderMode: 'cms',
                item: null,
                pageSlug: $viewSlug
            );
        }

        return new ResolvePageData(
            renderMode: 'cms',
            item: null,
            pageSlug: $fullSlug
        );
    }

    private function loadDynamicModel(string $container0, string $slug0): ?object
    {
        // /blog/{slug} e /events/{slug}: contenuti pubblicati del solo tipo giusto (mai post per event e viceversa).
        // Il modulo Blog e' opzionale: dove non c'e' si ripiega sulla mappa dei contenitori qui sotto.
        $publishedFinder = self::BLOG_PUBLISHED_FINDERS[$container0] ?? null;
        if ($publishedFinder !== null && class_exists(self::BLOG_COMPOSER) && class_exists(self::BLOG_ARTICLE)) {
            return $this->findPublishedArticle($publishedFinder, $slug0);
        }

        $modelClass = $this->allowedModelClass($container0);

        return $modelClass === null ? null : $this->findAuthorizedModel($modelClass, $slug0);
    }

    /**
     * Allowlist esplicita contenitore => modello (DCP-283, C-04). Il default e' negato: un contenitore non elencato non
     * carica nulla. `xra.container0_model_map` e' l'alias storico della stessa mappa.
     *
     * @return class-string<Model>|null
     */
    private function allowedModelClass(string $container0): ?string
    {
        foreach (['cms.config.container0_models', 'xra.container0_model_map'] as $key) {
            $map = config($key);
            $class = \is_array($map) ? ($map[$container0] ?? null) : null;

            if (\is_string($class) && class_exists($class) && is_subclass_of($class, Model::class)) {
                return $class;
            }
        }

        return null;
    }

    /**
     * Il modello e' letto con la sua chiave di rotta e i suoi scope globali, e mostrato solo se la policy `view` lo
     * consente a chi guarda (ospite incluso). Un record non autorizzato e' indistinguibile da uno inesistente: niente
     * oracolo di esistenza.
     *
     * @param  class-string<Model>  $modelClass
     */
    private function findAuthorizedModel(string $modelClass, string $identifier): ?Model
    {
        $model = app($modelClass);
        if (! $model instanceof Model) {
            return null;
        }

        try {
            $item = $model->resolveRouteBinding($identifier);
        } catch (QueryException) {
            return null;
        }

        return $item instanceof Model && Gate::allows('view', $item) ? $item : null;
    }

    private function findPublishedArticle(string $finder, string $slug): ?object
    {
        $composer = app(self::BLOG_COMPOSER);
        $item = is_callable([$composer, $finder]) ? call_user_func([$composer, $finder], $slug) : null;

        return is_object($item) && is_a($item, self::BLOG_ARTICLE) ? $item : null;
    }
}
