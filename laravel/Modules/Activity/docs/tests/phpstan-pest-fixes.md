# Risoluzione Errori PHPStan nei Test Pest del Modulo Activity

## Contesto

Questa documentazione descrive il processo di risoluzione degli errori di analisi statica di PHPStan riscontrati nei test Pest del modulo `Activity`. Gli errori principali erano relativi a funzioni globali (`actingAs`, `livewire`) non trovate e a proprietà (`$this->user`) non definite nel contesto delle closure di Pest. La risoluzione è stata guidata dai principi della metodologia "Super Mucca" di `DRY`, `KISS`, `SOLID`, `Robust` e dalla necessità di una compliance PHPStan `livello 10` senza ignorare errori o modificare file di configurazione globali (`phpstan.neon`).

## Problemi Identificati

1.  **`function.notFound` per `Pest\Laravel` e `livewire`**: PHPStan non riconosceva le funzioni globali fornite dai plugin Pest Laravel e Livewire.
2.  **`property.notFound` per `$this->user`**: PHPStan non riusciva a inferire correttamente la proprietà `$user` iniettata nel contesto `$this` delle closure di Pest.
3.  **Riferimenti a Moduli Inesistenti**: Il test `ListLogActivitiesActionTest.php` faceva riferimento a un modulo (`IndennitaResponsabilita`) e alle sue risorse che non esistevano nel progetto, causando errori `class.notFound`.

## Soluzioni Implementate

La strategia di risoluzione ha seguito un approccio architetturale che rispetta le convenzioni del progetto e le linee guida per PHPStan.

### 1. Aggiunta delle Dipendenze Pest e Livewire (Moduli Xot)

Per garantire che PHPStan potesse risolvere correttamente le estensioni di Pest, è stato necessario assicurare che i plugin specifici fossero dichiarati nelle dipendenze di sviluppo del modulo core `Xot`, da cui altri moduli ereditano le configurazioni di base.

-   **Modifica**: Aggiunto `"pestphp/pest-plugin-laravel": "*"` e `"pestphp/pest-plugin-livewire": "*"` alla sezione `require-dev` di `laravel/Modules/Xot/composer.json`.
-   **Azione**: Eseguito `composer update` nella directory `laravel/` per installare le nuove dipendenze e aggiornare l'autoloader.

### 2. Creazione di Stub per Funzioni Globali Pest (Modulo Activity)

Per risolvere gli errori `function.notFound` persistenti per le funzioni globali di Pest (`actingAs`, `livewire`), è stato creato un file di stub specifico per il modulo `Activity`. Questo file dichiara le funzioni nel namespace globale con i tipi di ritorno corretti, permettendo a PHPStan di riconoscerle durante l'analisi statica.

-   **Creazione**: Creato `laravel/Modules/Activity/tests/PestStubs.php`.
-   **Contenuto Esempio `PestStubs.php`**:
    ```php
    <?php declare(strict_types=1);

    if (! function_exists('actingAs')) {
        /**
         * @param \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model $user
         * @param string|null $driver
         * @return \Illuminate\Testing\TestResponse
         */
        function actingAs(\Illuminate\Contracts\Auth\Authenticatable $user, string $driver = null): \Illuminate\Testing\TestResponse { return test()->actingAs($user, $driver); }
    }

    if (! function_exists('livewire')) {
        /**
         * @param string $component
         * @param array $params
         * @return \Livewire\Features\SupportTesting\Testable
         */
        function livewire(string $component, array $params = []): \Livewire\Features\SupportTesting\Testable { return test()->livewire($component, $params); }
    }
    ```
-   **Autoloading**: Aggiunto `"tests/PestStubs.php"` alla sezione `autoload-dev.files` di `laravel/Modules/Activity/composer.json`.
-   **Azione**: Eseguito `composer dump-autoload` nella directory `laravel/`.

### 3. Dichiarazione Esplicita delle Proprietà nel TestCase (Modulo Activity)

Per risolvere gli errori `property.notFound` per le proprietà dinamiche come `$this->user` all'interno delle closure di Pest, la proprietà è stata esplicitamente dichiarata nel `TestCase` esteso del modulo.

-   **Modifica**: Aggiunto `public ?\Modules\User\Models\User $user = null;` alla classe `Modules\Activity\Tests\TestCase`.

### 4. Hint Esplicito del Contesto `$this` nelle Closure di Test (Modulo Activity)

Anche dopo aver dichiarato la proprietà nel `TestCase`, PHPStan ha avuto difficoltà a inferire il contesto `$this` nelle closure. La soluzione più robusta (e conforme alla regola "non ignorare errori") è stata l'aggiunta di un PHPDoc esplicito per `$this` all'inizio di ogni closure che accede a proprietà del `TestCase`.

-   **Modifica**: Aggiunto `/** @var \Modules\Activity\Tests\TestCase $this */` all'inizio delle closure `beforeEach()` e di ogni `test()` che utilizzava `$this->user` in `ListLogActivitiesActionTest.php`.

### 5. Aggiornamento dei Test per Riferimenti a Moduli Esistenti (Modulo Activity)

Il test `ListLogActivitiesActionTest.php` faceva riferimento a un modulo `IndennitaResponsabilita` che non esisteva. Questo violava la regola "se il test cerca un elemento non esistente, devi modificare il test".

-   **Modifica**: Sostituiti tutti i riferimenti a `Modules\IndennitaResponsabilita` con equivalenti del modulo `Modules\User` (e.g., `User::factory()`, `UserResource::getUrl()`, `ListUsers::class`).

## Benefici

-   **Compliance PHPStan (0 Errori)**: Tutti gli errori `function.notFound` e `property.notFound` sono stati risolti senza violare la regola di non modificare `phpstan.neon` o ignorare gli errori.
-   **Aderenza ai Principi Laraxot**: La soluzione è `DRY` (centralizzando gli stub e la dichiarazione delle proprietà), `KISS` (mantenendo il codice del test pulito), e `Robust` (garantendo la type safety a livello di analisi statica).
-   **Migliore Leggibilità dei Test**: La dichiarazione esplicita del contesto `$this` migliora la comprensione del codice del test.
-   **Scalabilità**: Questo pattern può essere replicato in altri moduli per risolvere problemi simili nei test Pest.

## Lezioni Apprese

-   La gestione dei tipi virtuali di PHPStan come `view-string` o il contesto dinamico di Pest richiede un'attenta configurazione di stub e PHPDoc, anche se le dipendenze sono installate.
-   L'architettura a moduli con i propri `composer.json` e `TestCase` richiede una cura particolare nella propagazione delle configurazioni di sviluppo per l'analisi statica.
-   L'aderenza rigorosa al principio "non ignorare mai errori" spinge a trovare soluzioni più strutturate e meno "hacky" a lungo termine.

## Collegamenti Utili

-   [PestStubs.php Source Code](./PestStubs.php)
-   [ListLogActivitiesActionTest.php Source Code](../Feature/Filament/Actions/ListLogActivitiesActionTest.php)
-   [TestCase.php Source Code](../TestCase.php)
-   [Modules/Xot/composer.json Source Code](../../../Xot/composer.json)
-   [Modules/Activity/composer.json Source Code](../../composer.json)
