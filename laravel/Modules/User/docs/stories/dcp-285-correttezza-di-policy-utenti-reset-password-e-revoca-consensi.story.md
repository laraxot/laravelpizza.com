---
id: dcp-285
title: "DCP-285: correttezza di policy utenti, mail di reset password, pagina verify e revoca consensi"
type: story
epic: dc-parity-v2
status: done-with-open-decisions
priority: P1
owner: module:User + module:Gdpr
module: User
created: 2026-10-26
updated: 2026-10-26
qmd: "userpolicy bypass autorizzazione reset-password mail template spatieemail verify.blade resend Verified revoca consensi RevokeGdprConsentsAction subject_type revoked_user_agent"
related: [dcp-282, dcp-200, dcp-204, dcp-178, 11.1-fix-userpolicy-authorization-bypass]
tags: [security, authorization, gdpr, email, correttezza]
---

# DCP-285: quattro difetti veri di correttezza e autorizzazione (User, Gdpr)

Nata dal report di gap D (D-02, D-04, D-05, D-06). Ogni affermazione del report e' stata riverificata nel codice prima di toccare. Etichette: **MISURATO** (eseguito: comando o test con output), **DEDOTTO** (letto nel codice, non eseguito).

## Fase BMAD

Build (dev-story): analisi gia' fatta nel report D; qui verifica, test rossi, correzione, test verdi. Chiude con l'esito sotto.

## Stato

Chiusa il 2026-10-26 sul codice dei quattro punti, con test rossi prima e verdi dopo (sezione Esito). Restano due decisioni del titolare (auto-cancellazione del cittadino, link di reset con email) e una richiesta di schema (`revoked_user_agent`).

## Fatti misurati prima di toccare

### D-06 UserPolicy

- MISURATO (lettura + test, vedi Esito): `Modules/User/app/Models/Policies/UserPolicy.php` risponde `true` a `view`, `create`, `update`, `delete` per qualunque utente autenticato; `viewAny` e' `false`. Estende `UserBasePolicy` (vuota) e quindi `XotBasePolicy`, la cui `before()` concede tutto al ruolo `super-admin`.
- MISURATO: nessun test esistente su `UserPolicy` (`grep -rn "UserPolicy" Modules/*/tests` trova solo `BaseUserPolicy`, mai estesa da nessuno).
- MISURATO: non c'e' registrazione esplicita: `UserServiceProvider::registerPolicies()` e' vuota, nessun `Gate::policy` per `User`. Vale la scoperta automatica di Laravel. Per `Modules\User\Models\User` trova `Modules\User\Models\Policies\UserPolicy`. Per `Modules\Fixcity\Models\User` (la classe di auth reale, `config/local/fixcity/auth.php`) nessuna `UserPolicy` esiste in `Modules\Fixcity\Models\Policies` ne' in `Modules\Fixcity\Policies`.
- MISURATO (test rosso `UserPolicyMatrixTest`, 2026-10-26): `Gate::getPolicyFor(Modules\Fixcity\Models\User::class)` e' `null`. Quindi sulla classe di autenticazione reale **non c'era nessuna policy**, e non solo una policy aperta. Non e' definito alcun `Gate::before`.
- MISURATO (sorgente Filament, `get_authorization_response`): senza policy, o con la policy ma senza il metodo richiesto, Filament in modalita' non rigida considera l'abilita' CONSENTITA. Effetto: per l'utente Fixcity la risorsa `UserResource` era aperta a chiunque entrasse nel pannello; e con una policy che manca di `deleteAny`, `restoreAny`, `forceDeleteAny`, `replicate`, `reorder` quelle abilita' sarebbero rimaste consentite. Per questo la policy le definisce tutte.
- DEDOTTO (non eseguito): prima della correzione `DeleteAccountAction` per l'utente Fixcity rispondeva gia' 403, perche' `Gate::authorize('delete', ...)` senza policy e senza `Gate::before` nega.
- Chi la chiama (grep): `UserResource` Filament (risorsa del modulo User, usa `canViewAny/canView/canEdit/canDelete` che passano dal Gate), `HasXotTable` (`Gate::allows('delete', $record)`), `Gdpr/app/Actions/Account/DeleteAccountAction.php:38` (`Gate::authorize('delete', $user)` sull'utente connesso). API: nessuna rotta di User chiama la policy. Widget del profilo: `EditUserWidget::canEdit()` e' un controllo proprio (id uguale), non passa dal Gate.
- MISURATO sul DB di sviluppo (sola lettura, `fixcity_user`): ruoli reali `super-admin`, `<modulo>::admin` (tra cui `user::admin`, 1 utente) e `operator`. Il ruolo `admin` e' nel `RoleSeeder` e in `canAccessPanel` ma non e' presente nel DB di sviluppo. `hr-manager` non esiste in nessun seeder (residuo di un altro progetto, D-29). Permessi nel DB: solo 5 `ticket.*`, nessun `user.*`.
- Il pannello di ogni modulo ha id `<modulo>::admin` e `BaseUser::canAccessPanel` richiede `hasRole(<id pannello>)`: per entrare nel back office di User serve il ruolo `user::admin`.

### D-05 mail di reset password

- MISURATO (lettura): `UserServiceProvider::registerMailsNotification()` costruisce `new SpatieEmail($notifiable, 'reset-password')`. `SpatieEmail::__construct` fa `MailTemplate::firstOrCreate` con un unico corpo di default valido per qualunque slug ("La tua registrazione e' in attesa di approvazione") e sincronizza solo lo slug `verify-email`, solo per la lingua corrente.
- MISURATO (SQL sola lettura): `fixcity_data.mail_templates` e' vuota. Il template `reset-password` non e' seminato: alla prima richiesta di reset verrebbe creato col testo di registrazione, senza il link.
- MISURATO: i file lingua `User/lang/en/reset_password.php` e `User/lang/de/reset_password.php` contengono testo italiano; `es/reset_password.php` non esiste. Le chiavi di quei file non sono usate da nessun codice (solo codice commentato).
- DEDOTTO: il link di reset non contiene l'email (`route('password.reset', ['token' => $token])`). Il form di reset chiede l'email all'utente (campo `email`), quindi e' un disagio e non un blocco. Non cambiato.

### D-04 pagina verify.blade.php

- MISURATO (lettura): `User/resources/views/pages/auth/verify.blade.php`, metodo `resend()`: `redirect('/')` senza `return` dopo `hasVerifiedEmail()` (l'esecuzione prosegue e rimanda la notifica a un indirizzo gia' verificato), e `event(new Verified($user))` subito dopo `sendEmailVerificationNotification()`.
- Correzione della descrizione del compito: nella pagina non c'e' alcun controllo di hash o firma da precedere. L'evento `Verified` e' lanciato dopo un semplice **reinvio**, quando nessun indirizzo e' stato verificato. L'hash e' controllato prima dell'evento in `EmailVerificationController` e in `VerifyEmailController` (non instradati).
- MISURATO: la pagina e' montata da Folio (`FolioVoltServiceProvider` monta `Modules/*/resources/views/pages` per ogni lingua), quindi `/{lang}/auth/verify` e' raggiungibile da un utente autenticato (middleware `auth`, `throttle:6,1`). La rotta `verification.verify` invece non e' definita in nessun file caricato (`User/routes/auth.php` e `web_tall.php` non sono caricati): D-03/DEC-11, non toccata.

### D-02 revoca consensi

- MISURATO (SQL sola lettura sul DB di sviluppo `fixcity_data.consents`): colonne presenti `subject_id`, `user_id`, `user_type`, `type`, `accepted_at`, `ip_address`, `user_agent`, `metadata`, `revoked_at`, `revoked_ip_address`, timestamp e `*_by`. Assenti: `subject_type` e `revoked_user_agent`. Tabella vuota (0 righe).
- MISURATO (lettura): `Gdpr/app/Actions/Consent/RevokeGdprConsentsAction.php` filtra su `subject_type` e scrive `revoked_user_agent`: errore SQL a ogni esecuzione. L'unico chiamante e' `DeleteAccountAction` (D-01, bloccata).
- MISURATO (lettura): chi scrive i consensi usa `user_id` + `user_type` (relazione morph `HasGdpr::consents()` e `giveConsent`) e, in piu', `subject_id` solo `SaveGdprConsentsAction`. La chiave comune a tutti i percorsi e' `user_id`.

## Causa

- D-06: `UserPolicy` e' stata scritta con `true` fissi (stub) e `BaseUserPolicy`, la versione con controllo dei ruoli, non e' estesa da nessuno.
- D-05: un solo default in `SpatieEmail` per tutti gli slug; nessun seeder per `reset-password`; i file lingua `en/de` sono copie dell'italiano.
- D-04: due righe di una pagina copiata da uno scaffold (Genesis) senza adattarla.
- D-02: l'azione e' stata scritta contro uno schema immaginato (`subject_type`, `revoked_user_agent`) mai migrato.

## Decisioni

1. **D-06, ruoli.** Si usano solo ruoli gia' esistenti, col controllo di ruolo di `TicketPolicy` (`hasRole`) e senza `hasPermissionToOrCreate`: quest'ultimo crea il permesso al primo controllo (un permesso `user.*` nuovo e' un dato nuovo non richiesto). Amministra gli utenti chi ha `super-admin` (via `before()`), `admin` o `user::admin`. `hr-manager` non e' incluso: non esiste in nessun seeder (D-29). Un amministratore di modulo non modifica ne' cancella un super-admin (altrimenti cambiandone la password lo diventa). La policy e' registrata con `Gate::policy(BaseUser::class, UserPolicy::class)` in `UserServiceProvider::registerPolicies()`: vale anche per le sottoclassi, quindi per la classe Fixcity, senza toccare il modulo Fixcity. `UserPolicy` ora estende `BaseUserPolicy` (la versione con controllo dei ruoli, prima mai estesa da nessuno): il codice duplicato sparisce e la collisione di nomi della story 11.1 resta aperta solo come nome.
2. **D-06, auto-cancellazione.** Nessuno si cancella da solo con la policy, nemmeno il `super-admin` (rischio di blocco del sistema): `before()` rifiuta `delete`/`forceDelete` quando il bersaglio e' l'utente stesso. Effetto dichiarato: `DeleteAccountAction` (Gdpr, D-01) fa `Gate::authorize('delete', $user)` sul proprio utente e risponde 403. Per l'utente Fixcity lo faceva gia' (DEDOTTO, nessuna policy), era un percorso senza link in UI, senza test e senza anonimizzazione: nessun comportamento funzionante e' stato tolto. DA DECIDERE nel quadro di DEC-10/D-01: se il cittadino deve potersi cancellare, serve una capacita' dedicata (proposta: `deleteOwnAccount` sulla stessa policy, chiamata da `DeleteAccountAction`), non il `delete` generico.
3. **D-05.** Il default giusto lo fornisce il modulo che possiede il flusso (User), non Notify: un'Action in User crea/aggiorna il template `reset-password` in it, en, de, es prima di costruire la mail. Cosi' `Modules/Notify` non cambia. Il testo e' in file lingua `user::reset_password_email.*`; nessun `Blade::render` su stringhe da database (il motore resta Mustache di `spatie/laravel-mail-templates`).
4. **D-04.** La logica del reinvio passa in un'Action (`ResendEmailVerificationAction`): non invia se l'indirizzo e' gia' verificato, non lancia mai `Verified`. La pagina chiama l'Action e fa `return redirect(...)`. Nessuna nuova rotta, nessun cambio al flusso di registrazione (DEC-11 resta del titolare).
5. **D-02.** L'azione usa solo colonne esistenti: filtro su `user_id` e `user_type` (sia il nome di classe sia l'alias morph, perche' i percorsi di scrittura usano l'uno o l'altro), poi `revoked_at`, `revoked_ip_address`, `updated_by`. L'user agent della revoca non si salva (colonna inesistente): vedi SCHEMA-DA-CHIEDERE.

## SCHEMA-DA-CHIEDERE

Non creata nessuna migrazione. Proposta (testo, da approvare dall'utente):

```php
// Modules/Gdpr/database/migrations/<progressivo>_add_revoked_user_agent_to_consents_table.php
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('revoked_user_agent')) {
        $table->string('revoked_user_agent', 191)->nullable();
    }
});
```

Serve solo se si vuole conservare lo user agent della revoca come si fa per l'ip (`revoked_ip_address`). Se approvata: aggiungere `revoked_user_agent` a `Consent::$fillable` e a `RevokeGdprConsentsAction`. Il consenso non perde valore probatorio senza questo campo: `revoked_at` e `revoked_ip_address` bastano per la data e la provenienza.

## DA DECIDERE (non bloccante per il codice di questa story)

- Self-delete del cittadino (D-01/DEC-10): vedi decisione 2.
- Link di reset senza email (D-05): aggiungere `?email=` richiederebbe che la pagina lo legga; valutare con la riscrittura del form di reset gia' segnalata in memoria.
- Traduzioni `de`/`es` di `verification_email` (D-34): fuori scope perche' appartengono al flusso di verifica email (DEC-11).

## Criteri di accettazione verificabili

- [x] D-06: matrice ruolo x abilita' x (se stesso / altro) verde: nessun utente senza ruolo amministrativo vede, modifica o cancella un altro utente; ognuno vede e modifica se stesso; `create` solo per `admin`/`user::admin`/`super-admin`; nessuno si cancella da solo.
- [x] D-06: `Gate::forUser(<utente Fixcity>)->allows('update', <altro utente>)` e' `false` (la policy si applica anche alla classe di auth reale).
- [x] D-05: dopo `new SpatieEmail($utente, 'reset-password')` nel flusso del provider, il template ha, in it/en/de/es, oggetto e corpo con `{{ reset_password_url }}` e senza "registrazione"; l'esecuzione ripetuta non lo duplica; un template personalizzato dall'admin non viene sovrascritto.
- [x] D-05: le chiavi `user::reset_password_email.*` esistono in it, en, de, es e nessun valore `en`/`de`/`es` e' uguale all'italiano.
- [x] D-04: `ResendEmailVerificationAction` non invia notifiche a un utente gia' verificato, ne invia una a un non verificato, non emette `Verified`; `verify.blade.php` non contiene piu' `event(new Verified` ne' un `redirect(` senza `return`.
- [x] D-02: `RevokeGdprConsentsAction` imposta `revoked_at` e `revoked_ip_address` sui consensi attivi dell'utente, non tocca quelli di un altro utente ne' quelli gia' revocati, senza errori SQL; nessuna migrazione creata.
- [x] PHPStan a zero sui file nuovi o toccati; Pint solo sui miei file.

## Test

- `Modules/User/tests/Unit/Policies/UserPolicyMatrixTest.php` (nuovo): matrice a doppia entrata con utenti reali sul DB di prova.
- `Modules/User/tests/Feature/Auth/ResetPasswordMailTemplateTest.php` (nuovo).
- `Modules/User/tests/Unit/Actions/ResendEmailVerificationActionTest.php` (nuovo) e guardia sulla pagina Blade.
- `Modules/Gdpr/tests/Unit/Actions/RevokeGdprConsentsActionTest.php` (nuovo).
- Esecuzione: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh <percorso>` dalla radice (DB usa-e-getta).

## Owned file scope

Modificati (esistenti, con lock `DCP-285`, sbloccati a fine lavoro):

- `laravel/Modules/User/app/Models/Policies/BaseUserPolicy.php`
- `laravel/Modules/User/app/Models/Policies/UserPolicy.php`
- `laravel/Modules/User/app/Providers/UserServiceProvider.php` (solo `registerPolicies()` e la riga del template nel callback di `ResetPassword::toMailUsing`; il file contiene anche le modifiche di DCP-282, non mie)
- `laravel/Modules/User/resources/views/pages/auth/verify.blade.php`
- `laravel/Modules/Gdpr/app/Actions/Consent/RevokeGdprConsentsAction.php`
- `laravel/Modules/User/docs/bmad/decision-log.md` (una voce in fondo e `updated`)

Nuovi:

- `laravel/Modules/User/app/Actions/Auth/EnsureResetPasswordMailTemplateAction.php`
- `laravel/Modules/User/app/Actions/Auth/ResendEmailVerificationAction.php`
- `laravel/Modules/User/lang/{it,en,de,es}/reset_password_email.php`
- `laravel/Modules/User/tests/Unit/Policies/UserPolicyMatrixTest.php`
- `laravel/Modules/User/tests/Feature/Auth/ResetPasswordMailTemplateTest.php`
- `laravel/Modules/User/tests/Feature/Auth/VerifyEmailResendPageTest.php`
- `laravel/Modules/Gdpr/tests/Unit/Actions/RevokeGdprConsentsActionTest.php`
- questa story

Non toccati: `Modules/Notify/**` (nemmeno `SpatieEmail.php`), `Modules/Cms/**`, `Modules/Fixcity/**`, `routes/web.php`, `bootstrap/*`, rotte API di User, migrazioni (nessuna creata ne' modificata).

## Esito

Output reali, sul DB usa-e-getta di `bashscripts/tools/pest-scratch-db.sh` (2026-10-26).

| Punto | Rosso prima | Verde dopo |
|---|---|---|
| D-06 `UserPolicyMatrixTest` | `Tests: 21 failed (48 assertions)`; poi, aggiunti 2 test sulle abilita' collettive: `2 failed, 21 passed` | `Tests: 23 passed (95 assertions)` |
| D-05 `ResetPasswordMailTemplateTest` | `Tests: 5 failed, 1 passed (17 assertions)`: il corpo salvato era `Gentile ... La tua registrazione e' in attesa di approvazione`, la mail resa non conteneva il token | `Tests: 6 passed (87 assertions)` |
| D-04 `VerifyEmailResendPageTest` (sulla pagina vera, `Volt::test('auth.verify')`) | `Tests: 2 failed (6 assertions)`: "The following notifications were sent unexpectedly: VerifyEmail" per l'utente gia' verificato, "The unexpected [Illuminate\Auth\Events\Verified] event was dispatched" al reinvio | `Tests: 2 passed (7 assertions)` |
| D-02 `RevokeGdprConsentsActionTest` | `Tests: 3 failed`: `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'revoked_user_agent' in 'SET'` (la query conteneva anche `subject_type`) | `Tests: 3 passed (14 assertions)`; con `GdprConsentBusinessLogicTest` e `SaveGdprConsentsActionTest`: `Tests: 11 passed (42 assertions)` |

Altre prove:

- `Modules/Fixcity/tests/Unit/Policies` e `Feature/Policies` (TicketPolicy, lookup permessi, con la policy di User ora registrata): `Tests: 8 passed (44 assertions)`.
- PHPStan, da `laravel/`, sui 14 file PHP nuovi o toccati (config unica, nessun `--level`): `[OK] No errors`. Pint `--test` sui file miei, escluso `UserServiceProvider.php` per non riformattare le righe di DCP-282: `passed`.
- Nessuna emoji ne' lineetta lunga nei file scritti (grep sui codepoint U+2013, U+2014 e sul blocco emoji: vuoto).
- Nessuna migrazione: `git status --short database` in User e in Gdpr e' vuoto.

Non partono o falliscono per cause non legate a queste modifiche (verificato leggendo l'errore, non provato con un confronto prima/dopo perche' git e' vietato):

- `Modules/User/tests/Unit/UserPolicyBehaviorTest.php`: 3 errori `Call to undefined function Modules\User\Tests\Unit\mockeryExpect()`.
- `Modules/User/tests/Feature/Filament/Resources/UserResourceTest.php`: 8 errori `Undefined array key "section01"` (schema del form).
- `Modules/Notify/tests/Unit/Emails/SpatieEmailAutoCreateDefaultsTest.php`: 2 errori `BindingResolutionException ... EventSubscriber`, uguali anche lanciato da solo (il file non dichiara nessun TestCase).
- `Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/AuthVerifyRouteTest.php`: `Call to undefined method ...::get()` (nessun TestCase).
- Gdpr: i test di quel modulo non dichiarano `uses(TestCase::class)` perche' `tests/Pest.php` del modulo li lega, ma una esecuzione per singolo file non carica quel Pest.php (un test in forma Pest dava `A facade root has not been set`). Il test nuovo e' quindi una classe PHPUnit che estende `Modules\Gdpr\Tests\TestCase`, come `GdprConsentBusinessLogicTest`.
- `Modules/User/tests/Feature/Filament` (intera cartella, eseguita per cercare regressioni di autorizzazione): `Tests: 18 failed, 3 todos, 21 skipped, 81 passed (235 assertions)`. Nessun fallimento cita 403, `AuthorizationException`, "Unauthorized" o una policy. I 18 sono: schema del form di `UserResource` (`Undefined array key "section01"`, 8), `SuperAdminWidget` (4: il widget legge `profile->user->hasRole('super-admin')`, nessuna policy nel percorso), `TeamChangeWidget`, `RegisterWidget FO`, rotta notifiche, dissociazione client OAuth (`owner_id` nullo), file `Http/Livewire/Team/Change.php` ancora presente. Non provati rossi anche prima della modifica (git vietato per il confronto): la lettura del codice di ciascun percorso non mostra alcuna chiamata alla policy degli utenti.

Non verificato:

- Nessun browser: l'accesso al back office di User con un utente `user::admin` reale non e' stato provato in pagina, solo col Gate e con le classi. Il ruolo `admin` non esiste nel DB di sviluppo (solo nel `RoleSeeder`).
- `UserServiceProvider.php` e' stato modificato da due sessioni (DCP-282 e questa): le due modifiche sono indipendenti e il file passa PHPStan, ma non e' stato rieseguito il test di DCP-282.
- La mail di reset non e' stata spedita davvero (MAIL_MAILER di sviluppo e' `sendmail`, D-15); provata solo la resa del template in tedesco.
- D-04: la rotta `verification.verify` resta non definita (DEC-11): il link nella mail di verifica continua a non poter essere generato finche' il titolare non decide. Questa story non lo risolve.

## 2026-11-03: destinatario delle email di autenticazione in una Action

Le closure `ResetPassword::toMailUsing` e `VerifyEmail::toMailUsing` di `UserServiceProvider` ripetevano la stessa ricerca dell'indirizzo, con `else` dopo `throw` e `\InvalidArgumentException` non importato (PHPMD `ElseExpression`, `MissingImport`). Ora usano `Actions/Auth/ResolveNotifiableEmailAction`: prima `getEmailForPasswordReset()`, poi `email`, null se mancano entrambi; un valore non stringa lancia `InvalidArgumentException` con lo stesso messaggio. Il reset password registra ancora l'errore quando manca il destinatario. Tolti tre import usati solo nei commenti (`Livewire`, `LoginWidget`, `RegisterWidget`).

Verifica: `tests/Unit/Actions/Auth/ResolveNotifiableEmailActionTest.php` (4 casi) e `tests/Feature/Auth/ResetPasswordMailTemplateTest.php` (6 casi, passano dalla closure): 10 passed. PHPStan intero progetto `[OK]`, Pint passa; PHPMD sul provider: solo `CouplingBetweenObjects` 20, uguale a prima e nella soglia di progetto.
