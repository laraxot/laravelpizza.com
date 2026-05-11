<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\AssociateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;
use Webmozart\Assert\Assert;

/**
 * Trait HasXotTable.
 *
 * Provides enhanced table functionality with translations and optimized structure.
 *
 * @property TableLayoutEnum $layoutView
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 */
trait HasXotTable
{
    use TransTrait;

    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    protected static bool $canReplicate = false;

    protected static bool $canView = true;

    protected static bool $canEdit = true;

    /**
     * Get table header actions.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Filament\Tables\Concerns\InteractsWithTable richiede visibilità PUBLIC.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * @return array<string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        $resource = $this;
        if ($this instanceof ListRecords) {
            $resourceClass = $this->getResource();
            // @phpstan-ignore-next-line
            Assert::string($resourceClass);

            $resource = app($resourceClass);
        }

        Assert::object($resource);

        $actions = [];

        $actions['create'] = CreateAction::make();

        if ($this->shouldShowAssociateAction()) {
            $actions['associate'] = AssociateAction::make()
                ->label('')
                ->icon('heroicon-o-paper-clip');
        }

        if (method_exists($resource, 'canAttach')) {
            $actions['attach'] = AttachAction::make()
                ->icon('heroicon-o-link')
                ->iconButton()
                ->visible(static fn (): bool => (bool) $resource->canAttach());
        }

        $actions['layout'] = TableLayoutToggleTableAction::make('layout');

        return $actions;
    }

    /**
     * Get grid table columns.
     *
     * @return array<int, Tables\Columns\Column|Stack>
     */
    public function getGridTableColumns(): array
    {
        return [
            Stack::make($this->getTableColumns()),
        ];
    }

    /**
     * Get table filters form columns.
     */
    public function getTableFiltersFormColumns(): int
    {
        $count = \count($this->getTableFilters()) + 1;

        return min($count, 6);
    }

    /**
     * Get table record title attribute.
     */
    public function getTableRecordTitleAttribute(): string
    {
        return 'name';
    }

    /**
     * Configura una tabella Filament.
     *
     * Nota: Questo metodo è stato modificato per risolvere l'errore
     * "Method Filament\Actions\Action::table does not exist" in Filament 3.
     * La soluzione verifica l'esistenza dei metodi getTableHeaderActions(),
     * getTableActions() e getTableBulkActions() prima di chiamarli,
     * garantendo la compatibilità con diverse versioni di Filament.
     *
     * Problema: Il trait chiamava direttamente metodi che potrebbero non esistere
     * nelle classi che lo utilizzano, causando errori in Filament 3.
     *
     * Soluzione: Verifica condizionale dell'esistenza dei metodi prima di chiamarli,
     * mantenendo la retrocompatibilità e prevenendo errori.
     *
     * Ultimo aggiornamento: 10/2023
     */
    public function table(Table $table): Table
    {
        /**
         * $modelClass = $this->getModelClass();
         * if (! app(TableExistsByModelClassActions::class)->execute($modelClass)) {
         * $this->notifyTableMissing();.
         *
         * return $this->configureEmptyTable($table);
         * }
         *
         * //  @var Model $model
         * $model = app($modelClass);
         * Assert::isInstanceOf($model, Model::class);
         */
        // Configurazione base della tabella
        $table = $table
            ->recordTitleAttribute($this->getTableRecordTitleAttribute())
            ->heading($this->getTableHeading())
            ->columns($this->layoutView->getTableColumns($this->getTableColumns(), $this->getGridTableColumns()))
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->filters($this->getTableFilters())
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns($this->getTableFiltersFormColumns())
            ->persistFiltersInSession()
            ->headerActions($this->getTableHeaderActions())
            ->recordActions($this->getTableActions())
            ->toolbarActions($this->getTableBulkActions())
            ->recordActionsPosition(RecordActionsPosition::BeforeColumns)
            ->emptyStateActions($this->getTableEmptyStateActions())
            ->striped()
            ->paginated($this->getTablePaginated());

        // Configurazioni opzionali personalizzabili
        $sortColumn = $this->getDefaultTableSortColumn();
        $sortDirection = $this->getDefaultTableSortDirection();
        if (null !== $sortColumn && null !== $sortDirection) {
            $table = $table->defaultSort($sortColumn, $sortDirection);
        }

        $pollInterval = $this->getTablePollInterval();
        if (null !== $pollInterval) {
            $table = $table->poll($pollInterval);
        }

        return $table;
    }

    /**
     * Get table filters.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Filament\Tables\Concerns\InteractsWithTable richiede visibilità PUBLIC.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * @return array<string|int, Tables\Filters\Filter|TernaryFilter|BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [];
    }

    /**
     * Get table actions.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * Per {@see TableWidget}: sovrascrivere {@see getTableActions()} nella classe
     * base del progetto (es. {@see XotBaseTableWidget}) invece di
     * ramificare qui su `instanceof TableWidget`.
     *
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        $actions = [];
        $resource = $this;
        if ($this instanceof ListRecords) {
            $resourceClass = $this->getResource();
            // @phpstan-ignore-next-line
            Assert::string($resourceClass);
            $resource = app($resourceClass);
        }
        Assert::object($resource);

        if (method_exists($resource, 'canView')) {
            $actions['view'] = ViewAction::make()
                ->iconButton()
                ->visible(static fn (Model $record): bool => (bool) $resource->canView($record));
        }

        if (method_exists($resource, 'canEdit')) {
            $actions['edit'] = EditAction::make()
                ->iconButton()
                ->visible(static fn (Model $record): bool => (bool) $resource->canEdit($record));
        }

        if (method_exists($resource, 'canDelete')) {
            $actions['delete'] = DeleteAction::make()
                ->iconButton()
                ->visible(static fn (Model $record): bool => (bool) $resource->canDelete($record));
        }

        if ($this->shouldShowReplicateAction()) {
            $actions['replicate'] = ReplicateAction::make()
                ->iconButton();
        }
        // @phpstan-ignore-next-line
        if ($this->shouldShowDetachAction() && $this->isFilamentRelationshipTableContext() && method_exists($this, 'getRelationship')) {
            /** @var Relation|Builder $relationship */
            $relationship = $this->getRelationship();

            if (method_exists($relationship, 'getTable')
                && method_exists($relationship, 'getPivotClass')
            ) {
                $pivotClass = $relationship->getPivotClass();

                if ((\is_object($pivotClass) || \is_string($pivotClass))
                    && method_exists($pivotClass, 'getKeyName')
                ) {
                    $actions['detach'] = DetachAction::make()
                        ->iconButton()
                        ->tooltip((string) __('user::actions.detach'));
                }
            }
        }

        return $actions;
    }

    /**
     * Get table bulk actions.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Filament\Tables\Concerns\InteractsWithTable richiede visibilità PUBLIC.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make()
                ->label('')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }

    /**
     * Get model class.
     *
     * @throws \Exception Se non viene trovata una classe modello valida
     *
     * @return class-string<Model>
     */
    public function getModelClass(): string
    {
        // @phpstan-ignore-next-line
        if ($this->isFilamentRelationshipTableContext() && method_exists($this, 'getRelationship')) {
            /** @var Relation|Builder $relationship */
            $relationship = $this->getRelationship();
            if ($relationship instanceof Relation) {
                $related = $relationship->getRelated();
                Assert::isInstanceOf($related, Model::class);

                return \get_class($related);
            }

            if ($relationship instanceof Builder) {
                $model = $relationship->getModel();
                Assert::isInstanceOf($model, Model::class);

                return \get_class($model);
            }

            // @phpstan-ignore-next-line
            throw new \UnexpectedValueException('Unsupported relationship type for getModelClass: '.get_debug_type($relationship));
        }

        if (method_exists($this, 'getModel')) {
            $model = $this->getModel();

            // @var class-string<Model>
            // @phpstan-ignore-next-line
            Assert::string($model);

            Assert::classExists($model);
            // Assert::isAOf($model, Model::class);
            // Assert::isInstanceOf($model, Model::class);

            // @var class-string<Model> $model
            // @phpstan-ignore-next-line
            return $model;
        }

        throw new \Exception('No model found in '.class_basename(self::class).'::'.__FUNCTION__);
    }

    /**
     * Get table search query.
     *
     * CRITICO: Deve essere public per rispettare il contratto ListRecords.
     */
    public function getTableSearch(): ?string
    {
        return $this->tableSearch ?? null;
    }

    /**
     * Get list table columns.
     *
     * @return array<string, Tables\Columns\Column>
     */
    abstract protected function getTableColumns(): array;

    /**
     * Get table heading.
     */
    protected function getTableHeading(): ?string
    {
        $key = static::getKeyTrans('table.heading');
        $trans = trans($key);

        if (! \is_string($trans)) {
            return null;
        }

        return $trans !== $key ? $trans : null;
    }

    /**
     * Get table empty state actions.
     *
     * @return array<string, Action>
     */
    protected function getTableEmptyStateActions(): array
    {
        return [];
    }

    protected function shouldShowAssociateAction(): bool
    {
        return false;
    }

    protected function shouldShowAttachAction(): bool
    {
        return $this->isFilamentRelationshipTableContext();
    }

    protected function shouldShowDetachAction(): bool
    {
        return $this->isFilamentRelationshipTableContext();
    }

    /**
     * True when this Livewire component is a Filament relation table (RelationManager or ManageRelatedRecords).
     */
    protected function isFilamentRelationshipTableContext(): bool
    {
        if ($this instanceof RelationManager) {
            return true;
        }

        // @phpstan-ignore-next-line
        return $this instanceof ManageRelatedRecords;
    }

    protected function shouldShowReplicateAction(): bool
    {
        return static::$canReplicate;
    }

    protected function shouldShowViewAction(): bool
    {
        return static::$canView;
    }

    protected function shouldShowEditAction(): bool
    {
        return static::$canEdit;
    }

    /**
     * Get header actions.
     *
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()->icon('heroicon-o-plus'),
        ];
    }

    /**
     * Get table pagination options.
     * Can return bool (true/false) or array of page sizes [10, 25, 50, 100].
     *
     * @return bool|array<int>
     */
    protected function getTablePaginated(): bool|array
    {
        return true;
    }

    /**
     * Get default table sort column.
     */
    protected function getDefaultTableSortColumn(): ?string
    {
        try {
            $modelClass = $this->getModelClass();
            /** @var Model $model */
            $model = app($modelClass);
            Assert::isInstanceOf($model, Model::class);

            return $model->getTable().'.id';
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get default table sort direction.
     */
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    /**
     * Get table polling interval.
     * Returns null to disable polling, or a string like '30s' to enable.
     */
    protected function getTablePollInterval(): ?string
    {
        return null;
    }

    /**
     * Notify that table is missing.
     */
    protected function notifyTableMissing(): void
    {
        $modelClass = $this->getModelClass();
        /** @var Model $model */
        $model = app($modelClass);
        Assert::isInstanceOf($model, Model::class);

        Notification::make()
            ->title((string) __('user::notifications.table_missing.title'))
            ->body((string) __('user::notifications.table_missing.body', [
                'table' => $model->getTable(),
            ]))
            ->persistent()
            ->warning()
            ->send();
    }

    /**
     * Configure empty table.
     */
    protected function configureEmptyTable(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(static fn (Builder $query) => $query->whereNull('id'))
            ->columns([
                TextColumn::make('message')->default(__('user::fields.message.default'))->html(),
            ])
            ->headerActions([])
            ->recordActions([]);
    }

    /**
     * Get searchable columns.
     *
     * @return array<string>
     */
    protected function getSearchableColumns(): array
    {
        return ['id', 'name'];
    }

    /**
     * Check if search is enabled.
     */
    protected function hasSearch(): bool
    {
        return true;
    }
}
