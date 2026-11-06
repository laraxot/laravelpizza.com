<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Widgets;

use FFMpeg\Format\Video\WebM;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Media\Actions\Ffmpeg\ResolveMediaExporterAction;
use Modules\Media\Filament\Resources\MediaResource;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertWidget extends XotBaseWidget
{
    public Media $record;

    public string $time = '';

    public string $start = '';

    public float $percentage = 0;

    public float $remaining = 0.0;

    public float $rate = 0.0;

    protected string $view = 'media::filament.widgets.convert';

    protected static string $resource = MediaResource::class;

    public function __construct()
    {
        $this->view = 'media::filament.widgets.convert';

        parent::__construct();
    }

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

        $exportedMedia = FFMpeg::fromDisk($disk_mp4)
            ->open($file_mp4)
            ->export();

        $exportedMedia->onProgress(function (float $percentage, float $remaining, float $rate): void {
            $this->percentage = $percentage;
            $this->remaining = $remaining;
            $this->rate = $rate;
            $msg = "{$percentage}% transcoded";
            $msg .= "{$remaining} seconds left at rate: {$rate}";
            Notification::make()
                ->title($msg)
                ->success()
                ->send();
        });

        $formattedMedia = app(ResolveMediaExporterAction::class)->execute(
            $exportedMedia->toDisk($disk_mp4)
        )->inFormat($format);
        $formattedMedia->save($file_new);

        while ($this->percentage < 100) {
            // Stream the current count to the browser...
            $this->stream(
                to: 'count',
                content: $this->start,
                replace: true,
            );

            $this->start =
                "{$this->percentage}% transcoded".PHP_EOL."{$this->remaining} seconds left at rate: {$this->rate}";
        }
    }
}
