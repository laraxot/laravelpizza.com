<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Profile;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bio' => $faker->text(200)
            'avatar' => '/avatars/'.$faker->word()
            'phone' => $faker->phoneNumber()
            'date_of_birth' => $faker->date()
            'location' => $faker->city()
            'website' => $faker->url()
            'twitter' => $faker->userName()
            'facebook' => $faker->userName()
            'linkedin' => $faker->userName()
            'github' => $faker->userName()
        ];
    }
}
