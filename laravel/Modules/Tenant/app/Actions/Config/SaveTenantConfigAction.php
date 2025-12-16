<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;

class SaveTenantConfigAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(string $name, array $data): void
    {
        $path = app(GetTenantFilePathAction::class)->execute($name.'.php');

        $configData = [];
        if (File::exists($path)) {
            /** @var mixed $existing */
            $existing = File::getRequire($path);
            if (\is_array($existing)) {
                /** @var array<string, mixed> $existingArray */
                $existingArray = $existing;
                $configData = $existingArray;
            }
        }

        /** @var array<string, mixed> $dataToMerge */
        $dataToMerge = $data;

        $configData = $this->arrayMergeRecursiveDistinct($configData, $dataToMerge);
        $configData = Arr::sortRecursive($configData);

        app(SaveArrayAction::class)->execute(
            data: $configData,
            filename: $path,
        );
    }

    /**
     * @param array<string, mixed> $array1
     * @param array<string, mixed> $array2
     *
     * @return array<string, mixed>
     */
    private function arrayMergeRecursiveDistinct(array $array1, array $array2): array
    {
        $merged = $array1;

        foreach ($array2 as $key => $value) {
            if (array_key_exists($key, $merged) && is_array($merged[$key]) && is_array($value)) {
                /** @var array<string, mixed> $left */
                $left = $merged[$key];
                /** @var array<string, mixed> $right */
                $right = $value;

                $merged[$key] = $this->arrayMergeRecursiveDistinct($left, $right);

                continue;
            }

            $merged[$key] = $value;
        }

        return $merged;
    }
}


