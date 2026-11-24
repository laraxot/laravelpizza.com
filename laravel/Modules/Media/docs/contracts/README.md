---
<<<<<<< HEAD
<<<<<<< HEAD
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
title: "Contratti — Media"
type: index
tags: [contracts, actions, interfaces, media]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Media

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile, nel formato `MEDIA-INV-N` o, per operazione, `MEDIA-<OPERAZIONE>-INV-<N>`; il test Pest
corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`;
contratto, codice e test cambiano nello stesso commit.

Cosa promettono le Action di Media che riscrivono file o salvano allegati, e le interfacce di `app/Contracts`. Le Action
`Diagnostic/*` (prove di connessione AWS) e i resolver di percorso non hanno contratto.

Leggili prima di chiamare o imitare il salvataggio degli allegati o il trattamento delle foto: «Non fa» dice cosa
l'Action lascia ad altri (validazione, conversioni, transazioni).

Formato (6 sezioni, invarianti con ID e group Pest): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
Lanciare le invarianti coperte: `vendor/bin/pest Modules/Media/tests --group=<ID>`.
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
title: "Contratti — Media"
type: index
tags: [contracts, actions, media]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Media

Cosa promettono le Action di Media che riscrivono file o salvano allegati, e le interfacce di `app/Contracts`. Le Action
`Diagnostic/*` (prove di connessione AWS) e i resolver di percorso non hanno contratto.

Leggili prima di chiamare o imitare il salvataggio degli allegati o il trattamento delle foto: «Non fa» dice cosa
l'Action lascia ad altri (validazione, conversioni, transazioni).

Formato (6 sezioni, invarianti con ID e group Pest): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
Lanciare le invarianti coperte: `vendor/bin/pest Modules/Media/tests --group=<ID>`.
=======
Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` può restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.
>>>>>>> laraxot/dev

## Contratti delle Action

- [StripImageMetadataAction](strip-image-metadata-action.md) — riscrive JPEG/PNG senza metadati, aggiorna `size`; 5 invarianti coperte.
- [SaveAttachmentsAction](save-attachments-action.md) — copia gli allegati del form nelle collezioni del record e ne salva i percorsi.

## Interfacce

- [PathGenerator e PathGeneratorContract](path-generator.md) — due interfacce identiche in `app/Contracts`, oggi non usate.
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; è un elenco precedente a questo README e descrive solo `path-generator.md`.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
>>>>>>> laraxot/dev
