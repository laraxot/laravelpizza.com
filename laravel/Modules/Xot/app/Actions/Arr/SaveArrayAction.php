<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Arr;

use InvalidArgumentException;
use Spatie\QueueableAction\QueueableAction;

class SaveArrayAction
{
    use QueueableAction;

    public function execute(array $data, string $filename, string $format = 'php'): bool
    {
        return match ($format) {
            'json' => app(SaveJsonArrayAction::class)->execute($data, $filename),
            'php' => app(SavePhpArrayAction::class)->execute($data, $filename),
            default => throw new InvalidArgumentException("Formato non supportato: {$format}"),
        };
    }
}
