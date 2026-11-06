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
 * Sincronizza sul file JSON la riga corrispondente al record in aggiornamento.
 *
 * Chiavizza le righe sulla colonna primaria come `DeleteJsonFileByRecordAction`,
 * cosi' la stessa coppia `($keyName, $key)` identifica la riga da sostituire
 * in scrittura e da rimuovere in cancellazione.
 */
class UpdateJsonFileByRecordAction
{
    use QueueableAction;

    public function execute(Model&HasSushiToJson $record): void
    {
        $rows = $record->getRows();

        $record->setAttribute('updated_at', now());

        $keyName = $record->getKeyName();
        // La chiave puo' essere un UUID oltre che un intero: bool e float invece non sono chiavi di array valide.
        $key = Assert::validArrayKey($record->getKey());

        /** @var array<int|string, array<string, mixed>> $keyed */
        $keyed = Arr::keyBy($rows, $keyName);

        $keyed[$key] = $record->toArray();

        $keyed = app(EnsureKeysAction::class)->execute(
            $keyed,
            array_keys($record->getSchema())
        );

        $keyed = array_values($keyed);
        $filename = $record->getJsonFile();

        app(SaveArrayAction::class)->execute($keyed, $filename, 'json');
    }
}
