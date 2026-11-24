---
<<<<<<< .merge_file_OXrnIQ
<<<<<<< .merge_file_fMWnY7
title: "SaveAttachmentsAction — contratto"
type: contract
owner: Media
status: accepted
action: "Modules\\Media\\Actions\\SaveAttachmentsAction"
tags: [contract, action, media, allegati]
created: 2026-11-24
updated: 2026-11-24
qmd: "SaveAttachmentsAction salva allegati media library addMedia record update percorso relativo disco"
=======
=======
>>>>>>> .merge_file_QVTMs6
title: "Contratto — SaveAttachmentsAction"
type: contract
action: "Modules\Media\Actions\SaveAttachmentsAction"
tags: [contract, action, media, allegati]
created: 2026-11-24
updated: 2026-11-24
<<<<<<< .merge_file_OXrnIQ
>>>>>>> .merge_file_kP5Jnu
=======
>>>>>>> .merge_file_QVTMs6
---

# SaveAttachmentsAction

<<<<<<< .merge_file_OXrnIQ
<<<<<<< .merge_file_fMWnY7
Importa in media library gli allegati caricati su un disco temporaneo e salva sul record il percorso relativo di ciascun media.
=======
>>>>>>> .merge_file_kP5Jnu
=======
>>>>>>> .merge_file_QVTMs6
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveAttachmentsAction.php`.

## Input

- `$record`: un modello `HasMedia` (deve avere anche `update()`, cioe' essere un Eloquent Model).
- `$attachments`: nomi dei campi allegato (sono anche i nomi delle collezioni media).
- `$data`: dati del form, `campo => percorso` del file gia' caricato su `$disk`.
- `$disk`: disco di origine e di destinazione (default `attachments`).

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| MEDIA-ATTACH-INV-1 | Un campo assente da `$data`, vuoto o il cui file non esiste sul disco e' saltato senza errori. | — |
| MEDIA-ATTACH-INV-2 | Il record si aggiorna una sola volta, alla fine, e solo se almeno un allegato e' stato salvato: valore del campo = percorso del media. | — |
| MEDIA-ATTACH-INV-3 | Il file temporaneo in `storage/framework/cache` viene cancellato anche se l'aggiunta del media fallisce (`finally`). | — |
| MEDIA-ATTACH-INV-4 | Il file di origine su `$disk` non viene cancellato. | — |

## Effetti collaterali

- Copia ogni file in un temporaneo e lo aggiunge alla collezione omonima del record (`addMedia()->toMediaCollection($campo, $disk)`):
  riga in `media` e file sul disco.
- `UPDATE` del record con i percorsi dei media.

## Errori

- `UnexpectedValueException` se il valore di un campo non e' una stringa o il file non si legge come stringa.
- Le eccezioni di Media Library (`addMedia`, collezione) risalgono al chiamante: gli allegati gia' aggiunti restano.

## Non fa

- Non valida mime ne' dimensione (lo fanno il campo Filament e la configurazione di Media).
- Non toglie metadati Exif (vedi `StripImageMetadataAction`).
- Non e' transazionale: niente rollback dei media gia' aggiunti se un allegato successivo fallisce.
<<<<<<< .merge_file_OXrnIQ
<<<<<<< .merge_file_fMWnY7
=======

Debito: `tests/Unit/Actions/SaveAttachmentsActionTest.php` oggi fallisce in 6 casi su 7 (mock di `update()` su
un'interfaccia `HasMedia` che non lo dichiara): nessuna invariante e' coperta finche' il test non usa un modello vero.
>>>>>>> .merge_file_kP5Jnu
=======

Debito: `tests/Unit/Actions/SaveAttachmentsActionTest.php` oggi fallisce in 6 casi su 7 (mock di `update()` su
un'interfaccia `HasMedia` che non lo dichiara): nessuna invariante e' coperta finche' il test non usa un modello vero.
>>>>>>> .merge_file_QVTMs6
