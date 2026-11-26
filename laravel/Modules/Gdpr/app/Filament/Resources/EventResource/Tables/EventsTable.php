<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * Tabella del registro eventi privacy.
 *
 * Mostra solo identificativi, azione e date: IP e payload restano fuori dalla lista
 * (minimizzazione dei dati; il dettaglio resta nel record).
 *
 * @see Modules/Gdpr/docs/manuals/manuale-utente.md
 */
class EventsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     *
     * @see Modules/Gdpr/docs/manuals/manuale-utente.md
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'treatment_id' => TextColumn::make('treatment_id')
                ->label(__('gdpr::events.fields.treatment_id.label'))
                ->searchable(),
            'consent.id' => TextColumn::make('consent.id')
                ->label(__('gdpr::events.fields.consent_id.label'))
                ->searchable(),
            'subject_id' => TextColumn::make('subject_id')
                ->label(__('gdpr::events.fields.subject_id.label'))
                ->searchable(),
            'action' => TextColumn::make('action')
                ->label(__('gdpr::events.fields.action.label'))
                ->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
