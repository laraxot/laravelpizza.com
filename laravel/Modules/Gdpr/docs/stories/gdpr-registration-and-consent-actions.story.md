---
title: "Gdpr: registrazione e consenso fuori dai widget, in una Action"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: Gdpr
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on:
  - ../../../Xot/docs/stories/test-database-guard.story.md
  - ./dcp-164-registrazione-consenso-obbligatorio-PA.story.md
  - ./phpstan-test-wave-gdpr.story.md
tags: [bmad, gdpr, registration, consent, queueable-action, transaction, widgets, tests, sqlite, w2, w3]
---

# Gdpr: registrazione e consenso fuori dai widget, in una Action

Fase BMAD: Create Story (waves W2 e W3 dell'epic, lane Gdpr). Solo documentazione: nessun PHP toccato per scriverla.

## Richiesta

Ordine permanente dell'utente (2026-10-20): "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint". Qui: capire che cosa deve garantire la registrazione con consenso (utente e prova del consenso insieme) e portarlo dove la regola 3 del blueprint lo vuole, in una Action Queueable. Epic: [epic-code-quality-ratchet](../../../Xot/docs/bmad/epic-code-quality-ratchet.md), wave W3. Il contenuto legale (testi, minori, eta') e' in [dcp-164](./dcp-164-registrazione-consenso-obbligatorio-PA.story.md) e [registration-unsubscribe-compliance](./registration-unsubscribe-compliance.story.md): qui non si tocca.

## Scopo

- `Filament/Widgets/Auth/RegisterWidget.php` e' il form pubblico di registrazione conforme al Garante: valida i consensi, crea l'utente, registra la prova del consenso (`Consent` con testo, versione, IP) e fa l'accesso. Conta perche' una registrazione senza prova del consenso non si difende in un controllo.
- `GdprConsentForm.php` e' una copia di `RegisterWidget` (stesso `submit()`), nata prima del throttle.
- Le Action esistono gia' (`ValidateGdprConsentAction`, `ValidateUserDataAction`, `CreateUserAction`, `SaveGdprConsentsAction`, `LogRegistrationAction`, `HandleSuccessfulRegistrationAction`): il widget le orchestra e tiene lui la transazione.

## Stato misurato

Misura del 2026-10-20 tra le 13:35 e le 14:05 UTC. Cifre volatili. Il modulo e' condiviso con altri progetti (Fixcity): i fatti qui valgono per questo repo.

- Orchestrazione nel widget: `rg -n "DB::connection\('user'\)->transaction" laravel/Modules/Gdpr/app` stampa `RegisterWidget.php:136` e `GdprConsentForm.php:90`. `diff` dei due `submit()`: `GdprConsentForm` non ha il throttle di `RegisterWidget.php:107-113` (10 tentativi per IP in 600 s). `rg -n 'GdprConsentForm' laravel --glob '!**/vendor/**' --glob '!**/docs/**' --glob '!*.md'` trova solo la classe: zero consumatori.
- La transazione non copre il consenso. Si apre su `user` (utente in `DB_DATABASE_USER`), ma `Consent` e `Treatment` usano la connessione `gdpr` (`Gdpr/app/Models/BaseModel.php:14`), che `TenantServiceProvider.php:149-155` costruisce copiando la connessione di default (`DB_DATABASE`, altro database). Un errore in `SaveGdprConsentsAction.php:58` lascerebbe l'utente creato senza prova del consenso. Letto nel codice, non riprodotto a runtime.
- `RegisterWidget` espone `$password` e `$password_confirmation` come proprieta' pubbliche Livewire (righe 49-51). `logRegistrationAttempt` (riga 152) scrive a livello `debug` IP e user agent con l'hash dell'email.
- Vista mancante: entrambi i widget rendono `filament.widgets.auth.register` (`RegisterWidget.php:92`, `GdprConsentForm.php:105`); `find laravel -type f -path '*filament/widgets/auth/register*' -not -path '*/vendor/*'` stampa 0 file (controprova: con `*filament/widgets/auth/login*` trova `Themes/Zero/.../login.blade.php`). La vista vive in `Themes/Sixteen` (dcp-164), tema che qui non c'e' (`ls laravel/Themes` stampa solo `Zero`). In questo repo la rotta `register` e' di User (`User/routes/web_tall.php:29`), che non usa Gdpr.
- Riferimento a classe inesistente: `User/resources/views/pages/auth/register.blade.php:69` monta `\Modules\Gdpr\Filament\Widgets\Auth\UserForm::class`; `ls laravel/Modules/Gdpr/app/Filament/Widgets/Auth` elenca solo `GdprConsentForm.php` e `RegisterWidget.php`. La docs di Gdpr (`docs/bmad/livewire-inventory.md:83`) lo dice a riga 70. Se la pagina Folio e' raggiungibile, Livewire lancia `ComponentNotFoundException`: non verificato a runtime.
- Validazione nel widget: 10 dei 13 skip espliciti (`tests/Feature/RegisterFormValidationTest.php:22-46,130-138`) dicono "ValidateUserDataAction does not validate ...: validation is in RegisterWidget"; gli altri 3 (`RegisterWidgetTest.php:152,208,278`) aspettano la tabella `treatments`. `rg -c -e 'gdprSkipTest\(' laravel/Modules/Gdpr/tests -g '*.php'` conta anche la definizione e un uso condizionale (`PestHelpers.php:59,105`).
- Coppia per maiuscole: `tests/Feature/conflictresolutiontest.php` (766 byte) e `ConflictResolutionTest.php` (1143 byte), stessi 2 test; il minuscolo ha asserzioni piu' deboli (`->not->toBeNull()` dove l'altro ha `->not->toBeEmpty()` e controlli di costruttore) e non gira mai (`phpunit.xml:11-12`, suffisso case-sensitive).
- `tests/TestCase.php:33,37`: `$connectionsToTransact = ['sqlite']` e `prepareSharedSqliteForTesting()`, contro la regola "test su MySQL" (decisione 7.4 dell'epic; `phpstan-test-wave-gdpr.story.md:67,99` la rimanda a Xot). Zero `RefreshDatabase` attivo in Gdpr.
- Ramo di test in produzione: `Models/Treatment.php:148` `if (! app()->environment('testing')) return;` registra un hook `creating` che suffissa il nome duplicato solo nei test.
- Extends diretto: 1, `Filament/AdminPanelProvider.php:11` (`extends PanelProvider`), doppione non registrato di `Providers/Filament/AdminPanelProvider.php`; `rg -n 'Gdpr.{1,2}Filament.{1,2}AdminPanelProvider' laravel --glob '!**/vendor/**' -g '*.php'` stampa 0. Stringhe hardcoded: 0 (`rg` del censimento).
- Docs (di un'altra sessione, solo nota): `docs/00-INDEX.md:80-81` linka `../../Fixcity/docs/...` e `ls laravel/Modules/Fixcity` non esiste; il blueprint elenca 2 Resource su 4 (mancano `EventResource`, `ProfileResource`) e nessun widget.

## Lavoro

1. Una Action Queueable `RegisterUserWithConsentsAction` (`execute()`) che possiede la sequenza validazione, creazione utente, consenso, log; i due widget la chiamano e restano orchestratori sottili (lifecycle, redirect). Rischio medio-alto: percorso di autenticazione, serve il test prima. Decisione 1.
2. Atomicita' reale: o compensazione esplicita (se `SaveGdprConsentsAction` fallisce, annullare l'utente creato e segnalare) o una sola connessione per i due insiemi di dati. Non affidarsi a `DB::connection('user')->transaction`. Decisione 2.
3. Cancellare `GdprConsentForm.php` (zero consumatori, senza throttle) invece di refactorizzarlo; cancellare `Filament/AdminPanelProvider.php`. Rischio basso.
4. Spostare le regole di validazione dei 10 skip dal widget in `ValidateUserDataAction` e riattivare i test. Rischio medio.
5. `User/resources/views/pages/auth/register.blade.php:69`: correggere il riferimento (file di User, lane User). Segnalare, non toccare da qui.
6. `Treatment.php:148`: togliere il ramo `testing` e fare la suffissazione nella factory. Rischio basso.
7. Test: cancellare `conflictresolutiontest.php` (il file con maiuscole e' piu' forte); TestCase da sqlite a MySQL solo dopo la decisione 7.4 dell'epic.

## Acceptance criteria

- [ ] `rg -n "DB::connection\('user'\)->transaction" laravel/Modules/Gdpr/app/Filament` stampa 0 righe (prima: 2) e la sequenza vive in una Action con `execute()`.
- [ ] `rg -n 'GdprConsentForm' laravel/Modules/Gdpr/app` stampa 0 righe (oppure la classe ha un consumatore e il throttle).
- [ ] `/usr/bin/find laravel/Modules/Gdpr/tests -type f -name '*test.php' ! -name '*Test.php'` stampa 0 file (prima: 1; controprova su `laravel/Modules/Cms/tests`).
- [ ] `rg -n "environment\('testing'\)" laravel/Modules/Gdpr/app` stampa 0 righe (prima: 1).
- [ ] `rg -nP '^class \w+ extends PanelProvider\b' laravel/Modules/Gdpr/app` stampa 0.
- [ ] Decisione scritta su atomicita' consenso-utente e su `UserForm` della pagina register.
- [ ] `phpstan analyse` mirato sui file toccati: `[OK] No errors`; nessun ignore, nessun `mixed` nuovo.

## Verifica

Da `laravel/`, solo lettura: i comandi di "Stato misurato", ognuno con il suo gemello di controprova. Nessun test eseguito.

## Vincoli

Nessun Pest/PHPUnit finche' la guardia DB (`Xot/tests/Support/TestDatabaseGuard.php`) non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta. PHPStan solo mirato, in coda `flock` di `bashscripts/docs/prompts/11-phpstan.md`; un solo run completo, a swarm fermo e a RAM libera. Un solo agente per modulo che edita PHP. `laravel/phpstan.neon` immutabile. Forward-only. Pest resta Pest. Niente nuovi `*Service`: la logica va in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var` o ignore di comodo. Il modulo e' condiviso con Fixcity: il comportamento verso quel progetto (vista del tema Sixteen, `RegistrationConsentTest`) non si rompe; avvisare prima di cambiare le firme pubbliche. Il `docs/` di Gdpr e' di un'altra sessione.

## Decisioni aperte

1. Quaeris ha bisogno della registrazione con consenso Gdpr, o basta quella di User? Se basta, i due widget sono usati solo da Fixcity.
2. Consenso e utente non possono stare nella stessa transazione (due database): compensazione o accettare il rischio?
3. La pagina Folio `auth/register` va corretta o ritirata?

## Come ripartire

1. Chiedere all'utente la decisione 1; rileggere `RegisterWidget.php:100-140` e `SaveGdprConsentsAction.php:35-75`.
2. Scrivere (senza eseguire) il test dell'Action: utente creato, consenso fallito, utente annullato.
3. Fare i punti 3 e 7 (cancellazioni a rischio basso) con il gate lock+mtime, poi rilanciare i comandi di "Stato misurato".
