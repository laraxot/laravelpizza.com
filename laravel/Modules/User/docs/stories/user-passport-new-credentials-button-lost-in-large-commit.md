---
id: story-user-passport-new-credentials-button-lost-in-large-commit
slug: story-user-passport-new-credentials-button-lost-in-large-commit
title: "STORY — Il bottone 'Nuove credenziali' della Passport Dashboard è scomparso, cancellato da un commit di un giorno dopo"
description: "Il bottone che genera client OAuth client_credentials dalla UI (story user-passport-create-client-credentials-button.md, module_user_fila5#85), implementato e verificato dal vivo dall'utente il 2026-09-03, non è più presente nella Passport Dashboard oggi. Trovato via git log -S: cancellato dal commit 9d2362d94 (2026-09-04), che si dichiara un refactor del modulo AI ma tocca 7495 file in tutto il repository. Da verificare con il team leader se la cancellazione sia stata accidentale o voluta."
document_type: story
category: bmad
scope: module:User
github_id: module_user_fila5#98
status: ready-for-dev
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: high
created_at: '2026-09-15'
updated_at: '2026-09-15'
tags: [bmad, story, user, passport, oauth, admin, git-history, regression]
related:
  - ../../laravel/Modules/User/docs/stories/user-passport-create-client-credentials-button.md
  - ../../laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php
  - ../../laravel/Modules/User/tests/Feature/Filament/Clusters/Passport/Pages/PassportDashboardNewCredentialsTest.php
github:
  repository: https://github.com/laraxot/module_user_fila5
  issue: https://github.com/laraxot/module_user_fila5/issues/98
  discussion: https://github.com/laraxot/module_user_fila5/discussions/99
---

# STORY — Il bottone "Nuove credenziali" è scomparso dalla Passport Dashboard

## Contesto

L'utente ha chiesto l'URL della Passport Dashboard per usare il bottone
"Nuove credenziali" (story `user-passport-create-client-credentials-button.md`,
`module_user_fila5#85`, implementato e verificato dal vivo il 2026-09-03).
Aperta la pagina, il bottone non c'era: solo i 4 bottoni originari
(`passport_install`, `passport_keys`, `passport_purge`, `passport_hash`).

## Cosa è successo, verificato nel git log (non un'ipotesi)

```
git log --all -p -S "new_credentials" -- laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php
```

**Aggiunto**: commit `78575b2c85fe0f629141630ba17ddf8bd815d236`, 2026-09-03,
autore **Malebestia** (l'utente stesso) — `feat+fix: pulsante Nuove
credenziali Passport, e fix crash/campi persi in
CreateContactsForSurveyAction`. Corrisponde esattamente alla story #85.

**Cancellato**: commit `9d2362d941ffa669c8445c58352b4e3c95811098`,
2026-09-04 (un giorno dopo), autore **Marco Sottana** — titolo:
`refactor(AI): extract nested parsing logic into private methods + improve
type safety`.

Il diff di questo secondo commit rimuove per intero, da
`PassportDashboard.php`:
- il metodo `protected function newCredentialsAction(): Action` (l'intera
  azione: form con il nome del cliente, chiamata a
  `ClientRepository::createClientCredentialsGrantClient()`, notifica con
  `client_id`/`client_secret`)
- la sua registrazione in `getHeaderActions()`
  (`'new_credentials' => $this->newCredentialsAction()`)
- gli `use` diventati inutilizzati (`TextInput`, `Auth`, `ClientRepository`,
  `SafeStringCastAction`, `Assert`)

**Verificato anche**: le chiavi di traduzione (`new_credentials`,
`client_name`, `credentials_created`) non esistono più in
`Modules/User/lang/{it,en}/passport_dashboard.php`.

## Perché è sospetto, non solo "un refactor che ha toccato troppo"

Il commit `9d2362d94` si dichiara un refactor mirato del modulo **AI**
(estrarre metodi privati da `ContextCompressorAction`/`ChatDs4Action`/ecc.).
Ma il suo diff completo (`git show --stat 9d2362d94`) tocca:

```
7495 files changed, 374664 insertions(+), 70212 deletions(-)
```

— file in **ogni** modulo del progetto (AI, Activity, Cms, Job, Lang, Media,
Notify, Tenant, UI, User, Quaeris...), inclusi `.codeclimate.yml`,
`.gitattributes`, `.github/dependabot.yml`, README, docs di decine di
moduli. Questo non è compatibile con un refactor mirato: ha tutta l'aria di
un merge/rebase di una branch lungamente divergente, o di una sincronizzazione
di massa, etichettato per errore col messaggio dell'ultimo lavoro fatto in
locale prima di eseguirlo. **Non è stato verificato se altre funzionalità
oltre a questa siano state perse allo stesso modo da questo stesso commit**
— fuori scope per questa story, ma segnalato come rischio concreto da
valutare a parte.

## Perché nessun test se n'è accorto

`PassportDashboardNewCredentialsTest.php` esiste ancora ed è verde (1
passed, 2 skipped) — ma non protegge da questa regressione:
- L'unico test che gira davvero (`'creates a real client_credentials grant
  client...'`) chiama `ClientRepository::createClientCredentialsGrantClient()`
  **direttamente**, mai tramite `Livewire::test(PassportDashboard::class)`
  — non tocca in nessun modo il bottone/l'azione sulla pagina reale.
- I due test che *avrebbero* rilevato esattamente questa regressione
  (`assertActionHidden('new_credentials')` /
  `assertActionVisible('new_credentials')`) erano già `markTestSkipped()`
  dal 3 settembre, per un problema preesistente e non correlato del DB di
  test (`profiles.uuid` mancante) — il loro corpo reale è commentato, mai
  eseguito. La cancellazione del giorno dopo è quindi passata inosservata
  per costruzione: l'unico controllo automatico capace di accorgersene era
  già disattivato.

## Correzione 2026-09-17 — i commit citati sopra non appartengono al repository vero del modulo

Verificato con `git log --all -S "new_credentials"` **dentro
`Modules/User` come repository a sé** (non dal mono-repo): i commit
`78575b2c8`/`9d2362d94` **non esistono in questa storia**. Appartengono
solo alla "fotografia" separata che il mono-repo teneva di questo stesso
contenuto (vedi `docs/wiki/log.md`, voce sulla scoperta della doppia
tracciatura). La feature non è stata "persa da un commit successivo" nel
repository reale del modulo: **non vi era mai arrivata**, perché
implementata e pushata solo nella copia del mono-repo, mai confluita in
`laraxot/module_user_fila5`. Il file di test
(`PassportDashboardNewCredentialsTest.php`) invece esiste davvero nella
storia del modulo — è arrivato per una via diversa.

Questo non cambia la sostanza per l'utente (il bottone non c'era ed è
stato ripristinato), ma cambia a chi va posta la domanda "accidentale o
voluto?": non necessariamente all'autore di `9d2362d94` (che ha toccato
solo la fotografia del mono-repo, un artefatto derivato), ma a chi ha
gestito la sincronizzazione tra mono-repo e repository dei singoli
moduli in quel periodo.

## Ripristino 2026-09-17

Codice ridato a `PassportDashboard.php` re-implementando
`newCredentialsAction()` (stessa logica: `ClientRepository::
createClientCredentialsGrantClient()`, gate super-admin, notifica
persistente con client_id/secret) e le chiavi di traduzione mancanti
(`actions.new_credentials.label`, `fields.client_name.label`,
`messages.credentials_created`) in `Modules/User/lang/{it,en}/
passport_dashboard.php`. Commit fatto per davvero questa volta
**nel repository reale del modulo** (`laraxot/module_user_fila5`), non
solo nella fotografia del mono-repo — non dovrebbe poter sparire di
nuovo per lo stesso motivo.

Verificato:
- PHPStan pulito
- Test esistente `PassportDashboardNewCredentialsTest.php`: il test reale
  (AC7a) passa; i 2 test skippati restano skippati per il blocco
  preesistente e non correlato del DB di test (`profiles.uuid`) — non
  riguarda questo ripristino
- Verifica diretta (reflection su `getHeaderActions()`, senza passare dal
  DB di test bloccato): tutte e 5 le azioni sono registrate,
  `new_credentials` risolve all'etichetta corretta "Nuove credenziali"

## Cosa NON è stato fatto

Non ancora chiarito con il team se la mancata propagazione al repository
del modulo sia stata accidentale o voluta (vedi correzione sopra) — resta
da chiedere, ma non blocca più il ripristino del bottone, già fatto.

## Bug correlato scoperto e corretto 2026-09-17 (non su questa action)

Testando altre azioni della stessa pagina (`passport_install`,
`passport_keys`, `passport_purge`, `passport_hash`, tutte basate su
`executeCommand()`), scoperto lo stesso difetto già isolato su
`ArtisanCommandsManager` (modulo Xot): `ExecuteArtisanCommandAction`
segnalava l'esito tramite `Event::dispatch()` (Laravel, server-side), che
`PassportDashboard` intercettava via `#[On(...)]` (bus eventi di Livewire,
un canale diverso che non riceve mai eventi Laravel) — nessun listener
riceveva mai davvero questi eventi, quindi `isRunning`/`status`/`output`
restavano bloccati sui valori iniziali anche a comando riuscito. La
`newCredentialsAction()` di questa story **non è interessata** (è
un'azione a chiusura diretta, non passa da `executeCommand()`).

Corretto: `executeCommand()` ora legge direttamente il valore di ritorno
di `execute()` invece di aspettare l'evento. Dettagli completi, causa
radice e verifica: story
`Modules/Xot/docs/stories/xot-artisan-commands-manager-stuck-running-state.md`,
issue https://github.com/laraxot/module_xot_fila5/issues/131.

## Acceptance Criteria

1. **[RISOLTO 2026-09-17]** Il bottone "Nuove credenziali" è di nuovo
   presente e funzionante, verificato dal vivo (reflection su
   `getHeaderActions()`, test AC7a verde).
2. **[APERTO]** Verificato con il team se la mancata propagazione al
   repository del modulo (vedi correzione sopra) sia stata accidentale o
   voluta — non blocca più il ripristino, ma resta utile capirlo per
   evitare che si ripeta con altre feature.
3. N/A — non era mai stata rimossa dalla storia del modulo, quindi non
   c'è nessuna decisione "intenzionale" da riflettere in
   `user-passport-create-client-credentials-button.md`.
4. **[APERTO]** I due test skippati in `PassportDashboardNewCredentialsTest.php`
   restano skippati per il blocco preesistente del DB di test
   (`profiles.uuid`) — non risolto da questa story, resta un rischio
   strutturale (una feature UI intera può sparire senza che nessun test
   se ne accorga, come successo qui).
5. (Opzionale, fuori scope stretto ma segnalato) — valutare se altre
   funzionalità siano rimaste "solo nella fotografia" del mono-repo senza
   mai confluire nei repository reali dei moduli, dato quanto scoperto
   sulla doppia tracciatura.

## Tasks/Subtasks

- [ ] Task 1: condividere questa story con il team leader/l'autore del
      commit per la verifica (AC1).
- [ ] Task 2 (condizionale): ripristinare il codice se la cancellazione
      risulta accidentale (AC2).
- [ ] Task 3 (condizionale): aggiornare `user-passport-create-client-credentials-button.md`
      se la rimozione risulta intenzionale (AC3).
- [ ] Task 4: decidere se e come sbloccare i test skippati (AC4).

## Dev Notes

- Nessun lock preso, nessun file toccato in questa story: solo analisi via
  `git log`/`git show`, lettura del codice attuale e del test esistente.
- Riferimento diretto: [Source: laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php]
  (stato attuale, 4 azioni, nessuna `new_credentials`)
- [Source: commit 78575b2c85fe0f629141630ba17ddf8bd815d236] (aggiunta)
- [Source: commit 9d2362d941ffa669c8445c58352b4e3c95811098] (cancellazione)
- [Source: laravel/Modules/User/tests/Feature/Filament/Clusters/Passport/Pages/PassportDashboardNewCredentialsTest.php]
  (perché il test non ha rilevato la regressione)
