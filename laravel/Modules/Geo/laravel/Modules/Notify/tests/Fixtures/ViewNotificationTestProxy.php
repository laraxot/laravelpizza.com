<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Modules\Notify\Filament\Resources\NotificationResource\Pages\ViewNotification;

final class ViewNotificationTestProxy extends ViewNotification
{
    /** @return array<int, mixed> */
    public function exposedInfolistSchema(): array
    {
        /** @var array<int, mixed> $schema */
        $schema = $this->getInfolistSchema();

        return $schema;
    }
}
