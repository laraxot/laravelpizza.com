<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Tenant\Tests\TestCase;

use function Safe\file_put_contents;
use function Safe\tempnam;
use function Safe\unlink;

uses(TestCase::class);

/*
 * I file JSON dei modelli Sushi salvano gli id come stringhe ("4"): l'id successivo va calcolato
 * sul valore numerico, altrimenti ogni nuovo record falliva (es. conteggi del menu del pannello).
 */
it('computes the next id when stored ids are strings', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'sushi').'.json';
    file_put_contents($file, '[]');

    $record = new class() extends Model implements HasSushiToJson
    {
        public static string $file = '';

        protected $guarded = [];

        public function getRows(): array
        {
            return [['id' => '4', 'name' => 'a'], ['id' => '11', 'name' => 'b'], ['id' => 'x', 'name' => 'c']];
        }

        public function getJsonFile(): string
        {
            return self::$file;
        }

        public function getSchema(): array
        {
            return ['id' => 'integer', 'name' => 'string'];
        }
    };
    $record::$file = $file;
    $record->setAttribute('name', 'nuovo');

    app(CreateJsonFileByRecordAction::class)->execute($record);

    expect($record->getKey())->toBe(12);
    unlink($file);
})->group('TENANT-JSON-CREATE-INV-1');
