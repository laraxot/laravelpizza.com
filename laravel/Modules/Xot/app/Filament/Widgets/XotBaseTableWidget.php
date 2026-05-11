<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as FilamentTableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Attributes\On;
use Modules\Xot\Filament\Traits\HasXotTable;
use Webmozart\Assert\Assert;

abstract class XotBaseTableWidget extends FilamentTableWidget
{
    // use TransTrait;
    use HasXotTable;
    use InteractsWithPageFilters;

    /**
     * Modello per la tabella: solo ramo {@see getModel()} (mai contesto RelationManager).
     *
     * @throws \Exception Se non viene trovata una classe modello valida
     *
     * @return class-string<Model>
     */
    public function getModelClass(): string
    {
        if (method_exists($this, 'getModel')) {
            $model = $this->getModel();
            if (is_string($model)) {
                Assert::classExists($model);
                if (! is_subclass_of($model, Model::class, true)) {
                    throw new \InvalidArgumentException('Expected Eloquent model class-string, got: '.$model);
                }

                return $model;
            }
            if ($model instanceof Model) {
                return $this->eloquentClassString($model);
            }
        }

        throw new \Exception('No model found in '.class_basename(self::class).'::'.__FUNCTION__);
    }

    /**
     * @template TModel of Model
     *
     * @param TModel $model
     *
     * @return class-string<TModel>
     */
    private function eloquentClassString(Model $model): string
    {
        return $model::class;
    }

    protected function shouldShowAttachAction(): bool
    {
        return false;
    }

    protected function shouldShowDetachAction(): bool
    {
        return false;
    }

    /**
     * I widget tabella non hanno Resource: nessuna azione riga di default (view/edit/delete).
     *
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [];
    }

    /**
     * Ascolta evento di aggiornamento filtri.
     */
    #[On('filterUpdate')]
    public function updateFilters(array $filters): void
    {
        // Forza refresh della tabella quando i filtri cambiano
        $this->resetTable();
    }

    /**
     * Configura la tabella con le risposte.
     */
    public function tableOLD(Table $table): Table
    {
        $query = $this->getTableQuery();
        if ($query instanceof Relation) {
            $query = $query->getQuery();
        }

        /* @var Builder|null $query */
        return $table
            ->query($query)
            ->columns($this->getTableColumns())
            ->defaultSort('submitdate', 'desc')
            ->paginated([10, 25, 50, 100])
            ->poll('30s');
    }

    /**
     * Restituisce una chiave univoca per ogni record.
     * Usa _id che è l'alias della primary key creato da withAnswersLabel().
     *
     * IMPORTANTE: Non usare mai chiavi hardcoded, altrimenti Livewire
     * pensa che tutti i record siano lo stesso e mostra duplicati.
     */
    public function getTableRecordKey(Model|array $record): string
    {
        if (\is_array($record)) {
            return (string) ($record['_id'] ?? $record['id'] ?? '');
        }

        return (string) ($record->_id ?? $record->id ?? '');
    }

    public function getTableSearch(): ?string
    {
        $search = $this->tableSearch ?? null;

        if (! \is_string($search)) {
            return null;
        }

        $search = trim($search);

        return '' !== $search ? $search : null;
    }
}
