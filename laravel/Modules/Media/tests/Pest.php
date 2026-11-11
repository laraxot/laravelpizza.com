<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Media\Database\Factories\MediaFactory;
use Modules\Media\Models\Media;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * Bootstrap Pest — modulo Media.
 * Ogni file test dichiara uses(\Modules\Media\Tests\TestCase::class).
 * Vietato pest()->extend() e pest()->uses() qui (PHPStan method.internalClass).
 */

/**
 * @param  array<string, mixed>  $where
 */
function assertMediaTableHas(string $table, array $where, string $connection = 'media'): void
{
    $query = DB::connection($connection)->table($table);

    foreach ($where as $column => $value) {
        $query->where((string) $column, $value);
    }

    Assert::assertTrue($query->exists());
}

/**
 * @param  array<string, mixed>  $where
 */
function assertMediaTableMissing(string $table, array $where, string $connection = 'media'): void
{
    $query = DB::connection($connection)->table($table);

    foreach ($where as $column => $value) {
        $query->where((string) $column, $value);
    }

    Assert::assertFalse($query->exists());
}

/**
 * @template T of object
 *
 * @param  ReflectionClass<T>  $reflection
 */
function assertMediaReflectionFilename(ReflectionClass $reflection): string
{
    $filename = $reflection->getFileName();
    Assert::assertNotFalse($filename);

    return $filename;
}

/**
 * @template T of object
 *
 * @param  ReflectionClass<T>  $reflection
 */
function mediaReflectionSource(ReflectionClass $reflection): string
{
    return file_get_contents(assertMediaReflectionFilename($reflection));
}

/**
 * @param  list<string>  $haystack
 */
function assertMediaListContains(string $needle, array $haystack): void
{
    Assert::assertTrue(in_array($needle, $haystack, true));
}

/**
 * @param  array<string, mixed>  $attributes
 */
function createMedia(array $attributes = []): Media
{
    return MediaFactory::new()->createOne($attributes);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function makeMedia(array $attributes = []): Media
{
    return MediaFactory::new()->makeOne($attributes);
}

/**
 * Colonne tabella media per test (list tipizzata per PHPStan).
 *
 * @return array<int, string>
 */
function mediaTableColumns(): array
{
    $columns = Schema::getColumnListing('media');

    return array_values(array_filter(
        $columns,
        static fn (mixed $column): bool => is_string($column) && $column !== '',
    ));
}

/**
 * @param  array<string, mixed>  $payload
 * @param  array<int, string>  $columns
 * @return array<string, mixed>
 */
function mediaPayloadSet(array $payload, array $columns, string $column, mixed $value): array
{
    if (in_array($column, $columns, true)) {
        $payload[$column] = $value;
    }

    return $payload;
}

/**
 * @param  class-string  $class
 */
function assertMediaUsesQueueableAction(string $class): void
{
    assertMediaListContains(
        'Spatie\QueueableAction\QueueableAction',
        (new ReflectionClass($class))->getTraitNames(),
    );
}

/**
 * @param  class-string  $class
 */
function assertMediaDeclaresStrictTypes(string $class): void
{
    $content = mediaReflectionSource(new ReflectionClass($class));
    Assert::assertStringContainsString('declare(strict_types=1);', $content);
}
