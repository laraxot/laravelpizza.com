<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class IndividualeAdmPolicy extends XotBasePolicy
{
    public function xlsIndividuale(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function xlsIndividualeStabiRepar(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function pdfIndividualeStabiRepar(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function massMail(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function pdfZipYear(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function pdfZipYearDip(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function pdfZipYearPo(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function pdfZipYearReg(UserContract $userContract, Model $model): bool
    {
        return true;
    }
}
