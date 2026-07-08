<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\PasswordReset;

class PasswordResetSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(PasswordReset::class);
    }
}
