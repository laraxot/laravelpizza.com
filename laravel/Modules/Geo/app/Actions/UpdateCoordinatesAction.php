<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Modules\Geo\Models\Place;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per aggiornare le coordinate di un luogo.
 */
class UpdateCoordinatesAction
{
    use QueueableAction;

    /**
     * Aggiorna le coordinate di un luogo usando il suo indirizzo.
     *
     * @throws \RuntimeException Se non è possibile ottenere le coordinate
     */
    public function execute(Place $place): void
    {
        if (! $place->address || ! is_string($place->address->formatted_address)) {
            throw new \RuntimeException('Place address is required');
        }

        $location = app(GetCoordinatesAction::class)->execute($place->address->formatted_address);

        if (! $location) {
            throw new \RuntimeException('Could not get coordinates for address: '.$place->address->formatted_address);
        }

        $place->update([
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ]);
    }
}
