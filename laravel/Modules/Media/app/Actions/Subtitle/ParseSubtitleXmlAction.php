<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Subtitle;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SimpleXMLElement;
use Spatie\QueueableAction\QueueableAction;

use function Safe\realpath;
use function Safe\simplexml_load_string;

/**
 * Parses a subtitle file (currently only XML is supported) into structured
 * sentence/item timing data.
 *
 * @phpstan-type SubtitleRow array{sentence_i: int, item_i: int, start: float|int, end: float|int, time: string, text: string}
 */
class ParseSubtitleXmlAction
{
    use QueueableAction;

    /**
     * @return list<SubtitleRow>
     */
    public function execute(string $filePath): array
    {
        $info = pathinfo($filePath);
        if (! isset($info['extension'])) {
            return [];
        }

        return match (Str::lower($info['extension'])) {
            'xml' => $this->getFromXml($filePath),
            default => [],
        };
    }

    /**
     * @return list<SubtitleRow>
     */
    private function getFromXml(string $filePath): array
    {
        $content = $this->getContent($filePath);
        $xmlObject = simplexml_load_string($content);

        $data = [];
        $sentence_i = 0;
        foreach ($xmlObject->annotation->type->sentence as $sentence) {
            $item_i = 0;
            foreach ($sentence->item as $item) {
                $attributes = $item->attributes();

                if (! ($attributes instanceof SimpleXMLElement)) {
                    throw new Exception('['.__LINE__.']['.self::class.']');
                }

                // 00:06:35,360
                $start = (int) $attributes->start->__toString() / 1000;
                $end = (int) $attributes->end->__toString() / 1000;
                $data[] = [
                    'sentence_i' => $sentence_i,
                    'item_i' => $item_i,
                    'start' => $start,
                    'end' => $end,
                    'time' => $this->secondsToHms($start).','.$this->secondsToHms($end),
                    'text' => (string) $item,
                ];
                $item_i++;
            }

            $sentence_i++;
        }

        return $data;
    }

    private function getContent(string $filePath): string
    {
        $path = realpath($filePath);

        return File::get($path);
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
}
