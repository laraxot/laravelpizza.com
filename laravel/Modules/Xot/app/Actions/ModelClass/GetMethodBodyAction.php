<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\ModelClass;

use ReflectionClass;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\file;

class GetMethodBodyAction
{
    use QueueableAction;

    public function execute(string $class_name, string $method_name): string
    {
        Assert::classExists($class_name);
        $reflection_class = new ReflectionClass($class_name);
        $table_method = $reflection_class->getMethod($method_name);
        $start_line = $table_method->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
        $end_line = $table_method->getEndLine();
        $length = $end_line - $start_line;
        Assert::string($file_name = $table_method->getFileName());
        $source = file($file_name);

        return implode('', \array_slice($source, $start_line, $length));
    }
}
