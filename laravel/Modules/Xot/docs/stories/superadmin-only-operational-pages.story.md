---
title: "[STORY] Pagine operative e scrittura di .env riservate al super-admin"
type: story
module: Xot
bmad: true
status: review
priority: high
created: 2026-10-29
updated: 2026-11-12
tags: [sicurezza, autorizzazione, filament, env, audit]
qmd: "xot super-admin canAccess pagine operative artisan env health setting escape dotenv EnvData EnvWidget"
related:
  - ../../../../../docs/stories/project-audit.story.md
  - ./base-setting-page.story.md
---

# Pagine operative e scrittura di `.env` riservate al super-admin

## Scopo

Dopo l'audit del 2026-10-29: chi entra nel pannello `xot::admin` non deve poter eseguire comandi
Artisan, aprire `.env` o cambiare le credenziali di posta. Ruolo ammesso: `super-admin`.

## Causa radice

Filament apre una pagina se `canAccess()` non è ridefinito. Solo `BaseSettingPage` lo ridefiniva;
`XotBasePage::authorizeAccess()` esiste ma nessuno la chiama. Le pagine operative erano quindi
aperte a ogni utente del pannello. Stessa famiglia del difetto già chiuso in Employee
(`AbsenceRequestPolicy`): il default di Filament è «consentito», non «negato».

Verifica che ha corretto l'audit: `Notify` e `Geo` `SettingPage` mostrano `EnvWidget` (host SMTP,
utente e password mail, token) ma estendono `XotBasePage`, non `BaseSettingPage`. Il finding XOTB-04
li dava per «già riservati al super-admin»: non lo erano.

## Cosa è cambiato

- **`SuperAdminOnlyTrait`** (`app/Filament/Traits/`): `canAccess()` vero solo per `super-admin`.
  Stesso criterio di prima di `BaseSettingPage`, che ora usa il trait (nessun cambio di
  comportamento, copre `BaseSettingPageAccessTest`).
- **Applicato a**: `ArtisanCommandsManager`, `EnvPage`, `HealthPage`, `EnvWidget`, e (fuori da Xot)
  `Notify` e `Geo` `SettingPage`. Job e il cluster Test di Notify hanno story proprie.
- **Difesa nel metodo**: `ArtisanCommandsManager::executeCommand` e `executeComposerDumpAutoload`
  e `EnvWidget::submit` fanno `abort_unless(static::canAccess(), 403)`: `canAccess()` protegge
  l'apertura della pagina, non una chiamata Livewire diretta.
- **`EnvWidget::submit`** legge `form->getState()`, non `$this->data` (stato Livewire modificabile
  dal client), e mostra un errore se il valore non è scrivibile.
- **`EnvData`** (scrittore di `.env`):
  - scrive solo le chiavi che dichiara (`array_intersect_key` su `get_object_vars`);
  - cerca la riga con `^CHIAVE=` (prima `strpos`: `APP_URL=` combaciava dentro `VITE_APP_URL=` e
    nei commenti), nome variabile validato `^[A-Z][A-Z0-9_]*\z`;
  - valori con `"` e `\` escapati; `$` resta libero perché `MAIL_FROM_NAME="${APP_NAME}"` è un
    riferimento legittimo; a capo nel valore rifiutato (iniettava righe come `APP_DEBUG=true`);
  - sostituzione via callback (un `$1` nel valore non è un riferimento regex); ultima riga senza
    `\n` gestita (prima eccezione); scrittura con `LOCK_EX`.

## Test (non eseguiti: `.env.testing` punta a MySQL)

- `tests/Unit/Filament/Pages/SuperAdminOnlyAccessTest.php`: trait presente, accesso per
  super-admin/altro/ospite, `EnvWidget::canView`.
- `tests/Unit/Datas/EnvDataTest.php`: solo stringhe, nessun accesso al vero `.env`.
- `tests/Feature/Filament/Widgets/EnvWidgetTest.php`: ora autenticato come super-admin; nuovi casi
  sul rifiuto (403, file invariato) e sulla chiave non dichiarata. **Attenzione**: questo file scrive
  il `.env` reale (con ripristino); da non eseguire su un ambiente con dati veri.
- Verifica statica: `php -l` e PHPStan sui file toccati = `[OK] No errors`.

## Aperto

- Read-modify-write di `.env` non atomico tra processi (`LOCK_EX` solo sulla scrittura).
- Altre pagine e campi del modulo non sono coperti da questa story: il dettaglio dei punti ancora da chiudere
  sta nel report riservato dell'audit (repo `bashscripts`), non in questo repository pubblico.
- Default chiuso in `XotBasePage` o `Gate::before` unico: decisione dell'utente (vedi story audit).

## Seguito — 2026-11-12: PHPStan sul test della pulizia della cache (#47)

Il commit `52b2e78498` ([module_quaeris_fila5#47](https://github.com/laraxot/module_quaeris_fila5/issues/47))
ha aggiunto a `tests/Feature/Filament/Widgets/EnvWidgetTest.php` il caso «clears the config cache after
writing», con la verifica `Artisan::shouldHaveReceived('call')->with('config:clear')->once()`. Funziona a
runtime (la facade inoltra la chiamata allo spy), ma PHPStan dava 3 errori alla riga 217:
`staticMethod.notFound` su `shouldHaveReceived()` e `method.nonObject` su `with()` e `once()`.

Correzione: lo spy si tiene in una variabile (`$artisan = Artisan::spy();`, tipo `MockInterface`) e la verifica
passa da li' (`$artisan->shouldHaveReceived(...)`, tipo `VerificationDirector`), come gia' fa
`Quaeris/tests/Feature/Filament/Widgets/QuestionChartItemWidgetTest.php` con `Log::spy()`. Nello stesso file Pint
ha sostituito il nome completo di `HttpException` (riga 172, preesistente) con un `use`.

Verifiche:

- `php -l` ok; PHPStan sul file e sull'intero modulo Xot: 0 errori.
- Pint ok; PHPMD (`tools/phpmd.sh`, ruleset di progetto) nessuna segnalazione.
- Pest (`--test-directory=Modules/Xot/tests`): 11 falliti su 11 nel `setUp`, prima del corpo dei test, con
  `SQLiteDatabaseDoesNotExistException` su `laravel/database/test_data.sqlite`. E' l'ambiente: il file non esiste
  sulla macchina di sviluppo e si crea con `php artisan xot:build-test-sqlite`, che migra tutti i moduli e va
  deciso dall'utente. Nessun test e' arrivato a `submit()`: `.env` confrontato con `cmp` prima e dopo, identico.
- Il commento in testa al file dice ancora che il test usa il `Tests\TestCase` della radice per non toccare il
  database: dal 2026-11-11 quella classe non esiste piu' e il file usa `Modules\Xot\Tests\TestCase`, che richiede
  il database sqlite. Commento non aggiornato qui, segnalato.
