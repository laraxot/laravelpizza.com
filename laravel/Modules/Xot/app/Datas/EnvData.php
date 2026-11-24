<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

use function Safe\preg_match;

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
     * Il file di ambiente che {@see update()} modifica.
     *
     * In produzione e' `base_path('.env')`, e non cambia. La chiave di
     * configurazione esiste perche' questo metodo **scrive su un file vero**, e
     * il solo modo di provarlo senza toccare il file della macchina e' poterlo
     * mandare altrove.
     *
     * I test di `EnvWidget` scrivevano sul `.env` reale e lo ripristinavano in
     * `afterEach` — lo dichiarava il loro stesso docblock. Un'asserzione che
     * interrompe la corsa prima del ripristino, e la configurazione di chi
     * sviluppa resta alterata; e in un container senza `.env` quegli undici
     * test morivano nel `beforeEach`, prima di provare qualunque cosa
     * (base_quaeris_fila5#244).
     */
    public static function envFilePath(): string
    {
        $configured = config('xot.env_file');

        return is_string($configured) && $configured !== '' ? $configured : base_path('.env');
    }

    /**
     * Scrive su `.env` solo le variabili dichiarate da EnvData: `$data` arriva dallo stato
     * Livewire, modificabile dal client, e le sue chiavi non sono mai nomi di variabile fidati.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): void
    {
        $env_path = self::envFilePath();

        if (! File::exists($env_path)) {
            // Un messaggio che dice cosa manca, invece della
            // `FileNotFoundException` grezza del Filesystem: questo metodo lo
            // chiama `EnvWidget` dal pannello, e chi premeva «salva» su un
            // ambiente senza `.env` — una macchina dove le variabili arrivano
            // dall'ambiente del container e non da un file — vedeva una traccia
            // di stack. Non si crea il file: farlo nascere da un pannello
            // significa che al riavvio successivo inizierebbe a **sovrascrivere**
            // le variabili vere (base_quaeris_fila5#244).
            throw new \RuntimeException(sprintf('Nessun file di ambiente da modificare in %s.', $env_path));
        }

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

        return Str::of($env_content)->replaceMatches($pattern, static fn (): string => $line, 1)->toString();
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
