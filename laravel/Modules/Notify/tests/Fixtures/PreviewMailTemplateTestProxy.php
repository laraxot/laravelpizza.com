<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\PreviewMailTemplate;

final class PreviewMailTemplateTestProxy extends PreviewMailTemplate
{
    /** @return array<int, mixed> */
    public function exposedHeaderActions(): array
    {
        /** @var array<int, mixed> $actions */
        $actions = $this->getHeaderActions();

        return $actions;
    }
}
