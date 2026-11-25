<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Helpers;

/**
 * Helper condivisi per sweep coverage UI (evita redeclare tra file Pest).
 * Cms opzionale in PTVX: stub via FQCN stringa in ensureCmsStub(), mai import Cms.
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

    public static function ensureCmsStub(): void
    {
        $fqcn = 'Modules\\Cms\\Actions\\GetLocalizedBlockDataAction';
        if (class_exists($fqcn, false)) {
            return;
        }

        eval(<<<'PHP'
namespace Modules\Cms\Actions;
class GetLocalizedBlockDataAction
{
    /** @var callable|null */
    public static $handler = null;
    public function execute(array $viewParams): array|string
    {
        if (is_callable(self::$handler)) {
            return (self::$handler)($viewParams);
        }
        // Default: pass-through (non rompere altri test ResolveLocalized)
        return $viewParams;
    }
}
PHP);
    }
}
