---
id: story-user-passport-create-client-credentials-button
slug: story-user-passport-create-client-credentials-button
title: "STORY — Pulsante 'Nuovo cliente OAuth' nella Passport Dashboard, senza SSH"
description: "Oggi creare un client OAuth con credenziali funzionanti (client_id + client_secret) richiede php artisan passport:client --client via SSH. L'amministratore di questo server non ha accesso SSH. La pagina Create esistente (OauthClientResource) crea il record ma senza secret — non produce credenziali utilizzabili. Aggiungere un pulsante alla Passport Dashboard che generi un client credentials grant client funzionante direttamente dall'admin panel."
document_type: story
category: bmad
scope: module:User
github_id: module_user_fila5#85
status: review
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: medium
created_at: '2026-09-03'
updated_at: '2026-09-03'
tags: [bmad, story, user, passport, oauth, admin, super-admin, invii]
related:
  - ../../laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php
  - ../../laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php
  - ../../laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Pages/CreateOauthClient.php
  - ../../laravel/Modules/Xot/app/Actions/ExecuteArtisanCommandAction.php
  - ../../laravel/Modules/Quaeris/app/Console/Commands/AssociatePassportClientToUser.php
  - ../../laravel/Modules/Quaeris/docs/stories/quaeris-bulk-invite-job-resilience.md
github:
  repository: https://github.com/laraxot/module_user_fila5
  issues: https://github.com/laraxot/module_user_fila5/issues
  discussions: https://github.com/laraxot/module_user_fila5/discussions
---

# STORY — Pulsante "Nuovo cliente OAuth" nella Passport Dashboard

## Contesto

Emerso durante il ripristino del servizio invii automatici dopo il trasloco
server (vedi
[quaeris-bulk-invite-job-resilience.md](../../laravel/Modules/Quaeris/docs/stories/quaeris-bulk-invite-job-resilience.md)):
l'amministratore di questo server **non ha accesso SSH**. Onboardare un
nuovo cliente (es. un quinto cliente oltre ad ATS/Clara/Smat/Vivaservizi)
richiede oggi 3 passi, di cui uno bloccato:

1. Creare l'account utente — già possibile via UI, nessun problema
2. **Creare le credenziali OAuth con `php artisan passport:client --client`
   — BLOCCATO, richiede SSH**
3. Associare il client all'utente (`user_id`) — già possibile via UI,
   il form di modifica del client OAuth ha già questo campo

## Problema

### Perché la pagina "Crea" esistente non basta

`OauthClientResource` ha già una pagina di creazione
(`CreateOauthClient`), ma usa il form generico
(`XotBaseCreateRecord`/`getFormSchemaOld()`): `name`, `user_id`,
`redirect`, `provider` — **nessun campo secret, nessuna logica che lo
generi**. Un client creato da lì avrebbe `secret = null` e non
funzionerebbe mai per autenticarsi. Verificato nel codice: in tutto il
progetto, `Laravel\Passport\ClientRepository` (la classe che genera e
hasha correttamente il secret) è referenziata solo nei file di test,
mai nel codice applicativo.

### Perché `ExecuteArtisanCommandAction` non è la soluzione giusta

Esiste già un meccanismo per eseguire comandi artisan da UI
(`Modules\Xot\Actions\ExecuteArtisanCommandAction`, usato dalla stessa
Passport Dashboard per `passport:keys`/`install`/`purge`/`hash`), ma:

- Confronta il comando con una whitelist a **stringa esatta**
  (`in_array($command, $this->allowedCommands, true)`). `passport:client
  --client --name="X"` cambia ad ogni cliente (il nome varia), non è
  compatibile con un confronto a stringa fissa senza aprire un problema
  di sicurezza (interpolare un nome arbitrario dentro una stringa di
  comando shell è un rischio di injection reale, verificato:
  `Process::command("php artisan {$command}")` costruisce il comando
  come stringa).
- Anche risolvendo la whitelist, resterebbe comunque un giro non
  necessario: chiamare `ClientRepository::createClientCredentialsGrantClient()`
  direttamente in PHP è più semplice, più sicuro (nessuna
  interpolazione di stringhe in un comando shell) ed è la stessa identica
  logica che il comando artisan invoca internamente (verificato nel
  sorgente vendor di Passport, `ClientCommand::createClientCredentialsClient()`).

## Solution Overview

Nuovo pulsante "Nuove credenziali" nella Passport Dashboard esistente
(`PassportDashboard.php`, accanto a Passport Keys/Install/Purge/Hash),
gestito da un form Filament che chiede solo il nome del cliente, poi
chiama direttamente:

```php
app(\Laravel\Passport\ClientRepository::class)
    ->createClientCredentialsGrantClient($name);
```

Nessun comando shell, nessuna whitelist da estendere, nessun rischio di
injection. Il `client_id` e il `client_secret` (visibile solo una volta,
Passport v13 salva il secret hashato — stesso comportamento del comando
da terminale) compaiono in una notifica/modale Filament, da copiare
subito.

## Acceptance Criteria

- AC1: sulla Passport Dashboard compare un'azione "Nuove credenziali" che
  apre un form con un solo campo obbligatorio, il nome del cliente.
- AC2: al submit, viene creato un client OAuth reale con grant
  `client_credentials` (`Laravel\Passport\ClientRepository::
  createClientCredentialsGrantClient()`), verificabile: il record compare
  in `oauth_clients` con un `secret` valorizzato (hashato).
- AC3: `client_id` e `client_secret` in chiaro vengono mostrati **una
  sola volta**, in una notifica o modale Filament — non salvati in
  nessun log, non recuperabili una seconda volta dalla UI (coerente con
  l'hashing di Passport v13).
- AC4: l'azione è visibile ed eseguibile **solo da utenti con ruolo
  `super-admin`** (pattern esistente nel progetto,
  `hasRole('super-admin')` — vedi `SurveyPdfPolicy.php`,
  `RegenImg2.php`, e la story
  `quaeris-question-chart-edit-button.md`).
- AC5: nessun comando shell eseguito — verificabile leggendo il codice
  dell'azione, nessuna chiamata a `Process::`/`Artisan::call` con un
  nome interpolato.
- AC6: il client creato è immediatamente utilizzabile: un test end-to-end
  (anche solo manuale) con quel client_id/secret contro `/oauth/token`
  restituisce un access token valido.
- AC7: Pest: (a) il client creato ha `client_credentials` grant e un
  secret hashato non nullo; (b) l'azione è nascosta/non eseguibile per un
  utente non super-admin; (c) il nome è obbligatorio (validazione form).
- AC8: PHPStan pulito sui file toccati.

## Tasks/Subtasks

- [x] Task 1: aggiunta l'azione "Nuove credenziali" a `PassportDashboard.php`
      con form (campo nome) e chiamata diretta a
      `ClientRepository::createClientCredentialsGrantClient()`
- [x] Task 2: client_id/client_secret mostrati in una notifica Filament
      persistente (`->persistent()`) dopo la creazione, una tantum
- [x] Task 3: gating `hasRole('super-admin')` sull'azione — sia in
      visibilità (`->visible()`) sia in esecuzione (`Assert::true(...)`
      dentro l'`->action()`, difesa in profondità)
- [x] Task 4: test Pest — AC7(a) coperto ed eseguito (verde); AC7(b)/(c)
      (visibilità dell'azione per super-admin/non-super-admin) scritti ma
      **bloccati da un problema preesistente del DB di test**, non
      causato da questa story: vedi Dev Notes
- [x] Task 5 (parziale): verificato dal vivo dall'utente in locale —
      il pulsante crea davvero un client `client_credentials` (screenshot,
      notifica con client_id/secret coerente), l'abbinamento tramite il
      campo `user_id` sull'edit del client OAuth funziona ed è stato
      confermato anche via query diretta sul database (`user_id`
      valorizzato correttamente sull'utente scelto). **Non ancora
      verificato**: una vera richiesta a `/oauth/token` con quelle
      credenziali — bloccato dall'assenza delle chiavi Passport in locale
      (story `quaeris-bulk-invite-job-resilience.md`, stesso problema
      noto). Da chiudere quando le chiavi saranno disponibili (locale o
      produzione).

## Dev Notes

- **Blocco test preesistente, scoperto durante Task 4**: la tabella
  `profiles` nel DB di test (`geek_quaeris_backup_server_23_10_2025_test`,
  uno snapshot di ottobre 2025) non ha la colonna `uuid`, aggiunta da
  migration successive (2026-04-28 modulo User, 2026-08-06 modulo
  Quaeris) mai applicate a quel DB. Il mount di una pagina Filament crea
  un `Profile` per l'utente autenticato e fallisce con `Unknown column
  'uuid' in field list`. Verificato che le migration dichiarano
  davvero la colonna — il DB di test è semplicemente indietro, non un
  problema del codice di questa story. Fix (una `migrate` sul DB di
  test condiviso) fuori scope: non isolato a questa story, potenziale
  impatto su altri test in corso. I 2 test AC7(b)/(c) sono scritti,
  con il corpo reale commentato (non cancellato) e uno
  `Assert::markTestSkipped()` che spiega il blocco — riattivabili non
  appena il DB di test viene risincronizzato.
- **Non in scope**: rivedere l'accesso all'intera Passport Dashboard
  (oggi nessun controllo di ruolo esplicito trovato sulla pagina — anche
  `passport:keys`/`install`/`purge`/`hash` sono apparentemente
  raggiungibili da qualunque utente autenticato sul pannello). Gap
  preesistente, più ampio di questa story — da valutare a parte se
  serve.
- Lock prima di ogni edit: `bash bashscripts/lock/lock.sh <path> <task-id> <agent-id>`.

### References

- [Source: laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php#L146-L151]
  pattern esistente per le azioni Passport (passport_keys), da seguire
  per coerenza
- [Source: laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php#L39-L51]
  form generico esistente, senza generazione secret — perché non basta
- [Source: laravel/vendor/laravel/passport/src/Console/ClientCommand.php]
  logica originale del comando artisan, `--client` non richiede altre
  domande interattive oltre al nome se passato come opzione
- [Source: laravel/vendor/laravel/passport/src/ClientRepository.php#L141]
  `createClientCredentialsGrantClient(string $name): Client`
- [Source: laravel/Modules/Xot/app/Actions/ExecuteArtisanCommandAction.php]
  whitelist esistente, perché non è la via giusta per questo caso
- [Source: laravel/Modules/Quaeris/app/Console/Commands/AssociatePassportClientToUser.php]
  passo 3 (associazione utente), già possibile via UI oggi

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### Completion Notes List

- Story creata 2026-09-03, nata durante il ripristino del servizio invii
  automatici (vedi story collegata) — l'utente non ha accesso SSH al
  server nuovo e ha bisogno di poter onboardare futuri clienti dalla UI.
  Verificato nel codice che la via "whitelist di comandi shell" non è
  adatta (nome cliente dinamico, rischio injection) — la via corretta è
  chiamare `ClientRepository` direttamente in PHP.
- **Decisione 2026-09-03**: azione rinominata da "Nuovo cliente" a "Nuove
  credenziali" — coerente con la terminologia già usata dall'utente in
  `extras/passport_tutorial_txt`. Confermato di NON unire questo passo
  con l'associazione all'account (passo 3): tenerli separati permette in
  futuro di revocare l'abbinamento credenziali↔account senza toccare le
  credenziali stesse, e riduce il rischio di perdere il secret (mostrato
  una tantum) distraendosi con la scelta dell'utente nello stesso form.
- **Implementazione 2026-09-03**: Task 1-4 completati. PHPStan pulito su
  produzione e test. Scoperto durante il Task 4 (non un difetto di
  questa story) che il DB di test è uno snapshot di ottobre 2025, indietro
  di alcune migration reali — vedi Dev Notes. Task 5 (verifica manuale
  end-to-end) resta da fare, richiede l'accesso al pannello reale.
- **Verifica manuale 2026-09-03 (locale)**: l'utente ha usato il pulsante
  dal vivo, creazione riuscita (screenshot), abbinamento tramite `user_id`
  confermato anche via query diretta sul DB. Durante la prova sono emerse
  due scoperte **indipendenti da questa story**, non ancora tracciate in
  una story/issue propria — segnalate all'utente, decisione in sospeso:
  1. `UserResource\RelationManagers\ClientsRelationManager.php` mostra i
     client di un utente tramite la relazione `clients()` (`owner_id`/
     `owner_type`, polimorfica), ma la sua stessa azione
     "associateExistingClient" scrive su `user_id` — le due colonne non
     sono sincronizzate, quella tab mostra sempre una lista
     vuota/incompleta indipendentemente da abbinamenti reali fatti altrove
     (verificato: nessun punto della logica applicativa reale legge
     `owner_id`/`owner_type` su `OauthClient`, solo quella tab — bug
     cosmetico, non funzionale).
  2. Sul server di produzione, la lista completa "Client OAuth" mostra
     solo i 4 client di default creati da `passport:install` (Personal
     Access Client, Password Grant Client) — **nessuno dei client_id
     storici usati dai clienti reali (ATS/Clara/Smat/Vivaservizi, con
     credenziali negli script `extras/`) risulta presente**. Ipotesi in
     discussione con l'utente: il database sulla connessione `user`
     (dove vive `oauth_clients`, separata dal DB applicativo principale)
     potrebbe non essere stato ripristinato da un backup reale durante il
     trasloco server, a differenza del DB principale.

### File List

- `laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php` (modificato — nuova azione `new_credentials`)
- `laravel/Modules/User/lang/it/passport_dashboard.php` (modificato — nuove chiavi `actions.new_credentials`, `fields.client_name`, `messages.credentials_created`)
- `laravel/Modules/User/lang/en/passport_dashboard.php` (modificato — stesse chiavi, EN)
- `laravel/Modules/User/tests/Feature/Filament/Clusters/Passport/Pages/PassportDashboardNewCredentialsTest.php` (nuovo — AC7a verde, AC7b/c skip per blocco DB di test)

## GitHub (tracciamento)

Repository del modulo, letto con `cd laravel/Modules/User && git remote -v`:
**`laraxot/module_user_fila5`**.

| Risorsa | Stato | Link |
|---|---|---|
| Issue (modulo) | aperta | https://github.com/laraxot/module_user_fila5/issues/85 |
| Issue (root, mirror) | aperta | https://github.com/laraxot/base_quaeris_fila5/issues/181 |
| Issue correlata (gestione manuale associazione client↔utente, 2026-09-15) | aperta | https://github.com/laraxot/module_user_fila5/issues/97 |
| Issue correlata (bottone "Nuove credenziali" scomparso, cancellato da commit 9d2362d94, 2026-09-15) | aperta | https://github.com/laraxot/module_user_fila5/issues/98 |
