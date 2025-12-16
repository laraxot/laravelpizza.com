<?php

declare(strict_types=1);

/**
 * @see https://github.com/TheDoctor0/laravel-factory-generator. 24 days ago
 * @see https://github.com/mpociot/laravel-test-factory-helper  on 2 Mar 2020.
 * @see https://github.com/laravel-shift/factory-generator on 10 Aug.
 * @see https://dev.to/marcosgad/make-factory-more-organized-laravel-3c19.
 * @see https://medium.com/@yohan7788/seeders-and-faker-in-laravel-6806084a0c7.
 */

namespace Modules\Xot\Actions\Factory;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see https://github.com/mpociot/laravel-test-factory-helper/blob/master/src/Console/GenerateCommand.php#L213
 */
class GetFakerAction
{
    use QueueableAction;

    public function execute(string $name, ?string $type = null, ?string $_table = null): string
    {
        if ($type !== null && Str::startsWith($type, 'factory(')) {
            return $type;
        }

        $fakeableTypes = [
            // 'enum' => '$faker->randomElement('.$this->enumValues($table, $name).')',
            'string' => '$faker->word',
            'text' => '$faker->text',
            'date' => '$faker->date()',
            'time' => '$faker->time()',
            'guid' => '$faker->word',
            'datetimetz' => '$faker->dateTime()',
            'datetime' => '$faker->dateTime()',
            'integer' => '$faker->randomNumber()',
            'bigint' => '$faker->randomNumber()',
            'smallint' => '$faker->randomNumber()',
            'decimal' => '$faker->randomFloat()',
            'float' => '$faker->randomFloat()',
            'boolean' => '$faker->boolean',
        ];

        $fakeableNames = [
            'city' => '$faker->city',
            'company' => '$faker->company',
            'country' => '$faker->country',
            'description' => '$faker->text',
            'email' => '$faker->safeEmail',
            'first_name' => '$faker->firstName',
            'firstname' => '$faker->firstName',
            'guid' => '$faker->uuid',
            'last_name' => '$faker->lastName',
            'lastname' => '$faker->lastName',
            'lat' => '$faker->latitude',
            'latitude' => '$faker->latitude',
            'lng' => '$faker->longitude',
            'longitude' => '$faker->longitude',
            'name' => '$faker->name',
            'password' => 'bcrypt($faker->password)',
            'phone' => '$faker->phoneNumber',
            'phone_number' => '$faker->phoneNumber',
            'postcode' => '$faker->postcode',
            'postal_code' => '$faker->postcode',
            'remember_token' => 'Str::random(10)',
            'slug' => '$faker->slug',
            'street' => '$faker->streetName',
            'address1' => '$faker->streetAddress',
            'address2' => '$faker->secondaryAddress',
            'summary' => '$faker->text',
            'url' => '$faker->url',
            'user_name' => '$faker->userName',
            'username' => '$faker->userName',
            'uuid' => '$faker->uuid',
            'zip' => '$faker->postcode',
        ];

        if (isset($fakeableNames[$name])) {
            return $fakeableNames[$name];
        }

        if (isset($fakeableTypes[$type])) {
            return $fakeableTypes[$type];
        }

        return '$faker->word';
    }
}
