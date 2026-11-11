<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;

/**
 * Carica e valida il file JSON dei dati geografici (regioni/province/città).
 */
class LoadGeoDataAction
{
    use QueueableAction;

    /**
     * @return Collection<int, array<string, mixed>>
     *
     * @throws \RuntimeException
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
