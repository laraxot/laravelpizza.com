<?php

declare(strict_types=1);

namespace Modules\Pdnd\Datas;


use Illuminate\Support\Facades\Config;
use Livewire\Wireable;
use RuntimeException;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class PdndData extends Data implements Wireable
{
    use WireableData;

    public string $kid;

    public string $issuer;

    public string $clientId;

    public string $purposeId;

    public string $privKeyPath;

    public string $authUrl;

    public string $audience;

    public string $serviceAud;

    public string $apiBaseUrlTest;

    /**
     * Singleton instance.
     */
    private static ?self $instance = null;

    /**
     * Creates or returns the singleton instance.
     */
    public static function make(string $ambiente = 'test'): self
    {
        if (! self::$instance) {
            if ($ambiente == 'test') {
                // $test = Config::string('pdnd::pdnd.default');
                // $data = Config::array('pdnd::pdnd.'.$test);
                $test = Config::string('pdnd.pdnd.default');
                $data = Config::array('pdnd.pdnd.'.$test);
                self::$instance = self::from($data);
            } elseif ($ambiente == 'prod') {
                // $data = Config::array('pdnd::pdnd.prod');
                $data = Config::array('pdnd.pdnd.prod');
                self::$instance = self::from($data);
            }
        }

        if (self::$instance === null) {
            throw new RuntimeException('Failed to initialize PdndData instance');
        }

        return self::$instance;
    }
}
