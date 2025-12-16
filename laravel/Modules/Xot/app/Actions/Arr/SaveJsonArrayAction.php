<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Arr;

use Spatie\QueueableAction\QueueableAction;

use function Safe\file_put_contents;
use function Safe\json_encode;

class SaveJsonArrayAction
{
    use QueueableAction;

    public function execute(array $data, string $filename): bool
    {
        $content = json_encode($data, JSON_PRETTY_PRINT);

        // if ($content === false) {
        //    return false;
        // }
        return (bool) file_put_contents($filename, $content);
    }
}
