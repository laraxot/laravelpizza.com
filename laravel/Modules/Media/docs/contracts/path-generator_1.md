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