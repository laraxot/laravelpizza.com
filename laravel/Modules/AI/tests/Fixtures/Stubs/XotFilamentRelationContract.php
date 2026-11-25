<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

final class XotFilamentRelationContract extends XotBaseRelationManager
{
    protected static string $relationship = 'sessions';
}
