<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Metatag;

use Modules\Seo\Adapters\MetatagState;
use Modules\Seo\Contracts\MetatagDataContract;
use Spatie\QueueableAction\QueueableAction;

final class GetMetatagDataAction
{
    use QueueableAction;

    public function execute(): MetatagDataContract
    {
        return app(MetatagState::class)->data;
    }
}
