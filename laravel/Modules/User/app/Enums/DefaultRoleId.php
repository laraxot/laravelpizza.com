<?php

declare(strict_types=1);

namespace Modules\User\Enums;

/**
 * Id storici dei ruoli di base (tabella roles, config permission.table_names.roles).
 *
 * Sostituisce le costanti Role::ROLE_ADMINISTRATOR / ROLE_OWNER / ROLE_USER.
 */
enum DefaultRoleId: int
{
    case Administrator = 1;
    case Owner = 2;
    case User = 3;
}
