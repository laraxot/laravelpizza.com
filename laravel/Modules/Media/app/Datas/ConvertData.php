<?php

declare(strict_types=1);

namespace Modules\Media\Datas;

use FFMpeg\Format\Video\DefaultVideo;
use FFMpeg\Format\Video\WebM;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

class ConvertData extends Data implements Wireable
{
    use WireableData;

    public string $disk;

    public string $file;

    public string $format;

    // -c:v libvpx-vp9: Utilizza il codec video VP9 per WebM.
    public string $codec_video;

    // -c:a libvorbis: Utilizza il codec audio Vorbis
    public string $codec_audio;

    // -preset ultrafast: Imposta il preset di velocità su ultrafast.
    public string $preset;

    // -b:v 1M: Imposta il bitrate video a 1 Mbps (puoi modificarlo in base alle tue esigenze).
    public string $bitrate;

    public ?int $width = null;

    public ?int $height = null;

    // -threads 4: utilizza 4 thread per l'elaborazione, aumentando la velocità di conversione sfruttando il multi-threading.
    public ?int $threads = null;

    // -speed 4: imposta la velocità del codec VP9 a 4, che è un valore elevato per massimizzare la velocità di codifica.
    public ?int $speed = null;

    public function exists(): bool
    {
        return Storage::disk($this->disk)->exists($this->file);
    }

    public function getFFMpegFormat(): DefaultVideo
    {
        $format = new WebM($this->codec_audio, $this->codec_video);
        $format = $format->setKiloBitrate((int) $this->bitrate);
        Assert::isInstanceOf($format, DefaultVideo::class);

        return $format;
    }

    public function getConvertedFilename(): string
    {
        $format = $this->getFFMpegFormat();
        $extension = mb_strtolower(class_basename($format));

        return Str::of($this->file)->replaceLast('.mp4', '.'.$extension)->toString();
    }
}
