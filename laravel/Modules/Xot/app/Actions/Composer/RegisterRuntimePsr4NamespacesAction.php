<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Composer;

use Composer\Autoload\ClassLoader;

/**
 * Registra PSR-4 fuori dal root composer.json (temi e seeders legacy app-level).
 *
 * Il root skeleton mantiene solo App\\ e Tests\\; i namespace qui non devono
 * comparire in laravel/composer.json.
 */
final class RegisterRuntimePsr4NamespacesAction
{
    /**
     * @return array<string, string|list<string>>
     */
    public static function namespaces(): array
    {
        $base = base_path();

        return [
            'Themes\\TwentyOne\\' => $base.'/Themes/TwentyOne/app',
            'Themes\\Sixteen\\' => $base.'/Themes/Sixteen/app',
            'Themes\\Sixteen\\Tests\\' => $base.'/Themes/Sixteen/tests',
            'Themes\\Two\\' => $base.'/Themes/Two/app',
            'Database\\Seeders\\' => $base.'/database/seeders',
        ];
    }

    public function execute(ClassLoader $loader): void
    {
        foreach (self::namespaces() as $prefix => $paths) {
            $pathList = is_array($paths) ? $paths : [$paths];

            foreach ($pathList as $path) {
                if (is_dir($path)) {
                    $loader->addPsr4($prefix, $path);
                }
            }
        }
    }
}
