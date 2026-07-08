# Laravel-FFMpeg – API Reference Completa

> Package: `protonemedia/laravel-ffmpeg` v8+
> Namespace root: `ProtoneMedia\LaravelFFMpeg`
> Dipendenza sottostante: `php-ffmpeg/php-ffmpeg`

---

## Installazione e Configurazione

```bash
composer require pbmedia/laravel-ffmpeg
php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider"
```

### Variabili `.env`

```dotenv
FFMPEG_BINARIES=/usr/bin/ffmpeg
FFPROBE_BINARIES=/usr/bin/ffprobe
FFMPEG_LOG_CHANNEL=stack
FFMPEG_TEMPORARY_FILES_ROOT=/tmp/ffmpeg
FFMPEG_TEMPORARY_FILES_ROOT_ENCRYPTED=/tmp/ffmpeg-encrypted
```

### `config/ffmpeg.php` – Opzioni chiave

| Chiave | Default | Descrizione |
|--------|---------|-------------|
| `ffmpeg.binaries` | `'ffmpeg'` | Percorso binario FFmpeg |
| `ffmpeg.threads` | `12` | Thread FFmpeg (false = disabilita) |
| `ffprobe.binaries` | `'ffprobe'` | Percorso binario FFprobe |
| `timeout` | `3600` | Timeout operazioni (secondi) |
| `log_channel` | `'stack'` | Canale log Laravel |
| `temporary_files_root` | sys temp | Cartella file temporanei |
| `set_command_and_error_output_on_exception` | `true` | Popola eccezione con dettagli |
| `hls.segment_length` | `10` | Lunghezza segmenti HLS (min 2 sec) |
| `hls.keyframe_interval` | `10` | Intervallo keyframe HLS |

---

## Facade: `FFMpeg`

**Namespace:** `ProtoneMedia\LaravelFFMpeg\Support\FFMpeg`

Tutti i metodi della facade sono statici e restituiscono un `MediaOpener`.

### Metodi di apertura

```php
// File da disco default
FFMpeg::open('video.mp4');

// File da disco specifico
FFMpeg::fromDisk('s3')->open('video.mp4');

// File da istanza Filesystem
FFMpeg::fromFilesystem(Storage::disk('videos'))->open('video.mp4');

// File uploadato (UploadedFile)
FFMpeg::open($request->file('video'));

// URL remota
FFMpeg::openUrl('https://example.com/video.mp4');

// URL remota con header HTTP
FFMpeg::openUrl('https://cdn.example.com/video.mp4', [
    'Authorization' => 'Bearer ' . $token,
]);

// Pulizia file temporanei (dopo URL remote)
FFMpeg::cleanupTemporaryFiles();

// HLS dinamico (per modifiche runtime al playlist)
FFMpeg::dynamicHLSPlaylist();
```

---

## Classe: `MediaOpener`

**Namespace:** `ProtoneMedia\LaravelFFMpeg\MediaOpener`

### Metodi di export

| Metodo | Return | Descrizione |
|--------|--------|-------------|
| `export()` | `MediaExporter` | Export standard |
| `exportForHLS()` | `HLSExporter` | Export HLS/M3U8 |
| `exportFramesByInterval(int $sec, ?int $w, ?int $h, ?int $q)` | `FrameExporter` | Frame ogni N secondi |
| `exportFramesByAmount(int $count, ?int $w, ?int $h, ?int $q)` | `FrameExporter` | N frame distribuiti |
| `exportTile(callable $factory)` | `TileExporter` | Grid di thumbnail |

### Estrazione frame singolo

```php
FFMpeg::open('video.mp4')
    ->getFrameFromSeconds(10)        // da secondi
    ->getFrameFromString('00:01:30.00') // da stringa timecode
    ->getFrameFromTimecode($tc)      // da oggetto TimeCode
    ->export()
    ->save('thumbnail.png');
```

### Metadati durata

```php
$seconds = FFMpeg::open('video.mp4')->getDurationInSeconds();
$ms      = FFMpeg::open('video.mp4')->getDurationInMiliseconds();
```

### Filtri (su MediaOpener)

```php
// Array FFmpeg nativo
->addFilter(['-vf', 'scale=1280:720']);

// Closure con VideoFilters
->addFilter(function ($filters) {
    $filters->scale(1280, 720);
});

// Resize shorthand
->resize(1280, 720)              // mode 'fit' default
->resize(1280, 720, 'fit')       // mantiene aspect ratio
->resize(1280, 720, 'inset')     // letterbox/pillarbox
->resize(1280, 720, 'width')     // scala per larghezza
->resize(1280, 720, 'height')    // scala per altezza
```

### Watermark

```php
->addWatermark(function (WatermarkFactory $watermark) {
    $watermark
        ->open('logo.png')           // da disco default
        ->fromDisk('s3')             // specifica disco
        ->openUrl('https://cdn.example.com/logo.png') // URL
        // Posizionamento pixel
        ->right(25)->bottom(25)
        // Allineamento con costanti
        ->horizontalAlignment(WatermarkFactory::RIGHT, 10)
        ->verticalAlignment(WatermarkFactory::BOTTOM, 10)
        // Resize (richiede spatie/image)
        ->width(150)->height(50)
        // Manipolazione immagine
        ->greyscale();
});
```

---

## Classe: `MediaExporter`

**Namespace:** `ProtoneMedia\LaravelFFMpeg\Exporters\MediaExporter`

### Configurazione output

```php
FFMpeg::open('input.mp4')
    ->export()
    ->toDisk('s3')                       // disco destinazione
    ->withVisibility('public')           // 'public' | 'private'
    ->inFormat(new X264())               // formato output
    ->save('output.mp4');                // salva e ritorna MediaOpener
```

### Formati video supportati

```php
use FFMpeg\Format\Video\X264;    // H.264 – massima compatibilità
use FFMpeg\Format\Video\WebM;   // VP8/VP9 – web-first
use FFMpeg\Format\Video\WMV;    // Windows Media Video
use ProtoneMedia\LaravelFFMpeg\FFMpeg\CopyFormat; // nessun re-encoding
```

### Formati audio supportati

```php
use FFMpeg\Format\Audio\Aac;    // AAC – compatibilità universale
use FFMpeg\Format\Audio\Mp3;    // MP3 – ampio supporto
use FFMpeg\Format\Audio\Flac;   // Lossless
```

### Export multiplo (stessa sorgente)

```php
FFMpeg::open('movie.mov')
    ->export()
        ->toDisk('ftp')->inFormat(new WMV)->save('movie.wmv')
    ->export()
        ->toDisk('s3')->inFormat(new X264)->save('movie.mp4')
    ->export()
        ->inFormat(new WebM)->save('movie.webm');
```

### Progress monitoring

```php
->onProgress(function (int $percentage, int $remaining, float $rate) {
    // $percentage: 0-100
    // $remaining:  secondi stimati rimanenti
    // $rate:       moltiplicatore velocità (es. 2.5x)
    Cache::put("job:{$jobId}:progress", $percentage, 3600);
});
```

### Filtri sull'esportatore

```php
// Filter semplice
->addFilter(['-threads', '4'])

// Filter complex (multi-input)
->addFilter(function ($filters, $in, $out) {
    $filters->custom($in, 'scale=1280:720', $out);
});

// Modifica comando prima dell'esecuzione
->beforeSaving(function (array $commands): array {
    // modifica $commands e ritorna
    return $commands;
});
```

### Concatenazione

```php
// Senza re-encoding (stream copy)
FFMpeg::open(['part1.mp4', 'part2.mp4'])
    ->export()
    ->concatWithoutTranscoding()
    ->save('combined.mp4');

// Con re-encoding
FFMpeg::open(['part1.mp4', 'part2.mp4'])
    ->export()
    ->concatWithTranscoding(hasVideo: true, hasAudio: true)
    ->inFormat(new X264)
    ->save('combined.mp4');
```

### Timelapse

```php
// Da sequenza di immagini
FFMpeg::open('frame_%04d.jpg')
    ->export()
    ->asTimelapseWithFramerate(25)
    ->inFormat(new X264)
    ->save('timelapse.mp4');
```

### Output del processo

```php
$output = FFMpeg::open('video.mp4')
    ->export()
    ->inFormat(new X264)
    ->save('out.mp4')
    ->getProcessOutput();

$all    = $output->all();    // tutti i log
$errors = $output->errors(); // solo errori
$out    = $output->out();    // solo stdout
```

### Frame come contenuto binario (no filesystem)

```php
$binary = FFMpeg::open('video.mp4')
    ->getFrameFromSeconds(5)
    ->export()
    ->getFrameContents(); // stringa binaria (PNG)
```

---

## Classe: `HLSExporter`

**Namespace:** `ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter`

Eredita tutti i metodi di `MediaExporter`.

### HLS base

```php
FFMpeg::open('video.mp4')
    ->exportForHLS()
    ->addFormat(
        (new X264)->setKiloBitrate(500),
        function ($media) {
            $media->addFilter(['-vf', 'scale=640:360']);
        }
    )
    ->addFormat(
        (new X264)->setKiloBitrate(1500),
        function ($media) {
            $media->resize(1280, 720);
        }
    )
    ->addFormat((new X264)->setKiloBitrate(3000))
    ->setSegmentLength(10)       // default config
    ->setKeyFrameInterval(10)    // min 2
    ->toDisk('videos')
    ->save('stream/playlist.m3u8');
```

### File generati

```
stream/
├── playlist.m3u8           # Master playlist (selettore bitrate)
├── playlist_500_00000.ts   # Segmenti variante 500kbps
├── playlist_500_00001.ts
├── playlist_1500_00000.ts  # Segmenti variante 1500kbps
├── playlist_500.m3u8       # Playlist variante 500kbps
├── playlist_1500.m3u8      # Playlist variante 1500kbps
└── ...
```

### Naming personalizzato segmenti

```php
->useSegmentFilenameGenerator(
    function (string $name, Format $format, int $key, callable $segments, callable $playlist) {
        $segments("{$name}_{$key}_{$format->getKiloBitrate()}_%05d.ts");
        $playlist("{$name}_{$key}_{$format->getKiloBitrate()}.m3u8");
    }
);
```

### Crittografia AES-128

```php
// Chiave statica
$key = HLSExporter::generateEncryptionKey(); // genera chiave random
FFMpeg::open('video.mp4')
    ->exportForHLS()
    ->withEncryptionKey($key, 'secret.key')
    ->addFormat(new X264)
    ->save('playlist.m3u8');

// Chiave rotante (una per segmento)
->withRotatingEncryptionKey(
    function (string $filename, string $contents) {
        // persisti la chiave (es. su S3 o DB)
        Storage::disk('keys')->put($filename, $contents);
    },
    segmentsPerKey: 3 // ruota ogni 3 segmenti
);
```

### Audio streams multipli

```php
->keepAllAudioStreams() // default: solo primo stream audio
```

---

## Classe: `DynamicHLSPlaylist`

**Namespace:** `ProtoneMedia\LaravelFFMpeg\Http\DynamicHLSPlaylist`

Usata per modificare i playlist HLS a runtime (es. URL firmate, auth).

```php
FFMpeg::dynamicHLSPlaylist()
    ->fromDisk('videos')
    ->open('stream/playlist.m3u8')
    ->setKeyUrlResolver(function (string $path) {
        return Storage::disk('keys')->temporaryUrl($path, now()->addHour());
    })
    ->setMediaUrlResolver(function (string $path) {
        return Storage::disk('videos')->temporaryUrl($path, now()->addHour());
    })
    ->setPlaylistUrlResolver(function (string $path) {
        return route('hls.playlist', ['path' => $path]);
    });
```

---

## Classe: `TileFactory`

**Namespace:** `ProtoneMedia\LaravelFFMpeg\Filters\TileFactory`

Per generare griglie di thumbnail (sprite sheet).

```php
FFMpeg::open('video.mp4')
    ->exportTile(function (TileFactory $tile) {
        $tile
            ->interval(5)        // un frame ogni 5 secondi
            ->scale(160, 90)     // dimensioni singolo frame
            ->grid(10, 10)       // griglia 10x10
            ->margin(2)          // margine esterno
            ->padding(2)         // padding tra frame
            ->quality(5)         // qualità JPEG (2=best, 31=worst)
            ->generateVTT('thumbnails.vtt'); // WebVTT per player
    })
    ->toDisk('videos')
    ->save('thumbnails.jpg');
```

---

## Classe: `WatermarkFactory` – Costanti di posizione

```php
WatermarkFactory::LEFT    // allineamento sinistro
WatermarkFactory::CENTER  // allineamento centro
WatermarkFactory::RIGHT   // allineamento destro
WatermarkFactory::TOP     // allineamento alto
WatermarkFactory::BOTTOM  // allineamento basso
```

---

## Gestione Eccezioni

```php
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;

try {
    FFMpeg::open('input.mp4')
        ->export()
        ->inFormat(new X264)
        ->save('output.mp4');
} catch (EncodingException $e) {
    $command     = $e->getCommand();     // comando FFmpeg eseguito
    $errorOutput = $e->getErrorOutput(); // output di errore FFmpeg

    Log::error('FFmpeg encoding failed', [
        'command' => $command,
        'error'   => $errorOutput,
    ]);
}
```

---

## Accesso al driver sottostante (`PHPFFMpeg`)

Per operazioni avanzate che richiedono accesso diretto a `php-ffmpeg`:

```php
$media = FFMpeg::open('video.mp4');

// Verifica tipo media
$media->isVideo();  // bool
$media->isFrame();  // bool
$media->isConcat(); // bool

// Accesso diretto all'oggetto php-ffmpeg
$phpFFMpeg = $media(); // __invoke restituisce AbstractMediaType

// Stream
$videoStream = $media->getVideoStream();
$audioStream = $media->getAudioStream();
```

---

## Logging

```php
// config/ffmpeg.php
'log_channel' => env('FFMPEG_LOG_CHANNEL', 'stack'),
```

I comandi FFmpeg eseguiti vengono loggati automaticamente nel canale configurato.

---

## Compatibilità PHPStan Level 10

Namespace corretti per i formati (v8+):

```php
// ✅ CORRETTO (v8+)
use FFMpeg\Format\Video\X264;
use FFMpeg\Format\Audio\Aac;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

// ❌ SBAGLIATO (namespace vecchio)
use ProtoneMedia\LaravelFFMpeg\Format\Video\X264;
```

Nota: `FFMpeg::open()` restituisce `MediaOpener`, non `static`. Tipizzare correttamente le variabili intermedie per soddisfare PHPStan.
