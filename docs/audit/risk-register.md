# Risk register

> Audit del 2026-11-05. Probabilità e impatto: A (alto), M (medio), B (basso).

| ID | Rischio | Prob. | Impatto | Evidenza | Mitigazione | Stato |
|---|---|---|---|---|---|---|
| R-01 | **Build non riproducibile**: `composer install` dal lock richiede PHP ≥ 8.4.1, mentre `composer.json` dichiara `^8.2`; in CI fallisce la risoluzione (`filament/filament` contro `filament/actions` 5.6.8 bloccato "by a partial update") | A | A | Log del run CI del 2026-11-05 su `6fbf2141` | Allineare `require.php` a `^8.4`, rigenerare il lock con `composer update` e committarlo insieme ai `composer.json` dei moduli (merge-plugin) | ⏳ |
| R-02 | **CI che mente**: `php artisan test --no-interaction \|\| true` rende il job Tests sempre verde. Il job PHPStan fallisce per un fatal (`_ide_helper.php`); Pint trova 1.868 problemi di stile; il build del tema non trova `vendor/filament/support` | A | A | `.github/workflows/ci.yml:136`, log CI | Togliere `\|\| true` e far girare i test dei moduli. Il resto dopo R-01 | ✔ rimosso `\|\| true` (la CI resterà rossa finché R-01 non è risolto: è lo stato reale) |
| R-03 | **La suite di test predefinita non esegue i test dei moduli**: `phpunit.xml` include solo `tests/Unit` e `tests/Feature` (8 test); i ~850 test di modulo girano solo se lanciati per percorso | A | A | `laravel/phpunit.xml` | Testsuite `Modules` in `phpunit.xml` | ✔ |
| R-04 | Test che si auto-saltano sugli errori 500 (`cmsSkipTest('Server error …')`): un crash del server diventa un test "skipped" | M | A | `Modules/Cms/tests/Feature/IndividualFolioRoutesTest.php:62,75` | Gli errori 5xx devono far fallire il test | ⏳ |
| R-05 | Divergenza documentazione/codice (Laravel 12 vs 13, regole duplicate, 377 file con conflitti Git): agenti e persone prendono decisioni su informazioni false | A | M | [project-overview.md](project-overview.md) | Una fonte di verità per lo stato (questo audit + sprint-status BMAD); pulizia dei conflitti | ⏳ |
| R-06 | Moduli condivisi importati come subtree: le correzioni locali (es. `Cms`, `User`) possono essere sovrascritte dal prossimo sync | M | M | `gitmodules.ini`, commit `bd81af55d` "risolve conflitti Git committati nei moduli subtree" | Portare upstream le correzioni a Cms e User fatte in questo ciclo | ⏳ |
| R-07 | Dati sensibili nel repo pubblico (APP_KEY, password DB locali) | M | M | S-06 | Rotazione e rimozione dei file | ⏳ |
| R-08 | Nessun runbook di deploy, backup, restore, monitoraggio o health check documentato | A | A | Assenza nel repo (`config/health.php` presente ma non configurato per il tenant) | Fase 5 della roadmap | ⏳ |
| R-09 | Scheduler non attivo: `JobServiceProvider` ha `registerSchedule` commentato; `routes/console.php` senza schedule. Le notifiche accodate richiedono un worker | M | M | `Modules/Job/app/Providers/JobServiceProvider.php:31-90` | Worker di coda nel deploy (supervisor/systemd); scheduler se servirà | ⏳ |
| R-10 | Font Google caricati prima del consenso (trasferimento dell'IP a terzi): profilo di rischio GDPR in UE | M | M | `layouts/main.blade.php:8`, `auth.blade.php:17-19` | Self-hosting dei font. **Valutazione legale da confermare con un professionista** | ⏳ |
