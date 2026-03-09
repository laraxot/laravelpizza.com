<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

/**
 * Class ResolvePageData.
 *
 * DTO per il risultato della risoluzione della pagina Folio generica.
 */
class ResolvePageData extends Data
{
    public string $renderMode;

    public ?object $item;

    public string $pageSlug;

    public function __construct(
        string $renderMode,
        ?object $item,
        string $pageSlug,
    ) {
        $this->renderMode = $renderMode;
        $this->item = $item;
        $this->pageSlug = $pageSlug;
    }
}
