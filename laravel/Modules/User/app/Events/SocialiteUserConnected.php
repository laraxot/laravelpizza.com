<?php

declare(strict_types=1);

namespace Modules\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\SocialiteUser;

class SocialiteUserConnected
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public SocialiteUser $socialiteUser,
    ) {
    }
}
