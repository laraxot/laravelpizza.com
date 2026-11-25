---
title: "Contratti — UI"
type: index
owner: UI
updated: 2026-11-24
qmd: "UI contract comportamentali assenti blocchi layer condiviso presentazione"
---

# Contratti — UI

Un contract descrive una singola operazione che muove denaro, dati personali, permessi o produce effetti irreversibili. Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance: [ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Stato

**Nessun contract formale in UI.** Motivo: il modulo è il layer di presentazione condiviso e le sue 6 Action (`app/Actions/`) leggono o compongono dati di vista (blocchi, icone, mappatura giorni, dati utente per l'interfaccia, calendario del pannello): nessuna scrive dati, cambia permessi o ha effetti irreversibili. Le decisioni di confine (UI non autorizza dati di dominio, blocchi localizzati dal CMS) stanno negli ADR: [adr/INDEX.md](../adr/index.md).

Se in futuro un'Action UI inizierà a scrivere dati o a decidere accessi, va aggiunto un contract nel formato a sei sezioni (`## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`) con frontmatter `type: contract` e `action: "Modules\\UI\\Actions\\..."`, e un ID `UI-<AREA>-INV-<N>` per ogni invariante.

## File presenti

- [index.md](index.md): registro operativo e backlog
- [_template](template.md): template
