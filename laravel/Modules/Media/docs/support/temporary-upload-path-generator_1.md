# TemporaryUploadPathGenerator

## Descrizione
Questa classe gestisce la generazione dei percorsi per i file temporanei caricati nel sistema media, seguendo le best practices di Laraxot.

## Funzionalità
- Generazione percorsi per file originali
- Generazione percorsi per conversioni
- Generazione percorsi per immagini responsive
- Generazione percorsi base univoci

## Struttura
- Namespace: `Modules\Media\Support`
- Dipendenze:
  - `Modules\Media\Models\Media`
  - `Webmozart\Assert\Assert`

## Metodi Principali
1. `getPath(Media $media): string`
   - Genera il percorso per il file originale
   - Utilizza MD5 per garantire unicità

2. `getPathForConversions(Media $media): string`
   - Genera il percorso per le conversioni
   - Utilizza MD5 per garantire unicità

3. `getPathForResponsiveImages(Media $media): string`
   - Genera il percorso per le immagini responsive
   - Utilizza MD5 per garantire unicità

4. `getBasePath(Media $media): string`
   - Metodo protetto per generare il percorso base
   - Utilizza UUID e ID per garantire unicità

## Best Practices
- Utilizzo di tipizzazione stretta
- Validazione degli input con Assert
- Generazione di percorsi univoci e sicuri
- Documentazione PHPDoc completa

## Note di Sicurezza
- I percorsi generati sono univoci per ogni media
- Utilizzo di hash MD5 per prevenire collisioni
- Validazione degli input per prevenire injection

## Collegamenti
- [Documentazione Media Module](../module_media.md)
- [Gestione File Temporanei](../file_management.md)

## Note di Manutenzione
- Mantenere la documentazione PHPDoc aggiornata
- Verificare la compatibilità con le nuove versioni di Laravel
- Testare la generazione di percorsi univoci 