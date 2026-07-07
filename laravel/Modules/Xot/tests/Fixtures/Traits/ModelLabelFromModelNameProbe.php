<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Traits;

final class ModelLabelFromModelNameProbe extends HasCustomModelLabelProbeBase
{
    public static function getModel(): string
    {
        return 'App\Models\UserInvitation';
    }
}
