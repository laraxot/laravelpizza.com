---
title: "Contratti del modulo Activity"
type: index
module: Activity
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "activity contracts readme azioni invarianti pest group audit log"
tags: [contracts, actions, interfaces]
---

# Contratti
title: "Contratti del modulo Activity"
type: index
tags: [contracts, actions, interfaces, activity, audit, log-viewer]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Activity

Un contract descrive il comportamento promesso da una Action che accede a file di log, applica permessi o cancella dati di audit.
Standard: `Modules/Xot/docs/contracts/contract-authoring-standard.md`; governance: `Modules/Xot/docs/adr/0012-behavioral-contract-governance.md`.

## Formato

- Frontmatter con `type: contract` e `action: "Modules\\Activity\\Actions\\..."`.
- Sezioni nell'ordine: `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`.
- Invarianti con ID `ACT-<AREA>-INV-<N>`, ciascuno con test Pest `->group('<ID>')`.

## File presenti

- [resolve-log-file-path-action.md](resolve-log-file-path-action.md) (`ACT-LOGPATH-INV-1..4`)
- [authorize-log-access-action.md](authorize-log-access-action.md) (`ACT-LOGAUTH-INV-1..2`)
- [activity-maintenance-action.md](activity-maintenance-action.md) (`ACT-CLEAN-INV-1..2`)
- `template-2.md`: modello per i nuovi contract.

Copertura e backlog: [index-2.md](index-2.md).
Cosa promettono le Action di Activity che scrivono il log delle attività, riscrivono un record dal suo storico, o
aprono file di `storage/logs` scelti dall'utente (sicurezza dei percorsi e degli accessi). Le Action di sola query
(`Actions/Query`) e di parsing dei log non hanno effetti collaterali e restano fuori.

Leggili prima di chiamare, modificare o imitare una di queste Action. Le invarianti con group si verificano con
`cd laravel && vendor/bin/pest Modules/Activity/tests --group=<ID>`; `—` è debito dichiarato.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `ACTIVITY-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`; la riga legacy
`Contratto di comportamento: docs/contracts/<file>.md` può restare.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

title: "Contratti del modulo Activity"
type: index
tags: [contracts, actions, activity, audit, log-viewer]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Activity

Cosa promettono le Action di Activity che scrivono il log delle attività, riscrivono un record dal suo storico, o
aprono file di `storage/logs` scelti dall'utente (sicurezza dei percorsi e degli accessi). Le Action di sola query
(`Actions/Query`) e di parsing dei log non hanno effetti collaterali e restano fuori.

Leggili prima di chiamare, modificare o imitare una di queste Action. Le invarianti con group si verificano con
`cd laravel && vendor/bin/pest Modules/Activity/tests --group=<ID>`; `—` è debito dichiarato.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

## Indice

- [LogActivityAction](log-activity-action.md) — una riga di `activity_log` sulla connessione `activity`; non toglie dati sensibili dalle properties.
- [RestoreActivityAction](restore-activity-action.md) — riporta un record ai valori `old` di un'attività con un solo `update()`.
- [AuthorizeLogAccessAction](authorize-log-access-action.md) — log visibili solo a `super-admin` o a chi ha `log.viewAny`; permesso mancante = negato senza errore.
- [ResolveLogFilePathAction](resolve-log-file-path-action.md) — unico passaggio da input dell'utente a percorso: solo `.log`, dentro `storage/logs`, link simbolici risolti.
- [DownloadLogFileAction](download-log-file-action.md) — download del file intero come `BinaryFileResponse`, passando dal risolutore.
- [LogModelUpdatedAction](log-model-updated-action.md) — log di modifica (e, per la stessa regola, di creazione e cancellazione) senza password, token né segreti 2FA.

## Indici e template

- [index-2.md](index-2.md) — inventario machine-readable del modulo (la sua tabella oggi dichiara «nessun contratto»: vale l'elenco qui sopra).
- [template-2.md](template-2.md) — template minimo `type: contract` con `action: <FQCN>` e le sei sezioni.
