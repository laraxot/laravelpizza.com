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
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\Layout\Component as LayoutComponent;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\UI\Filament\Traits\HasTableLayoutPage;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Filament\PlainTextFromFilamentValueAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Actions\Model\ModelHasColumnAction;
use Modules\Xot\Filament\Links\RecordAnchor;
use RuntimeException;
use Webmozart\Assert\Assert;

/**
 * Trait HasXotTable.
 *
 * Provides enhanced table functionality with translations and optimized structure.
 *
 * @property TableLayoutEnum $layoutView
 * @property string|null $tableSearch
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 */
trait HasXotTable
{
    use HasTableLayoutPage;

    protected static bool $canReplicate = false;

    protected static bool $canView = true;

    protected static bool $canEdit = true;

    public function bootHasXotTable(): void
    {
        if (! $this instanceof Component) {
            return;
        }

        $this->mountTableLayoutFromSession();
    }

    /**
     * Get table header actions.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Filament\Tables\Concerns\InteractsWithTable richiede visibilità PUBLIC.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * @return array<int|string, Action|ActionGroup>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    public function getTableHeaderActions(): array
    {
        $resource = $this;
        if ($this instanceof ListRecords) {
            $resourceClass = $this->getResource();
            Assert::string($resourceClass);
            $resource = app($resourceClass);
        }

        // dddx(method_exists($resource, 'canAttach'));

        $actions = [
            CreateAction::make(),
        ];

        if ($this->shouldShowAssociateAction()) {
            $actions[] = AssociateAction::make()
                ->label('')
                ->icon('heroicon-o-paper-clip');
        }

        if (is_object($resource) && method_exists($resource, 'canAttach')) {
            $actions[] = AttachAction::make()
                ->icon('heroicon-o-link')
                ->iconButton()
                ->visible(static fn (): bool => (bool) $resource->canAttach());
        }

        $actions[] = TableLayoutToggleTableAction::make('layout');

        return $actions;
    }

    /**
     * Get grid table columns.
     *
     * In content-grid ogni riga mostra label e valore sulla stessa linea (es. «Ente: 123»).
     *
     * @return array<int, Column|ColumnGroup|LayoutComponent>
     */
    public function getGridTableColumns(): array
    {
        $columns = [];

        foreach (array_values($this->getTableColumns()) as $column) {
            if ($column instanceof ColumnGroup) {
                // Stack::make() non accetta ColumnGroup: nella vista a griglia le colonne
                // raggruppate non hanno un layout sensato, quindi vengono saltate.
                continue;
            }

            if (! $column instanceof Column && ! $column instanceof LayoutComponent) {
                // getTableColumns() può restituire, in alcuni contesti, elementi non tipizzati
                // (fallback deprecato di Filament): si scartano per restare coerenti col
                // tipo atteso da Stack::make().
                continue;
            }

            $gridColumn = clone $column;

            if ($gridColumn instanceof TextColumn) {
                $labelText = PlainTextFromFilamentValueAction::cast($gridColumn->getLabel());

                $gridColumn->formatStateUsing(
                    static function (mixed $state) use ($labelText): string {
                        if ($state === null || $state === '') {
                            return $labelText.': —';
                        }

                        return $labelText.': '.PlainTextFromFilamentValueAction::cast($state);
                    },
                );
            }

            $columns[] = $gridColumn;
        }

        return [
            Stack::make($columns)->space(1),
        ];
    }

    /**
     * Se i filtri vanno applicati solo dopo il bottone "Applica filtri" (default Filament)
     * oppure a ogni modifica del campo.
     *
     * Filament rende il bottone nel piede del form dei filtri, quindi occupa sempre una riga
     * propria: una tabella che vuole i filtri su una riga sola deve rinunciare al bottone e
     * applicare al volo. Il default `true` conserva il comportamento di tutte le tabelle
     * esistenti; si sovrascrive solo dove serve.
     */
    public function shouldDeferTableFilters(): bool
    {
        return true;
    }

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
        /*
        $modelClass = $this->getModelClass();
        if (! app(TableExistsByModelClassActions::class)->execute($modelClass)) {
            $this->notifyTableMissing();

            return $this->configureEmptyTable($table);
        }

        //  @var Model $model
        $model = app($modelClass);
        Assert::isInstanceOf($model, Model::class);
        */
        // Configurazione base della tabella
        // getTableColumns() può restituire, in alcuni contesti, elementi non tipizzati
        // (fallback deprecato di Filament): si filtrano per restare coerenti col tipo
        // atteso da TableLayoutEnum::getTableColumns().
        // Le Resource costruiscono la tabella da un'istanza della `*Table` class, che non e' un
        // componente Livewire: bootHasXotTable() non scatta e $layoutView resterebbe sempre LIST.
        // Qui si legge la scelta dell'utente (griglia per il cellulare) dalla sessione.
        if (! $this instanceof Component) {
            $this->mountTableLayoutFromSession();
        }

        $tableColumns = array_values(array_filter(
            $this->getTableColumns(),
            static fn (mixed $column): bool => $column instanceof Column || $column instanceof ColumnGroup || $column instanceof LayoutComponent,
        ));

        $columns = $this->layoutView->getTableColumns($tableColumns, $this->getGridTableColumns());

        $table = $table
            ->recordTitleAttribute($this->getTableRecordTitleAttribute())
            ->heading($this->getTableHeading())
            ->headerActions($this->getTableHeaderActions())
            ->columns($columns)
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->filters($this->getTableFilters())
            ->filtersLayout($this->getTableFiltersLayout())
            ->filtersFormColumns($this->getTableFiltersFormColumns())
            ->deferFilters($this->shouldDeferTableFilters())
            ->persistFiltersInSession($this->shouldPersistTableFiltersInSession())
            ->recordActions($this->getTableActions())
            ->toolbarActions($this->getTableBulkActions())
            ->recordActionsPosition($this->getTableRecordActionsPosition())
            ->emptyStateActions($this->getTableEmptyStateActions())
            ->striped($this->isTableStriped())
            // Mobile: sotto `sm` (640 px) ogni riga diventa una card con etichetta + valore per
            // cella, ordinamento in un select e "seleziona tutti" nell'intestazione: niente scroll
            // orizzontale. Da `sm` in su la tabella resta identica. Vedi
            // Modules/UI/docs/stories/mobile-ux-pass.story.md
            ->stackedOnMobile()
            ->paginated($this->getTablePaginated());

        // Configurazioni opzionali personalizzabili
        $sortColumn = $this->getDefaultTableSortColumn();
        $sortDirection = $this->getDefaultTableSortDirection();
        if ($sortColumn !== null && $sortDirection !== null) {
            $table = $table->defaultSort($sortColumn, $sortDirection);
        }

        $pollInterval = $this->getTablePollInterval();
        if ($pollInterval !== null) {
            $table = $table->poll($pollInterval);
        }

        $table = $this->applyReorderable($table);

        return $table;
    }

    /**
     * Get table filters.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Filament\Tables\Concerns\InteractsWithTable richiede visibilità PUBLIC.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * @return array<string|int, Filter|TernaryFilter|BaseFilter>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
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
     * @return array<int|string, Action|ActionGroup>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    public function getTableActions(): array
    {
        $actions = [];
        $resource = $this;
        // Ripristinato a method_exists() il 2026-09-11: un giro precedente
        // aveva ristretto questo controllo a `$this instanceof ListRecords`,
        // pensato per le pagine, ma XotBaseResourceTable::getTableActions()
        // (usato da OGNI {Model}sTable.php del repo, non solo dalle pagine
        // ListRecords) espone `getResource()` senza essere una ListRecords —
        // verificato dal vivo: la versione ristretta faceva sparire
        // view/edit/delete di default per tutte quelle tabelle (es.
        // ChartsTable::getTableActions() tornava [] invece di
        // view/edit/delete), zero errori, nessuna eccezione. Nessuna
        // giustificazione trovata per la versione ristretta (nessuna story
        // la documenta); il controllo ampio e' quello verificato corretto
        // per il resto di questa sessione.
        if (method_exists($this, 'getResource')) {
            $resourceClass = $this->getResource();
            Assert::string($resourceClass);
            $resource = app($resourceClass);
        }
        Assert::object($resource);

        if (method_exists($resource, 'canView')) {
            $actions['view'] = self::withRecordReturnTo(
                ViewAction::make()
                    ->iconButton()
                    ->visible(static fn (Model $record): bool => (bool) $resource->canView($record)),
                isAnchor: true,
            );
        }

        if (method_exists($resource, 'canEdit')) {
            $actions['edit'] = self::withRecordReturnTo(
                EditAction::make()
                    ->iconButton()
                    ->visible(static fn (Model $record): bool => (bool) $resource->canEdit($record)),
                isAnchor: ! isset($actions['view']),
            );
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

        // Check if class has the getRelationship method
        // Note: In some contexts (ListRecords), getRelationship() may not exist
        if ($this->shouldShowDetachAction() && method_exists($this, 'getRelationship')) {
            $relationship = $this->getRelationship();

            if ($relationship instanceof BelongsToMany) {
                $actions['detach'] = DetachAction::make()
                    ->iconButton()
                    ->tooltip((string) __('user::actions.detach'));
            }
        }

        return $actions;
    }

    /**
     * Azione di riga con `return_to`: dalla pagina view/edit si torna all'elenco sulla stessa riga
     * (`#record-N`, vedi IDColumn). L'URL di destinazione e' quello che Filament assegnerebbe
     * comunque; dove non ce n'e' uno (modale, widget) resta `null`.
     *
     * `$isAnchor`: l'ancora `record-N` sta sull'azione quando nessuna IDColumn e' visibile. Una colonna
     * nascosta di default (la regola nei `*Table` del repo) non entra nel DOM, e senza bersaglio il ritorno
     * non troverebbe la riga. Con l'ID visibile resta lo `<span>` della colonna: mai due `id` uguali.
     */
    private static function withRecordReturnTo(Action $action, bool $isAnchor): Action
    {
        $action->url(static function (Action $action): ?string {
            $url = $action->getHasActionsLivewire()?->getDefaultActionUrl($action);
            $record = $action->getRecord();
            $key = $record instanceof Model ? $record->getKey() : null;

            return $url === null || (! is_int($key) && ! is_string($key))
                ? $url
                : RecordAnchor::appendReturnTo($url, RecordAnchor::currentUrl(), $key);
        });

        if (! $isAnchor) {
            return $action;
        }

        return $action->extraAttributes(static function (Action $action, Model $record): array {
            $key = $record->getKey();

            return (! is_int($key) && ! is_string($key)) || self::hasVisibleIdColumn($action)
                ? []
                : ['id' => RecordAnchor::id($key)];
        });
    }

    private static function hasVisibleIdColumn(Action $action): bool
    {
        foreach ($action->getTable()?->getVisibleColumns() ?? [] as $column) {
            if ($column instanceof IDColumn) {
                return true;
            }
        }

        return false;
    }

    /**
     * Regola per record dell'azione di eliminazione di gruppo (audit DCP-181, A-1): come Filament, un modello SENZA policy resta consentito (la
     * stringa `'delete'` lo negherebbe: `Gate::inspect` senza policy dice no); con una policy decide `delete()` su ogni record.
     *
     * @return \Closure(Model): bool
     */
    public static function bulkDeleteRecordAuthorization(): \Closure
    {
        return static fn (Model $record): bool => Gate::getPolicyFor($record) === null
            || Gate::allows('delete', $record);
    }

    /**
     * Get table bulk actions.
     *
     * CRITICO: Deve essere public perché viene chiamato da Filament/Livewire dall'esterno.
     * Filament\Tables\Concerns\InteractsWithTable richiede visibilità PUBLIC.
     * Vedi: Modules/Xot/docs/filament/widget-method-visibility-rules.md
     *
     * @return array<int|string, BulkAction>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
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
     *
     * @return class-string<Model>
     *
     * @phpstan-return class-string<Model>
     *
     * @throws \Exception Se non viene trovata una classe modello valida
     */
    public function getModelClass(): string
    {
        // Su pagine "related records" / relation manager, getModel() risale al
        // model della Resource proprietaria (es. SurveyPdf), non al model della
        // relazione mostrata in tabella (es. Contact): va usato getRelationship().
        if (method_exists($this, 'getRelationship')) {
            $relationship = $this->getRelationship();
            Assert::isInstanceOfAny($relationship, [Relation::class, Builder::class]);
            $related = $relationship instanceof Builder ? $relationship->getModel() : $relationship->getRelated();
            if ($related instanceof Model) {
                /** @var class-string<Model> $relatedClass */
                $relatedClass = get_class($related);

                return $relatedClass;
            }
        }

        if (method_exists($this, 'getModel')) {
            $model = $this->getModel();
            Assert::string($model);
            if (! is_a($model, Model::class, true)) {
                throw new RuntimeException('Invalid model class '.$model);
            }

            return $model;
        }

        throw new RuntimeException('No model found in '.class_basename(self::class).'::'.__FUNCTION__);
    }

    /**
     * Get table search query.
     *
     * CRITICO: Deve essere public per rispettare il contratto ListRecords.
     */
    public function getTableSearch(): ?string
    {
        if (! property_exists($this, 'tableSearch')) {
            return null;
        }

        $tableSearch = $this->tableSearch;

        if (! filled($tableSearch)) {
            return null;
        }

        $trimmed = Str::trim(SafeStringCastAction::cast($tableSearch));

        return $trimmed !== '' ? $trimmed : null;
    }

    /**
     * Get list table columns.
     *
     * @return array<string, Column|ColumnGroup|LayoutComponent>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    abstract protected function getTableColumns(): array;

    /**
     * Get table heading.
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    protected function getTableHeading(): ?string
    {
        /** @var string $transKey */
        $transKey = app(GetTransKeyAction::class)->execute(static::class);
        $key = Str::of($transKey)
            ->append('.table.heading')
            ->replace('.cluster.pages.', '.')
            ->toString();

        if (Str::startsWith($key, 'edit_')) {
            $key = Str::after($key, 'edit_');
        }

        if (Str::endsWith($key, '_widget')) {
            $key = Str::beforeLast($key, '_widget');
        }

        $trans = trans($key);

        if (! is_string($trans)) {
            return null;
        }

        return $trans !== $key ? $trans : null;
    }

    /**
     * Get table empty state actions.
     *
     * @return array<int|string, Action>
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
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
        return method_exists($this, 'getRelationship');
    }

    protected function shouldShowDetachAction(): bool
    {
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
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        $create = CreateAction::make()->icon('heroicon-o-plus');

        return ['create' => $create];
    }

    /**
     * Get table filters layout.
     */
    protected function getTableFiltersLayout(): FiltersLayout
    {
        return FiltersLayout::AboveContent;
    }

    /**
     * Get table record actions position.
     */
    protected function getTableRecordActionsPosition(): RecordActionsPosition
    {
        return RecordActionsPosition::BeforeColumns;
    }

    /**
     * Whether table rows are striped.
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    protected function isTableStriped(): bool
    {
        return true;
    }

    /**
     * Whether table filters persist in session.
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

    /**
     * Get table pagination options.
     * Can return bool (true/false) or array of page sizes [10, 25, 50, 100].
     *
     * @return bool|array<int, int|string>
     */
    protected function getTablePaginated(): bool|array
    {
        return true;
    }

    /**
     * Get default table sort column.
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
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
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
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
            ->modifyQueryUsing(
                static fn (Builder $query): Builder => $query->whereNull('id')
            )
            ->columns([
                TextColumn::make('message')
                    ->default(__('user::fields.message.default'))
                    ->html(),
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

    /**
     * Check if model has a specific column via schema introspection.
     * Generic, reusable method for any column check.
     */
    protected function hasColumn(string $column): bool
    {
        $modelClass = $this->getModelClass();
        $model = app($modelClass);
        Assert::isInstanceOf($model, Model::class);

        // Cache per connessione.tabella.colonna ora in ModelHasColumnAction, condivisa con i componenti
        // Filament che si nascondono dove la colonna manca.
        return app(ModelHasColumnAction::class)->execute($model, $column);
    }

    /**
     * Get the column name used for table reordering.
     * Returns 'order_column' if it exists in the model's table, null otherwise.
     */
    protected function getOrderColumn(): ?string
    {
        if ($this->hasColumn('order_column')) {
            return 'order_column';
        }

        return null;
    }

    /**
     * Apply reorderable to table if order column is available.
     */
    protected function applyReorderable(Table $table): Table
    {
        $orderColumn = $this->getOrderColumn();

        if ($orderColumn !== null) {
            return $table->reorderable($orderColumn);
        }

        return $table;
    }
}
