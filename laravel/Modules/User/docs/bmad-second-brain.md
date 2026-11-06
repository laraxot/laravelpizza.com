---
title: "BMAD + Second Brain: Fix Log"
type: note
status: draft
updated: 2026-10-18
tags: [docs, user]
qmd: "bmad + second brain   fix log user"
---
# BMAD + Second Brain: Fix Log

## Diagnosi
- `main_module=''` → `XotData::getProfileClass()` falliva (`InvalidArgumentException`)
- `IsProfileTrait.php`: duplicato `use UserContract`
- `BaseProfile.php`: `id` UUID mancante (`PDOException` 1364)
- PHPStan: 309 `class.notFound` (mancanti `User`/`Profile` nei test, Riferimenti `Quaeris`)

## Fix applicati (SSoT)
- `Modules\Xot\Contracts\UserContract` / `ProfileContract`
- `XotData.php:31` → `main_module = 'User'`
- `IsProfileTrait.php`: rimosso duplicato
- `Profile.php:50` → `@property-read UserContract|null $user`
- `BaseProfile.php`: `$incrementing=false`, `$keyType='string'`, UUID `booted()`
- Gdpr actions: `UserContract $user` (nessun modello concreto in public type-hints)

## Docs aggiornati
- `Modules/User/docs/` → SSoT contratti
- `demo/` e `docs/` nei moduli: rifattorizzazione con `UserContract`

## Fix applicati (SSoT): 2026-10-18
- Listener (`FailedLoginListener`, `LoginListener`, `LogoutListener`) + Widget (`NotificationsCenterWidget`): `instanceof BaseUser` → `instanceof UserContract` per rispettare il contratto (non la classe astratta).
- `Modules/User/docs/bmad/authentication-logs-connection-ownership.md`: documentata proprietà `authentication_logs` su DB `fixcity_user`.
- Traduzioni: aggiunte chiavi `auth.php` (`actions.login.success/error/throttle`, `create_account`).
- `LoginWidget.php`: `getLocalizedURL` → `localizeUrl()` (fix locale `'/it'`).

## Prossimi passi
- Verificare tabella `authentication_logs` in `fixcity_user` (`migrate --database=user`).
- Verificare `phpstan analyse Modules` con baseline/alias corretto

## Regola URL localizzati: 2026-10-18

`LaravelLocalization::getLocalizedURL()` ha firma
`getLocalizedURL($locale, $url, ...)`: il primo argomento non è l'URL.
Per localizzare il percorso corrente usare `localizeURL($url)`; in alternativa
passare sempre esplicitamente locale e URL. Questo evita che `/it` venga
interpretato come locale e causi `UnsupportedLocaleException`.

## Regola login i18n: 2026-10-18

La pagina `/it/auth/login` usa sia la vista Sixteen sia `LoginWidget`: il
contratto runtime è `user::auth.login.*` con valore finale `.text`.
`it/auth.php` aveva definizioni duplicate di `login`/`actions`; la definizione
successiva nasconde quella iniziale. Sono state allineate le chiavi operative
in `it`, `en`, `de`, `es`, completati i campi mancanti di `login_widget` e
rimosso l'ultimo testo hardcoded del widget.

Guardrail: `AuthLoginTranslationContractTest` deve verificare tutte le lingue
supportate, `login.google.button.text`, success/error e i nodi `.text` della
vista. Non usare fallback italiani o il nome della chiave come testo UI.
Accessibilità link: `pub_theme::accessibility.title.text` (non stringa piatta).

## Protocollo second brain: potenza massima

Prima di codice: Hindsight search + leggere `docs/bmad/` + `second-brain` del
modulo/tema owner + Filament blueprint. Dopo il fix: aggiornare decision-log e
second brain nello stesso turno. Mai “fix cieco” dal solo stack trace.

## Regola contratti utente: 2026-10-18

Un consumer non deve riconoscere l'utente con `instanceof BaseUser`: la classe
è astratta e rappresenta un'implementazione interna. Il controllo corretto è
`instanceof UserContract`; per capability opzionali si usa il contratto
specifico o una guardia capability. La spiegazione completa è in
[`wiki/concepts/usercontract-boundary.md`](wiki/concepts/usercontract-boundary.md)
e nella decisione del tema Sixteen.

### Applicazione Auth audit (stesso turno)

- `RecordAuthenticationLogAction::execute(UserContract&HasAuthentications $user, …)`
 : non più `BaseUser $user`.
- `LoginListener` / `FailedLoginListener` / `OtherDeviceLogoutListener`:
  doppio guard `UserContract` + `HasAuthentications` (e `Model` dove serve morph).
- Guardrail: `RecordAuthenticationLogActionTest` asserisce assenza di
  `BaseUser $user` / `instanceof BaseUser` nei listener login.

## Campagna PHPStan: Pest Internal error (2026-10-18)

Famiglia condivisa Geo/Cms/Notify/User: `HigherOrderExpectationTypeExtension`
può abortire l'analisi intero modulo. Fix nei test (`PHPUnit\Framework\Assert`
nei BusinessLogic), **mai** `excludePaths` su `tests/`.

SSoT pattern: [Notify wiki](../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md).
Confine utente (stesso ciclo BMAD): [`usercontract-boundary.md`](wiki/concepts/usercontract-boundary.md).

## Autorizzazione Spatie e confine `fixcity_user`: 2026-10-18

`permissions`, `roles`, `model_has_permission`, `model_has_role` e
`role_has_permission` sono dati di identità/autorizzazione. Appartengono al
modulo User e devono essere letti e scritti tramite la connessione Laravel
`user`, il cui database FixCity è `fixcity_user`; `fixcity_data` contiene solo
il dominio civico.

La configurazione Spatie usa i modelli `Modules\\User\\Models\\Permission` e
`Role`, entrambi con connessione `user`. Di conseguenza un errore come
`Connection: user, Database: fixcity_data` indica configurazione di produzione
in cache obsoleta o `.env` errato, non una ragione per spostare le tabelle nel
database applicativo. Dopo il deploy va eseguito, in ordine:

```bash
php artisan config:clear
php artisan migrate --database=user --no-interaction
php artisan config:cache
```

Le migration canoniche `create_*` del modulo User ricostruiscono soltanto le
tabelle mancanti tramite `XotBaseMigration`, senza cancellare dati e senza
modificare quelle già presenti.
Verifica minima:

```bash
php artisan tinker --execute='foreach (["permissions", "roles", "model_has_permission", "model_has_role", "role_has_permission"] as $table) echo $table."=".(Schema::connection("user")->hasTable($table) ? "ok" : "missing").PHP_EOL;'
```

## Fix permissions ownership: 2026-10-18

- Sintomo: `Table 'fixcity_data.permissions' doesn't exist` su `/it/tickets/1`.
- Canonico: [bmad/permissions-connection-ownership.md](bmad/permissions-connection-ownership.md).
- Deploy: `DB_DATABASE_USER=fixcity_user` + `config:clear` + migrate delle
  migration canoniche `create_*` sul modulo User.
- Soft-guard: `BuildTicketTimelineAction` non chiama Spatie se manca la tabella.
