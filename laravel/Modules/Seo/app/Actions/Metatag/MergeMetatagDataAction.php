<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Metatag;

use Modules\Seo\Adapters\MetatagState;
use Modules\Seo\Datas\MetatagData;
use Spatie\QueueableAction\QueueableAction;

final class MergeMetatagDataAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $partial
     */
    public function execute(array $partial): void
    {
        $state = app(MetatagState::class);
        $state->data = new MetatagData(array_merge($state->data->toArray(), $partial));
    }
}
