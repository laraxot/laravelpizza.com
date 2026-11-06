---
title: "index"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-23
qmd: "index"
issues: []
discussions: []
status: draft
---

# Media Module Documentation

> Nota 2026-10-14: bridge di discovery legacy. L'ingresso verificato sul codice e' [README.md](./README.md); l'indice operativo canonico era `00-INDEX.md`, rimosso il 2026-10-22 (commit e2282c1b). Questo file e' una concatenazione di due indici storici: le voci indicate come "non presente" puntavano a file che non esistono nella cartella (misurato il 2026-10-14, ricontrollato il 2026-10-23) e sono state lasciate come testo, senza inventare bersagli. Funzionalita' citate ma non presenti nel codice: watermark automatico, CDN generico (esiste solo CloudFront), `MediaService`.

**Last Update**: Feb 2026
**Status**: Active Development

## Principi Chiave
1. **Modularità**: Il modulo Media è progettato per essere riutilizzabile in diversi progetti, mantenendo funzionalità generiche
2. **Estensibilità**: Consente personalizzazione e aggiunta di nuovi tipi di media senza alterare il codice principale
3. **Affidabilità**: Garantisce la gestione sicura e efficiente dei file multimediali attraverso gestione robusta degli errori e logging

- [README.md](./README.md) - Panoramica modulo

## Core Features

- **Multi-format Files**: Immagini, video, documenti, audio
- **Upload**: Drag-and-drop, multi-upload
- **Media Library**: Gestione file (spatie/laravel-medialibrary)
- **Image Processing**: Ottimizzazione immagini (intervention/image)
- **Video Conversion**: Conversione video (FFmpeg)
- **CDN Integration**: Integrazione CDN

## Standards

Vedi anche: [bashscripts/ai/.agents/docs/critical-rules.md](../../../../bashscripts/ai/.agents/docs/critical-rules.md)

## Collegamenti Correlati
- [Documentazione Generale del progetto](../../../../docs/README.md)
- Collegamenti Documentazione (`docs/collegamenti-documentazione.md` non presente)
- [Standard di Documentazione](../../../../docs/ai-agents/documentation-standards.md)
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Lang](../../Lang/docs/README.md)
- [Modulo UI](../../UI/docs/README.md)

## Categorie Principali

### Architettura e Struttura
- [README](./README.md) - Panoramica generale del modulo
- Architettura (`architecture/readme.md` non presente) - Architettura generale del modulo
- [Struttura](./structure.md) - Struttura delle directory e dei componenti
- [Modelli](./data-models.md) - Documentazione dei modelli Eloquent
- Eventi (`events.md` non presente) - Eventi e listeners

### Gestione Media
- [Funzionalità Core](./core-functionality.md) - Funzionalità principali del modulo
- Upload File (`file-upload.md` non presente) - Sistema di upload file
- Ottimizzazione (`optimization.md` non presente) - Tecniche di ottimizzazione media
- Conversione Video (`video-conversion.md` non presente) - Sistema di conversione video
- Streaming Video (`video-streaming.md` non presente) - Funzionalità di streaming
- Gestione Sottotitoli (`subtitle-management.md` non presente) - Elaborazione sottotitoli

### Filament UI
- Risorse Filament (`filament-resources.md` non presente) - Componenti Filament Resources
- Pagine Filament (`filament-pages.md` non presente) - Componenti Filament Pages
- Azioni Filament (`filament-actions.md` non presente) - Azioni personalizzate
- Convenzioni Filament (`filament_extension_pattern.md` non presente) - Pattern di estensione per Filament

### API e Integrazione
- API RESTful (`api.md` non presente) - API per la gestione media
- Integrazione CDN (`cdn-integration.md` non presente) - Integrazione con Content Delivery Network
- Servizi Esterni (`external-services.md` non presente) - Integrazione con servizi esterni

### Configurazione
- Struttura Config (`config_structure.md` non presente) - Struttura dei file di configurazione
- Configurazione Upload (`upload-config.md` non presente) - Configurazione sistema upload
- Principi di Configurazione (`configurations_usage_principles.md` non presente) - Principi per l'utilizzo delle configurazioni

### Pattern e Architettura
- Pattern Factory (`factory_pattern_analysis.md` non presente) - Analisi del pattern Factory
- Risoluzione Dinamica delle Classi (`dynamic_class_resolution.md` non presente) - Pattern di risoluzione dinamica delle classi
- Queueable Actions (`queueable-action.md` non presente) - Utilizzo di Spatie Queueable Actions

### Standard e Traduzioni
- Convenzioni di Naming (`naming_conventions.md` non presente) - Standard per i nomi di file e classi
- [Traduzioni](./translations.md) - Sistema di traduzioni
- Standard Traduzioni (`translation_standards.md` non presente) - Standard per le chiavi di traduzione

### Testing e Qualità
- [PHPStan Level 10](./phpstan-level10-fixes.md) - Correzioni per PHPStan Level 10
- [Testing](./testing.md) - Strategie e approcci per il testing

## Linee Guida per l'Implementazione

### 1. Struttura del Modulo
Il modulo Media segue una struttura standard con directory per modelli, servizi, provider e componenti Filament per garantire chiarezza e manutenibilità.

### 2. Tipi di Media Supportati
Supporta diversi tipi di media con gestione specifica per ogni formato:
```php
// Esempio storico, NON corrisponde a config/config.php (chiavi reali: name, description, icon, navigation, routes, providers)
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
- Non esiste `app/Services` (rimosso, story 2026-10-08). Al posto di `SubtitleService` e `VideoStream` ci sono le Action `Actions/Subtitle/*` e `Actions/Stream/StreamVideoAction`; `MediaService` non e' mai stato trovato nel codice (verificato 2026-10-14).

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
- Index (`actions/index.md` non presente) - Indice della documentazione sulle azioni

### Architettura
- Index (`architecture/index.md` non presente) - Indice della documentazione sull'architettura

### Conversions
- Index (`conversions/index.md` non presente) - Indice della documentazione sulle conversioni

### Filament
- Index (`filament/index.md` non presente) - Indice della documentazione sui componenti Filament

### Performance
- Index (`performance/index.md` non presente) - Indice della documentazione sulle ottimizzazioni

### PHPStan
- Index (`phpstan/index.md` non presente) - Indice della documentazione PHPStan

### Support
- Index (`support/index.md` non presente) - Indice della documentazione sui componenti di supporto

## Collegamenti alla Documentazione Correlata
- [Panoramica Architettura](./ARCHITECTURE.md)
- [Funzionalità Core](./core-functionality.md)
- [Gestione File](./file-management.md)
- [Ottimizzazione](./optimization-analysis.md)
- [Troubleshooting](./troubleshooting.md)

## Note sulla Manutenzione
Questa documentazione viene aggiornata regolarmente. Prima di apportare modifiche al codice, consultare la documentazione pertinente e aggiornare i documenti correlati.

## Risoluzione Conflitti e Standard
- **Gennaio 2025**: Risoluzione sistematica di tutti i conflitti Git nei file di documentazione
- Il file `lang/it/media_theme.php` (oggi assente da `lang/it`, verificato 2026-10-14) è stato risolto manualmente mantenendo PSR-12, strict_types, array short syntax e solo chiavi effettive, come richiesto dagli standard PHPStan livello 10
- **Filosofia di risoluzione**: Approccio olistico con analisi manuale approfondita, mantenimento integrità architetturale, documentazione bidirezionale aggiornata
- Vedi anche: [../../../../../docs/README.md](../../../../docs/README.md)
- Per dettagli sulle scelte architetturali e funzionali, consultare la doc globale e la sezione "Standard e Traduzioni".

# Indice della Documentazione - Modulo Media

## Panoramica
Questo documento serve come indice centrale per il modulo Media, fornendo una guida per la gestione dei contenuti multimediali all'interno di un'applicazione Laravel. Il modulo Media gestisce vari tipi di file multimediali come immagini, video, documenti e audio in modo modulare e riutilizzabile.

## Principi Chiave
1. **Modularità**: Il modulo Media è progettato per essere riutilizzabile in diversi progetti, mantenendo funzionalità generiche
2. **Estensibilità**: Consente personalizzazione e aggiunta di nuovi tipi di media senza alterare il codice principale
3. **Affidabilità**: Garantisce la gestione sicura e efficiente dei file multimediali attraverso gestione robusta degli errori e logging

## Funzionalità Principali
- **Gestione File Multi-formato**: Supporto per immagini, video, documenti e audio
- **Upload Avanzato**: Funzionalità di drag-and-drop e upload multiplo
- **Ottimizzazione Media**: Compressione e ottimizzazione automatica dei file
- **Conversione Video**: Sistema di conversione video con supporto per diversi formati
- **Streaming Video**: Funzionalità di streaming video ottimizzata
- **Gestione Sottotitoli**: Supporto per sottotitoli e loro elaborazione
- **Integrazione CDN**: Supporto per Content Delivery Network
- **Watermark Automatico**: non presente nel codice (verificato 2026-10-14)

## Collegamenti Correlati
- [Documentazione Generale del progetto](../../../../docs/README.md)
- Collegamenti Documentazione (`docs/collegamenti-documentazione.md` non presente)
- [Standard di Documentazione](../../../../docs/ai-agents/documentation-standards.md)
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Lang](../../Lang/docs/README.md)
- [Modulo UI](../../UI/docs/README.md)

## Categorie Principali

### Architettura e Struttura
- [README](README.md) - Panoramica generale del modulo
- Architettura (`architecture/readme.md` non presente) - Architettura generale del modulo
- [Struttura](./structure.md) - Struttura delle directory e dei componenti
- [Modelli](./data-models.md) - Documentazione dei modelli Eloquent
- Eventi (`events.md` non presente) - Eventi e listeners

### Gestione Media
- [Funzionalità Core](./core-functionality.md) - Funzionalità principali del modulo
- Upload File (`file-upload.md` non presente) - Sistema di upload file
- Ottimizzazione (`optimization.md` non presente) - Tecniche di ottimizzazione media
- Conversione Video (`video-conversion.md` non presente) - Sistema di conversione video
- Streaming Video (`video-streaming.md` non presente) - Funzionalità di streaming
- Gestione Sottotitoli (`subtitle-management.md` non presente) - Elaborazione sottotitoli

### Filament UI
- Risorse Filament (`filament-resources.md` non presente) - Componenti Filament Resources
- Pagine Filament (`filament-pages.md` non presente) - Componenti Filament Pages
- Azioni Filament (`filament-actions.md` non presente) - Azioni personalizzate
- Convenzioni Filament (`filament_extension_pattern.md` non presente) - Pattern di estensione per Filament

### API e Integrazione
- API RESTful (`api.md` non presente) - API per la gestione media
- Integrazione CDN (`cdn-integration.md` non presente) - Integrazione con Content Delivery Network
- Servizi Esterni (`external-services.md` non presente) - Integrazione con servizi esterni

### Configurazione
- Struttura Config (`config_structure.md` non presente) - Struttura dei file di configurazione
- Configurazione Upload (`upload-config.md` non presente) - Configurazione sistema upload
- Principi di Configurazione (`configurations_usage_principles.md` non presente) - Principi per l'utilizzo delle configurazioni

### Pattern e Architettura
- Pattern Factory (`factory_pattern_analysis.md` non presente) - Analisi del pattern Factory
- Risoluzione Dinamica delle Classi (`dynamic_class_resolution.md` non presente) - Pattern di risoluzione dinamica delle classi
- Queueable Actions (`queueable-action.md` non presente) - Utilizzo di Spatie Queueable Actions

### Standard e Traduzioni
- Convenzioni di Naming (`naming_conventions.md` non presente) - Standard per i nomi di file e classi
- [Traduzioni](./translations.md) - Sistema di traduzioni
- Standard Traduzioni (`translation_standards.md` non presente) - Standard per le chiavi di traduzione

### Testing e Qualità
- [PHPStan Level 10](./phpstan-level10-fixes.md) - Correzioni per PHPStan Level 10
- [Testing](./testing.md) - Strategie e approcci per il testing

## Linee Guida per l'Implementazione

### 1. Struttura del Modulo
Il modulo Media segue una struttura standard con directory per modelli, servizi, provider e componenti Filament per garantire chiarezza e manutenibilità.

<!-- Merged from INDEX.md, which collided with this file on case-insensitive filesystems. -->

# Documentation Index

Modulo: Media

## File disponibili

<!-- auto-generato: elencare i file .md presenti -->
---
Doc verificati e presenti in `docs/` utili per approfondimenti puntuali (non un indice esaustivo):
- [structure.md](./structure.md)
- [data-models.md](./data-models.md)
- [core-functionality.md](./core-functionality.md)
- [file-management-architecture.md](./file-management-architecture.md)
- [phpstan_level10_fixes.md](./phpstan-level10-fixes.md) / [phpstan-report.md](./phpstan-report.md)
- [testing.md](./testing.md)
- [troubleshooting.md](./troubleshooting.md)
- [wiki/index.md](./wiki/index.md)