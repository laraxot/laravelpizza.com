<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\ViewRecord as FilamentViewRecord;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

abstract class XotBaseViewRecord extends FilamentViewRecord
{
    final public function infolist(Schema $schema): Schema
    {
        return $schema->components($this->getInfolistSchema());
    }

    /**
     * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
     * Questo metodo deve sempre restituire un array con chiavi di tipo stringa.
     *
     * @return array<int|string, Component>
     */
    abstract protected function getInfolistSchema(): array;
}
