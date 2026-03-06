<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRelatedRecords as FilamentManageRelatedRecords;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Traits\HasXotTable;

/**
 * Base page per la gestione dei record correlati con tabella standard Xot.
 */
abstract class XotBaseManageRelatedRecords extends FilamentManageRelatedRecords
{
    use HasXotTable;

    // protected static string $resource;
    protected static string $recordTitleAttribute = 'name';

    /**
     * Restituisce il titolo della pagina.
     */
    public function getTitle(): string
    {
        return static::transFunc(__FUNCTION__).' - '.$this->getRecordTitle();
    }

    public function getRecordTitle(): string
    {
        $value = $this->getRecord()->getAttribute(static::$recordTitleAttribute);

        return is_string($value) ? $value : (string) ($value ?? '');
    }

    /**
     * Get the navigation label.
     */
    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    /**
     * Get the navigation badge.
     */
    public static function getNavigationBadge(): ?string
    {
        return null;
    }

    /**
     * Get the infolist schema.
     * This can be used to display metadata of the owner record.
     *
     * @return array<int|string, Component>
     */
    public function getInfolistSchema(): array
    {
        return [];
    }

    /**
     * Configura lo schema per i record correlati.
     */
    public function schema(Schema $schema): Schema
    {
        $formSchema = $this->getFormSchema();

        return $schema->components($formSchema);
    }

    /**
     * Restituisce lo schema del form per i record correlati.
     *
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Definisce le colonne della tabella per la visualizzazione dei record correlati.
     * Questo metodo può essere sovrascritto nelle classi figlie.
     *
     * @return array<string, TextColumn>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->icon('heroicon-o-hashtag')
                ->iconColor('gray')
                ->sortable(),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime('d/m/Y H:i')
                ->since()
                ->color('gray')
                ->sortable(),
        ];
    }

    /**
     * Azioni header della pagina (non della tabella).
     *
     * Per le pagine ManageRelatedRecords il default è vuoto: la creazione
     * avviene tramite le azioni della tabella (`getTableHeaderActions()` del trait HasXotTable).
     *
     * Le classi figlie possono sovrascrivere questo metodo per aggiungere
     * azioni di pagina (es. export, report PDF).
     *
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
