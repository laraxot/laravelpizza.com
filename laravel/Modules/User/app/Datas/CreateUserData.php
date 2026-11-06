<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Modules\User\Actions\User\CreateUserAction;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * Dati per la creazione di un nuovo utente.
 *
 * Usato da Modules\User\Actions\User\CreateUserAction::execute().
 * Ogni proprietà è `Optional` per preservare la semantica precedente
 * (array parziale → solo i campi forniti vengono passati a `User::create()`).
 *
 * @see CreateUserAction
 */
class CreateUserData extends Data
{
    public function __construct(
        public string|Optional $name,
        public string|Optional $first_name,
        public string|Optional $last_name,
        public string|Optional $email,
        public string|Optional $password,
        public string|Optional $lang,
        public int|string|Optional $current_team_id,
        public bool|Optional $is_active,
        public bool|Optional $is_otp,
        public string|Optional $password_expires_at,
        public string|Optional $email_verified_at,
        public string|Optional $type,
        public string|Optional $state,
    ) {}
}
