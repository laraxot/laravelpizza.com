---
issues: []
discussions: []
title: "PathGenerator e PathGeneratorContract (interfacce)"
module: "Media"
type: concept
tags: [path, generator, contracts, interface]
created: 2026-07-14
updated: 2026-11-24
qmd: "path generator"
related:
  - "../webm.md"
---

# PathGenerator e PathGeneratorContract

Interfacce in `app/Contracts/PathGenerator.php` e `app/Contracts/PathGeneratorContract.php`: firme identiche, tre metodi
che restituiscono la cartella di un `Modules\Media\Models\Media`. Definiscono il contratto per la generazione dei percorsi
dei file media nel sistema.

| Metodo | Restituisce |
|---|---|
| `getPath(Media $media): string` | cartella del file originale |
| `getPathForConversions(Media $media): string` | cartella delle conversioni |
| `getPathForResponsiveImages(Media $media): string` | cartella delle immagini responsive |

Ogni metodo riceve `$media`, l'istanza del modello Media, e ritorna il percorso come stringa.

Stato verificato (2026-11-24): nessuna classe del repo implementa o usa nessuna delle due interfacce. Il generatore di percorso
effettivo e' quello di Spatie configurato in `config/media-library.php` (`path_generator` =
`Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator`). La versione precedente di questa pagina citava come
implementazione `TemporaryUploadPathGenerator` (con una pagina `support/temporary_upload_path_generator.md`): né la classe né
la pagina esistono nel checkout.

Per chi scrive codice nuovo: implementare l'interfaccia di Spatie; le due interfacce del modulo sono doppioni da eliminare,
non un modello da seguire. Un percorso generato non deve dipendere da input dell'utente (niente path traversal).

## Buone pratiche per chi implementa

- Tipizzazione stretta e PHPDoc su tutti i metodi.
- Percorsi coerenti tra le implementazioni e unici per ogni file generato.
- Validare sempre gli input, evitare path traversal e gestire correttamente i caratteri speciali.

## Manutenzione

- Aggiornare questa pagina quando si modificano i metodi.
- Verificare che ogni implementazione rispetti il contratto.
- Testare la generazione dei percorsi in condizioni diverse.
