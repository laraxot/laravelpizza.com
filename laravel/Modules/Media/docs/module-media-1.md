# Modulo Media

> **Collegamento globale:** Per le strategie generali e le best practices sulla risoluzione dei conflitti git, vedi [docs/git_conflict_resolution.md](../../../../docs/git_conflict_resolution.md).

## Informazioni Generali
- **Nome**: `laraxot/module_media_fila3`
- **Descrizione**: Modulo dedicato alla gestione di immagini e video
- **Namespace**: `Modules\Media`
- **Repository**: https://github.com/laraxot/module_media_fila3.git

## Service Providers
1. `Modules\Media\Providers\MediaServiceProvider`
2. `Modules\Media\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi media
```

## Aggiornamenti Recenti

### Risoluzione Conflitti Git

Sono stati risolti importanti conflitti di merge in diversi file critici del modulo:

- **app/Actions/Image/Merge.php**: Risolti conflitti nelle importazioni e nella struttura del codice per la fusione di immagini
- **app/Actions/Video/ConvertVideoAction.php**: Risolti conflitti di formattazione e corretto l'utilizzo del metodo Storage::disk()->path()
- **app/Services/SubtitleService.php**: Risolti conflitti nel metodo `upateModel()`
- **app/View/Components/_components.json**: Mantenuta versione con componente `video-player`
- **app/Http/Livewire/_components.json**: Scelta formattazione più leggibile e strutturata
- **app/Console/Commands/_components.json**: Uniformata formattazione con gli altri file di componenti

La risoluzione ha puntato a mantenere la coerenza del codice, evitando duplicazioni e garantendo il corretto funzionamento delle funzionalità di gestione media e del sistema di registrazione componenti.

Per maggiori dettagli, consultare la [documentazione locale sulla risoluzione dei conflitti](./conflitti_merge_risolti.md) e la [documentazione globale](../../../../docs/git_conflict_resolution.md).

## Dipendenze
### Pacchetti Required
- PHP ^8.2
- `pbmedia/laravel-ffmpeg`: ^8.5
- `intervention/image`: *

### Moduli Required
- User
- Tenant
- UI
- Xot

## Database
### Factories
Namespace: `Modules\Media\Database\Factories`

### Seeders
Namespace: `Modules\Media\Database\Seeders`

### Tests
Namespace: `Modules\Media\Tests`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Gestione immagini
  - Upload
  - Ridimensionamento
  - Ottimizzazione
  - Watermark
- Gestione video
  - Conversione formati
  - Streaming
  - Thumbnails
- Integrazione con Filament
- Sistema di cache media

## Configurazione
### FFmpeg
- Richiede FFmpeg installato nel sistema
- Configurazione in `config/media.php`

### Intervention Image
- Configurazione driver (GD o Imagick)
- Ottimizzazione cache

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Ottimizzare le risorse media
7. Implementare gestione cache

## Troubleshooting
### Problemi Comuni
1. **Errori FFmpeg**
   - Verificare installazione FFmpeg
   - Controllare permessi di esecuzione
   - Verificare supporto codec

2. **Problemi di Upload**
   - Controllare limiti PHP (upload_max_filesize, post_max_size)
   - Verificare permessi directory
   - Controllare configurazione storage

3. **Errori di Processamento**
   - Verificare memoria disponibile
   - Controllare log di sistema
   - Verificare supporto GD/Imagick

## Changelog
Le modifiche vengono tracciate nel repository GitHub.

---

> **Collegamento globale:** Questa documentazione locale dettaglia i casi concreti e le decisioni architetturali adottate nel modulo Media. Per le strategie generali e le best practices, consulta sempre anche la documentazione globale in [docs/git_conflict_resolution.md](../../../../docs/git_conflict_resolution.md).
