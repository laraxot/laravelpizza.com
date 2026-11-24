<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Policies;

use Modules\Xot\Contracts\UserContract;

class MailTemplatePolicy extends NotifyBasePolicy
{
    public function viewAny(UserContract $user): bool
    {
        return false;
    }
}
