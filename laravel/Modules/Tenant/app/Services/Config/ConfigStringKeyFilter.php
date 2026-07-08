<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config;

final class ConfigStringKeyFilter
{
    /**
     * @param  array<string, mixed>  $config
     * @return array<string, mixed>
     */
    public static function onlyStringKeys(array $config): array
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

    /**
     * @param  array<string, mixed>  ...$configs
     * @return array<string, mixed>
     */
    public static function mergeRecursive(array ...$configs): array
    {
        /** @var array<string, mixed> $merged */
        $merged = [];

        foreach ($configs as $config) {
            $merged = array_replace_recursive($merged, self::onlyStringKeys($config));
        }

        /** @var array<string, mixed> $merged */
        return self::onlyStringKeys($merged);
    }
}
