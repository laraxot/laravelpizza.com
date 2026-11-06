---
title: "[STORY] PHPStan cleanup modulo Cms (scopo prima dell'errore)"
type: story
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [cms, phpstan, tests, enum, lang, bmad]
related:
  - ./phpstan-cleanup-cms.dev.md
  - ../actions/page-resolution-pipeline.md
---

# [STORY] PHPStan cleanup modulo Cms

## User Request

> sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore;
> aumenta la qualita' del codice; usa enum al posto delle costanti.

Gruppo Cms: 111 errori in 51 file (`laravel/Modules/Cms/**`). Nessun file spostato o cancellato, nessun `phpstan.neon`/baseline toccato.

## Analysis

Il modulo Cms gestisce pagine/sezioni/blocchi (`BlockData`, `HasBlocks`, `x-page`). Gli errori non erano cosmetici:
la maggior parte dei "variabile mai letta" nei test erano test **senza asserzione** (creavano l'oggetto e finivano li').

| Area | Cosa doveva fare | Cosa mancava / era sbagliato |
|------|------------------|-------------------------------|
| `BuildPageSchemaAction` / `PageSchemaBuilder` | JSON-LD `Person` del profilo pubblico: `email` dall'utente **con fallback** sull'email del profilo (come nome/cognome) | `$profileEmail` veniva letto e mai usato: il fallback era stato perso in un refactor tipizzato (commit `4a7877c3` lo aveva: `$publicUser->email ?? $profileEmail`). Ripristinato. |
| `FolioVoltServiceProvider` | registrare i path Folio per ogni locale supportato | `$defaultLocale` calcolato e mai usato dalla prima versione; il default lo gestisce `SetFolioLocale`. Codice morto, rimosso. |
| `CmsBasePolicy::before()` | scorciatoia super-admin via ruolo | `$xotData` inutile (la regola canonica e' `hasRole('super-admin')`, come `XotBasePolicy`). Rimosso insieme all'import. |
| `Menu::getTreeMenuOptions()` | passare la classe all'action Xot dell'albero | `@var` generico incompleto (e prima un `@phpstan-ignore`): il vero problema era `@implements ...<Menu>` contro un'action che accetta `<Model>` (template invariante). Allineato a `<Model>`, nessun `@var`. |
| `HasBlocks` (errori "in context of anonymous class") | trait dei blocchi di Page/Section | Falsi positivi generati dalle `anonymous class extends BaseModel` nel test: PHPStan analizza il trait fuori dal suo contesto e perde i PHPDoc. Il test ora usa i modelli reali (`Page`, `Section`). |
| `AttachmentDiskEnum` | enum con label/colore/icona/descrizione per la select `disk` di `AttachmentForm` | **Mancavano le traduzioni** `cms::attachment_disk_enum.values.*`: la UI mostrava `fix:cms::attachment_disk_enum...`. Creati i lang it/en/de. |
| `app/docs/config.php` | config Jigsaw (sito docs statico) con closure su `$page` | Tipi `mixed` ovunque, `env()` fuori da `config/`. Letture difensive su oggetto Jigsaw (non installato) e ambiente da `$_SERVER`/`$_ENV`. |
| `tests/PestStubs.php` | stub per PHPStan di `actingAs`/`livewire` | Parametri inutilizzati: ora entrano nel messaggio dell'eccezione dello stub (firma invariata). |
| Test (~40 file) | verificare comportamento | Assegnazioni senza asserzioni: sostituite con asserzioni di comportamento; dove serve uno store isolato/markup del tema, `->todo('<motivo>')` come gia' fa il modulo. |

## Acceptance Criteria

- [x] `./vendor/bin/phpstan analyse Modules/Cms --memory-limit=-1 --no-progress` a 0 errori (111 -> 0)
- [x] Nessun `@phpstan-ignore*`, `@var` bugiardo, cast per zittire o `assert` finti
- [x] Nessun file cancellato/spostato/rinominato; `phpstan.neon` e baseline intatti
- [x] Nessuna modifica a `config/local/techplanner/database/content/{pages,sections}`
- [x] `$profileEmail` usato davvero (fallback email profilo nello schema JSON-LD)
- [x] Traduzioni dell'enum `AttachmentDiskEnum` presenti (it/en/de)
- [x] Test con asserzioni reali al posto di variabili inutilizzate
- [x] `php -l` OK sui file toccati
- [ ] Esecuzione Pest: NON eseguita (`.env.testing` punta a MySQL, vedi dev story)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
