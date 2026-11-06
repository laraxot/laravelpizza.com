<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;

use function Safe\json_decode;

use Spatie\QueueableAction\QueueableAction;

/**
 * Carica e valida il file JSON dei dati geografici (regioni/province/città).
 */
class LoadGeoDataAction
{
    use QueueableAction;

    /**
     * @throws \RuntimeException
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function execute(): Collection
    {
        if (! File::exists(base_path(GeoDataConfig::JSON_PATH))) {
            throw new \RuntimeException('Il file JSON dei comuni non esiste');
        }

        /** @var array<string, mixed> $data */
        $data = json_decode(File::get(base_path(GeoDataConfig::JSON_PATH)), true);

        if (! \is_array($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! app(CheckGeoDataIntegrityAction::class)->execute($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! isset($data['regions']) || ! \is_array($data['regions'])) {
            throw new \RuntimeException('Regioni mancanti nel file JSON');
        }

        /** @var array<int, array<string, mixed>> $regions */
        $regions = $data['regions'];

        /** @var Collection<int, array<string, mixed>> $result */
        $result = (new Collection($regions))->values();

        return $result;
    }
}
