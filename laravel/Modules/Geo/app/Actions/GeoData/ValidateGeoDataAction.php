<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Modules\Geo\Infrastructure\Validation\GeoDataValidationRules;

use Illuminate\Support\Facades\Validator;
use Spatie\QueueableAction\QueueableAction;

class ValidateGeoDataAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): bool
    {
        $validator = Validator::make($data, GeoDataValidationRules::RULES, GeoDataValidationRules::MESSAGES);

        return ! $validator->fails();
    }
}
