<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use function Safe\json_encode;
use function Safe\file_put_contents;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class SaveJsonArrayAction
{
    use QueueableAction;

    public function execute(array $data, string $filename): bool
    {
        $content = json_encode($data, JSON_PRETTY_PRINT);
        //if ($content === false) {
        //    return false;
        //}
        return (bool) file_put_contents($filename, $content);
    }
}
