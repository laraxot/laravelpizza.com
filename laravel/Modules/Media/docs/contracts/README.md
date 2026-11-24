---
<<<<<<< .merge_file_ukJYHZ
title: "Contratti del modulo Media"
type: index
tags: [contracts, actions, interfaces, media]
module: Media
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "media contracts readme azioni invarianti pest group upload percorsi"
=======
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
>>>>>>> .merge_file_6UDUmi
---

# Contratti del modulo Media

<<<<<<< .merge_file_ukJYHZ
Cosa promettono le Action di `app/Actions` e le interfacce di `app/Contracts`. Ogni Action ha il suo contratto e porta nel
docblock il marker `@contract docs/contracts/<file>.md`: il controllo e' in
`Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`. Elenco con copertura Pest: [INDEX.md](INDEX.md).

Leggili prima di chiamare o imitare il salvataggio degli allegati, il trattamento delle foto o le diagnostiche AWS/S3:
«Non fa» dice cosa l'Action lascia ad altri (validazione, conversioni, transazioni).

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio.
Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in una promessa.

Ogni invariante ha un ID stabile nel formato `<OPERAZIONE>-INV-<N>` (es. `MEDIA-STRIP-INV-1`, `GET-FILE-INFO-INV-2`); il test
Pest corrispondente usa lo stesso ID come group. Contratto, codice e test cambiano nello stesso commit.
Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance:
[ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Formato di un contratto di Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine (scheletro: [_template.md](_template.md)):
=======
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
>>>>>>> .merge_file_6UDUmi

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

<<<<<<< .merge_file_ukJYHZ
Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`, quello verificato dai test; la
riga legacy `Contratto di comportamento: docs/contracts/<file>.md` puo' restare. Chi cambia il comportamento aggiorna il
contratto nello stesso commit.

Lanciare le invarianti coperte: `vendor/bin/pest Modules/Media/tests --group=<ID>` (oggi hanno un group solo gli ID
`MEDIA-STRIP-INV-1`..`5`).

## Contratti principali

- [StripImageMetadataAction](strip-image-metadata-action.md) — riscrive JPEG/PNG senza metadati, aggiorna `size`; 5 invarianti coperte.
- [SaveAttachmentsAction](save-attachments-action.md) — copia gli allegati del form nelle collezioni del record e ne salva i percorsi.
- [GenerateTemporaryUploadPathAction](generate-temporary-upload-path-action.md) — percorso `tmp/` di un upload temporaneo.
=======
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
>>>>>>> .merge_file_6UDUmi

## Interfacce

- [PathGenerator e PathGeneratorContract](path-generator.md) — due interfacce identiche in `app/Contracts`, oggi non usate.
<<<<<<< .merge_file_ukJYHZ

## Indice e template

- [INDEX](INDEX.md) — tabella operativa contratto, classe, invarianti e copertura Pest, per tutte le Action.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======

## Indice e template

- [INDEX](INDEX.md) — tabella operativa operazione, contratto, classe, invarianti; è un elenco precedente a questo README e descrive solo `path-generator.md`.
- [Template di contratto](_template.md) — scheletro con le sei sezioni e la tabella degli invarianti, da copiare per una nuova Action.
>>>>>>> laraxot/dev
>>>>>>> .merge_file_6UDUmi
