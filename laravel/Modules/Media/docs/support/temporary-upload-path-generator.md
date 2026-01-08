# TemporaryUploadPathGenerator Documentation

## Overview
Il `TemporaryUploadPathGenerator` è una classe che gestisce la generazione dei percorsi per i file multimediali temporanei nel sistema.

## Funzionalità

### Generazione Percorsi
- `getPath()`: Genera il percorso per il file originale
- `getPathForConversions()`: Genera il percorso per le conversioni
- `getPathForResponsiveImages()`: Genera il percorso per le immagini responsive
- `getBasePath()`: Genera il percorso base univoco

### Caratteristiche
- Generazione percorsi univoci basati su UUID e ID
- Supporto per file originali e conversioni
- Gestione immagini responsive
- Struttura directory organizzata

## Struttura Directory
```
tmp/
└── {md5_hash}/
    ├── {md5_hash_original}/
    ├── {md5_hash_conversion}/
    └── {md5_hash_responsive}/
```

## Utilizzo
```php
$generator = new TemporaryUploadPathGenerator();

// Percorso file originale
$path = $generator->getPath($media);

// Percorso conversioni
$conversionPath = $generator->getPathForConversions($media);

// Percorso immagini responsive
$responsivePath = $generator->getPathForResponsiveImages($media);
```

## Sicurezza
- Utilizzo di hash MD5 per i nomi delle directory
- Percorsi univoci per ogni media
- Validazione dei parametri con Assert

## Recent Changes
- Rimossi conflitti di merge
- Migliorata la documentazione del codice
- Aggiunta tipizzazione stretta
- Ottimizzata la generazione dei percorsi

## Caratteristiche principali

- Generazione di percorsi univoci per i file temporanei
- Supporto per conversioni e immagini responsive
- Gestione sicura degli UUID e degli ID
- Integrazione con il sistema di media di Spatie

## Metodi principali

### `getPath(Media $media): string`
Genera il percorso base per il file originale.
```php
// Esempio di output: tmp/abc123/def456original/
```

### `getPathForConversions(Media $media): string`
Genera il percorso per le conversioni del file.
```php
// Esempio di output: tmp/abc123/def456conversion
```

### `getPathForResponsiveImages(Media $media): string`
Genera il percorso per le immagini responsive.
```php
// Esempio di output: tmp/abc123/def456responsive
```

### `getBasePath(Media $media): string`
Genera il percorso base univoco per il media.
```php
// Esempio di output: tmp/abc123
```

## Best Practices

- Utilizzare sempre gli UUID per garantire l'unicità
- Validare gli input con Assert
- Mantenere la coerenza nella struttura delle directory
- Gestire correttamente la pulizia dei file temporanei

## Sicurezza

- I percorsi sono generati usando MD5 per evitare collisioni
- Gli UUID garantiscono l'unicità dei file
- I percorsi sono validati prima della creazione
- I file temporanei sono isolati in una directory dedicata

## Esempio di utilizzo

```php
use Modules\Media\Support\TemporaryUploadPathGenerator;
use Modules\Media\Models\Media;

$generator = new TemporaryUploadPathGenerator();
$media = Media::find(1);

$originalPath = $generator->getPath($media);
$conversionPath = $generator->getPathForConversions($media);
$responsivePath = $generator->getPathForResponsiveImages($media);
``` 