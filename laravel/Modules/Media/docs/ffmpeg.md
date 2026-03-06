# Laravel FFmpeg - Guida Completa

## Panoramica

**Pacchetto**: `pbmedia/laravel-ffmpeg`  
**GitHub**: https://github.com/protonemedia/laravel-ffmpeg  
**Versione**: Laravel 10+ con supporto PHP 8.1+

Questo pacchetto fornisce un'integrazione completa con FFmpeg per Laravel, utilizzando il Filesystem di Laravel per la gestione dei file.

## Caratteristiche

- Wrapper semplice attorno a PHP-FFMpeg
- Integrazione con Filesystem, config e logging Laravel
- Supporto HLS integrato
- Supporto HLS crittografato (AES-128)
- Supporto concatenazione, multiple inputs/outputs
- Esportazione frame/thumbnail
- Watermark positioning
- Creazione mosaic/sprite/tile
- Generazione VTT preview thumbnails

## Installazione

```bash
composer require pbmedia/laravel-ffmpeg
```

Pubblicare la configurazione:
```bash
php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"
```

## Configurazione

### Installazione FFmpeg

```bash
# Verifica versione
ffmpeg -version

# Linux (Ubuntu/Debian)
sudo apt install ffmpeg

# macOS
brew install ffmpeg

# Windows
choco install ffmpeg
winget install ffmpeg
```

### Variabili Environment

```env
FFMPEG_PATH=c:/ProgramData/chocolatey/bin/ffmpeg.exe
FFPROBE_PATH=c:/ProgramData/chocolatey/bin/ffprobe.exe
```

## Utilizzo Base

### Conversione Audio/Video

```php
use FFMpeg\Format\Audio\Aac;

FFMpeg::fromDisk('songs')
    ->open('yesterday.mp3')
    ->export()
    ->toDisk('converted_songs')
    ->inFormat(new Aac)
    ->save('yesterday.aac');
```

### Monitoraggio Progresso

```php
FFMpeg::open('video.mp4')
    ->export()
    ->onProgress(function ($percentage, $remaining, $rate "{$percentage}%) {
        echo transcoded";
    })
    ->save('output.mp4');
```

## Funzionalità Avanzate

### Filtri Video

```php
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Coordinate\Dimension;

FFMpeg::fromDisk('videos')
    ->open('video.mp4')
    ->addFilter(function (VideoFilters $filters) {
        $filters->resize(new Dimension(640, 480));
    })
    ->export()
    ->inFormat(new \FFMpeg\Format\Video\X264)
    ->save('video_resized.mp4');
```

### Watermark

```php
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;

FFMpeg::open('video.mp4')
    ->addWatermark(function (WatermarkFactory $watermark) {
        $watermark->fromDisk('local')
            ->open('logo.png')
            ->right(25)
            ->bottom(25);
    })
    ->save('video_with_watermark.mp4');
```

### HLS Export

```php
$low = (new X264)->setKiloBitrate(250);
$mid = (new X264)->setKiloBitrate(500);
$high = (new X264)->setKiloBitrate(1000);

FFMpeg::open('video.mp4')
    ->exportForHLS()
    ->setSegmentLength(10)
    ->setKeyFrameInterval(48)
    ->addFormat($low)
    ->addFormat($mid)
    ->addFormat($high)
    ->save('adaptive.m3u8');
```

### HLS Crittografato

```php
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

$key = HLSExporter::generateEncryptionKey();

FFMpeg::open('video.mp4')
    ->exportForHLS()
    ->withEncryptionKey($key)
    ->addFormat($low)
    ->save('encrypted.m3u8');
```

### Esportazione Frame

```php
// Frame al secondo 10
FFMpeg::open('video.mp4')
    ->getFrameFromSeconds(10)
    ->export()
    ->save('frame_10.png');

// Frame multipli per intervallo
FFMpeg::open('video.mp4')
    ->exportFramesByInterval(2)
    ->save('thumb_%05d.jpg');
```

### Concatenazione Video

```php
// Senza transcodifica
FFMpeg::open(['video1.mp4', 'video2.mp4'])
    ->export()
    ->concatWithoutTranscoding()
    ->save('concat.mp4');

// Con transcodifica
FFMpeg::open(['video1.mp4', 'video2.mp4'])
    ->export()
    ->inFormat(new X264)
    ->concatWithTranscoding(true, true)
    ->save('concat.mp4');
```

### Tile/Sprite Generation

```php
use ProtoneMedia\LaravelFFMpeg\Filters\TileFactory;

FFMpeg::open('video.mp4')
    ->exportTile(function (TileFactory $factory) {
        $factory->interval(5)
            ->scale(160, 90)
            ->grid(3, 5);
    })
    ->save('tile_%05d.jpg');

// Con VTT
FFMpeg::open('video.mp4')
    ->exportTile(function (TileFactory $factory) {
        $factory->interval(10)
            ->scale(320, 180)
            ->grid(5, 5)
            ->generateVTT('thumbnails.vtt');
    })
    ->save('tile_%05d.jpg');
```

## Gestione Errori

```php
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;

try {
    FFMpeg::open('video.mp4')
        ->export()
        ->inFormat(new X264)
        ->save('output.mp4');
} catch (EncodingException $e) {
    $command = $e->getCommand();
    $errorLog = $e->getErrorOutput();
}
```

## Best Practices

1. **Progress monitoring**: Utilizzare `onProgress` per operazioni lunghe
2. **HLS segments**: Impostare segment length >= 2 secondi
3. **Cleanup**: Chiamare `FFMpeg::cleanupTemporaryFiles()` dopo operazioni remote
4. **Temporary files**: Configurare `temporary_files_root` in config per file system lenti
5. **Format**: Usare `CopyFormat` per esportare senza transcodifica

## Riferimenti

- [GitHub](https://github.com/protonemedia/laravel-ffmpeg)
- [Documentazione](https://protone.media/en/blog/how-to-use-ffmpeg-in-your-laravel-projects)
- [PHP-FFMpeg](https://github.com/PHP-FFMpeg/PHP-FFMpeg)
