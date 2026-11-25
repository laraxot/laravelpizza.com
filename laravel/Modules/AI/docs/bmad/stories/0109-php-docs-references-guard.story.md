---
title: "Riferimenti dal codice PHP ai docs: correzione e guardia"
type: story
epic: tooling-quality
module: Xot
status: in-progress
created: 2026-11-25
qmd: "see contract docblock riferimenti docs rotti php guardia tetto consolidazione docs link codice"
related:
  - ./0056-docs-consolidate-redundant-md.story.md
  - ./0065-docs-topic-synthesis-swarm.story.md
---
# Riferimenti PHP → docs

## Context and Problem Statement

I docblock PHP puntano ai docs (`@see docs/...`, `@contract docs/contracts/...`): sono il ponte fra il codice e la
sua spiegazione. Misura 2026-11-25 11:55: **150 rotti su 1796** (Xot 40, Ptv 38, User 22, Performance 13,
IndennitaResponsabilita 13, ...). Due sessioni stanno consolidando i docs (fusione + cancellazione): senza
una guardia eseguibile il numero puo' solo crescere. Lane complementare: tocca solo righe di docblock nei `.php`,
mai file in `docs/`.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Perche'

I docblock PHP puntano ai docs (`@see docs/...`, `@contract docs/contracts/...`): sono il ponte fra il codice e la
sua spiegazione. Misura 2026-11-25 11:55: **150 rotti su 1796** (Xot 40, Ptv 38, User 22, Performance 13,
IndennitaResponsabilita 13, ...). Due sessioni stanno consolidando i docs (fusione + cancellazione): senza
una guardia eseguibile il numero puo' solo crescere. Lane complementare: tocca solo righe di docblock nei `.php`,
mai file in `docs/`.

## Task

- [ ] Correggere i riferimenti con un solo bersaglio esistente (stesso basename), preferendo il modulo owner
- [ ] Script `bashscripts/tools/docs/check-php-docs-refs.py` (sola lettura, exit 1 se rotti > tetto) da lanciare prima di cancellare/spostare docs
- [ ] Test Pest Xot con tetto che puo' solo scendere
- [ ] Elenco dei residui ambigui/mancanti per gli owner dei docs

## AC

- [ ] Rotti dopo < 150, residui elencati con motivo
- [ ] Nessuna riga non-docblock modificata; PHPStan sui file toccati 0 errori; Pint ok
- [ ] Pest: eseguito o skip documentato (TestDatabaseGuard)

### Coordinamento (claude-opus-5.5 f3659729, 2026-11-25 12:00)

- Prendo **tutto `laravel/Modules/Pdnd/app/**`** (lock `bashscripts/lock/code-pdnd-app-docblocks.lock`): array shapes dei
  payload ANPR e, nello stesso passaggio, i riferimenti `@see`/`@contract` rotti del solo Pdnd. Per favore saltate Pdnd.
- Le mie lane docs (story `docs-topic-synthesis-swarm`) su Ptv, Performance, IndennitaResponsabilita, Progressioni, Sigma,
  Tenant, Lang, ICL, Incentivi, Pdnd e temi hanno l'ordine di non eliminare docs citati dal codice; a fine lane rilancio la
  vostra misura. Se `check-php-docs-refs.py` e' pronto, segnalatelo qui: lo uso come gate prima della chiusura.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
