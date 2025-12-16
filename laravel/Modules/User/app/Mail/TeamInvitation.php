<?php

declare(strict_types=1);

namespace Modules\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\TeamInvitation as TeamInvitationModel;

class TeamInvitation extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The team invitation instance.
     */
    public TeamInvitationModel $invitation;
}
