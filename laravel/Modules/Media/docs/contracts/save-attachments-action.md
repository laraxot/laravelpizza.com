---
<<<<<<< HEAD
title: "Contratto — SaveAttachmentsAction"
type: contract
action: "Modules\Media\Actions\SaveAttachmentsAction"
tags: [contract, action, media, allegati]
created: 2026-11-24
updated: 2026-11-24
=======
title: "SaveAttachmentsAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\SaveAttachmentsAction"
qmd: "SaveAttachmentsAction salva allegati media library addMedia record update percorso relativo disco"
>>>>>>> laraxot/dev
---

# SaveAttachmentsAction

<<<<<<< HEAD
Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveAttachmentsAction.php`.

## Input

- `$record`: un modello `HasMedia` (deve avere anche `update()`, cioe' essere un Eloquent Model).
- `$attachments`: nomi dei campi allegato (sono anche i nomi delle collezioni media).
- `$data`: dati del form, `campo => percorso` del file gia' caricato su `$disk`.
- `$disk`: disco di origine e di destinazione (default `attachments`).
=======
Importa in media library gli allegati caricati su un disco temporaneo e salva sul record il percorso relativo di ciascun media. Codice: `app/Actions/SaveAttachmentsAction.php:26-70`.

## Input

- `HasMedia $record`: il modello destinatario.
- `array<int, string> $attachments`: nomi dei campi allegato.
- `array<string, mixed> $data`: dati del form; il valore di ogni allegato è un percorso sul disco.
- `string $disk = 'attachments'`: disco sorgente e destinazione.
>>>>>>> laraxot/dev

## Output

- `void`.

## Invarianti

<<<<<<< HEAD
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

Debito: `tests/Unit/Actions/SaveAttachmentsActionTest.php` oggi fallisce in 6 casi su 7 (mock di `update()` su
un'interfaccia `HasMedia` che non lo dichiara): nessuna invariante e' coperta finche' il test non usa un modello vero.
=======
- **SAVE-ATTACHMENTS-INV-1** — Un allegato assente da `$data`, con percorso vuoto o inesistente sul disco viene saltato.
  Test: nessuno esplicito per il salto; `tests/Unit/Actions/SaveAttachmentsActionTest.php:51` copre solo la lista vuota.
- **SAVE-ATTACHMENTS-INV-2** — Il record è aggiornato con i percorsi dei media solo se almeno un allegato è stato importato.
  Test: nessuno esplicito.
- **SAVE-ATTACHMENTS-INV-3** — Il file temporaneo in `storage/framework/cache` è rimosso sempre (blocco `finally`).
  Test: nessuno.

## Effetti collaterali

- Per ogni allegato: scrittura di un file temporaneo, `addMedia()` con `toMediaCollection()` (righe media e file nel disco), cancellazione del temporaneo.
- Poi un `update()` del record con i percorsi.
- Nessuna transazione: un errore a metà lascia i media già importati.

## Errori

- `UnexpectedValueException` se il valore dell'allegato non è stringa o se il contenuto non è leggibile come stringa.
- Altre eccezioni di Media Library si propagano.

## Non fa

- Non cancella il file sorgente sul disco temporaneo dopo l'import.
- Non gestisce transazioni né rollback.
>>>>>>> laraxot/dev
