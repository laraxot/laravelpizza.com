<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Modules\Xot\Actions\String\GetPronounceablePasswordAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

class GetNewPasswordAction
{
    use QueueableAction;

    /**
     * Genera una nuova password temporanea pronunciabile per l'utente.
     */
    public function execute(UserContract $record): string
    {
        return app(GetPronounceablePasswordAction::class)->execute(12);
    }
}
