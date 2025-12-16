<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use function Safe\file_put_contents;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class SavePhpArrayAction
{
    use QueueableAction;

    public function execute(array $data, string $filename): bool
    {
        $content = "<?php\n\nreturn " . var_export($data, true) . ";\n";
        return (bool) file_put_contents($filename, $content);
    }
}
