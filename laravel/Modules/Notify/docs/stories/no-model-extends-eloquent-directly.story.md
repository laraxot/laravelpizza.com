---
title: "no model extends eloquent directly.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no model extends eloquent directly.story"
issues: []
discussions: []
name: no-model-extends-eloquent-directly
description: Theme/EmailTemplate/NotificationType extended Eloquent Model directly instead of Notify's own BaseModel
metadata:
  type: story
  status: done
  module: Notify
  claimed_by: claude-sonnet-5 (this session)
---

# Story: no model may extend `Illuminate\Database\Eloquent\Model` directly

## Richiesta utente

"`laravel/Modules/Comment/app/Models/CommentNotificationSubscription.php`
non deve estendere `Illuminate\Database\Eloquent\Model`, nessun modello
deve estendere direttamente `Illuminate\Database\Eloquent\Model`" — con
richiesta di applicare la regola a tutto il repo, non solo al file
segnalato, e di capire il perche'.

## Perche' la regola

`Modules\Xot\Models\XotBaseModel` (via il `BaseModel` di ogni modulo)
fornisce comportamento condiviso da ogni model del monorepo: cast
comuni (`id`/`uuid` come stringa, `published_at`/`verified_at` datetime),
il trait `Updater` (popolamento automatico `created_by`/`updated_by`/
`deleted_by`), `HasXotFactory` (risoluzione factory via
`GetFactoryAction`), `RelationX`, `getClassName()` per la risoluzione
modulo-agnostica del namespace concreto. Un model che estende `Model`
direttamente perde TUTTO questo silenziosamente — nessun errore, nessun
warning, solo comportamento mancante (es. audit fields sempre `null`).

## Controllo altri agenti + ricerca per regola, non per sintomo

Grep per la regola (`class \w+ extends (Model|EloquentModel|...Model)`,
non solo il file segnalato) in `*/app/Models/*.php`, escludendo
`XotBaseModel.php` (root legittima della catena) e `packages/` (copie
vendor di terze parti): trovati altri 5 file, oltre a quello segnalato
dall'utente:

- `Modules/Notify/app/Models/Theme.php`
- `Modules/Notify/app/Models/EmailTemplate.php`
- `Modules/Notify/app/Models/NotificationType.php`
- `Modules/Comment/app/Models/Comment.php`
- `Modules/Comment/app/Models/CommentNotificationOptOut.php`
- `Modules/Comment/app/Models/CommentNotificationSubscription.php`
  (quest'ultimo gia' preso in carico da un'altra sessione con lock attivo
  al momento dell'indagine — vedi
  `docs/chat/commentnotificationsubscription-morphto-covariance-standdown.md`)

Due file esclusi dopo revisione, non modificati:

- `Modules/Activity/app/Models/TestModel.php` — modello di test dedicato
  con migration/factory/seeder propri, usato per verificare che il
  sistema di Activity logging funzioni contro un model Eloquent generico
  (non-XotBase). Probabile scelta deliberata per isolare il test dal
  comportamento XotBase — non toccato senza conferma owner.
- `Modules/User/app/Models/PersonalAccessToken.php` — punto di
  integrazione Laravel Sanctum, richiede valutazione separata (il modello
  e' configurabile via `Sanctum::usePersonalAccessTokenModel()`, ma
  cambiare la classe base tocca un pacchetto di terze parti con
  aspettative proprie sul modello token) — segnalato, non toccato qui.

## Fix applicato (questo modulo)

`Theme`, `EmailTemplate`, `NotificationType`: `extends Model` ->
`extends BaseModel` (gia' esistente in `Modules/Notify/app/Models/BaseModel.php`,
`$connection = 'notify'`). Rimosso l'import ora inutile di
`Illuminate\Database\Eloquent\Model` dove non piu' referenziato altrove
nel file.

Comment (Comment.php, CommentNotificationOptOut.php): stesso fix,
applicato in collaborazione con sessioni concorrenti nello stesso
intervallo di tempo, committato in
`laraxot/dev` del repo Comment (commit `7ffcbf2`, story `CMT-002`).

## Verifica

`phpstan analyse Modules/Notify`: 0 errori (cache pulita, 3 file).
`./tools/phpmd.sh` sui 3 file: 0 violazioni. Dettaglio Pest in
`docs/coverage.md` (suite completa non eseguibile in modo affidabile per
contesa dell'ambiente condiviso; nessuna nuova failure imputabile a
questo fix).

## Esito

3 file corretti in Notify, committati e pushati. Comment gia' chiuso da
altra sessione. `CommentNotificationSubscription.php` lasciato
esplicitamente ad altra sessione attiva (vedi standdown note).
