<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;

class IndividualeRegionalePolicy extends IndividualePolicy
{
    /*
    public function viewAny(?UserContract $userContract): bool
    {
        return true;
    }

    public function edit(UserContract $userContract, Model $model): bool
    {
        return false;
    }

    public function update(UserContract $userContract, Model $model): bool
    {
        return false;
    }

    public function show(?UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function compila(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function individualePdf(UserContract $userContract, Model $model): bool
    {
        return $model->getAttributeValue('disci1') === 203;
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
        */
}
