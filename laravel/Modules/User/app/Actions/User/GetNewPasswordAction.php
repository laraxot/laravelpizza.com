<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Modules\Xot\Actions\String\GetPronounceablePasswordAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

class GetNewPasswordAction
{
    use QueueableAction;

    public function execute(UserContract $record): string
    {
        $user = $record;

        $password = once(function () use ($user) {
            $generator = new GetPronounceablePasswordAction;
            $plainPassword = $generator->execute();
            $hasher = app(\Illuminate\Contracts\Hashing\Hasher::class);
            $hashedPassword = $hasher->make($plainPassword);

            $user->forceFill([
                'password' => $hashedPassword,
            ])->save();

            return $plainPassword;
        });

        return $password;
    }
}
