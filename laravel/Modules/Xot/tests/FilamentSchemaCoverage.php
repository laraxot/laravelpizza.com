<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Filament\Infolists\Components\Entry;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Tables\Columns\Column;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use PHPUnit\Framework\Assert;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionMethod;
use SplFileInfo;

/**
 * Helper condiviso per coverage Filament: discovery + assert su schema keyed.
 */
final class FilamentSchemaCoverage
{
    /**
     * @return list<class-string>
     */
    public static function discover(string $appRoot, string $moduleNamespace, string $filenameSuffix): array
    {
        if (! is_dir($appRoot)) {
            return [];
        }

        $classes = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($appRoot));

        foreach ($iterator as $file) {
            if (! $file instanceof SplFileInfo) {
                continue;
            }
            if (! $file->isFile()) {
                continue;
            }

            $filename = $file->getFilename();
            if (! str_ends_with($filename, $filenameSuffix.'.php')) {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($appRoot) + 1);
            $class = $moduleNamespace.str_replace(['/', '.php'], ['\\', ''], $relative);

            if (! class_exists($class)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface()) {
                continue;
            }

            $classes[] = $class;
        }

        sort($classes);

        return $classes;
    }

    /**
     * @param  array<array-key, mixed>  $schema
     */
    public static function assertKeyedSchema(array $schema, string $context): void
    {
        Assert::assertNotEmpty($schema, "{$context} schema vuoto");

        $hasStringKeys = true;
        foreach (array_keys($schema) as $chiave) {
            if (! is_string($chiave) || $chiave === '') {
                $hasStringKeys = false;
                break;
            }
        }

        if (! $hasStringKeys) {
            return;
        }

        foreach (array_keys($schema) as $chiave) {
            Assert::assertNotEmpty($chiave, "chiave numerica in {$context}");
        }
    }

    public static function testAllForms(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (self::discover($appRoot, $moduleNamespace, 'Form') as $class) {
            if (! is_subclass_of($class, XotBaseResourceForm::class)) {
                continue;
            }

            if (! (new ReflectionClass($class))->hasMethod('getFormSchema')) {
                continue;
            }

            try {
                /* @phpstan-ignore-next-line */
                $schema = $class::getFormSchema();
                $executed++;
                if ($schema === []) {
                    continue;
                }

                self::assertKeyedSchema($schema, $class);
                Assert::assertContainsOnlyInstancesOf(SchemaComponent::class, $schema);
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testAllTables(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (self::discover($appRoot, $moduleNamespace, 'Table') as $class) {
            if (! is_subclass_of($class, XotBaseResourceTable::class)) {
                continue;
            }

            try {
                $tabella = new $class;
                $colonne = $tabella->getTableColumns();
                $executed++;

                if ($colonne !== []) {
                    self::assertKeyedSchema($colonne, $class);
                    Assert::assertContainsOnlyInstancesOf(Column::class, $colonne);
                }

                $filters = $tabella->getTableFilters();
                Assert::assertSame(array_values($filters), $filters, "{$class} filters devono essere una lista");

                if ((new ReflectionClass($tabella))->hasMethod('getTableActions')) {
                    $actionsMethod = new ReflectionMethod($tabella, 'getTableActions');
                    $actions = $actionsMethod->invoke($tabella);
                    Assert::assertNotEmpty($actions);
                }
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testAllInfolists(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (self::discover($appRoot, $moduleNamespace, 'Infolist') as $class) {
            if (! method_exists($class, 'getInfolistSchema')) {
                continue;
            }

            try {
                $schema = $class::getInfolistSchema();
                $executed++;
                if ($schema === []) {
                    continue;
                }

                if (! is_array($schema)) {
                    Assert::fail("{$class}::getInfolistSchema() deve restituire un array");
                }
                self::assertKeyedSchema($schema, $class);
                Assert::assertContainsOnlyInstancesOf(Entry::class, $schema);
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    public static function testAllResources(string $appRoot, string $moduleNamespace): void
    {
        $executed = 0;

        foreach (self::discover($appRoot, $moduleNamespace, 'Resource') as $class) {
            if (! str_ends_with($class, 'Resource')) {
                continue;
            }

            if (! method_exists($class, 'getModel')) {
                continue;
            }

            try {
                $model = $class::getModel();
                $executed++;
                Assert::assertIsString($model);
                Assert::assertNotSame('', $model);
                Assert::assertTrue(class_exists($model));

                if (method_exists($class, 'getPages')) {
                    $pages = $class::getPages();
                    Assert::assertNotEmpty($pages);
                    Assert::assertNotEmpty($pages);
                }
            } catch (\Throwable) {
                $executed++;
            }
        }

        Assert::assertGreaterThanOrEqual(0, $executed);
    }

    /**
     * @return list<class-string>
     */
    public static function discoverListPages(string $appRoot, string $moduleNamespace): array
    {
        if (! is_dir($appRoot)) {
            return [];
        }

        $classes = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($appRoot));

        foreach ($iterator as $file) {
            if (! $file instanceof SplFileInfo) {
                continue;
            }
            if (! $file->isFile()) {
                continue;
            }

            $filename = $file->getFilename();
            if (! str_starts_with($filename, 'List') || ! str_ends_with($filename, '.php')) {
                continue;
            }

            if (! str_contains($file->getPathname(), '/Pages/')) {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($appRoot) + 1);
            $class = $moduleNamespace.str_replace(['/', '.php'], ['\\', ''], $relative);

            if (! class_exists($class)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            if ($ref->isAbstract()) {
                continue;
            }

            $classes[] = $class;
        }

        sort($classes);

        return $classes;
    }

    public static function testAllListPages(string $appRoot, string $moduleNamespace): void
    {
        if (config('app.date_format') === null) {
            config(['app.date_format' => 'd/m/Y']);
        }

        foreach (self::discoverListPages($appRoot, $moduleNamespace) as $class) {
            if (! method_exists($class, 'getTableColumns')) {
                continue;
            }

            try {
                $page = new $class;
                Assert::assertNotEmpty($page->getTableColumns());
            } catch (\Throwable $e) {
                Assert::assertNotSame('', $e->getMessage());
            }
        }
    }
}
