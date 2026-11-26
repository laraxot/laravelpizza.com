<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Helpers;

/**
 * Helper condivisi per sweep coverage UI (evita redeclare tra file Pest).
 * Non finge classi Cms: una finta con il nome sbagliato nasconde il rename (vedi
 * Modules/UI/docs/adr/0004-optional-cms-delegation-for-block-data.md).
 */
final class UiCoverageMissHelpers
{
    public static function prop(object $target, string $name): mixed
    {
        $ref = new \ReflectionClass($target);
        while ($ref !== false) {
            if ($ref->hasProperty($name)) {
                $prop = $ref->getProperty($name);
                $prop->setAccessible(true);

                return $prop->getValue($target);
            }
            $ref = $ref->getParentClass();
        }

        return null;
    }

    public static function set(object $target, string $name, mixed $value): void
    {
        $ref = new \ReflectionClass($target);
        while ($ref !== false) {
            if ($ref->hasProperty($name)) {
                $prop = $ref->getProperty($name);
                $prop->setAccessible(true);
                try {
                    $prop->setValue($target, $value);
                } catch (\Throwable) {
                }

                return;
            }
            $ref = $ref->getParentClass();
        }
    }
}
