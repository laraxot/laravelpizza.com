<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Spatie\LaravelData\Data;

class SocialiteUserAttributesData extends Data
{
    public function __construct(
        public string $name,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $provider,
    ) {
    }
}
