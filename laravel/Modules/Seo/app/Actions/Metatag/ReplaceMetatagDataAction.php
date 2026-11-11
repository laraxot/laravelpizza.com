<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Metatag;

use Modules\Seo\Adapters\MetatagState;
use Modules\Seo\Datas\MetatagData;
use Spatie\QueueableAction\QueueableAction;

final class ReplaceMetatagDataAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): void
    {
        app(MetatagState::class)->data = new MetatagData($data);
    }
}
