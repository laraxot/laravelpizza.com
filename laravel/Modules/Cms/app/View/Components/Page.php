<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Actions\ResolvePageMetaAction;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\LaravelData\DataCollection;

/**
 * CMS page shell: blocks loaded by slug. Route/context keys live only in {@see $data}.
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 *
 * @see Modules/Cms/docs/components/page-component-data-contract.md
 */
final class Page extends Component
{
    public string $side;

    public string $slug = '';

    /** @var DataCollection<int, BlockData>|array<string, BlockData> */
    public DataCollection|array $blocks;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * @param  array<string, mixed>  $data  Opaque context bag (container0, slug0, models, …)
     *
     * @see Modules/Cms/docs/components/page-component-data-contract.md
     */
    public function __construct(
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
        array $data = [],
    ) {
        $this->side = $side;
        $this->data = $data;

        if ($slug === null && isset($data['slug']) && is_string($data['slug'])) {
            $slug = $data['slug'];
        }

        if ($slug === null) {
            $slug = '';
        }

        if ($type !== null) {
            $slug = $type.'-'.$slug;
        }

        $this->slug = $slug;

        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
        $this->resolveDynamicContext();

        // Titolo e descrizione della pagina per <x-metatags> (il layout è reso dopo il contenuto).
        if ($this->side === 'content') {
            app(ResolvePageMetaAction::class)->remember($this->slug, $this->blocks, $this->data);
        }
    }

    /**
     * Risolve il fallback per le rotte Folio dinamiche senza riportare query o rami di dominio nelle Blade.
     *
     * @see Modules/Cms/docs/adr/cms-owns-page-resolution.md
     * @see Modules/Cms/docs/components/page-component-data-contract.md
     */
    private function resolveDynamicContext(): void
    {
        $container0 = $this->data['container0'] ?? null;
        $slug0 = $this->data['slug0'] ?? null;
        if (! is_string($container0) || $container0 === '' || ! is_string($slug0) || $slug0 === '') {
            return;
        }

        // Il componente viene anche usato direttamente dai test e da altri componenti CMS:
        // la politica HTTP (404/fallback) appartiene solo al percorso Folio reale.
        if (request()->route() === null) {
            return;
        }

        // Se la pagina Folio ha gia' risolto (e autorizzato) il record e lo passa nel data bag, il Page non lo
        // rilegge ne' decide la visibilita': l'oggetto arriva dal codice della pagina, mai dall'URL.
        // Senza questa uscita /events/{slug} e /profile/{id} rispondevano 404 anche per un record valido.
        if (is_object($this->data['item'] ?? null)) {
            return;
        }

        $resolved = app(ResolvePageAction::class)->execute($container0, $slug0);
        $resolvedPage = PageModel::findUniqueBySlug($resolved->pageSlug);
        $requestedSlug = $container0.'.'.$slug0;
        $isDynamicTicket = $container0 === 'tickets' && ctype_digit($slug0);

        if ($resolved->pageSlug !== $this->slug) {
            $this->slug = $resolved->pageSlug;
            $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
        }

        if ($resolved->item !== null) {
            $this->data['item'] = $resolved->item;
        }

        // Il dettaglio ticket è una route dinamica: il contenuto non può avere
        // un JSON per ogni ID, ma resta un blocco CMS-owned e data-driven.
        if ($resolvedPage === null && $resolved->item === null && $isDynamicTicket) {
            $this->blocks = ['ticket_detail' => new BlockData('ticket_detail', [
                'view' => 'pub_theme::components.pages.ticket-detail',
                'header_active' => 'all-services',
            ])];

            return;
        }

        // Un dettaglio ticket numerico usa il CMS come contenitore del blocco,
        // ma l'identificativo non è uno slug CMS: la visibilità è verificata
        // dal componente ticket-detail tramite l'Action del modulo Fixcity.
        if ($isDynamicTicket) {
            return;
        }

        if ($resolvedPage === null && $resolved->item === null) {
            abort(404);
        }

        if (($resolved->pageSlug !== $requestedSlug || $slug0 === 'view') && $resolved->item === null) {
            abort(404);
        }
    }

    /**
     * @see Modules/Cms/docs/components/page-component-data-contract.md
     */
    public function render(): ViewContract|Factory
    {
        $viewName = 'cms::components.page';

        return view($viewName, array_merge($this->data, [
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
        ]));
    }
}
