<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Exception;
use Illuminate\Support\Facades\File;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

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

    public function update(array $data): void
    {
        $env_path = base_path('.env');
        $env_content = File::get($env_path);

        foreach ($data as $k => $v) {
            if ($v !== $this->$k && (is_bool($v) || is_int($v) || is_string($v))) {
                $env_content = $this->updateVar($k, $v, $env_content);
            }
        }

        File::put($env_path, $env_content);
    }

    public function updateVar(string $key, int|bool|string $value, string $env_content): string
    {
        $key = str($key)->upper()->toString();
        $replace = $this->getLine($key, $value);
        $pos_start = mb_strpos($env_content, $key.'=');
        if ($pos_start === false) {
            // throw new \Exception('['.__LINE__.']['.class_basename($this).']');
            return $env_content."\n".$replace;
        }
        $pos_end = mb_strpos($env_content, "\n", $pos_start);
        if ($pos_end === false) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }

        $length = $pos_end - $pos_start;
        $find = mb_substr($env_content, $pos_start, $length + 1);

        return str($env_content)->replace($find, $replace)->toString();
    }

    public function getLine(string $key, int|bool|string $value): string
    {
        $replace = $key.'=';
        if (is_bool($value)) {
            $replace .= $value ? 'true' : 'false';
        }
        if (is_string($value)) {
            $replace .= '"'.$value.'"';
        }
        if (is_int($value)) {
            $replace .= $value;
        }
        $replace .= "\n";

        return $replace;
    }
}
