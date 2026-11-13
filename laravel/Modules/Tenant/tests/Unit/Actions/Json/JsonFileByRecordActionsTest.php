<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction;
use Modules\Tenant\Actions\Json\UpdateJsonFileByRecordAction;
use Modules\Tenant\Tests\Fixtures\TestSushiModelForPath;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

/*
 * Le action scrivono il file JSON del tenant quando un modello Sushi viene creato o aggiornato.
 * Qui si chiamano direttamente su un file temporaneo: nessun salvataggio del modello, nessun DB.
 */

function tenantJsonActionTempFile(string $json): string
{
    $dir = sys_get_temp_dir().'/tenant_json_action_'.uniqid('', true);
    File::ensureDirectoryExists($dir);
    $path = $dir.'/rows.json';
    File::put($path, $json);

    return $path;
}

/**
 * @return array<int|string, mixed>
 */
function tenantJsonActionNamesById(string $path): array
{
    $rows = json_decode(File::get($path), true);
    Assert::assertIsArray($rows);

    return array_column($rows, 'name', 'id');
}

test('create assegna max(id) + 1 anche quando il JSON ha gli id come stringhe numeriche', function (): void {
    $path = tenantJsonActionTempFile('[{"id":"1","name":"Alpha"},{"id":"7","name":"Beta"},{"id":"3","name":"Gamma"}]');

    try {
        $record = (new TestSushiModelForPath(['name' => 'Delta']))->setJsonPath($path);

        app(CreateJsonFileByRecordAction::class)->execute($record);

        Assert::assertSame(8, $record->getKey());
        Assert::assertSame(
            [
                1 => 'Alpha',
                7 => 'Beta',
                3 => 'Gamma',
                8 => 'Delta',
            ],
            tenantJsonActionNamesById($path),
        );
    } finally {
        File::deleteDirectory(dirname($path));
    }
});

test('create assegna id 1 quando il file JSON non ha righe', function (): void {
    $path = tenantJsonActionTempFile('[]');

    try {
        $record = (new TestSushiModelForPath(['name' => 'Primo']))->setJsonPath($path);

        app(CreateJsonFileByRecordAction::class)->execute($record);

        Assert::assertSame(1, $record->getKey());
        Assert::assertSame([1 => 'Primo'], tenantJsonActionNamesById($path));
    } finally {
        File::deleteDirectory(dirname($path));
    }
});

test('update sostituisce solo la riga con la stessa chiave primaria', function (): void {
    $path = tenantJsonActionTempFile('[{"id":1,"name":"Alpha"},{"id":2,"name":"Beta"}]');

    try {
        $record = (new TestSushiModelForPath)->setJsonPath($path);
        $record->forceFill([
            'id' => 2,
            'name' => 'Beta aggiornato',
        ]);

        app(UpdateJsonFileByRecordAction::class)->execute($record);

        Assert::assertSame(
            [
                1 => 'Alpha',
                2 => 'Beta aggiornato',
            ],
            tenantJsonActionNamesById($path),
        );
    } finally {
        File::deleteDirectory(dirname($path));
    }
});
