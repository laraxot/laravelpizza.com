<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;

class IndividualePoPolicy extends IndividualePolicy
{
    /*
    public function viewAny(?UserContract $user): bool
    {
        return true;
    }

    public function index(?UserContract $user, Model $model): bool
    {
        return false;
    }

    public function edit(UserContract $user, Model $model): bool
    {
        return false;
    }

    public function update(UserContract $user, Model $model): bool
    {
        return false;
    }

    public function show(?UserContract $user, Model $model): bool
    {
        return false;
    }

    public function view(UserContract $user, Model $model): bool
    {
        return $user->isSuperAdmin();
    }

    public function destroy(?UserContract $user, Model $model): bool
    {
        return false;
    }

    public function delete(?UserContract $user, Model $model): bool
    {
        return false;
    }

    public function compila(UserContract $user, Model $model): bool
    {
        //return $model->getAttributeValue('posfun') >= 100;
        return (bool) $model->getAttributeValue('ha_diritto');
    }

    public function individualePdf(UserContract $user, Model $model): bool
    {
        //return $model->getAttributeValue('posfun') >= 100;
        return (bool) $model->getAttributeValue('ha_diritto');
    }

    public function xlsIndividualeStabiRepar(UserContract $user, Model $model): bool
    {
        return true;
    }

    public function pdfIndividualeStabiRepar(UserContract $user, Model $model): bool
    {
        return true;
    }

    public function massMail(UserContract $user, Model $model): bool
    {
        return true;
    }
    */
}
