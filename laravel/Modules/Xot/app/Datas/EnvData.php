<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Illuminate\Support\Facades\File;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

use function Safe\preg_match;
use function Safe\preg_replace_callback;

/**
 * Undocumented class.
 */
class EnvData extends Data implements Wireable
{
    use WireableData;

    public string $app_url = 'http://localhost';

    public bool $debugbar_enabled = false;

    public string $google_maps_api_key = '';

    public string $telegram_bot_token = '';

    public string $sms_driver = '';

    public string $netfun_token = '';

    public string $mail_mailer = '';

    public string $mail_host = '';

    public string $mail_port = '';

    public string $mail_encryption = '';

    public string $mail_username = '';

    public string $mail_password = '';

    public string $mail_from_address = '';

    public string $mail_from_name = '';

    private static ?self $instance = null;

    public static function make(): self
    {
        if (! self::$instance) {
            $data = [];

            foreach ($_ENV as $k => $v) {
                $k = mb_strtolower($k);
                if ($v === 'false') {
                    $v = false;
                }
                if ($v === 'true') {
                    $v = true;
                }
                $data[$k] = $v;
            }

            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    /**
     * Scrive su `.env` solo le variabili dichiarate da EnvData: `$data` arriva dallo stato
     * Livewire, modificabile dal client, e le sue chiavi non sono mai nomi di variabile fidati.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): void
    {
        $env_path = base_path('.env');
        $env_content = File::get($env_path);

        foreach (array_intersect_key($data, get_object_vars($this)) as $k => $v) {
            if ($v !== $this->$k && (is_bool($v) || is_int($v) || is_string($v))) {
                $env_content = $this->updateVar($k, $v, $env_content);
            }
        }

        // ponytail: LOCK_EX sulla scrittura, non sul read-modify-write; rename atomico se serve concorrenza.
        File::put($env_path, $env_content, true);
    }

    public function updateVar(string $key, int|bool|string $value, string $env_content): string
    {
        $key = str($key)->upper()->toString();
        if (preg_match('/^[A-Z][A-Z0-9_]*\z/', $key) !== 1) {
            throw new \InvalidArgumentException('Nome variabile .env non valido.');
        }

        $line = $this->getLine($key, $value);
        // Solo a inizio riga: `X_MAIL_HOST=` e `# MAIL_HOST=` non sono `MAIL_HOST=`.
        $pattern = '/^'.$key.'=.*(?:\R|\z)/m';

        if (preg_match($pattern, $env_content) !== 1) {
            return ($env_content === '' || str_ends_with($env_content, "\n") ? $env_content : $env_content."\n").$line;
        }

        return preg_replace_callback($pattern, static fn (): string => $line, $env_content, 1);
    }

    public function getLine(string $key, int|bool|string $value): string
    {
        $replace = $key.'=';
        if (is_bool($value)) {
            $replace .= $value ? 'true' : 'false';
        }
        if (is_string($value)) {
            if (preg_match('/[\r\n]/', $value) === 1) {
                throw new \InvalidArgumentException('Il valore di '.$key.' non può contenere a capo.');
            }
            // Tra doppi apici dotenv vuole `\\` e `\"`; `$` resta libero per i riferimenti `${APP_NAME}`.
            $replace .= '"'.addcslashes($value, '"\\').'"';
        }
        if (is_int($value)) {
            $replace .= $value;
        }
        $replace .= "\n";

        return $replace;
    }
}
