<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class ProgressioniPolicy extends XotBasePolicy
{
    public function pdfZip(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function xlsCoeff(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function populate(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function resetFields(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function populateFields(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function sendMail(UserContract $userContract, Model $model): bool
    {
        return false;
    }
}
