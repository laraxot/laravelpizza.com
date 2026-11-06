<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Rimuove dal file JSON la riga corrispondente al record in cancellazione.
 *
 * `getRows()` restituisce righe indicizzate per posizione, quindi la chiave va
 * recuperata da `Arr::keyBy()` sulla colonna primaria: e' la stessa coppia
 * `($keyName, $key)` che `UpdateJsonFileByRecordAction` usa per riscrivere la riga.
 */
class DeleteJsonFileByRecordAction
{
    use QueueableAction;

    public function execute(Model&HasSushiToJson $record): void
    {
        $rows = $record->getRows();

        $keyName = $record->getKeyName();
        $key = $record->getKey();

        Assert::integer($key);

        /** @var array<int|string, array<string, mixed>> $keyed */
        $keyed = Arr::keyBy($rows, $keyName);

        Arr::forget($keyed, $key);

        $keyed = app(EnsureKeysAction::class)->execute(
            $keyed,
            array_keys($record->getSchema())
        );

        $keyed = array_values($keyed);
        $filename = $record->getJsonFile();

        app(SaveArrayAction::class)->execute($keyed, $filename, 'json');
    }
}
