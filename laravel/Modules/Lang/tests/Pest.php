<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\Lang\Actions\ReadTranslationFileAction;
use Modules\Lang\Database\Factories\TranslationFactory;
use Modules\Lang\Models\BaseModel;
use Modules\Lang\Models\Translation;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\unlink;

/** @param array<string, mixed> $attributes */
function createTranslation(array $attributes = []): Translation
{
    return TranslationFactory::new()->createOne($attributes);
}
/** @param array<string, mixed> $attributes */
function makeTranslation(array $attributes = []): Translation
{
    $translation = TranslationFactory::new()->make($attributes);
    if (! $translation instanceof Translation) {
        throw new InvalidArgumentException('Expected Translation model from factory make().');
    }

    return $translation;
}

/** @param array<string, mixed> $translations */
function createTranslationFile(string $filePath, array $translations): void
{
    file_put_contents($filePath, "<?php\n\nreturn ".var_export($translations, true).";\n");
}

function cleanupTranslationFile(string $filePath): void
{
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

/** @param array<string, mixed> $data */
function langAssertDatabaseHasRow(string $table, array $data, ?string $connection = 'lang'): void
{
    $query = DB::connection($connection)->table($table);

    foreach ($data as $column => $value) {
        $query->where((string) $column, $value);
    }

    Assert::assertTrue($query->exists());
}

function makeLangBaseModel(): BaseModel
{
    return new class extends BaseModel
    {
        protected $table = 'test_lang_table';
    };
}

function makeLangServiceProvider(): Modules\Lang\Providers\LangServiceProvider
{
    return Modules\Lang\Tests\TestCase::makeLangServiceProvider();
}

/** @return array<string, mixed> */
function defaultReadTranslationTestData(): array
{
    return [
        'auth' => [
            'failed' => 'These credentials do not match our records.',
            'password' => 'The provided password is incorrect.',
        ],
        'pagination' => [
            'previous' => '&laquo; Previous',
            'next' => 'Next &raquo;',
        ],
    ];
}

function readTranslationTestFilePath(): string
{
    return sys_get_temp_dir().'/test_translations.php';
}

function makeReadTranslationFileAction(): ReadTranslationFileAction
{
    return new ReadTranslationFileAction;
}

