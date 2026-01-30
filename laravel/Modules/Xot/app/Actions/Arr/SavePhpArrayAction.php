<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Arr;

use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\VarExporter\VarExporter;

use function Safe\file_put_contents;

class SavePhpArrayAction
{
    use QueueableAction;

    public function execute(array $data, string $filename): bool
    {
        $exported = VarExporter::export($data);
        // $exported = var_export($data, true);
        $content = "<?php\n\ndeclare(strict_types=1);\n\nreturn ".$exported.";\n";

        return (bool) file_put_contents($filename, $content);
    }
}
