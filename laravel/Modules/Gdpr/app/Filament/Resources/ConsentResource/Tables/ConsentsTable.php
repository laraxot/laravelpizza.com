<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * Tabella della lista consensi: trattamento, soggetto e date.
 *
 * Le colonne vivono qui e non nella list page: Xot costruisce la tabella dalla classe *Table.
 *
 * @see Modules/Gdpr/docs/manuals/manuale-utente.md
 */
class ConsentsTable extends XotBaseResourceTable
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
            TextColumn::make('treatment.name')
                ->label(__('gdpr::consents.fields.treatment.name.label'))
                ->searchable(),
            'subject_id' => TextColumn::make('subject_id')
                ->label(__('gdpr::consents.fields.subject_id.label'))
                ->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
