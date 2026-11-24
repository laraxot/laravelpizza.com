<?php

declare(strict_types=1);

namespace Modules\UI\Data;

use Spatie\LaravelData\Data;

final class UserData extends Data
{
    /**
<<<<<<< .merge_file_WYFJoK
     * @param  array<int, string>  $permissions
     * @param  array<string, mixed>  $settings
=======
     * @param array<int, string>   $permissions
     * @param array<string, mixed> $settings
>>>>>>> .merge_file_FDP3B8
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $avatar,
        public ?string $role,
        public array $permissions,
        public array $settings,
<<<<<<< .merge_file_WYFJoK
    ) {}
=======
    ) {
    }
>>>>>>> .merge_file_FDP3B8
}
