<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggiunge al file JSON del tenant la riga corrispondente al record in creazione.
 *
 * L'id non viene assegnato dal database (Sushi usa SQLite in memoria): il
 * record riceve `max(id esistenti) + 1`. Lo `0` iniziale copre il file
 * vuoto, dove `max()` su array senza elementi leverebbe una ValueError.
 */
class CreateJsonFileByRecordAction
{
    use QueueableAction;

    public function execute(Model&HasSushiToJson $record): void
    {
        $rows = $record->getRows();

        $record->setAttribute('created_at', now());
        $record->setAttribute('updated_at', now());

        $keyName = $record->getKeyName();

        // Gli id letti dal JSON possono essere stringhe numeriche ('1'): SafeIntCastAction li porta a int.
        $ids = array_map(SafeIntCastAction::cast(...), Arr::pluck($rows, $keyName));

        $newId = max([0, ...$ids]) + 1;

        $record->setAttribute($keyName, $newId);

        $rows[$newId] = $record->toArray();
        $rows = app(EnsureKeysAction::class)->execute($rows, array_keys($record->getSchema()));

        $rows = array_values($rows);
        $filename = $record->getJsonFile();
        app(SaveArrayAction::class)->execute($rows, $filename, 'json');
    }
}
