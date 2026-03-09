<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Widgets;

use FFMpeg\Format\Video\WebM;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Media\Filament\Resources\MediaResource;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use RuntimeException;

class ConvertWidget extends XotBaseWidget
{
    public Media $record;
    public string $time = '';
    public string $start = '';
    public float $percentage = 0;
    public float $remaining = 0;
    public float $rate = 0;

    protected string $view = 'media::filament.widgets.convert';
    protected static string $resource = MediaResource::class;

    public function getFormSchema(): array
    {
        return [];
    }

    public function begin(): void
    {
        $disk_mp4 = $this->record->disk;
        $file_mp4 = $this->record->getPath();
        $disk_path = Storage::disk($disk_mp4)->path('/');
        $file_mp4 = Str::after($file_mp4, $disk_path);

        $format = new WebM;
        $extension = mb_strtolower(class_basename($format));
        $file_new = Str::of($file_mp4)->replaceLast('.mp4', '.'.$extension)->toString();

        $exportedMedia = FFMpeg::fromDisk($disk_mp4)->open($file_mp4)->export();

        $exportedMedia->onProgress(function (float $percentage, float $remaining, float $rate): void {
            $this->percentage = $percentage;
            $this->remaining = $remaining;
            $this->rate = $rate;
            $msg = "{$percentage}% transcoded. {$remaining} seconds left.";
            Notification::make()->title($msg)->success()->send();
        });

        $toDiskMedia = $exportedMedia->toDisk($disk_mp4);
        if ($toDiskMedia === null) {
            throw new RuntimeException('Failed to export media to disk');
        }

        $formattedMedia = $toDiskMedia->inFormat($format);
        if ($formattedMedia === null || ! is_object($formattedMedia)) {
            throw new RuntimeException('Failed to format media');
        }

        $formattedMedia->save($file_new);
    }
}
