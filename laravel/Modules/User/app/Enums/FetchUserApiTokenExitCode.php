<?php

declare(strict_types=1);

namespace Modules\User\Enums;

/**
 * Codici di uscita (diversi da Command::SUCCESS) di `passport:fetch-user-token`.
 *
 * Distinti tra loro cosi' gli script che invocano il comando possono
 * distinguere "ambiente vietato" da "utente inesistente".
 */
enum FetchUserApiTokenExitCode: int
{
    case InvalidEnvironment = 1;
    case UserNotFound = 2;
}
