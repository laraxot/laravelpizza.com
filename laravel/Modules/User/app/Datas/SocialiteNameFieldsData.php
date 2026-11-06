<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Spatie\LaravelData\Data;

final class SocialiteNameFieldsData extends Data
{
    public function __construct(
        public string $name,
        public string $firstName,
        public string $lastName,
    ) {}
}
