<?php

declare(strict_types=1);

namespace Modules\Seo\Adapters;

use Modules\Seo\Contracts\MetatagDataContract;
use Modules\Seo\Datas\MetatagData;

/**
 * Request-scoped accumulator per i metatag SEO (backing del facade Metatag).
 */
final class MetatagState
{
    public MetatagDataContract $data;

    public function __construct()
    {
        $this->data = new MetatagData();
    }
}
