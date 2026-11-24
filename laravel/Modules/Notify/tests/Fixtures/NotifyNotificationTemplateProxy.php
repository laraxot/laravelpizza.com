<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Modules\Notify\Models\NotificationTemplate;

final class NotifyNotificationTemplateProxy extends NotificationTemplate
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function exposedCompileString(?string $template, array $data): ?string
    {
        return $this->compileString($template, $data);
    }

    /** @return array<string, string> */
    public function exposedCasts(): array
    {
        /** @var array<string, string> $casts */
        $casts = $this->getCasts();

        return $casts;
    }
}
