<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Spatie\QueueableAction\QueueableAction;

use function Safe\file_get_contents;
use function Safe\preg_match;

/**
 * @see docs/contracts/get-class-name-by-path-action.md
<<<<<<< .merge_file_4tB6GW
 *
=======
>>>>>>> .merge_file_awq8Kp
 * @contract docs/contracts/get-class-name-by-path-action.md
 */
class GetClassNameByPathAction
{
    use QueueableAction;

    public function execute(string $path): string
    {
        $content = file_get_contents($path);

        preg_match('/namespace\s+(.+);/', $content, $namespaceMatch);
        preg_match('/class\s+(\w+)/', $content, $classMatch);

        $namespace = $namespaceMatch[1] ?? '';
        $className = $classMatch[1] ?? '';

        return $namespace ? ($namespace.'\\'.$className) : $className;
    }
}

/*
 * $class = Str::of($path)
 * ->after(base_path('Modules'))
 * ->prepend('\Modules')
 * ->before('.php')
 * ->replace('/', '\\')
 * ->toString();
 */
