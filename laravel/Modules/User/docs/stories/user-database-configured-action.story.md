---
type: story
slug: user-database-configured-action
title: "Login in 500: IsUserDatabaseConfiguredAction referenziata ma mai committata"
status: done
owner: User
created: 2026-11-10
updated: 2026-11-10
---

# Login in 500: `IsUserDatabaseConfiguredAction` referenziata ma mai committata

## Problema

Il commit `e880c41d0` usa `Modules\User\Actions\Database\IsUserDatabaseConfiguredAction` in `LoginListener` e in
`RecordAuthenticationLogAction`, ma il file della classe non e' nel repo. Ogni login riuscito su qualsiasi pannello
finiva in `BindingResolutionException` (500 sulla chiamata Livewire): verificato avviando l'app con Roosko e
facendo login su `/roosko/admin/login`.

## Correzione

Aggiunta l'action: vero se `database.connections.user` esiste ed ha un nome di database non vuoto, cosi' le
scritture di audit del login vengono saltate (con log) quando la connessione non e' configurata, come previsto
dai due chiamanti. Test unitario in `tests/Unit/Actions/Database/IsUserDatabaseConfiguredActionTest.php`.

## Nota per chi ha il file in locale

Se esiste una versione locale non committata della classe, va confrontata con questa e unita con una patch in
avanti: i chiamanti si aspettano solo `execute(): bool`.

## Aggiornamento 2026-11-10 (pomeriggio): la classe non era mai arrivata nel repo

Il commit `b6607e7af` conteneva solo questa story: `app/Actions/Database/` e `tests/Unit/Actions/Database/`
erano esclusi dalla regola `Database/` del `.gitignore` del modulo. La regola doveva colpire solo la cartella
maiuscola nella radice del modulo (story `uppercase-root-dirs-database-application`), ma senza `/` iniziale vale
a ogni livello. PHPStan: `class.notFound` in `LoginListener` e `RecordAuthenticationLogAction`.

- Regole ancorate alla radice: `/Database/` e `/Application/`.
- Classe e test ricreati dalla specifica di questa story (`execute(): bool`, legge solo
  `database.connections.user.database`, nessuna connessione aperta).
- Verifica: PHPStan senza errori su User; nell'app (tinker) `null`, `''`, `'  '` → false, `'predict_user'` → true.
