---
title: "Compatibilità plugin Graphify con OpenCode"
type: story
module: Xot
status: in-progress
created: 2026-11-05
updated: 2026-11-05
tags: [opencode, graphify, quality-gates, plugin]
qmd: "OpenCode plugin Graphify compatibilità API default setup modello autenticazione"
related:
  - ../../../../../../docs/stories/quality-gates-opencode-repair.story.md
  - ./ptvx-code-review.story.md
---

# Compatibilità plugin Graphify con OpenCode

## Obiettivo

Correggere il plugin Graphify locale che impediva l'attivazione dei plugin OpenCode,
poi eseguire OpenCode sul working tree corrente e risolvere i finding confermati.

## Criteri di accettazione

- [x] Il plugin esporta il contratto v2 atteso da OpenCode (`default`, `id`, `setup`).
- [x] Il plugin conserva il promemoria Graphify nelle istruzioni agent quando il grafo esiste.
- [ ] Eseguire una revisione completa del working tree con OpenCode e risolvere tutti i finding confermati.
- [ ] Aggiornare `docs/sprint-status.yaml` e indicizzare il risultato.

## Evidenze

- Il plugin precedente esportava solo `GraphifyPlugin` con eventi del vecchio
  contratto Kilo. OpenCode lo rifiutava: `Plugin must export a default definition
  with an id and an effect or setup function`.
- `node --check .opencode/plugins/graphify.js`: exit 0 dopo la modifica.
- OpenCode nativo: `/home/zorin/.opencode/bin/opencode` (il wrapper
  `/home/zorin/.local/bin/opencode` è bloccato perché manca il postinstall npm).
- `/home/zorin/.opencode/bin/opencode debug agents`: exit 0 dopo il fix, elenco
  agenti restituito. Conferma che il loader e i plugin si attivano senza invocare
  un modello.
- La CLI ha superato il precedente errore di attivazione plugin, ma la revisione
  non è partita: il modello predefinito risponde `This model is not available in
  your country`; il modello OmniRoute configurato risponde `authentication
  expired`.
- Il watcher OpenCode segnala inoltre che `.opencode` è un symlink e non riesce ad
  aggiungere un watch diretto. La configurazione continua a essere letta e i plugin
  vengono caricati; verificare separatamente se il warning richiede una modifica.
- `docs/sprint-status.yaml` è sotto lock attivo `claude-docs-refactor` (acquisito
  alle 08:54), quindi il relativo stato non è stato modificato.

## Stato

Il finding del contratto plugin è corretto. La revisione richiesta resta aperta
finché OpenCode non dispone di un modello raggiungibile e autenticato; non sono
state fatte modifiche ai finding PHP senza una revisione eseguibile.
