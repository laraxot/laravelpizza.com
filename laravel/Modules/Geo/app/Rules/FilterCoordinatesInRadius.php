<?php

declare(strict_types=1);

namespace Modules\Geo\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;

/**
 * Regola di validazione per filtrare le coordinate all'interno di un raggio.
 */
class FilterCoordinatesInRadius implements Rule
{
    private string $message = '';

    public function __construct(
        private readonly FilterCoordinatesInRadiusAction $filterAction,
        private readonly float $centerLatitude,
        private readonly float $centerLongitude,
        private readonly int $radius,
    ) {}

    /**
     * Determina se le coordinate passate sono all'interno del raggio specificato.
     *
     * @param  mixed  $_attribute  Nome dell'attributo
     * @param  mixed  $value  Valore da validare
     */
    public function passes(mixed $_attribute, mixed $value): bool
    {
        // Convert to string for internal use
        $_attribute = (string) $_attribute;

        if (! \is_array($value)) {
            $this->message = 'Il valore deve essere un array di coordinate';

            return false;
        }

        /** @var array<array{latitude: string, longitude: string}> $coordinates */
        $coordinates = array_map(static function ($coordinate): array {
            if (! \is_array($coordinate)) {
                return ['latitude' => '', 'longitude' => ''];
            }

            $latitude = $coordinate['latitude'] ?? null;
            $longitude = $coordinate['longitude'] ?? null;

            return [
                'latitude' => \is_scalar($latitude) ? ((string) $latitude) : '',
                'longitude' => \is_scalar($longitude) ? ((string) $longitude) : '',
            ];
        }, $value);

        $filteredCoordinates = $this->filterAction->execute(
            $this->centerLatitude,
            $this->centerLongitude,
            $coordinates,
            $this->radius,
        );

        return \count($filteredCoordinates) > 0;
    }

    /**
     * Ottiene il messaggio di errore per la validazione fallita.
     */
    public function message(): string
    {
        return $this->message ?: 'Nessuna coordinata trovata nel raggio specificato';
    }
}
