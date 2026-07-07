<?php

declare(strict_types=1);

namespace Modules\Media\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SimpleXMLElement;

use function Safe\file_put_contents;
use function Safe\fopen;
use function Safe\realpath;
use function Safe\simplexml_load_string;

/**
 * SubtitleService.
 */
class SubtitleService
{
    public string $disk = 'media';

    // nome che usa storage
    public string $file_path;

    public string $field_name = 'txt';

    /** @var array<int, array<string, float|int|string|mixed>> */
    public array $subtitles = [];

    public Model $model;

    private static ?self $instance = null;

    /**
     * ---.
     */
    public static function getInstance(): self
    {
        if (! (self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * ---.
     */
    public static function make(): self
    {
        return static::getInstance();
    }

    public function setFilePath(string $file_path): static
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function upateModel(): static
    {
        $plain = $this->getPlain();
        $up = [$this->field_name => $plain];
        $this->model = tap($this->model)->update($up);

        return $this;
    }

    /**
     * Undocumented function.
     */
    public function getPlain(): string
    {
        $content = $this->getContent();
        $xmlObject = simplexml_load_string($content);
        $txt = '';
        foreach ($xmlObject->annotation->type->sentence as $sentence) {
            foreach ($sentence->item as $item) {
                $txt .= $item->__toString().' ';
            }
        }

        return $txt;
    }

    /**
     * @return array<int, array<string, float|int|string|mixed>>
     */
    public function get(): array
    {
        $info = pathinfo($this->file_path);
        if (! isset($info['extension'])) {
            return [];
        }

        return match (Str::lower($info['extension'])) {
            'xml' => $this->getFromXml(),
            default => [],
        };
    }

    /**
     * Undocumented function.
     */
    public function getContent(): string
    {
        $path = realpath($this->file_path);

        return File::get($path);
    }

    /**
     * @return array<int, array<string, float|int|string|mixed>>
     *
     * @psalm-return list{0?: array{sentence_i: int<0, max>, item_i: int<0, max>, start: float|int, end: float|int, time: string, text: mixed},...}
     */
    public function getFromXml(): array
    {
        $this->subtitles = [];
        $content = $this->getContent();
        $xmlObject = simplexml_load_string($content);

        $data = [];
        $sentence_i = 0;
        foreach ($xmlObject->annotation->type->sentence as $sentence) {
            $item_i = 0;
            foreach ($sentence->item as $item) {
                $attributes = $item->attributes();

                if (! ($attributes instanceof SimpleXMLElement)) {
                    throw new Exception('['.__LINE__.']['.class_basename($this).']');
                }

                // 00:06:35,360
                $start = (int) $attributes->start->__toString() / 1000;
                $end = (int) $attributes->end->__toString() / 1000;
                // dddx([$start,$this->secondsToHms($start),$end,$this->secondsToHms($end)]);
                $tmp = [
                    // 'id' => $i++,
                    'sentence_i' => $sentence_i,
                    'item_i' => $item_i,
                    'start' => $start,
                    'end' => $end,
                    'time' => $this->secondsToHms($start).','.$this->secondsToHms($end),
                    'text' => (string) $item,
                ];
                $data[] = $tmp;
                $item_i++;
            }

            $sentence_i++;
        }

        return $data;
    }

    private function secondsToHms(int|float $seconds): string
    {
        $totalMs = (int) round($seconds * 1000);
        $hours = intdiv($totalMs, 3_600_000);
        $minutes = intdiv($totalMs % 3_600_000, 60_000);
        $secs = intdiv($totalMs % 60_000, 1000);
        $ms = $totalMs % 1000;

        return sprintf('%02d:%02d:%02d,%03d', $hours, $minutes, $secs, $ms);
    }

    /**
     * Undocumented function.
     */
    public function srtToVtt(string $srtFile, string $webVttFile): void
    {
        $fileHandle = fopen(public_path($srtFile), 'r');
        $lines = [];
        if ($fileHandle) {
            // $lines = [];
            while (($line = fgets($fileHandle, 8192)) !== false) {
                $lines[] = $line;
            }

            if (! feof($fileHandle)) {
                exit("Error: unexpected fgets() fail\n");
            }

            // ($fileHandle);
        }

        $length = \count($lines);
        for ($index = 1; $index < $length; $index++) {
            if ($index === 1 || trim($lines[$index - 2]) === '') {
                $lines[$index] = str_replace(',', '.', $lines[$index]);
            }
        }

        $header = "WEBVTT\n\n";

        file_put_contents(public_path($webVttFile), $header.implode('', $lines));
    }
}
