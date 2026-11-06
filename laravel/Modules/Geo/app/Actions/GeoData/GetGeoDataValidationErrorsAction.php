<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Modules\Geo\Infrastructure\Validation\GeoDataValidationRules;

use Illuminate\Support\Facades\Validator;
use Spatie\QueueableAction\QueueableAction;

class GetGeoDataValidationErrorsAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, array<int, string>>
     */
    public function execute(array $data): array
    {
        $validator = Validator::make($data, GeoDataValidationRules::RULES, GeoDataValidationRules::MESSAGES);

        /** @var array<string, array<int, string>> $errors */
        $errors = $validator->errors()->toArray();

        return $errors;
    }
}
