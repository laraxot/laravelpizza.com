<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Trova o crea l'utente che ha appena fatto accesso con SPID o CIE e ne aggiorna i dati d'identità.
 *
 * - L'utente si riconosce dal codice fiscale; se non c'è ancora, da un'email **verificata** dall'IdP (così chi si era
 *   registrato con l'email e poi entra con SPID ritrova il proprio account invece di urtare il vincolo di unicità).
 * - Nome e cognome vanno in `first_name`/`last_name`; `name` è il nome completo.
 * - Senza email verificata si usa `<metodo>.<CF>@noemail.local` con `email_verified_at` null: l'identità è comunque
 *   garantita (HasVerifiedIdentityAction), ma al cittadino non partono email verso un indirizzo inesistente.
 * - Si conservano solo i dati necessari (vedi la migrazione owner `create_users_table`).
 */
final class UpsertUserFromDigitalIdentityAction
{
    use QueueableAction;

    /**
     * @param  string  $authMethod  `spid` o `cie` (controllato a runtime)
     * @param  array<string, mixed>  $attributes  chiavi usate: fiscal_code, name, surname, email
     */
    public function execute(string $authMethod, array $attributes, bool $emailVerified, ?string $identityProvider = null): UserContract&Model
    {
        Assert::inArray($authMethod, HasVerifiedIdentityAction::TRUSTED_IDENTITY_METHODS);

        $fiscalCode = self::normalizeFiscalCode($attributes['fiscal_code'] ?? null);
        $firstName = self::cleanString($attributes['name'] ?? null);
        $lastName = self::cleanString($attributes['surname'] ?? null);
        $email = self::cleanString($attributes['email'] ?? null);
        $email = $email !== null && filter_var($email, FILTER_VALIDATE_EMAIL) !== false ? mb_strtolower($email) : null;
        $verifiedEmail = $emailVerified ? $email : null;

        $userClass = XotData::make()->getUserClass();

        $user = $userClass::query()->where('fiscal_code', $fiscalCode)->first();
        if ($user === null && $verifiedEmail !== null) {
            $user = $userClass::query()->where('email', $verifiedEmail)->first();
        }

        $fullName = trim(($firstName ?? '').' '.($lastName ?? ''));
        $data = [
            'fiscal_code' => $fiscalCode,
            'auth_method' => $authMethod,
            'identity_provider' => $identityProvider ?? $authMethod,
            'last_login_at' => now(),
        ];
        if ($firstName !== null) {
            $data['first_name'] = $firstName;
        }
        if ($lastName !== null) {
            $data['last_name'] = $lastName;
        }
        if ($fullName !== '') {
            $data['name'] = $fullName;
        }

        if ($user instanceof Model) {
            $currentEmail = $user->getAttributes()['email'] ?? null;
            $currentVerifiedAt = $user->getAttributes()['email_verified_at'] ?? null;
            if ($verifiedEmail !== null && ($currentEmail !== $verifiedEmail || $currentVerifiedAt === null)) {
                $data['email'] = $verifiedEmail;
                $data['email_verified_at'] = now();
            }
            $user->forceFill($data)->save();
        } else {
            $data['name'] ??= $fiscalCode;
            $data['email'] = $verifiedEmail ?? $authMethod.'.'.mb_strtolower($fiscalCode).'@noemail.local';
            $data['email_verified_at'] = $verifiedEmail !== null ? now() : null;
            $user = new $userClass;
            $user->forceFill($data)->save();
        }

        Assert::isInstanceOf($user, UserContract::class);

        return $user;
    }

    /**
     * Il codice fiscale da SPID arriva come `TINIT-RSSMRA80A01H501U`; da CIE senza prefisso.
     */
    public static function normalizeFiscalCode(mixed $value): string
    {
        Assert::string($value, 'Codice fiscale mancante nei dati dell\'identità digitale');
        $code = mb_strtoupper(trim($value));
        if (str_starts_with($code, 'TINIT-')) {
            $code = mb_substr($code, 6);
        }
        Assert::regex($code, '/^[A-Z0-9]{11,16}$/', 'Codice fiscale non valido nei dati dell\'identità digitale');

        return $code;
    }

    private static function cleanString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }
        $value = trim($value);

        return $value === '' ? null : $value;
    }
}
