<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\TeamInvitation;

class TeamInvitationSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(TeamInvitation::class);
    }
}
