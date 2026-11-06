---
title: "Coordinamento fra agenti nelle story BMAD, docs/chat in archivio"
type: story
status: review
module: Xot
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, multi-agent, coordinamento, docs-chat, archivio, guardia, pest]
qmd: "docs chat archivio sola lettura coordinamento agenti story bmad claim aggiornamento discussione tra agenti handoff guardia pest"
related:
  - ../../tests/Unit/Docs/DocsChatIsReadOnlyArchiveTest.php
  - ../../../../../docs/wiki/rules/agent-chat-directory.md
  - ../../../../../bashscripts/docs/modular-bmad-story-policy.md
---

# Coordinamento fra agenti nelle story BMAD, docs/chat in archivio

Stato: **review**. Owner Xot perche' la guardia vive in `Xot/tests/Unit/Docs/`, accanto a `StoryNumbersAreUniqueTest`.

## Richiesta (verbatim, 2026-10-27)

«quello che facevamo con la cartella docs/chat/ ora lo facciamo con le bmad stories, correggi»

## Analisi

- La policy delle story diceva gia' «Mai `docs/chat`», ma la regola `agent-chat-directory.md` imponeva ancora `./docs/chat/`
  come bacheca obbligatoria, e bootstrap, skill, workflow e prompt la ripetevano. Due regole in contrasto: vinceva quella letta per prima.
- Misura del 2026-10-27: `docs/chat` 338 file `.md`, `Modules/Geo/docs/chat` 68, `Modules/Rating/docs/chat` 4, `Modules/Comment/docs/chat` 1.

## Modifiche

- `agent-chat-directory.md` riscritta (nome invariato per i link): protocollo nelle story owner.
- Istruzioni attive riallineate: `CLAUDE.md`, `GEMINI.md`, `docs/wiki/index.md`, trigger map, BOOTSTRAP, lock protocol,
  workflow, skill, prompt `00-start` e `46`, guideline sui nomi. La skill `docs-chat-filename-no-dates` e' `superseded`.
- Banner «archivio in sola lettura» in `docs/chat/00-START-HERE.md`, `README-START-HERE-FIRST.md`, `INDEX.md`, `README.md` e negli
  indici di Geo e Comment. Nessun file cancellato o spostato.
- Guardia `DocsChatIsReadOnlyArchiveTest`: tetto per cartella che puo' solo scendere, nessuna cartella `docs/chat` nuova.
  Legge solo il filesystem, quindi non usa `TestCase` ne' il database.

## Discussione tra agenti

- Un'altra sessione aveva gia' avviato lo stesso lavoro alle 17:24 (regola, trigger map, banner, `CLAUDE.md`, `GEMINI.md`).
  Decisione: non riscrivere le sue righe, completare il resto e allineare i nomi delle sezioni a quelli gia' usati da DCP-377
  (`## Registro`, `## Coordinamento fra ...`, `## Note operative per altre sessioni`) piu' `## Aggiornamento` e `## Discussione tra agenti`.

## Verifica

- `vendor/bin/phpstan analyse Modules/Xot/tests/Unit/Docs/DocsChatIsReadOnlyArchiveTest.php`: `[OK] No errors`.
- `vendor/bin/pest Modules/Xot/tests/Unit/Docs/DocsChatIsReadOnlyArchiveTest.php`: 3 passed (6 assertions).
- Prova negativa: tetto `docs/chat` abbassato a 337, il test fallisce con «docs/chat: 338 file, tetto 337»; tetto ripristinato.

## Aperto

- Circa 200 memorie e concept storici citano ancora `docs/chat`: sono cronologia, non istruzioni attive, e restano come sono.
