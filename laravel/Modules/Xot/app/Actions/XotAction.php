<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Tenant;
use Spatie\QueueableAction\QueueableAction;

class XotAction
{
    use QueueableAction;

    /**
     * @return class-string<Model>
     */
    public function getTenantClass(): string
    {
        return Tenant::class;
    }

    public function execute(): void {}
}
