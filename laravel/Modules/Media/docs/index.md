# Media Module Documentation

**Last Update**: Feb 2026
**Status**: Active Development

## Quick Start

- [README.md](./README.md) - Panoramica modulo

## Core Features

- **Multi-format Files**: Immagini, video, documenti, audio
- **Upload**: Drag-and-drop, multi-upload
- **Media Library**: Gestione file (spatie/laravel-medialibrary)
- **Image Processing**: Ottimizzazione immagini (intervention/image)
- **Video Conversion**: Conversione video (FFmpeg)
- **CDN Integration**: Integrazione CDN

## Standards

Vedi anche: [.agents/docs/critical-rules.md](../../../.agents/docs/critical-rules.md)

## Collegamenti Correlati
- [Documentazione Generale <nome progetto>](../../../../../docs/readme.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)
- [Standard di Documentazione](../../../../../docs/documentation_standards.md)
- [Modulo Xot](../../xot/docs/readme.md)
- [Modulo Lang](../../lang/docs/readme.md)
- [Modulo UI](../../ui/docs/readme.md)

## Categorie Principali

### Architettura e Struttura
- [README](./readme.md) - Panoramica generale del modulo
- [Architettura](./architecture/readme.md) - Architettura generale del modulo
- [Struttura](./structure.md) - Struttura delle directory e dei componenti
- [Modelli](./data-models.md) - Documentazione dei modelli Eloquent
- [Eventi](./events.md) - Eventi e listeners

### Gestione Media
- [Funzionalità Core](./core-functionality.md) - Funzionalità principali del modulo
- [Upload File](./file-upload.md) - Sistema di upload file
- [Ottimizzazione](./optimization.md) - Tecniche di ottimizzazione media
- [Conversione Video](./video-conversion.md) - Sistema di conversione video
- [Streaming Video](./video-streaming.md) - Funzionalità di streaming
- [Gestione Sottotitoli](./subtitle-management.md) - Elaborazione sottotitoli

### Filament UI
- [Risorse Filament](./filament-resources.md) - Componenti Filament Resources
- [Pagine Filament](./filament-pages.md) - Componenti Filament Pages
- [Azioni Filament](./filament-actions.md) - Azioni personalizzate
- [Convenzioni Filament](./filament_extension_pattern.md) - Pattern di estensione per Filament

### API e Integrazione
- [API RESTful](./api.md) - API per la gestione media
- [Integrazione CDN](./cdn-integration.md) - Integrazione con Content Delivery Network
- [Servizi Esterni](./external-services.md) - Integrazione con servizi esterni

### Configurazione
- [Struttura Config](./config_structure.md) - Struttura dei file di configurazione
- [Configurazione Upload](./upload-config.md) - Configurazione sistema upload
- [Principi di Configurazione](./configurations_usage_principles.md) - Principi per l'utilizzo delle configurazioni

### Pattern e Architettura
- [Pattern Factory](./factory_pattern_analysis.md) - Analisi del pattern Factory
- [Risoluzione Dinamica delle Classi](./dynamic_class_resolution.md) - Pattern di risoluzione dinamica delle classi
- [Queueable Actions](./queueable-action.md) - Utilizzo di Spatie Queueable Actions

### Standard e Traduzioni
- [Convenzioni di Naming](./naming_conventions.md) - Standard per i nomi di file e classi
- [Traduzioni](./translations.md) - Sistema di traduzioni
- [Standard Traduzioni](./translation_standards.md) - Standard per le chiavi di traduzione

### Testing e Qualità
- [PHPStan Level 10](./phpstan_level10_fixes.md) - Correzioni per PHPStan Level 10
- [Testing](./testing.md) - Strategie e approcci per il testing

## Linee Guida per l'Implementazione

### 1. Struttura del Modulo
Il modulo Media segue una struttura standard con directory per modelli, servizi, provider e componenti Filament per garantire chiarezza e manutenibilità.

### 2. Tipi di Media Supportati
Supporta diversi tipi di media con gestione specifica per ogni formato:
```php
// Esempio Configurazione Media
return [
    'image' => [
        'allowed_formats' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'max_size' => 10240, // KB
        'optimize' => true,
    ],
    'video' => [
        'allowed_formats' => ['mp4', 'avi', 'mov', 'wmv'],
        'max_size' => 102400, // KB
        'convert_to' => 'mp4',
    ],
];
```

### 3. Servizi Disponibili
- **SubtitleService**: Gestione e elaborazione sottotitoli
- **VideoStream**: Streaming video ottimizzato
- **MediaService**: Servizio principale per la gestione media

### 4. Gestione Errori
Implementare una gestione robusta degli errori per gestire i fallimenti nell'upload o elaborazione dei media.

## Problemi Comuni e Soluzioni
- **Errori di Upload**: Assicurarsi della corretta configurazione dei limiti di dimensione file
- **Errori di Conversione**: Verificare la configurazione dei servizi di conversione video
- **Problemi di Ottimizzazione**: Controllare le impostazioni di ottimizzazione per ogni tipo di media
- **Colli di Bottiglia Performance**: Utilizzare il queueing per operazioni pesanti come conversione video

## Documentazione e Aggiornamenti
- Documentare qualsiasi implementazione personalizzata o nuovi tipi di media nella cartella di documentazione pertinente
- Aggiornare questo indice se vengono introdotte nuove funzionalità o modifiche significative al modulo Media

## Sottocartelle

### Actions
- [Index](./actions/index.md) - Indice della documentazione sulle azioni

### Architettura
- [Index](./architecture/index.md) - Indice della documentazione sull'architettura

### Conversions
- [Index](./conversions/index.md) - Indice della documentazione sulle conversioni

### Filament
- [Index](./filament/index.md) - Indice della documentazione sui componenti Filament

### Performance
- [Index](./performance/index.md) - Indice della documentazione sulle ottimizzazioni

### PHPStan
- [Index](./phpstan/index.md) - Indice della documentazione PHPStan

### Support
- [Index](./support/index.md) - Indice della documentazione sui componenti di supporto

## Collegamenti alla Documentazione Correlata
- [Panoramica Architettura](./architecture.md)
- [Funzionalità Core](./core-functionality.md)
- [Gestione File](./file-management.md)
- [Ottimizzazione](./optimization-analysis.md)
- [Troubleshooting](./troubleshooting.md)

## Note sulla Manutenzione
Questa documentazione viene aggiornata regolarmente. Prima di apportare modifiche al codice, consultare la documentazione pertinente e aggiornare i documenti correlati.

## Risoluzione Conflitti e Standard
- **Gennaio 2025**: Risoluzione sistematica di tutti i conflitti Git nei file di documentazione
- Il file `lang/it/media_theme.php` è stato risolto manualmente mantenendo PSR-12, strict_types, array short syntax e solo chiavi effettive, come richiesto dagli standard PHPStan livello 10
- **Filosofia di risoluzione**: Approccio olistico con analisi manuale approfondita, mantenimento integrità architetturale, documentazione bidirezionale aggiornata
- Vedi anche: [../../../../../docs/README.md](../../../../../docs/readme.md)
- Per dettagli sulle scelte architetturali e funzionali, consultare la doc globale e la sezione "Standard e Traduzioni".

