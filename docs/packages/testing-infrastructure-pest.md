# Infrastruttura di Testing con Pest - Laraxot PTVX

L'architettura di testing è progettata per garantire isolamento e performance in un ambiente multi-database MySQL.

## 1. Regole Fondamentali (MANDATORY)
- **NO SQLite**: Mai usare SQLite o `:memory:`. I test devono girare su MySQL con database terminanti in `_test`.
- **DatabaseTransactions**: Usare il trait `DatabaseTransactions` per l'isolamento dei dati. Il trait `RefreshDatabase` è VIETATO perché distruttivo in ambiente multi-tenant.
- **XotData Pattern**: Non istanziare mai i modelli direttamente (es. `new User()`). Usare `XotData::make()->getUserClass()` per supportare i contract pattern.

## 2. Configurazione Environment
- Il file `.env.testing` deve essere allineato a MySQL.
- Prima di eseguire i test, assicurarsi di aver copiato la configurazione: `cp .env.testing .env`.

## 3. Pest PHP (v4.4)
- **Sintassi**: Usare la sintassi fluida di Pest (`it()`, `expect()`).
- **TestCase**: Ogni test deve estendere il `TestCase` del modulo di appartenenza.
- **Autoload Dev**: Assicurarsi che il `composer.json` del modulo abbia il nodo `autoload-dev` configurato per il namespace `Modules\<Modulo>\Tests`.

## 4. Comandi Qualità
- Eseguire periodicamente:
  - `./vendor/bin/pest --coverage` (Coverage)
  - `./vendor/bin/phpstan analyse Modules` (Static Analysis Livello 10)
  - `./vendor/bin/pint --dirty` (Style formatting)
