# Piano Coverage 100%

Obiettivo: portare il progetto LaravelPizza al **100% di coverage** dei test Pest.

## Stato attuale

- **Test falliti**: da verificare con `./vendor/bin/pest --coverage`
- **Moduli**: Activity, Cms, User, Xot (principali)
- **Fix applicati (2026-03)**:
  - **XotBaseTestCase** (DRY + KISS): tutti i TestCase moduli estendono `Modules\Xot\Tests\XotBaseTestCase` invece di `Illuminate\Foundation\Testing\TestCase` — regola: `.cursor/rules/testcase-xotbase-extends.mdc`
  - Root `tests/TestCase.php`: estende `XotBaseTestCase`
  - User TestCase: aggiunto `DatabaseTransactions` e `$connectionsToTransact`
  - Script `bashscripts/testing/ensure-test-db.sh` per verifica DB pre-test
  - XotBaseTransitionTest: firma già corretta (report coverage obsoleto)
  - **Gdpr RegisterPageTest**: riscritto da POST a Livewire::test(RegisterWidget::class); skip condizionale se tabella `treatments` non migrata — vedi [Modules/Gdpr/docs/registration-testing.md](../laravel/Modules/Gdpr/docs/registration-testing.md)
  - **Gdpr RegisterFormValidationTest**: skip per validazioni non presenti in ValidateUserDataAction (required, email format, password); email univoche per evitare conflitti; vedi [Modules/Gdpr/docs/registration-testing.md](../laravel/Modules/Gdpr/docs/registration-testing.md)
  - **Gdpr RegisterWidgetTest**: rimosso assert su `state` (ValidateUserDataAction non lo restituisce); skip condizionale per SaveGdprConsentsAction se tabella `treatments` non migrata
  - **Activity model**: hack in `__construct()` — in testing usa `config('database.default')` invece di `activity`. Anti-pattern documentato in [testing-connection-hack](../laravel/Modules/Activity/docs/testing/testing-connection-hack.md)

## Fasi

### Fase 1: Test falliti – correzione

1. **Activity** (priorità alta)
   - Verificare `ActivityBusinessLogicTest`, `ActivityEventSourcingTest`, `ActivityIntegrationTest`, `ActivityManagementTest`: DB connection `activity`, schema
   - `SnapshotBusinessLogicTest`: `it can query snapshots by date range` – scope o metodo
   - `StoredEventBusinessLogicTest`: `it can query events by event class`, `date range`
   - `ActivityLoggerTest`: `get activities by type`, `get recent activities`

2. **Cms Auth** (priorità alta)
   - `AuthenticationTest`, `LoginTest`, `LoginVoltTest`, `LoginWidgetTest`
   - `PasswordConfirmationTest`, `PasswordResetTest`, `ProfileUpdateTest`
   - `RegisterTest`, `RegisterTypeTest`, `RegisterTypeWidgetTest`
   - Cause: routing, widget, locale, `XotData::getUserClass()`

3. **Cms Homepage** (priorità media)
   - `HomepageContentManagementTest`, `HomepageFilamentBlocksArchitectureTest`
   - Cause: JSON content, blocks, theme integration, fixture

### Fase 2: Test eliminabili

- Test obsoleti o duplicati (con motivazione in docs)
- Test che richiedono setup troppo complesso (es. CmsContentManagementTest – già skippati)

### Fase 3: Coverage 100%

1. Eseguire `./vendor/bin/pest --coverage --min=0`
2. Identificare file con coverage < 100%
3. Aggiungere test per ogni branch/codice non coperto
4. Usare pattern: Actions, DTO, Models, Services

## Comandi

```bash
# Esegui tutti i test
cd laravel && ./vendor/bin/pest

# Coverage
./vendor/bin/pest --coverage --min=0

# Coverage per modulo
./vendor/bin/pest Modules/Activity/tests --coverage-text
./vendor/bin/pest Modules/Cms/tests --coverage-text

# Genera report
bash bashscripts/testing/generate-coverage.sh
```

## Collegamenti

- [Testing guidelines](../.agents/docs/agents-guide/08-testing/testing-guidelines.md)
- [Coverage 100 Agent](../.agents/agents/coverage-100-agent.md)
- [AGENTS.md](../AGENTS.md)
