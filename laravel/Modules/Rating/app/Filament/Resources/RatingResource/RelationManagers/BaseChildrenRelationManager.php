<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * Base relation manager per i figli del rating (adjacency list via parent_id).
 *
 * Fornisce la configurazione della tabella per la relazione `children()`
 * fornita dalla trait HasRecursiveRelationships (staudenmeir/laravel-adjacency-list).
 *
 * Le classi figlio estendono questa base e non dichiarano altro.
 *
 * Niente `table()`: in un RelationManager la tabella la costruisce `HasXotTable` a partire
 * da `getTableColumns()` e dagli hook di azione. Ridichiararla scavalca il layout, i filtri
 * e il toggle delle colonne che il trait fornisce.
 */
abstract class BaseChildrenRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'children';

    /**
     * Il form dei sotto-criteri e' quello della Resource, con una sola differenza:
     * `parent_id` diventa **nascosto e gia' valorizzato** con il record aperto.
     *
     * Qui il padre non e' una scelta, e' il contesto. Chi apre «nuovo» dalla tabella
     * dei figli di 52 sta gia' dicendo di chi il record sara' figlio, e la relazione
     * lo scrive comunque: `children()` e' una `HasMany` su `parent_id`, quindi la
     * creazione passa dalla relazione e il padre arriva da li'. Verificato in
     * transazione: da rating 52 il figlio nasce con `parent_id = 52`.
     *
     * Lasciare il Select visibile sarebbe **peggio di toglierlo**: sembrerebbe una
     * scelta, e non lo e'. Un campo che finge di decidere e non decide e' la forma
     * peggiore, perche' l'utente scopre lo scarto solo dopo aver salvato.
     *
     * Il Select resta dov'e' una scelta vera: nell'edit del criterio stesso, dove
     * riassegnare il padre e' un'operazione legittima.
     *
     * @return array<int|string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        $schema = parent::getFormSchema();

        $schema['parent_id'] = Hidden::make('parent_id')
            ->default(function (): int|string|null {
                $key = $this->getOwnerRecord()->getKey();

                return is_int($key) || is_string($key) ? $key : null;
            });

        return $schema;
    }

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')
                ->searchable()
                ->sortable(),

            'slug' => TextColumn::make('slug')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            'children_count' => TextColumn::make('children_count')
                ->counts('children')
                ->badge()
                ->alignCenter(),

            'rule' => TextColumn::make('rule')
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
