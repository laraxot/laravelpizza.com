<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Subtitle;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

use function Safe\realpath;
use function Safe\simplexml_load_string;

/**
 * Extracts the plain text content from a subtitle XML file.
 *
 * @see docs/contracts/extract-subtitle-plain-text-action.md
 *
 * @contract docs/contracts/extract-subtitle-plain-text-action.md
 */
class ExtractSubtitlePlainTextAction
{
    use QueueableAction;

    public function execute(string $filePath): string
    {
        $content = $this->getContent($filePath);
        $xmlObject = simplexml_load_string($content);
        $txt = '';
        foreach ($xmlObject->annotation->type->sentence as $sentence) {
            foreach ($sentence->item as $item) {
                $txt .= $item->__toString().' ';
            }
        }

        return $txt;
    }

    private function getContent(string $filePath): string
    {
        $path = realpath($filePath);

        return File::get($path);
    }
}
