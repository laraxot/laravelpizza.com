<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Device;

/**
 * @extends Factory<Device>
 */
class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Device>
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'mobile_id' => fake()->uuid(),
            'languages' => [fake()->languageCode(), fake()->languageCode()],
            'device' => fake()->randomElement(['iPhone', 'Android', 'Desktop']),
            'platform' => fake()->randomElement(['iOS', 'Android', 'Windows', 'macOS', 'Linux']),
            'browser' => fake()->randomElement(['Safari', 'Chrome', 'Firefox', 'Edge']),
            'version' => fake()->numerify('#.#.#'),
            'is_robot' => false,
            'robot' => null,
            'is_desktop' => false,
            'is_mobile' => true,
            'is_tablet' => false,
            'is_phone' => true,
        ];
    }
}
