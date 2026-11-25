<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Modules\Xot\Actions\GetTransKeyAction;

class TransKeyCaller
{
    public function executeWithoutClass(): string
    {
        return app(GetTransKeyAction::class)->execute();
    }

    public function executeWithNonModuleClass(): string
    {
        return app(GetTransKeyAction::class)->execute('App\\Models\\User');
    }
}
