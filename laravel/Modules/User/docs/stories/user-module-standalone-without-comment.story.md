---
title: User module runs without the Comment module
status: done
module: User
created: 2026-10-21
updated: 2026-10-21
---

# User module runs without the Comment module

## Obiettivo

Il modulo User deve poter vivere in un progetto che non include il modulo Comment.
Il modulo Comment dipende da User (commenti sugli utenti), non il contrario. Un modulo
base non deve dichiarare sibling opzionali.

## Perche

Moduli sono repo git indipendenti. Un riferimento a un sibling assente rende il modulo
legato alla presenza di quel sibling, e viola la direzione delle dipendenze del progetto
(bashscripts/docs/prompts/14-module-dependency-direction.md): il basso non conosce l'alto
o l'opzionale.

## Ricognizione

- `Modules/User/composer.json`: repository di tipo path verso `../Comment`. Non compariva in
  `require`, quindi era un residuo senza uso, ma faceva dipendere il modulo da una cartella
  che in un progetto senza Comment non esiste.
- Codice in `Modules/User/app`: nessun `use Modules\Comment\...`.
- Le altre occorrenze di "comment" in User sono falsi positivi: docblock, commenti di codice,
  `$this->comment()` di Artisan, tabelle di audit nei doc.
- `Modules/Blog` e `config/local/*/morph_map.php` con `'comment' => Blog\Models\Comment`
  riguardano un altro modulo, non Comment: fuori perimetro.

## Decisione

Rimuovere la voce `../Comment` da `composer.json` e trasformare la regola in un test, non in
una memoria: un test che fallisce se il riferimento torna.

## Ciclo TDD

1. Rosso: il test `user composer does not reference the comment module` fallisce perche' il
   `composer.json` contiene `"../Comment"`.
2. Verde: rimossa la voce, JSON valido (`python3 -m json.tool`).
3. Estensione: test `user app code does not import the comment module` sulla cartella `app/`.

## Verifica

- `./vendor/bin/pest Modules/User/tests/Unit/NoCommentModuleDependencyTest.php`
  -> `Tests: 3 passed (688 assertions)`.
- `composer validate --no-check-all` nel modulo User: valido.

## File toccati

- `Modules/User/composer.json`
- `Modules/User/tests/Unit/NoCommentModuleDependencyTest.php`

## Rischi residui

- Nessun commit eseguito: il repo User ha modifiche locali non correlate (es. `.gitignore`).
  Il commit va fatto dalla persona che gestisce il repo.
- Il test verifica solo il perimetro di User. La regola generale di direzione delle dipendenze
  resta sul prompt 14 e non e' coperta qui.
