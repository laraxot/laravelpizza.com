# Laravel-FFMpeg – Pattern Laraxot nel Modulo Media

Questa guida descrive come usare `protonemedia/laravel-ffmpeg` seguendo i pattern architetturali
del progetto (XotBase, QueueableAction, Spatie Data, PHPStan level 10).

---

## Pattern 1 – Action di Conversione Video

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Actions\Video;

use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class ConvertVideoToH264Action
{
    use QueueableAction;

    public function execute(
        string $sourceDisk,
        string $sourcePath,
        string $destinationDisk,
        string $destinationPath,
        int $kiloBitrate = 1500,
        ?callable $onProgress = null,
    ): void {
        $format = (new X264())->setKiloBitrate($kiloBitrate);

        try {
            $export = FFMpeg::fromDisk($sourceDisk)
                ->open($sourcePath)
                ->export()
                ->toDisk($destinationDisk)
                ->inFormat($format);

            if ($onProgress !== null) {
                $export->onProgress($onProgress);
            }

            $export->save($destinationPath);
        } catch (EncodingException $e) {
            Log::error('Video conversion failed', [
                'source'  => $sourcePath,
                'command' => $e->getCommand(),
                'error'   => $e->getErrorOutput(),
            ]);

            throw $e;
        }
    }
}
```

---

## Pattern 2 – Action HLS Multi-Bitrate

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Actions\Video;

use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class GenerateHLSStreamAction
{
    use QueueableAction;

    /** @param array<int, int> $bitrates Bitrate in kbps per variante */
    public function execute(
        string $sourceDisk,
        string $sourcePath,
        string $destinationDisk,
        string $playlistPath,
        array $bitrates = [500, 1500, 3000],
    ): void {
        $exporter = FFMpeg::fromDisk($sourceDisk)
            ->open($sourcePath)
            ->exportForHLS()
            ->toDisk($destinationDisk)
            ->setSegmentLength(10)
            ->setKeyFrameInterval(10);

        // Aggiunge ogni variante di bitrate
        $resolutions = [
            500  => [640, 360],
            1500 => [1280, 720],
            3000 => [1920, 1080],
        ];

        foreach ($bitrates as $bitrate) {
            $format = (new X264())->setKiloBitrate($bitrate);
            $res    = $resolutions[$bitrate] ?? null;

            $exporter->addFormat(
                $format,
                $res !== null
                    ? function ($media) use ($res): void {
                        $media->resize($res[0], $res[1]);
                    }
                    : null
            );
        }

        $exporter->save($playlistPath);
    }
}
```

---

## Pattern 3 – Thumbnail Extraction Action

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Actions\Video;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class ExtractVideoThumbnailAction
{
    use QueueableAction;

    public function execute(
        string $disk,
        string $videoPath,
        string $thumbnailPath,
        int $atSecond = 5,
    ): void {
        FFMpeg::fromDisk($disk)
            ->open($videoPath)
            ->getFrameFromSeconds($atSecond)
            ->export()
            ->toDisk($disk)
            ->save($thumbnailPath);
    }
}
```

---

## Pattern 4 – Tile/Sprite Sheet per Player

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Actions\Video;

use ProtoneMedia\LaravelFFMpeg\Filters\TileFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class GenerateVideoTileAction
{
    use QueueableAction;

    public function execute(
        string $disk,
        string $videoPath,
        string $tilePath,
        string $vttPath,
    ): void {
        FFMpeg::fromDisk($disk)
            ->open($videoPath)
            ->exportTile(function (TileFactory $tile) use ($vttPath): void {
                $tile
                    ->interval(5)
                    ->scale(160, 90)
                    ->grid(10, 10)
                    ->padding(2)
                    ->quality(5)
                    ->generateVTT($vttPath);
            })
            ->toDisk($disk)
            ->save($tilePath);
    }
}
```

---

## Pattern 5 – HLS Crittografato con Chiavi Rotanti

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Actions\Video;

use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\QueueableAction\QueueableAction;

class GenerateEncryptedHLSAction
{
    use QueueableAction;

    public function execute(
        string $sourceDisk,
        string $sourcePath,
        string $outputDisk,
        string $playlistPath,
    ): void {
        FFMpeg::fromDisk($sourceDisk)
            ->open($sourcePath)
            ->exportForHLS()
            ->addFormat((new X264())->setKiloBitrate(1500))
            ->withRotatingEncryptionKey(
                function (string $filename, string $contents) use ($outputDisk): void {
                    Storage::disk($outputDisk)->put("keys/{$filename}", $contents);
                },
                segmentsPerKey: 3,
            )
            ->toDisk($outputDisk)
            ->save($playlistPath);
    }
}
```

---

## Pattern 6 – Dynamic HLS Playlist con URL Firmate

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

// Nota: in <nome progetto> usare Folio+Volt, NON controller tradizionali
// Questo è un esempio per contesti dove il controller è consentito
class HLSPlaylistController
{
    public function show(Request $request, string $path): Response
    {
        $content = FFMpeg::dynamicHLSPlaylist()
            ->fromDisk('videos')
            ->open($path)
            ->setKeyUrlResolver(
                fn (string $keyPath) => Storage::disk('keys')
                    ->temporaryUrl($keyPath, now()->addHour())
            )
            ->setMediaUrlResolver(
                fn (string $segmentPath) => Storage::disk('videos')
                    ->temporaryUrl($segmentPath, now()->addHour())
            )
            ->setPlaylistUrlResolver(
                fn (string $playlistPath) => route('hls.playlist', [
                    'path' => $playlistPath,
                ])
            );

        return response($content, 200, ['Content-Type' => 'application/x-mpegURL']);
    }
}
```

---

## Pattern 7 – Job Queueable con Progress su Cache

```php
<?php

declare(strict_types=1);

namespace Modules\Media\app\Jobs;

use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class TranscodeVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $timeout = 3600;
    public int $tries   = 2;

    public function __construct(
        private readonly string $mediaId,
        private readonly string $disk,
        private readonly string $inputPath,
        private readonly string $outputPath,
    ) {}

    public function handle(): void
    {
        try {
            FFMpeg::fromDisk($this->disk)
                ->open($this->inputPath)
                ->export()
                ->toDisk($this->disk)
                ->inFormat((new X264())->setKiloBitrate(1500))
                ->onProgress(function (int $percentage, int $remaining, float $rate) {
                    Cache::put(
                        "media:{$this->mediaId}:progress",
                        compact('percentage', 'remaining', 'rate'),
                        ttl: 3600
                    );
                })
                ->save($this->outputPath);

            Cache::put("media:{$this->mediaId}:progress", ['percentage' => 100], 3600);
        } catch (EncodingException $e) {
            Cache::put("media:{$this->mediaId}:error", $e->getErrorOutput(), 3600);
            throw $e;
        }
    }
}
```

---

## Convenzioni obbligatorie (PHPStan Level 10)

```php
<?php

declare(strict_types=1); // SEMPRE presente

// Import corretto namespace v8+
use FFMpeg\Format\Video\X264;         // ✅
use FFMpeg\Format\Audio\Aac;          // ✅
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;              // ✅
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException; // ✅
use ProtoneMedia\LaravelFFMpeg\Filters\TileFactory;         // ✅
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;    // ✅

// Tipizzare sempre i callable/closure con parametri espliciti
->onProgress(function (int $percentage, int $remaining, float $rate): void {
    // ...
})

// Non usare var_ senza tipo, sempre typed
$format = new X264();
$format->setKiloBitrate(1500);
```

---

## Checklist prima del commit

- [ ] `declare(strict_types=1)` presente nel file
- [ ] Namespace import corretti (v8+ non usa namespace obsoleti)
- [ ] `EncodingException` catturata e loggata con `getCommand()` + `getErrorOutput()`
- [ ] Operazioni pesanti in `QueueableAction` o `Job`, mai in controller/blade
- [ ] PHPStan livello 10 superato senza soppressioni
- [ ] Progress callback tipizzato correttamente
- [ ] `FFMpeg::cleanupTemporaryFiles()` chiamato dopo operazioni su URL remote
