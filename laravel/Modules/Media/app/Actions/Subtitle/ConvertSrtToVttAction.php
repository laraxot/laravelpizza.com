<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Subtitle;

use RuntimeException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\fclose;
use function Safe\file_put_contents;
use function Safe\fopen;

/**
 * Converts an SRT subtitle file (public path) to WebVTT format.
 */
class ConvertSrtToVttAction
{
    use QueueableAction;

    public function execute(string $srtFile, string $webVttFile): void
    {
        $fileHandle = fopen(public_path($srtFile), 'r');
        $lines = [];
        while (($line = fgets($fileHandle)) !== false) {
            $lines[] = $line;
        }

        if (! feof($fileHandle)) {
            throw new RuntimeException("Unexpected fgets() failure while reading {$srtFile}");
        }

        fclose($fileHandle);

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
