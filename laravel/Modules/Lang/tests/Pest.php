<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\Lang\Database\Factories\TranslationFactory;
use Modules\Lang\Models\Translation;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\unlink;

/*
 * Bootstrap Pest — modulo Lang.
 * Ogni file test dichiara uses(\Modules\Lang\Tests\TestCase::class) se serve binding.
 * Vietato pest()->extend() / expect()->extend() qui (PHPStan method.internalClass).
 */

/**
 * @param array<string, mixed> $attributes
 */
function createTranslation(array $attributes = []): Translation
{
    return TranslationFactory::new()->createOne($attributes);
}

/**
 * @param array<string, mixed> $attributes
 */
function makeTranslation(array $attributes = []): Translation
{
    $translation = TranslationFactory::new()->make($attributes);
    if (! $translation instanceof Translation) {
        throw new InvalidArgumentException('Expected Translation model from factory make().');
    }

    return $translation;
}

/**
 * @param array<string, mixed> $translations
 */
function createTranslationFile(string $filePath, array $translations): void
{
    $phpContent = "<?php\n\nreturn ".var_export($translations, true).";\n";
    file_put_contents($filePath, $phpContent);
}

function cleanupTranslationFile(string $filePath): void
{
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

/**
 * @param array<string, mixed> $data
 */
function langAssertDatabaseHasRow(string $table, array $data, ?string $connection = 'lang'): void
{
    $query = DB::connection($connection)->table($table);

    foreach ($data as $column => $value) {
        $query->where((string) $column, $value);
    }

    Assert::assertTrue($query->exists());
}
