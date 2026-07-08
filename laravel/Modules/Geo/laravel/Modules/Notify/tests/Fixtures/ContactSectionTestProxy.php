<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Modules\Notify\Filament\Forms\Components\ContactSection;

final class ContactSectionTestProxy extends ContactSection
{
    /** @return array<int|string, mixed> */
    public function exposedFormSchema(): array
    {
        return $this->getFormSchema();
    }
}
