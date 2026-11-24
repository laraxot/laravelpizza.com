---
title: "Contratto delle classi XotBase"
type: base-contract
contract: Modules\\Xot
tags: [xot, xotbase, contratti, ereditarieta, filament, phpstan]
created: 2026-11-19
updated: 2026-11-19
---

# Contratto delle classi XotBase

Xot non e' un modulo come gli altri: e' il modulo delle classi base. Gli altri 18 moduli di questo
monorepo non lo usano, lo **estendono**. Una firma cambiata qui non resta qui.

Questo file dice cosa una classe `XotBase*` **garantisce** a chi la estende e cosa **pretende** in
cambio. Serve a rispondere a una domanda sola, che e' la domanda che rende rischiosa ogni modifica a
questo modulo: *se tocco questo metodo, cosa si rompe negli altri moduli?*

Regola che ne discende, e che vale per chiunque modifichi un file di questo elenco:

> Una correzione che tocca una classe `XotBase*` non e' verificata finche' non gira la suite di
> almeno un modulo consumatore. Il modulo stesso che passa non prova niente.

## Perche' questo file esiste

Tre quarti delle segnalazioni dell'analizzatore statico su Xot non erano difetti del codice di Xot:
erano **contratti non scritti**. Un `@property` che manca su una classe base produce una segnalazione
in ogni modulo che la estende; un tipo di ritorno assente si propaga allo stesso modo. Finche' il
contratto vive solo nella testa di chi ha scritto la classe, ogni consumatore lo indovina, e lo
indovina diverso.

## Le famiglie

### `XotBaseResource` — le Resource Filament

`Modules/Xot/app/Filament/Resources/XotBaseResource.php`

**Garantisce**

- `getModel(): class-string<Model>`. Se la Resource non dichiara `$model`, il modello si deduce dal
  nome (`ContactResource` → `Modules\<Modulo>\Models\Contact`) e si memoizza **per `static::class`**,
  non nella property. La property `$model` di Filament sta sul parent: una Resource che non la
  ridichiara scrive in uno slot condiviso con tutte le altre nella stessa condizione (457 su 571 in
  questo progetto), e la prima risolta detterebbe il modello a tutte. La mappa indicizzata evita la
  contaminazione.
- `getFormClass()`, `getTableClass()`, `getInfolistClass()` risolvono la classe della parte
  (`Schemas\{Model}Form`, `Tables\{Modelli}Table`, `Schemas\{Model}Infolist`) in tre tentativi: nome
  dal modello, nome dalla Resource, Resource registrata per il modello. Il passo 2 serve quando piu'
  Resource condividono un modello.
- `getModuleName(): string` — il nome del modulo dal namespace.
- `trans()` — non lancia mai per una chiave mancante: restituisce `fix:<chiave>`, che e' visibile
  nell'interfaccia e quindi si corregge.
- `getNavigationBadge()` non propaga mai un'eccezione: in caso di errore riporta `'--'` e segnala
  l'eccezione con `report()`. Un badge non deve poter rompere la navigazione.

**Pretende**

- `form()`, `infolist()` e `getFormSchema()` sono **`final`**. Non si sovrascrivono: lo schema si
  scrive nella classe `Schemas\{Model}Form`, che estende `XotBaseResourceForm` e implementa
  `getFormSchema(): array`, dichiarato `abstract` li'.
- `getFormSchemaOld()` **non** e' `final` ed e' un ponte di migrazione: una cinquantina di Resource lo
  sovrascrive ancora. Renderlo `final` o `abstract` fa fallire il bootstrap con
  `Cannot override final method` e blocca anche l'analizzatore statico.
- La classe tabella deve estendere `XotBaseResourceTable` e implementare
  `getTableColumns(): array<string, Column>` (`abstract`).

**Effetto di una modifica qui**: ogni Resource di ogni modulo. E' la classe base piu' estesa del
monorepo.

### `XotBaseResourceTable`, `XotBaseResourceForm` — le parti di una Resource

`XotBaseResourceTable::configure()` rifiuta di essere chiamata sulla classe base
(`LogicException`): va chiamata su una classe concreta. `getResource()` deduce la Resource
proprietaria dal namespace, tagliando su `\Tables\`; `getModelClass()` delega a
`getResource()::getModel()`.

`$tableSearch` e' dichiarata **solo** come `@property` nel docblock di classe, mai come property
vera: chi consuma `HasXotTable` in un contesto Livewire la fornisce a runtime. Dichiararla
ricreerebbe un conflitto di composizione gia' risolto.

### `XotBaseModel` — i modelli

`Modules/Xot/app/Models/XotBaseModel.php`

**Garantisce**

- connessione `xot` come default, `$perPage = 30`, `$snakeAttributes = true`;
- cast comuni (`created_at`, `updated_at`, `deleted_at`, `published_at`, `verified_at` a `datetime`;
  `id`, `uuid`, `created_by`, `updated_by`, `deleted_by` a `string`);
- `factory()` via `HasXotFactory`.

**Attenzione a `getClassName()`**: non deduce il namespace da `static`, lo deduce **dall'oggetto
chiamante** letto nel backtrace. Va invocata come `CriteriOption::getClassName()`, senza `static::`
e senza argomenti. Lancia `RuntimeException` se nel backtrace non c'e' un oggetto il cui nome
contiene `Models\` o `Filament\Resources\`. E' un contratto fragile e poco ovvio: chi lo tocca
controlli i consumatori, non i test di Xot.

### `XotBasePolicy` — le autorizzazioni

`Modules/Xot/app/Models/Policies/XotBasePolicy.php`

**Garantisce** che `before()` conceda tutto a `super-admin` e al ruolo `{modulo}::admin`, ricavato dal
namespace della policy (`Modules\Cms\...` → `cms::admin`). Senza questa regola le policy con
`hasPermissionTo` lanciavano `PermissionDoesNotExist` e i pannelli andavano in 500.

**Pretende** che l'utente implementi `UserContract`. `viewAny()` risponde `false` di default: una
policy che non dichiara nulla **nega**, non concede. Le abilita' Filament non dichiarate sono negate
da `DeniesUndeclaredFilamentAbilities`.

### `XotBaseServiceProvider` — la registrazione di un modulo

`Modules/Xot/app/Providers/XotBaseServiceProvider.php`

**Garantisce** in `boot()`: traduzioni, config, viste, migrazioni, componenti Blade, comandi, asset
pubblici. In `register()`: `RouteServiceProvider` ed `EventServiceProvider` del modulo, piu' le icone
Blade lette da `resources/svg`.

**Trappola nota, non ancora risolta.** `registerConfig()` fa:

```php
$files = File::glob($configPath.'/*.php');
```

`glob` con `*.php` **non e' ricorsivo**: una config annidata (`config/qualcosa/altro.php`) non viene
caricata e nessuno se ne accorge, perche' non c'e' errore — la chiave semplicemente non esiste. E'
gia' costato quattro copie morte di file di configurazione nel modulo Notify. Chi aggiunge una
config a un modulo la tenga **piatta**, oppure si cambi questo metodo e si verifichi su tutti i
moduli.

### `XotBaseMigration` — le migrazioni

`Modules/Xot/app/Database/Migrations/XotBaseMigration.php`

**Trappola nota, non ancora risolta.** `tableUpdate()` **non aggiorna soltanto**:

```php
public function tableUpdate(\Closure $next, ?string $table = null): void
{
    $tableName = $table ?? $this->getTable();

    if (! $this->getConn()->hasTable($tableName)) {
        $this->getConn()->create($tableName, $next);   // <- crea

        return;
    }

    $this->getConn()->table($tableName, $next);
}
```

Se la tabella manca, la **crea** con la sola closure di aggiornamento — cioe' con le colonne che quella
migrazione voleva aggiungere, non con lo schema completo. Da li' in poi la catena delle migrazioni e'
rotta: la migrazione che avrebbe dovuto creare la tabella trova la tabella gia' esistente e non fa
nulla. E' la causa di una catena di migrazioni rotta tracciata in una issue aperta. `tableCreate()`,
invece, si comporta come dice il nome: crea solo se manca, e non tocca una tabella esistente.

### `XotBaseTestCase` — la base dei test

`Modules/Xot/tests/XotBaseTestCase.php`

**Garantisce**

- applicazione avviata **senza** `DatabaseTransactions`: l'isolamento transazionale lo aggiunge il
  `TestCase` di ciascun modulo, dichiarando le proprie `$connectionsToTransact`;
- `refreshDatabase()` **svuotato di proposito**: nessun `TestCase` di modulo puo' lanciare
  `migrate:fresh`. I dati dei database di test sono dati veri;
- `withoutVite()` e `Process::fake(['composer *' => ...])` attivi in `setUp()`: nei test `composer`
  non parte mai (un `composer dump-autoload` vero riscriverebbe `vendor/composer/autoload_psr4.php` e
  i moduli successivi non troverebbero piu' il proprio `TestCase`);
- `tearDown()` chiude e ripulisce tutte le connessioni, ingoiando gli errori per non mascherare il
  fallimento vero del test;
- aiutanti tipizzati che evitano il `mixed`: `getAction()`, `mockService()`, `createUnitMock()`,
  `singleExpectation()`.

**Debito dichiarato.** La classe espone una decina di property `public mixed` (`$action`, `$model`,
`$widget`, `$record`, ...) con i rispettivi `@property` nel docblock. Esistono perche' i test Pest
scrivono `$this->qualcosa` dentro le closure, e senza quelle property l'analizzatore statico segnala
`property.notFound`. **Non e' un modello da imitare**: ogni property aggiunta qui e' un `mixed` che
tutti i moduli ereditano. Un test che ha bisogno di uno stato fra `beforeEach` e il corpo lo tenga
in una variabile locale o in una funzione del file di test, non in una nuova property della base.

## Come verificare una modifica a una classe XotBase

```bash
cd laravel

# 1. l'analizzatore, sul modulo e su un consumatore
COMPOSER_ALLOW_SUPERUSER=1 ./vendor/bin/phpstan analyse Modules/Xot Modules/Quaeris \
    --memory-limit=-1 --no-progress

# 2. la suite di Xot
./vendor/bin/pest --test-directory=Modules/Xot/tests

# 3. almeno una suite consumatrice
./vendor/bin/pest --test-directory=Modules/Quaeris/tests

# 4. lo stile
./vendor/bin/pint --quiet <i file toccati>
```

`COMPOSER_ALLOW_SUPERUSER=1` non e' facoltativo: da root composer disattiva i plugin,
`composer-merge-plugin` non unisce i `Modules/*/composer.json` e l'analisi gira su un autoload che non
conosce i namespace dei moduli.

Nel messaggio di commit va scritto **quali moduli consumatori** sono stati verificati.

## Riferimenti

- [Contratti](README.md) — indice dei contratti del modulo
- [ADR: Action invece di Service](../adr/actions-over-services.md)
- [ADR: test di architettura con Pest arch](../adr/architecture-tests-pest-arch.md)
