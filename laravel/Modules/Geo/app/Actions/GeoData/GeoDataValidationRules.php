<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Spatie\QueueableAction\QueueableAction;

/**
 * Regole condivise per la validazione del JSON comuni.
 */
final class GeoDataValidationRules
{
    use QueueableAction;

    /** @var array<string, string> */
    public const array RULES = [
        'regions' => 'required|array',
        'regions.*.name' => 'required|string',
        'regions.*.code' => 'required|string|size:2',
        'regions.*.provinces' => 'required|array',
        'regions.*.provinces.*.name' => 'required|string',
        'regions.*.provinces.*.code' => 'required|string|size:2',
        'regions.*.provinces.*.cities' => 'required|array',
        'regions.*.provinces.*.cities.*.name' => 'required|string',
        'regions.*.provinces.*.cities.*.code' => 'required|string',
        'regions.*.provinces.*.cities.*.cap' => 'required|string|size:5',
    ];

    /** @var array<string, string> */
    public const array MESSAGES = [
        'regions.required' => 'Il file JSON deve contenere un array di regioni',
        'regions.array' => 'Le regioni devono essere un array',
        'regions.*.name.required' => 'Ogni regione deve avere un nome',
        'regions.*.name.string' => 'Il nome della regione deve essere una stringa',
        'regions.*.code.required' => 'Ogni regione deve avere un codice',
        'regions.*.code.string' => 'Il codice della regione deve essere una stringa',
        'regions.*.code.size' => 'Il codice della regione deve essere di 2 caratteri',
        'regions.*.provinces.required' => 'Ogni regione deve avere un array di province',
        'regions.*.provinces.array' => 'Le province devono essere un array',
        'regions.*.provinces.*.name.required' => 'Ogni provincia deve avere un nome',
        'regions.*.provinces.*.name.string' => 'Il nome della provincia deve essere una stringa',
        'regions.*.provinces.*.code.required' => 'Ogni provincia deve avere un codice',
        'regions.*.provinces.*.code.string' => 'Il codice della provincia deve essere una stringa',
        'regions.*.provinces.*.code.size' => 'Il codice della provincia deve essere di 2 caratteri',
        'regions.*.provinces.*.cities.required' => 'Ogni provincia deve avere un array di città',
        'regions.*.provinces.*.cities.array' => 'Le città devono essere un array',
        'regions.*.provinces.*.cities.*.name.required' => 'Ogni città deve avere un nome',
        'regions.*.provinces.*.cities.*.name.string' => 'Il nome della città deve essere una stringa',
        'regions.*.provinces.*.cities.*.code.required' => 'Ogni città deve avere un codice',
        'regions.*.provinces.*.cities.*.code.string' => 'Il codice della città deve essere una stringa',
        'regions.*.provinces.*.cities.*.cap.required' => 'Ogni città deve avere un CAP',
        'regions.*.provinces.*.cities.*.cap.string' => 'Il CAP deve essere una stringa',
        'regions.*.provinces.*.cities.*.cap.size' => 'Il CAP deve essere di 5 caratteri',
    ];

    /**
     * @return array{rules: array<string, string>, messages: array<string, string>}
     */
    public function execute(): array
    {
        return [
            'rules' => self::RULES,
            'messages' => self::MESSAGES,
        ];
    }
}
