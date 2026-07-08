<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Policies;

use Modules\Notify\Models\MailTemplate as Post;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class MailTemplatePolicy extends XotBasePolicy
{
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return false;
    }

    public function view(UserContract $user, Post $post): bool
    {
        return false;
    }

    public function create(UserContract $user): bool
    {
        return false;
    }

    public function update(UserContract $user, Post $post): bool
    {
        return false;
    }

    public function delete(UserContract $user, Post $post): bool
    {
        return false;
    }

    public function restore(UserContract $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(UserContract $user, Post $post): bool
    {
        return false;
    }
}
