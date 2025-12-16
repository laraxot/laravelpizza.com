<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Modules\User\Models\DeviceProfile;

/**
 * DeviceProfile Factory.
 *
 * Factory for creating DeviceProfile model instances for testing and seeding.
 * Extends DeviceUserFactory since DeviceProfile extends DeviceUser.
 */
class DeviceProfileFactory extends DeviceUserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<DeviceProfile>
     */
    protected $model = DeviceProfile::class;

    /**
     * Define the model's default state.
     * Inherits from DeviceUserFactory and adds profile-specific attributes.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function definition(): array
    {
        return array_merge(
            parent::definition(),
            [
                // DeviceProfile-specific attributes can be added here if needed
            ],
        );
    }
}
