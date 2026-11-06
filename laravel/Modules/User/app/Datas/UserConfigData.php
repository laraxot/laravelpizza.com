<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Modules\User\Filament\Pages\SettingPage;
use Modules\User\Observers\UserObserver;
use Modules\User\Providers\PassportServiceProvider;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di User del tenant corrente: `config/{tenant}/user.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin). I default sono i valori che
 * prima erano scritti nel codice: nulla cambia finche' nessuno salva. Token, modelli e scope di
 * Passport restano in `config/passport.php` del modulo: sono strutture di sicurezza, non
 * impostazioni da form.
 *
 * @see SettingPage
 * @see UserObserver
 * @see PassportServiceProvider
 */
class UserConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Crea il team personale a ogni nuovo utente (prima `config('user.create_personal_team', false)`). */
    public bool $create_personal_team = false;

    /** Abilita il password grant di Passport (prima `config('user.passport.enable_password_grant', true)`). */
    public bool $passport_enable_password_grant = true;
}
