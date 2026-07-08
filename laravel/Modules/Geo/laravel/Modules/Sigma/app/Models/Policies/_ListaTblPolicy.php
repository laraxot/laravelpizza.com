<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class _ListaTblPolicy extends XotBasePolicy
{
    public function dwnSigmaFile(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function dwnGuzzleSigmaFile(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function uploadCsvSigma(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function rawCsvSigma(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function webService(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function uploadZipSigma(UserContract $userContract, Model $model): bool
    {
        return true;
    }
}
