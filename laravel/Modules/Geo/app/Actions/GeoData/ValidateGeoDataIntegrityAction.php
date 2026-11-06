<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Modules\Geo\Infrastructure\Validation\GeoDataValidationRules;

use Illuminate\Support\Facades\Validator;
use Spatie\QueueableAction\QueueableAction;

/**
 * Validazione struttura JSON comuni/regioni.
 *
 * Sostituisce GeoDataValidator.
 */
final class ValidateGeoDataIntegrityAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): bool
    {
        if (! $this->validate($data)) {
            return false;
        }

        if (! isset($data['regions']) || ! is_array($data['regions'])) {
            return false;
        }

        $regionCodes = [];

        foreach ($data['regions'] as $region) {
            if (! is_array($region)) {
                return false;
            }
            if (! $this->isValidRegionWithUniqueCode($region, $regionCodes)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, array<int, string>>
     */
    public function getErrors(array $data): array
    {
        $validator = Validator::make($data, GeoDataValidationRules::RULES);

        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        return $errors;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function validate(array $data): bool
    {
        $validator = Validator::make($data, GeoDataValidationRules::RULES);

        return ! $validator->fails();
    }

    /**
     * @param array<mixed, mixed> $region
     * @param list<string>        $regionCodes
     *
     * @param-out list<string> $regionCodes
     */
    private function isValidRegionWithUniqueCode(array $region, array &$regionCodes): bool
    {
        if (! isset($region['code']) || ! is_string($region['code'])) {
            return false;
        }
        if (in_array($region['code'], $regionCodes, strict: true)) {
            return false;
        }
        $regionCodes[] = $region['code'];

        if (! isset($region['provinces']) || ! is_array($region['provinces'])) {
            return false;
        }

        $provinceCodes = [];
        foreach ($region['provinces'] as $province) {
            if (! is_array($province)) {
                return false;
            }
            if (! $this->isValidProvinceWithUniqueCode($province, $provinceCodes)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<mixed, mixed> $province
     * @param list<string>        $provinceCodes
     *
     * @param-out list<string> $provinceCodes
     */
    private function isValidProvinceWithUniqueCode(array $province, array &$provinceCodes): bool
    {
        if (! isset($province['code']) || ! is_string($province['code'])) {
            return false;
        }
        if (in_array($province['code'], $provinceCodes, strict: true)) {
            return false;
        }
        $provinceCodes[] = $province['code'];

        if (! isset($province['cities']) || ! is_array($province['cities'])) {
            return false;
        }

        $cityCodes = [];
        foreach ($province['cities'] as $city) {
            if (! is_array($city)) {
                return false;
            }

            /** @var array<string, mixed> $cityData */
            $cityData = [];
            foreach ($city as $key => $value) {
                if (is_string($key)) {
                    $cityData[$key] = $value;
                }
            }

            if (! $this->isValidCityWithUniqueCode($cityData, $cityCodes)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<mixed, mixed> $city
     * @param list<string>        $cityCodes
     *
     * @param-out list<string> $cityCodes
     */
    private function isValidCityWithUniqueCode(array $city, array &$cityCodes): bool
    {
        if (! isset($city['code']) || ! is_string($city['code'])) {
            return false;
        }
        if (in_array($city['code'], $cityCodes, strict: true)) {
            return false;
        }
        $cityCodes[] = $city['code'];

        return true;
    }
}
