<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Resources\Pages\ManageRelatedRecords as FilamentManageRelatedRecords;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Filament\GetRelatedResourceClassAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

/**
 * Pagina "related records": mostra i record di una RELAZIONE di un owner
 * (es. i Contact di un SurveyPdf), con la stessa qualita' (colonne, filtri,
 * azioni, autorizzazioni) con cui la Resource propria del model mostrato
 * (`ContactResource`) li mostrerebbe da sola — mai con quella della
 * Resource dell'owner.
 *
 * DESIGN (settima direzione, 2026-09-11 — corregge la sesta): `HasXotTable`
 * NON e' usato qui, di proposito. La sesta direzione lo aveva reintrodotto
 * pensando (a torto, mai verificato empiricamente) che senza il trait sulla
 * PAGINA si perdessero layout toggle/sort/poll/striped/ecc. — falso: quei
 * comportamenti li applica GIA' `HasXotTable::table()` dentro
 * `$resourceClass::table($table)` sotto, perche' la Resource CORRELATA
 * (`ContactsTable` e ogni `XotBaseResourceTable`) usa il trait a sua volta.
 * Il `Table` che arriva qui da quella chiamata e' gia' completo — non serve
 * applicare `HasXotTable::table()` una seconda volta sulla pagina.
 *
 * Non e' solo ridondante, e' DANNOSO (proposta dell'utente di reintrodurre
 * `use HasXotTable { table as parentTable; }` + `$this->parentTable($table)`
 * al posto dei 5 setter sotto, valutata e respinta il 2026-09-11 sera —
 * osservazione DRY corretta, ma verificato sul CODICE del trait, non solo
 * sulla story, il motivo per cui non si puo' applicare): `HasXotTable::table()`
 * imposta INCONDIZIONATAMENTE ~10 aspetti oltre alle 5 colonne/azioni/filtri
 * di contenuto — `striped()`, `paginated()`, `defaultSort()`, `poll()`,
 * `recordActionsPosition()`, `filtersLayout()`, `deferFilters()`,
 * `persistFiltersInSession()`, `emptyStateActions()`, `heading()` — usando i
 * DEFAULT di QUESTA classe. Chiamarlo una seconda volta sul `$table` gia'
 * restituito da `$resourceClass::table($table)` sovrascriverebbe silenziosamente
 * qualunque valore Contact-specifico (o specifico della Resource correlata)
 * che `ContactsTable`/`XotBaseResourceTable` avesse impostato per uno di quei
 * 10 aspetti, con i default generici di questa pagina — la stessa classe di
 * bug (config sovrascritta da una seconda passata) gia' vista oggi con
 * `pushColumns()`, qui su dieci proprieta' diverse invece che sulle colonne.
 *
 * Riusarlo qui viola direttamente la story
 * `18.27.hasxottable-fuori-dai-componenti-filament.story.md` (2026-09-08,
 * ready-for-dev PRIMA di questa sessione — andava letta prima di
 * implementare, non dopo un rimprovero): `HasXotTable` implementa hook
 * dell'interfaccia Filament `Contracts\HasTable` che li marca deprecati
 * per i componenti Pagina/RelationManager/Widget ("famiglia B"), costringendo
 * a un ignore PHPStan mirato per ogni chiamata (78 nel trait stesso — costo
 * gia' misurato, non stimato). CORREZIONE (2026-09-11, verificato via grep,
 * non solo la story): `HasXotTable` NON dichiara i due nomi canonici del
 * contratto nativo `getTableSortColumn()`/`getTableSortDirection()` (legge
 * `$tableSort` di Livewire) — dichiara solo `getDefaultTableSortColumn()`/
 * `getDefaultTableSortDirection()`, apposta diversi. Il click
 * sull'intestazione di colonna NON e' rotto oggi da nessuna parte: e'
 * PROPRIO il motivo per cui il trait evita quei due nomi (vedi
 * `18.28.hook-sort-nomi-canonici-tabella.story.md`) — un rischio evitato
 * di proposito, non un bug attivo. `XotBaseManageRelatedRecords` e'
 * nominata esplicitamente in quella story come una delle 5 classi da
 * migrare via da `HasXotTable`. Il precedente gia' migrato e verificabile e'
 * `XotBaseListRecords.php` (commit `23965cd0b`, 2026-09-08): stesso
 * principio, "la tabella si configura nella Table class", applicato li'
 * senza alcun hook (le List page hanno un solo Resource possibile); qui
 * serve mantenere i 5 hook di CONTENUTO (sotto) perche' la delega e' verso
 * la Resource CORRELATA, non quella proprietaria della pagina, e alcune
 * pagine (`ManageContacts`, `ManageQuestionCharts`) hanno bisogno di
 * differenze legate al contesto owner che la Table class correlata non puo'
 * conoscere.
 *
 * `table()` costruisce la tabella della Resource CORRELATA
 * (`$resourceClass::table($table)`, gia' completa: colonne, azioni,
 * filtri, layout toggle, sort, poll, tutto) e applica sopra i 5 hook di
 * CONTENUTO con l'API NATIVA di `Table` (`->columns()`, `->headerActions()`,
 * `->recordActions()`, `->toolbarActions()`, `->filters()`) — non e' una
 * reimplementazione di `HasXotTable::table()`: sono 5 setter Filament
 * puri, usati esattamente come li userebbe qualunque pagina Filament senza
 * trait Xot. Gli ALTRI comportamenti (striped, paginated, sort, poll,
 * layout toggle...) restano quelli gia' applicati dalla Resource correlata,
 * mai toccati qui.
 *
 * Un override in una sottoclasse SOSTITUISCE solo quell'hook; per estendere
 * invece di sostituire: `[...propri, ...parent::getTableXxx()]`.
 *
 * `getModelClass()' e' ridefinito qui (sotto), non ereditato da un trait —
 * stesso pattern di `XotBaseListRecords::getModelClass()`. Storia
 * dell'incidente che ha reso questo pezzo critico: una prima versione
 * (2026-09-11) rimuoveva `HasXotTable` senza spostare `getModelClass()`
 * altrove — quel trait era l'ALLORA unica fonte del metodo, e
 * `GetRelatedResourceClassAction` lo usa per il fallback per convenzione. Il
 * risultato in produzione: `getRelatedResourceClass()` sempre `null` per
 * ogni pagina senza `$relatedResource` esplicito, poi `null::configure()` →
 * `Class name must be a valid object or a string`. Da allora
 * `getModelClass()` vive SEMPRE direttamente su questa classe, mai da un
 * trait — guardia automatica in `XotBaseManageRelatedRecordsRegressionTest`.
 *
 * CORREZIONE (2026-09-11, sera): il paragrafo che seguiva qui affermava che
 * le pagine con esigenze piu' profonde "chiamano SEMPRE parent::table()
 * per primo" — falso, verificato sui 3 consumer reali che sovrascrivevano
 * `table()` per intero (`ManageRolePermissions`, `ManageMailTemplates`,
 * `ManageSurveyPdfQuestionCharts`): NESSUNO chiamava `parent::table()`.
 * `form()` e `table()` sono ORA entrambi `final` (vedi sotto): i 3 consumer
 * sono stati migrati agli hook (`getFormSchema()`/i 5 hook di contenuto per
 * `ManageRolePermissions`; `modifyRelatedQuery()` — 6° hook, query scoping —
 * per `ManageMailTemplates`), nello stesso commit che ha aggiunto
 * `modifyRelatedQuery()`. Nessun override di `table()`/`form()` resta nel
 * repo — guardia automatica in `XotBaseManageRelatedRecordsRegressionTest`
 * (test "form() e table() sono final").
 *
 * @template TModel of Model = Model
 *
 * @see Modules/Xot/docs/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php.md
 * @see Modules/Xot/docs/stories/xotbasemanagerelatedrecords-convention-over-configuration.story.md
 * @see Modules/Xot/docs/stories/18.27.hasxottable-fuori-dai-componenti-filament.story.md
 */
abstract class XotBaseManageRelatedRecords extends FilamentManageRelatedRecords
{
    use NavigationLabelTrait;

    /**
     * Stato conservato sulla pagina per gli schemi Xot con statePath('data').
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Tabella della Resource CORRELATA, gia' costruita da table() sotto —
     * unica fonte dei default dei 5 hook di contenuto, mai ricalcolata da
     * loro.
     *
     * PROTECTED, non public: Livewire sincronizza (idrata/deidrata) solo le
     * proprieta' PUBBLICHE di un componente, e solo per tipi che sa
     * serializzare (scalari, array, Enum, oggetti Wireable/Synthesizable) —
     * `Filament\Tables\Table` non lo e', quindi dichiararla public causerebbe
     * "Property type not supported in Livewire for property: [...]" al primo
     * render. CORREZIONE (2026-09-11): il riferimento precedente a
     * `HasXotTable::$_table` come precedente reale era falso — verificato
     * (`grep`/`git log -S` su tutta la storia del file):
     * `HasXotTable.php` non ha mai dichiarato una property `$_table`, ne'
     * ora ne' in passato. Restava PROTECTED per la ragione Livewire sopra,
     * corretta a prescindere da quella citazione inventata.
     */
    protected ?Table $relatedResourceTable = null;

    /**
     * Schema della Resource CORRELATA, gia' costruito da form() sotto —
     * unica fonte del default di getFormSchema(), mai ricalcolato da esso.
     * PROTECTED per lo stesso motivo di `$relatedResourceTable` sopra.
     */
    protected ?Schema $relatedResourceSchema = null;

    /** Attributo del titolo dell'owner, non del record correlato. */
    protected static string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string
    {
        return '';
    }

    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    public function getTitle(): string
    {
        return static::transFunc(__FUNCTION__).' - '.$this->getRecordTitle();
    }

    /** Legge il titolo dall'owner risolto da Filament. */
    public function getRecordTitle(): string
    {
        return SafeStringCastAction::cast(
            $this->getOwnerRecord()->getAttribute(static::$recordTitleAttribute),
        );
    }

    /**
     * `final` per lo stesso motivo di `HasXotForm::form()` (anch'esso
     * `final`, vedi `Modules/Xot/app/Filament/Traits/HasXotForm.php:25`):
     * costruisce lo schema della Resource CORRELATA (`$resourceClass::form()`,
     * gia' completo) e applica sopra l'UNICO override point,
     * `getFormSchema()`, con l'API nativa `Schema::components()` (resetta poi
     * assegna, mai un accumulo tipo `pushColumns()` — vedi il bug di
     * duplicazione colonne gia' preso e corretto altrove in questa stessa
     * saga). Nessuna pagina deve piu' sovrascrivere `form()` per intero: chi
     * ha bisogno di un form diverso sovrascrive `getFormSchema()`.
     */
    final public function form(Schema $schema): Schema
    {
        $resourceClass = $this->getRelatedResourceClass();
        $this->relatedResourceSchema = $resourceClass::form($schema);

        return $this->relatedResourceSchema->components($this->getFormSchema());
    }

    /**
     * Override point per i componenti del form. Default: quelli della
     * Resource correlata (vedi form() sopra). Un override sostituisce
     * (nessun merge implicito); per estendere:
     * `[...propri, ...parent::getFormSchema()]`.
     *
     * @return array<Component|Action|ActionGroup>
     */
    public function getFormSchema(): array
    {
        return $this->relatedResourceSchema?->getComponents() ?? [];
    }

    /**
     * Costruisce la tabella della Resource CORRELATA — colonne, azioni,
     * filtri, layout toggle, sort, poll, tutto gia' applicato da
     * `HasXotTable::table()` DENTRO `$resourceClass::table()`, perche' la
     * Table class correlata (`ContactsTable`, ecc.) usa il trait a sua
     * volta — poi applica sopra i 5 hook di CONTENUTO con l'API nativa di
     * `Table`. Nessun trait Xot usato qui: vedi docblock di classe.
     *
     * Se `$relatedResource` nativo e' impostato (es. `ManageQuestionCharts`),
     * Filament ha gia' chiamato `$relatedResource::configureTable($table)`
     * dentro `makeTable()` prima che questo metodo esegua: chiamare di nuovo
     * `$resourceClass::table($table)` qui e' ridondante ma non scorretto
     * (stesso risultato, calcolato due volte) — accettato per tenere un
     * solo percorso di risoluzione invece di un `if` speciale.
     *
     * `final` dal 2026-09-11, stesso motivo di `form()` sopra: prima di
     * questo, piu' sessioni concorrenti hanno sovrascritto `table()` per
     * intero (motivato ogni volta come "eccezione legittima" — vedi storia
     * dell'incidente nel docblock di classe), perdendo ogni volta pezzi
     * diversi del comportamento condiviso. Un `final` rende quella classe
     * di errore un fatal error di compilazione invece di una regressione
     * runtime silenziosa. Le uniche due pagine che sovrascrivevano `table()`
     * per intero (`ManageMailTemplates`, `ManageRolePermissions`)
     * sono state migrate agli hook (`modifyRelatedQuery()` per il primo,
     * i 5 hook di contenuto per il secondo) nello stesso commit.
     */
    final public function table(Table $table): Table
    {
        $resourceClass = $this->getRelatedResourceClass();
        $this->relatedResourceTable = $resourceClass::table($table)
            ->modifyQueryUsing(fn (Builder $query): Builder => $this->modifyRelatedQuery($query));

        return $this->relatedResourceTable
            ->columns($this->getTableColumns())
            ->headerActions($this->getTableHeaderActions())
            ->recordActions($this->getTableActions())
            ->toolbarActions($this->getTableBulkActions())
            ->filters($this->getTableFilters());
    }

    /**
     * Override point per lo scoping della query (es. filtrare per slug
     * dell'owner in `ManageMailTemplates`). Default: nessuna modifica.
     * `Table::modifyQueryUsing()` ACCUMULA i callback (vedi
     * `HasQuery::modifyQueryUsing()`, `$this->queryScopes[] = $callback`),
     * non li sostituisce: aggiungere questo hook non perde nessuno scoping
     * (es. tenant) gia' applicato da `$resourceClass::table()`.
     *
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    protected function modifyRelatedQuery(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Override point per le colonne. Default: quelle della Resource
     * correlata (vedi table() sopra). Un override sostituisce (nessun merge
     * implicito); per estendere: `[...proprie, ...parent::getTableColumns()]`.
     *
     * @not-deprecated Hook di progetto omonimo a un nome deprecato di Filament: API attiva di questa classe.
     *
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return $this->relatedResourceTable?->getColumns() ?? [];
    }

    /**
     * Override point per le azioni header. Stessa semantica di
     * getTableColumns(). Le azioni header di una pagina "related" sono
     * tipicamente legate al contesto dell'OWNER (es. `ImportAction` con
     * `survey_pdf_id` in `ManageContacts`) — il default della Resource
     * correlata non le conosce comunque.
     *
     * @not-deprecated Hook di progetto omonimo a un nome deprecato di Filament: API attiva di questa classe.
     *
     * @return array<int|string, Action|BulkAction|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        return $this->relatedResourceTable?->getHeaderActions() ?? [];
    }

    /**
     * Override point per le azioni riga (record actions). Stessa semantica.
     *
     * @not-deprecated Hook di progetto omonimo a un nome deprecato di Filament: API attiva di questa classe.
     *
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return $this->relatedResourceTable?->getRecordActions() ?? [];
    }

    /**
     * Override point per le azioni bulk (toolbar actions). Stessa
     * semantica. Senza questo hook, il fallback sarebbe `[]` — nessuna
     * azione bulk — invece delle azioni reali della Resource correlata
     * (es. make-token/send-invite/send-spatie-email di `ContactsTable`).
     *
     * @not-deprecated Hook di progetto omonimo a un nome deprecato di Filament: API attiva di questa classe.
     *
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableBulkActions(): array
    {
        return $this->relatedResourceTable?->getToolbarActions() ?? [];
    }

    /**
     * Override point per i filtri. Stessa semantica.
     *
     * @not-deprecated Hook di progetto omonimo a un nome deprecato di Filament: API attiva di questa classe.
     *
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return $this->relatedResourceTable?->getFilters() ?? [];
    }

    /**
     * Risolve la Resource UI del model della RELAZIONE (mai quella
     * proprietaria della pagina, vedi docblock di classe). Priorita':
     * `$relatedResource` nativo Filament se dichiarato (gia' usato da
     * `ManageQuestionCharts`), altrimenti convenzione per nome sul model
     * della relazione — mai `Filament::getModelResource()` (verificato dal
     * vivo: scoped al pannello corrente, cieco su model di altri moduli, e
     * per `QuestionChart` risolverebbe una Resource diversa da quella
     * dichiarata esplicitamente dalla pagina).
     *
     * NON usare mai `$this->getResource()` qui: identifica la Resource
     * PROPRIETARIA della pagina, non quella della relazione.
     *
     * @return class-string<XotBaseResource>
     *
     * @throws \InvalidArgumentException Se nessuna Resource e' risolvibile — fallire rumorosamente e' preferibile a un default silenzioso su una pagina che si aspetta dati reali.
     */
    protected function getRelatedResourceClass(): string
    {
        $resourceClass = app(GetRelatedResourceClassAction::class)->execute($this);

        Assert::notNull($resourceClass, 'Nessuna Resource correlata risolvibile per '.static::class.'.');

        return $resourceClass;
    }

    /**
     * Modello delle righe mostrate (la relazione), distinto dal modello
     * dell'owner. Ridefinito DIRETTAMENTE qui, mai da un trait: vedi
     * l'incidente storico nel docblock di classe. Stesso pattern di
     * `XotBaseListRecords::getModelClass()`.
     *
     * `getRelationship()` (nativo Filament,
     * `ManageRelatedRecords::getRelationship(): Relation|Builder`) non
     * restituisce MAI una stringa — verificato via Reflection sul metodo
     * nativo. Una variante di questo metodo che trattava
     * `is_string($relationship)` come caso possibile e' stata reintrodotta
     * piu' volte lo stesso giorno da sessioni concorrenti: oltre a essere
     * morta, lasciava il caso reale `Builder` (non `Relation`) senza
     * gestione, sempre finito nel throw. Guardia automatica in
     * `XotBaseManageRelatedRecordsRegressionTest`.
     *
     * @return class-string<Model>
     */
    public function getModelClass(): string
    {
        $relationship = $this->getRelationship();

        $related = $relationship instanceof Builder
            ? $relationship->getModel()
            : $relationship->getRelated();

        return $related::class;
    }
}
