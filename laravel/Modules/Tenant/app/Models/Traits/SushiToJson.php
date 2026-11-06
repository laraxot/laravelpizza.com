<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Json\CreateJsonFileByRecordAction;
use Modules\Tenant\Actions\Json\DeleteJsonFileByRecordAction;
use Modules\Tenant\Actions\Json\UpdateJsonFileByRecordAction;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Sushi\Sushi;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Trait SushiToJson.
 *
 * Questo trait permette ai modelli di utilizzare il pacchetto Sushi per leggere
 * dati da file JSON con isolamento per tenant. Ogni tenant ha i propri file JSON
 * nella directory config/{tenant_name}/database/content/.
 *
 * @see https://github.com/calebporzio/sushi
 */
trait SushiToJson
{
    use Sushi {
        getSchema as protected sushiGetSchema;
    }
    use SushiConnectionByName;

    /**
     * @return array<string, string>
     */
    public function getSchema(): array
    {
        $schema = $this->sushiGetSchema();
        Assert::isArray($schema);

        /** @var array<string, string> $schema */
        return $schema;
    }

    /**
     * @return array<string, mixed>
     */
    public function loadExistingData(): array
    {
        $path = $this->getJsonFile();

        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        $data = json_decode($content, true);
        Assert::isArray($data);

        /** @var array<string, mixed> $data */
        return $data;
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $data
     */
    public function saveToJson(array $data): bool
    {
        $path = $this->getJsonFile();

        File::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return true;
    }

    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     * Il file è specifico per il tenant corrente e la tabella del modello.
     *
     * @return string Percorso completo del file JSON
     */
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();

        return app(GetTenantFilePathAction::class)->execute('database/content/'.$tbl.'.json');
    }

    /**
     * Metodo richiesto da Sushi per popolare la tabella in-memory.
     * Delegato a getSushiRows() per mantenere separazione semantica.
     *
     * @return array<array-key, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $path = $this->getJsonFile();
        // Tabella vuota, non errore, finche' il file JSON del tenant non esiste: e' il caso del
        // primo avvio e dei test (`SushiToJsonTraitPestTest` "returns empty rows when json file is missing").
        if (! File::exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);
        if (! \is_array($data)) {
            throw new Exception('Data is not array ['.$path.']');
        }

        /** @var array<int|string, array<string, mixed>> $data */
        $schema = $this->getSchema();

        $res = app(EnsureKeysAction::class)->execute($data, array_keys($schema));

        // La tabella in-memory di Sushi non salva array: i valori annidati diventano stringhe JSON.
        return array_map(
            static fn (array $row): array => array_map(
                static fn (mixed $value): mixed => \is_array($value) || \is_object($value) ? json_encode($value) : $value,
                $row,
            ),
            array_values($res),
        );
    }

    protected function sushiShouldCache(): bool
    {
        return false;
    }

    /**
     * Boot method per il trait SushiToJson.
     * Gestisce gli eventi di creazione, aggiornamento e cancellazione
     * per sincronizzare automaticamente i dati con i file JSON.
     *
     * I modelli Sushi read-only (che usano il trait solo per leggere il JSON)
     * non implementano HasSushiToJson: su di loro la sincronizzazione non deve
     * essere registrata, altrimenti le callback riceverebbero un tipo non
     * conforme al contratto e il listener fallirebbe con TypeError.
     */
    protected static function bootSushiToJson(): void
    {
        static::creating(static function (Model $record): void {
            if (! $record instanceof HasSushiToJson) {
                return;
            }
            app(CreateJsonFileByRecordAction::class)->execute($record);
        });

        static::updating(static function (Model $record): void {
            if (! $record instanceof HasSushiToJson) {
                return;
            }
            app(UpdateJsonFileByRecordAction::class)->execute($record);
        });

        static::deleting(static function (Model $record): void {
            if (! $record instanceof HasSushiToJson) {
                return;
            }
            app(DeleteJsonFileByRecordAction::class)->execute($record);
        });
    }
}
