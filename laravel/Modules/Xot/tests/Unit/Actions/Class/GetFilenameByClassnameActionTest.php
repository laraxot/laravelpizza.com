<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Class;

use Modules\Xot\Actions\Class\GetFilenameByClassnameAction;
use Modules\Xot\Models\Log;

it('gets filename from classname correctly', function (): void {
    $action = app(GetFilenameByClassnameAction::class);

    $filename = $action->execute(Log::class);

    expect($filename)->toBeString();
    expect($filename)->toContain('Log.php');
});
