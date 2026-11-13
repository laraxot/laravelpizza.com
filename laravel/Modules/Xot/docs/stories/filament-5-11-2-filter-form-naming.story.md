---
title: Filament 5.11.2 inverte form()/schema() sui filtri - vincolo ^5.11.2 e guardia sul vendor
status: review
owner: Xot
created: 2026-11-10
related:
  - xot-widgets-islazyloaded-filament-511.story.md
  - ../../../Geo/docs/stories/geo-exposed-attribute-filament-511.story.md
  - ../../../../../docs/stories/rebase-pull-untracked-ignored-files-restore.story.md
---

# Filament 5.11.2 inverte form()/schema() sui filtri

## Fase BMAD

Dev (bugfix dopo il pull dei moduli del 2026-11-10 pomeriggio). Richiesta dell'utente: risolvere i
2 errori PHPStan `method.deprecated` seguendo le linee guida.

## Problema

```
User/.../RoleResource/RelationManagers/UsersRelationManager.php:81  Call to deprecated method form() of class BaseFilter: Use `schema()` instead.
Xot/app/Filament/Builders/FilterBuilder.php:90                       Call to deprecated method form() of class BaseFilter: Use `schema()` instead.
```

## Causa: il vendor locale e' indietro, non il codice

Filament **v5.11.2** (2026-11-07, [filamentphp/filament#20956](https://github.com/filamentphp/filament/pull/20956)
"align form-specific API naming") ha invertito la deprecazione sui filtri di tabella:

| Versione | Trait | Canonico | Deprecato |
|---|---|---|---|
| v5.11.0, v5.11.1 | `Filters\Concerns\HasSchema` | `schema()` | `form()` |
| v5.11.2 | `Filters\Concerns\HasForm` (`HasSchema` diventa alias deprecato) | `form()`, `getFormSchema()`, `hasForm()`, `getForm()` | `schema()`, `getSchemaComponents()`, `hasSchema()`, `getSchema()` |

La stessa PR rinomina anche `ChartWidget\Concerns\HasFiltersSchema` -> `HasFiltersForm` (`filtersForm()`,
`getFiltersForm()`) e i metodi MFA `get*SchemaComponents()` -> `get*FormComponents()`. I vecchi nomi
restano come alias: `filtersForm()` delega a `filtersSchema()`, `getFiltersForm()` a `getFiltersSchema()`,
quindi gli override esistenti continuano a funzionare.

Il vendor di questo mono e' `filament/tables v5.11.0`; quello di Marco e del clone `base_predict_fila5` e'
v5.11.2. Il vincolo dichiarato (`filament/filament: ^5.11`) accetta entrambi, quindi ogni ambiente
"corregge" il codice verso il proprio vendor:

| Quando | Dove | Vendor | Cambio |
|---|---|---|---|
| 2026-11-09 | Marco, Xot `e29b74f8c7`, User `99ef2f364` | 5.11.2 | `schema()` -> `form()` |
| 2026-11-10 09:48 | questo mono, Xot `043989d5c3`, User `5169aeb73` | 5.11.0 | `form()` -> `schema()` |
| 2026-11-10 15:40 | clone predict, Xot `aee0cee7c8`, User `dbc393e6a` | 5.11.2 | `schema()` -> `form()` |

E' lo stesso ping-pong del 2026-11-05 (`#[Exposed]`/`$isLazyLoaded`, vedi
[xot-widgets-islazyloaded-filament-511](xot-widgets-islazyloaded-filament-511.story.md)), che si era chiuso
alzando il vincolo al minimo reale.

## Decisione

1. **Il codice dei due file non si tocca**: la versione di HEAD dei moduli (`form()`) e' la piu' recente ed
   e' quella giusta per il Filament corrente. Riportarla a `schema()` sarebbe il quarto giro del ping-pong.
2. `Modules/Xot/composer.json`: `filament/filament` da `^5.11` a **`^5.11.2`**, il minimo per cui
   `form()` sui filtri non e' deprecato. `docs/structure.md` allineato.
3. Le due chiamate `->schema()` su filtri rimaste nel monorepo, in moduli che il clone predict non ha (quindi
   mai viste con 5.11.2), passano a `->form()`:
   - `Quaeris/app/Datas/DashboardFilterData.php` (`Filter::make('sent')`);
   - `Quaeris/app/Filament/Resources/ContactResource/Tables/ContactsTable.php` (`Filter::make('search_contacts')`).
   `->form()` esiste su ogni 5.x (alias deprecato sotto 5.11.2), quindi nessun rischio a runtime su un server
   ancora a 5.11.0.
4. Guardia nuova `tests/Unit/InstalledVendorSatisfiesXotConstraintsTest.php`: ogni pacchetto di
   `require`/`require-dev` di questo `composer.json` installato deve soddisfare il vincolo dichiarato. Un
   vendor rimasto indietro fallisce qui con il comando da lanciare, invece di presentarsi come
   `method.deprecated` da "correggere" nel codice.

Fuori perimetro, di proposito:
- `PermissionsTable.php:111` usa `->schema()` su una **Action**: le Action non sono toccate dalla PR.
- `Quaeris/resources/views/filament/widgets/question-chart-item-widget.blade.php:57` chiama
  `getFiltersSchema()`: deprecato da 5.11.2 ma funzionante, PHPStan non analizza Blade. Il nuovo
  `getFiltersForm()` non esiste sotto 5.11.2: passarci solo dopo aver confermato 5.11.2 sul server.
- Le chiamate ai metodi `->label()` in `FilterBuilder` (regola no-filament-labels): debito preesistente, non
  legato a questo errore.

## Da fare dall'utente

```bash
cd laravel && composer update 'filament/*' -W
```

(`composer.lock` non e' tracciato, quindi non resta niente da committare per il lock.) Al deploy: il server
deve avere `filament/filament >= 5.11.2`.

## Verifica

Con il vendor di questo mono (`filament/tables v5.11.0`, prima del `composer update`):

| Gate | Risultato |
|---|---|
| PHPStan sui 5 file toccati/segnalati (`laravel/phpstan.neon`) | 4 errori, tutti `form()` deprecato sui filtri (i 2 originali + i 2 Quaeris): attesi finche' il vendor e' 5.11.0; il test nuovo 0 |
| PHPStan con Filament 5.11.2 (clone `base_predict_fila5`, `FilterBuilder.php` e `UsersRelationManager.php` identici byte per byte) | `[OK] No errors` |
| `InstalledVersions::satisfies('filament/filament', '^5.11.2')` | `false` qui, `true` nel clone predict |
| Pest `InstalledVendorSatisfiesXotConstraintsTest` | 63 passati, 1 fallito: `filament/filament installato v5.11.0, dichiarato ^5.11.2` con il comando da lanciare. E' il comportamento voluto; verde dopo l'update |
| Pint sul test | passed |
| PHPMD (`tools/phpmd.sh`) | test nuovo: nessun finding; Quaeris: solo finding preesistenti, nessuno sulle righe toccate |
| PHPInsights sul test | code 98.9, complexity 100, architecture 100, style 96.3; restano `new` senza parentesi e spaziatura degli `use` (impostati da Pint, che prevale) e "side effects" (inevitabile in un file Pest) |

Da rifare dopo `composer update 'filament/*' -W`: PHPStan intero progetto (atteso 0) e il test (atteso tutto verde).

GitHub: issue [#215](https://github.com/laraxot/base_quaeris_fila5/issues/215), discussion
[#216](https://github.com/laraxot/base_quaeris_fila5/discussions/216) (regola: deprecazione dopo un pull ->
prima confrontare il vendor con quello dell'autore del commit).

## Seguito: PHPStan dopo `composer update 'filament/*' -W` (2026-11-10 sera)

Vendor ora `filament/filament`, `filament/tables` v5.11.2, `livewire/livewire` v4.4.8. PHPStan intero
progetto: i 4 `form()` deprecati spariscono, ne arrivano **8** nuovi.

| File | Errori | Causa | Correzione |
|---|---|---|---|
| `Quaeris/tests/Feature/Filament/QuaerisPanelWithoutTenantRegistrationAndProfileTest.php` | 3 `method.nonObject` | Filament 5.11.1 corregge il docblock della Facade: `@method static Panel getPanel(...)` -> `Panel \| null` (il metodo restituiva gia' `?Panel`: `null` se il pannello non e' registrato) | `Assert::assertInstanceOf(Panel::class, $panel)`, il pattern gia' usato in `Notify/tests/Feature/SpatieTranslatablePluginTest.php`: un pannello mancante diventa un'asserzione leggibile invece di un `Error` su `null` |
| `Quaeris/tests/Feature/Filament/TenantSwitcherListsAllUserCustomersTest.php` | 2 `argument.type` | stessa causa | stessa correzione |
| `Xot/app/Http/Middleware/SecurityMiddleware.php` | 2 `typeCoverage.constantTypeCoverage` | Xot `2369eda985` (oggi 15:10, rate limiting per IP) aggiunge `DEFAULT_LIMIT` e `STRICT_LIMITS` senza tipo: le costanti tipizzate scendono a 244/247 (98,7 %), sotto la soglia di progetto del 99 % | `private const int`, `private const array` |
| `DbForge/app/Console/Commands/ViewDatabaseConfigCommand.php` | 1 `typeCoverage.constantTypeCoverage` | costante senza tipo dal 2026-10-20; sopra soglia finche' era l'unica, segnalata ora che il totale e' sotto il 99 % | `private const array`, come il gemello `Xot/app/Console/Commands/ViewDatabaseConfigCommand.php:25` |

La soglia `typeCoverage` e' di progetto (wiki `memories/typecoverage-global-threshold-full-tree-only.md`):
un errore compare su ogni costante non tipizzata appena il totale scende sotto il 99 %, quindi DbForge e'
segnalato per colpa del commit Xot. Obiettivo 100 %: si tipizzano tutte e tre.

### Pest rotto dopo il dump: `Modules\Xot\Tests\XotBaseTestCase` non autoloadabile

Il `composer update` ha rigenerato l'autoload (16:57) dal `composer.json` attuale di Xot, dove
`autoload-dev` e' `{"classmap": ["tests/"]}` (Marco, `81f55b2b6d` 11-08, tenuto nel conflitto `1022ce6cb9`
11-09; prima era `{}`). Il root ha `exclude-from-classmap: ["Modules/*/tests/"]` dal 2026-08-25
(regola `bashscripts/ai/wiki/rules/composer-psr4-test-stub-classes.md`), quindi quella classmap non carica
niente: `Pest\Exceptions\TestCaseClassOrTraitNotFound` su ogni test Xot, `Class "Modules\Xot\Tests\XotBaseTestCase"
not found` su ogni test dei moduli che lo estendono (Quaeris compreso). Il clone predict non ha l'esclusione
nel root, per questo li' la classmap funziona.

La regola `bashscripts/ai/wiki/docs/module-rules.md` ("Composer autoload-dev per moduli, OBBLIGATORIO")
prescrive `psr-4: {"Modules\\<Modulo>\\Tests\\": "tests/"}`, come negli altri 18 moduli. Correzione: nodo
psr-4 aggiunto, `classmap` di Marco lasciata (qui esclusa dal root, innocua; utile nei cloni senza
esclusione), cosi' non si apre un altro ping-pong. Poi `composer dump-autoload`.

### Verifica del seguito

| Gate | Risultato |
|---|---|
| PHPStan intero progetto | `[OK] No errors` (da 8) |
| Pint sui 4 PHP | passed; su `SecurityMiddleware.php` applicato anche a una riga preesistente (ordine degli `use`) |
| PHPMD | DbForge e i due test Quaeris puliti; `SecurityMiddleware`: 3 finding preesistenti del commit `2369eda985` (`BooleanArgumentFlag`, `ShortVariable $ip`), nessuno sulle costanti |
| Costanti | `php -l` ok; reflection: `DEFAULT_LIMIT` int 300, `STRICT_LIMITS` e `SECRET_KEY_PARTS` array, valori invariati |
| Pest, con bootstrap di prova che registra la stessa voce psr-4 (vendor non toccato) | guardia `InstalledVendorSatisfiesXotConstraintsTest` 64/64 verde; `QuaerisPanelWithoutTenantRegistrationAndProfileTest` 1/1 (4 asserzioni); `TenantSwitcherListsAllUserCustomersTest` rosso alla riga 52 per un bug vero, vedi sotto |
| Pest dei test Xot su `SecurityMiddleware` | non eseguibili: `SQLiteDatabaseDoesNotExistException` nel setup (difetto noto dell'harness Xot locale), non arrivano al codice |

Resta all'utente: `cd laravel && composer dump-autoload` per scrivere la voce psr-4 nell'autoload vero.

Bug scoperto da `TenantSwitcherListsAllUserCustomersTest`, non legato a Filament: `BaseTenant` usa
`HasUuids` (User `2e4612eaa`, 2026-11-05), che rende `Quaeris\Models\Customer` (chiave intera
auto-increment) `keyType = 'string'`, `incrementing = false`, `uniqueIds() = ["id"]`. Analisi e correzioni
possibili in `Quaeris/docs/stories/quaeris-tenant-switcher-lists-all-user-customers.story.md`; decisione
all'utente.

Fuori perimetro: `DbForge/.../ViewDatabaseConfigCommand.php` e' una copia del comando Xot (stesso
`SECRET_KEY_PARTS`, stesso `isSecret()`), segnalata come debito DRY, non toccata qui.

## Note di processo

- `bashscripts/tools/claims-open.py` citato dalle regole non esiste piu' nel repo: lock controllati con
  `bashscripts/lock/check.sh` (nessun lock attivo), presi con `lock.sh` (task `filament-5112-filter-form`).
- GitHub `laraxot/base_quaeris_fila5`: nessuna issue o discussion su Filament 5.11.2 / form-schema dei filtri.
