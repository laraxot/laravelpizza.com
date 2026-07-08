# Modulo Media

## Informazioni Generali
- **Nome**: `laraxot/module_media_fila5`
- **Descrizione**: Modulo dedicato alla gestione di immagini e video
- **Namespace**: `Modules\Media`
- **Repository**: https://github.com/laraxot/module_media_fila5.git

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