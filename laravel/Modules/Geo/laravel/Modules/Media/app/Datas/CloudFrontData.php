<?php

declare(strict_types=1);

namespace Modules\Media\Datas;

use Illuminate\Support\Facades\Config;
use Livewire\Wireable;
use RuntimeException;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

use function Safe\file_get_contents;

class CloudFrontData extends Data implements Wireable
{
    use WireableData;

    public string $region; // ' => env('CLOUDFRONT_REGION', 'eu-west-1'),

    public string $base_url; // ' => env('CLOUDFRONT_RESOURCE_KEY_BASE_URL'),

    public ?string $private_key; // ' => env('CLOUDFRONT_PRIVATE_KEY'),

    public ?string $private_key_path; // ' => env('CLOUDFRONT_PRIVATE_KEY_PATH'),

    public string $key_pair_id; // ' => env('CLOUDFRONT_KEYPAIR_ID'),

    /**
     * Singleton instance.
     */
    private static ?self $instance = null;

    /**
     * Creates or returns the singleton instance.
     */
    public static function make(): self
    {
        if (! self::$instance) {
            /** @var array<string, mixed> $data */
            $data = Config::array('services.cloudfront');
            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function getPrivateKey(): string
    {
        if ($this->private_key) {
            return $this->private_key;
        }
        if ($this->private_key_path) {
            return file_get_contents(storage_path($this->private_key_path));
        }
        throw new RuntimeException('CLOUDFRONT_PRIVATE_KEY environment variable is not set or empty');
    }
}
