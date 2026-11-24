---
issues: []
discussions: []
<<<<<<< HEAD
title: "PathGenerator Interface"
module: "Media"
type: concept
tags: [path, generator]
created: 2026-07-14
updated: 2026-07-14
qmd: "path generator"
related:
  - "./webm.md"
---
# PathGenerator Interface

## Descrizione
Questa interfaccia definisce il contratto per la generazione dei percorsi dei file media nel sistema, seguendo le best practices di Laraxot.

## Metodi Richiesti

### getPath(Media $media): string
- Genera il percorso per il file originale
- Parametri:
  - `$media`: L'istanza del modello Media
- Ritorna: Il percorso come stringa

### getPathForConversions(Media $media): string
- Genera il percorso per le conversioni del file
- Parametri:
  - `$media`: L'istanza del modello Media
- Ritorna: Il percorso come stringa

### getPathForResponsiveImages(Media $media): string
- Genera il percorso per le immagini responsive
- Parametri:
  - `$media`: L'istanza del modello Media
- Ritorna: Il percorso come stringa

## Implementazioni
- [TemporaryUploadPathGenerator](../support/temporary_upload_path_generator.md)

## Best Practices
- Utilizzare tipizzazione stretta
- Documentare tutti i metodi con PHPDoc
- Mantenere i percorsi coerenti tra le implementazioni
- Garantire l'unicità dei percorsi generati

## Note di Sicurezza
- Validare sempre gli input
- Evitare path traversal
- Gestire correttamente i caratteri speciali

## Collegamenti
- [Documentazione Media Module](../module_media.md)
- [Gestione File](../file_management.md)

## Note di Manutenzione
- Aggiornare la documentazione quando si modificano i metodi
- Verificare che tutte le implementazioni rispettino il contratto
- Testare la generazione dei percorsi in diverse condizioni
=======
title: "PathGenerator e PathGeneratorContract (interfacce)"
module: "Media"
type: concept
tags: [path, generator, contracts, interface]
created: 2026-07-14
updated: 2026-11-24
qmd: "path generator"
---

# PathGenerator e PathGeneratorContract

Interfacce in `app/Contracts/PathGenerator.php` e `app/Contracts/PathGeneratorContract.php`: firme identiche, tre metodi
che restituiscono la cartella di un `Modules\Media\Models\Media`.

| Metodo | Restituisce |
|---|---|
| `getPath(Media $media): string` | cartella del file originale |
| `getPathForConversions(Media $media): string` | cartella delle conversioni |
| `getPathForResponsiveImages(Media $media): string` | cartella delle immagini responsive |

Stato verificato (2026-11-24): nessuna classe del repo implementa o usa nessuna delle due interfacce. Il generatore di percorso
effettivo e' quello di Spatie configurato in `config/media-library.php` (`path_generator` =
`Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator`).

Per chi scrive codice nuovo: implementare l'interfaccia di Spatie; le due interfacce del modulo sono doppioni da eliminare,
non un modello da seguire. Un percorso generato non deve dipendere da input dell'utente (niente path traversal).
>>>>>>> laraxot/dev
