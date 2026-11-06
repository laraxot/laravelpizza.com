<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Spatie\QueueableAction\QueueableAction;

final class FilterConfigStringKeysAction
{
    use QueueableAction;

    /**
     * @param  array<mixed, mixed>  $config
     * @return array<string, mixed>
     */
    public function execute(array $config): array
    {
        /** @var array<string, mixed> $result */
        $result = [];

        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
