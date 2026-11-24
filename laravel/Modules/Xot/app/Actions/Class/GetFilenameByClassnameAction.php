<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Class;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/class-get-filename-by-classname-action.md
<<<<<<< .merge_file_n4m0Uk
 *
=======
>>>>>>> .merge_file_hUvpcS
 * @contract docs/contracts/class-get-filename-by-classname-action.md
 */
class GetFilenameByClassnameAction
{
    use QueueableAction;

    public function execute(string $class_name): string
    {
        $filename = null;
        try {
            if (class_exists($class_name)) {
                $reflector = new \ReflectionClass($class_name);
                $filename = $reflector->getFileName();
            }
        } catch (\Exception $e) {
            $filename = str_replace('\\', '/', $class_name);
            $filename = base_path($filename).'.php';
        }

        if (is_string($filename)) {
            return $filename;
        }
        throw new \Exception('['.__LINE__.']['.class_basename($this).']['.$class_name.']');
    }
}
