---
title: "Audit harness ECC Codex e piano di miglioramento"
type: story
module: Xot
status: review
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, audit, harness]
qmd: "ECC Codex harness audit 34 39 memory persistence GitHub integration limiti runtime"
related:
  - ../../ecc/00-index.md
  - ../../ecc/ptvx-integration.md
  - ecc-codex-plugin-setup.story.md
---
# Audit harness ECC Codex e piano di miglioramento

## Contesto

L'audit ECC ufficiale del plugin 2.2.3 è stato eseguito sull'harness Codex del progetto. Il risultato osservato è 34/39: tre controlli risultano non superati, con lacune concentrate nella persistenza della memoria (0/10) e nell'integrazione GitHub (7/10). L'esecuzione ha richiesto una dipendenza temporanea `@iarna/toml` installata sotto `/tmp`; non sono stati modificati progetto o plugin.

## User story

Come manutentore PTVX, voglio valutare in modo tracciabile i rilievi dell'audit ECC così da migliorare l'integrazione senza introdurre una seconda fonte di verità o automatismi non governati.

## Criteri di accettazione

- [x] Registrare score, esito, versione ECC, harness e dipendenza temporanea usata.
- [x] Distinguere i rilievi dell'audit dai vincoli locali PTVX e dai limiti dell'ambiente.
- [ ] Valutare separatamente persistenza memoria, policy aggiornamento dipendenze e ownership GitHub nelle story collegate.
- [ ] Aggiornare la documentazione ECC e il second brain solo dopo aver verificato che l'informazione non sia già coperta.
- [ ] Non creare una SSoT concorrente alle memorie QMD/Graphify già adottate.

## Task

- [x] Eseguire e registrare l'audit ECC con dipendenza temporanea isolata.
- [ ] Verificare le tre failing checks e classificare ciascuna come azione, limite harness o non applicabile.
- [ ] Integrare gli esiti conclusivi nell'indice ECC e nella story di setup, evitando duplicati.

## Riferimenti

- `laravel/Modules/Xot/docs/ecc/00-index.md`
- `laravel/Modules/Xot/docs/ecc/ptvx-integration.md`
- `AGENTS.md`
- `laravel/Modules/Xot/docs/bmad/stories/ecc-codex-plugin-setup.story.md`

## Esito

Audit acquisito: 34/39, tre controlli failing. Il presente documento traccia il piano e non dichiara completate le remediation. Nessun test applicativo è pertinente alla sola registrazione dell'audit.
