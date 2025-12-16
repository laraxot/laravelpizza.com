<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Exception;
use Filament\Actions;
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
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\Xot\Actions\Model\TableExistsByModelClassActions;
use Webmozart\Assert\Assert;

/**
 * Trait HasXotTable.
 *
 * Provides enhanced table functionality with translations and optimized structure.
 *
 * @property TableLayoutEnum $layoutView
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
     * @return array<string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        $actions = [];

        $actions['create'] = CreateAction::make();

        if ($this->shouldShowAssociateAction()) {
            $actions['associate'] = AssociateAction::make()
                ->label('')
                ->icon('heroicon-o-paper-clip')
                ;
        }

        if ($this->shouldShowAttachAction()) {
            $actions['attach'] = AttachAction::make()
                ->label('')
                ->icon('heroicon-o-link')
                ->preloadRecordSelect();
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
     * Get list table columns.
     *
     * @return array<string, Tables\Columns\Column>
     */
    abstract public function getTableColumns(): array;

    /**
     * Get table filters form columns.
     */
    public function getTableFiltersFormColumns(): int
    {
        $count = count($this->getTableFilters()) + 1;

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
     * Get table heading.
     */
    public function getTableHeading(): ?string
    {
        $key = static::getKeyTrans('table.heading');
        /** @var string|array<int|string,mixed>|null $trans */
        // @phpstan-ignore-next-line
        $trans = trans($key);

        return is_string($trans) && $trans !== $key ? $trans : null;
    }

    /**
     * Get table empty state actions.
     *
     * @return array<string, Action>
     */
    public function getTableEmptyStateActions(): array
    {
        return [];
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
        $modelClass = $this->getModelClass();
        if (! app(TableExistsByModelClassActions::class)->execute($modelClass)) {
            $this->notifyTableMissing();

            return $this->configureEmptyTable($table);
        }

        /** @var Model $model */
        $model = app($modelClass);
        Assert::isInstanceOf($model, Model::class);

        // Configurazione base della tabella
        return $table
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

        /*
         * ->defaultSort(
         * column: $this->getDefaultTableSortColumn(),
         * direction: $this->getDefaultTableSortDirection(),
         * );
         */
    }

    /**
     * Get table filters.
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
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        $actions = [];
        $resource = $this->getResource();

        if (method_exists($resource, 'canView')) {
            $actions['view'] = ViewAction::make()
                ->iconButton()
                ->visible($resource::canView(...));
        }

        if (method_exists($resource, 'canEdit')) {
            $actions['edit'] = EditAction::make()
                ->iconButton()
                ->visible($resource::canEdit(...));
        }

        if (method_exists($resource, 'canDelete')) {
            $actions['delete'] = DeleteAction::make()
                ->iconButton()
                ->visible($resource::canDelete(...));
        }

        if ($this->shouldShowReplicateAction()) {
            $actions['replicate'] = ReplicateAction::make()
                ->iconButton()
                ;
        }

        // Check if class has the getRelationship method
        // Note: In some contexts (ListRecords), getRelationship() may not exist
        // @phpstan-ignore-next-line function.alreadyNarrowedType (needed for contexts where method doesn't exist)
        if ($this->shouldShowDetachAction() && method_exists($this, 'getRelationship')) {
            $relationship = $this->getRelationship();

            // Type guard: ensure relationship is an object with required methods
            // @phpstan-ignore-next-line function.alreadyNarrowedType (in RelationManager, always object; in ListRecords, may not be)
            if (! is_object($relationship)) {
                // Skip if not object
            } elseif (method_exists($relationship, 'getTable')
                && method_exists($relationship, 'getPivotClass')
            ) {
                /** @var mixed $pivotClass */
                $pivotClass = $relationship->getPivotClass();

                // Type guard: ensure pivotClass is object/string with getKeyName method
                if ((is_object($pivotClass) || is_string($pivotClass))
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
     * @return class-string<Model>
     *
     * @throws Exception Se non viene trovata una classe modello valida
     */
    public function getModelClass(): string
    {
        // @phpstan-ignore-next-line
        if (method_exists($this, 'getRelationship')) {
            $relationship = $this->getRelationship();
            if ($relationship instanceof Relation) {
                /** @var class-string<Model> */
                return get_class($relationship->getModel());
            }
        }

        if (method_exists($this, 'getModel')) {
            $model = $this->getModel();
            // @phpstan-ignore-next-line
            if (is_string($model)) {
                Assert::classExists($model);

                // Assert::isAOf($model, Model::class);
                /** @var class-string<Model> */
                // @phpstan-ignore-next-line
                return $model;
            }
            // @phpstan-ignore-next-line
            if ($model instanceof Model) {
                /** @var class-string<Model> */
                // @phpstan-ignore-next-line
                return $model::class;
            }
        }

        throw new Exception('No model found in '.class_basename(self::class).'::'.__FUNCTION__);
    }

    /**
     * Get table search query.
     */
    public function getTableSearch(): string
    {
        /** @var string */
        return $this->tableSearch ?? '';
    }

    protected function shouldShowAssociateAction(): bool
    {
        return false;
    }

    protected function shouldShowAttachAction(): bool
    {
        // @phpstan-ignore-next-line
        return method_exists($this, 'getRelationship');
    }

    protected function shouldShowDetachAction(): bool
    {
        // @phpstan-ignore-next-line
        return method_exists($this, 'getRelationship');
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
     * @return array<string, Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()->icon('heroicon-o-plus'),
        ];
    }

    protected function getTablePaginated(): bool
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
        } catch (Exception $e) {
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
