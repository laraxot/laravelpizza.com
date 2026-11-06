<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Schemas\Schema;

trait HasXotInfolist
{
    public function getInfolistColumns(): int
    {
        return 2;
    }

    final public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components($this->getInfolistSchema())
            ->columns($this->getInfolistColumns());
    }
}
