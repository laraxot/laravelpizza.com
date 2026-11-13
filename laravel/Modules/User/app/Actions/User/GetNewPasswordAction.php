<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Xot\Actions\String\GetPronounceablePasswordAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetNewPasswordAction
{
    use QueueableAction;

    /**
     * Genera una nuova password temporanea pronunciabile, ne salva l'hash sull'utente
     * e restituisce il valore in chiaro (da comunicare una sola volta all'utente).
     */
    public function execute(UserContract $record): string
    {
        Assert::isInstanceOf($record, Model::class);

        $password = app(GetPronounceablePasswordAction::class)->execute(12);

        $record->forceFill([
            'password' => Hash::make($password),
        ])->save();

        return $password;
    }
}
