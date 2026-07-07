<?php

declare(strict_types=1);

namespace Modules\UI\Data;

use Spatie\LaravelData\Data;

final class UserData extends Data
{
    /**
     * @param array<int, string>   $permissions
     * @param array<string, mixed> $settings
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $avatar,
        public ?string $role,
        public array $permissions,
        public array $settings,
    ) {
    }
}
