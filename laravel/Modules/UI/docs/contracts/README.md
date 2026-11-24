---
<<<<<<< HEAD
<<<<<<< .merge_file_faTeY5
<<<<<<< HEAD
=======
>>>>>>> .merge_file_QpBHCn
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.
=======
title: "Contratti — UI"
type: index
tags: [contracts, actions, interfaces, ui]
created: 2026-11-18
updated: 2026-11-24
<<<<<<< .merge_file_faTeY5
=======
title: "Contratti — UI"
type: index
owner: UI
updated: 2026-11-24
qmd: "UI contract comportamentali assenti blocchi layer condiviso presentazione"
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_QpBHCn
---

# Contratti — UI

<<<<<<< .merge_file_faTeY5
<<<<<<< HEAD
=======
>>>>>>> .merge_file_QpBHCn
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile, nel formato `UI-INV-N` o, per operazione, `UI-<OPERAZIONE>-INV-<N>`; il test Pest
corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`;
contratto, codice e test cambiano nello stesso commit.

Cosa promettono le Action di UI che altri moduli usano o che toccano dati personali: scoperta dei blocchi (usata da
Cms), localizzazione dei dati dei blocchi (delegata a Cms se presente), dati dell'utente autenticato. Le altre Action
di UI sono pure (icone, giorni della settimana) o disattivate (`ApplyCalendarToPanelAction`, no-op con log). Le
interfacce di `app/Contracts` non hanno ancora un documento qui.

**Quando leggerli**: prima di chiamare, modificare o imitare una di queste Action.

Formato (6 sezioni, tabella invarianti con ID e group Pest, `@contract` nel docblock):
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md). Un'invariante con group si
verifica con `vendor/bin/pest Modules/UI/tests --group=<ID>`; `—` è debito dichiarato.
>>>>>>> laraxot/dev

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

<<<<<<< HEAD
Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

=======
Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` può restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.

## Contratti

- [ResolveLocalizedBlockDataAction](resolve-localized-block-data-action.md) — passa i dati del blocco al resolver di Cms se esiste, altrimenti li ritorna invariati.
- [GetAllBlocksAction](get-all-blocks-action.md) — elenca i blocchi del page builder di tutti i moduli installati.
- [GetUserDataAction](get-user-data-action.md) — identità, ruolo, permessi e impostazioni dell'utente autenticato (dati personali).

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; è un elenco precedente a questo README e oggi dichiara «nessun contract», mentre i tre sopra esistono.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
>>>>>>> laraxot/dev
<<<<<<< .merge_file_faTeY5
=======
Un contract descrive una singola operazione che muove denaro, dati personali, permessi o produce effetti irreversibili. Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance: [ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Stato

**Nessun contract formale in UI.** Motivo: il modulo è il layer di presentazione condiviso e le sue 6 Action (`app/Actions/`) leggono o compongono dati di vista (blocchi, icone, mappatura giorni, dati utente per l'interfaccia, calendario del pannello): nessuna scrive dati, cambia permessi o ha effetti irreversibili. Le decisioni di confine (UI non autorizza dati di dominio, blocchi localizzati dal CMS) stanno negli ADR: [adr/INDEX.md](../adr/INDEX.md).

Se in futuro un'Action UI inizierà a scrivere dati o a decidere accessi, va aggiunto un contract nel formato a sei sezioni (`## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`) con frontmatter `type: contract` e `action: "Modules\\UI\\Actions\\..."`, e un ID `UI-<AREA>-INV-<N>` per ogni invariante.

## File presenti

- [INDEX.md](INDEX.md): registro operativo e backlog
- [_template](_template.md): template
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_QpBHCn
