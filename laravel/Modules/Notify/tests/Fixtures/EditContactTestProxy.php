<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Modules\Notify\Filament\Resources\ContactResource\Pages\EditContact;

final class EditContactTestProxy extends EditContact
{
    /** @return array<string, mixed> */
    public function exposedHeaderActions(): array
    {
        return $this->getHeaderActions();
    }
}
