<?php

declare(strict_types=1);

namespace Modules\Media\Console\Commands;

use FFMpeg\Format\Video\WebM;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Webmozart\Assert\Assert;

class ConvertVideoCommand extends Command
{
    protected $signature = 'media:convert-video {disk} {file}';

    protected $description = 'Convert Video';

    public function handle(): string
    {
        Assert::string($disk = $this->argument('disk'));
        Assert::string($file = $this->argument('file'));
        $this->info('disk: '.print_r($disk, true));
        $this->info('file: '.print_r($file, true));

        if (! Storage::disk($disk)->exists($file)) {
            $this->error('['.$disk.'] file ['.$file.'] Not Exists');

            return '';
        }

        $format = new WebM;
        $extension = mb_strtolower(class_basename($format));
        $file_new = Str::of($file)->replaceLast('.mp4', '.'.$extension)->toString();

        $media = FFMpeg::fromDisk($disk)->open($file);
        $export = $media->export();

        $export->onProgress(function (float $percentage, float $remaining, float $rate): void {
            $this->info("{$percentage}% transcoded");
            $this->info("{$remaining} seconds left at rate: {$rate}");
        });
        // @phpstan-ignore method.nonObject, method.nonObject
        $export
            ->toDisk($disk)
            // @phpstan-ignore method.nonObject
            ->inFormat($format)
            // @phpstan-ignore method.nonObject
            ->save($file_new);

        return Storage::disk($disk)->url($file_new);
    }
}
