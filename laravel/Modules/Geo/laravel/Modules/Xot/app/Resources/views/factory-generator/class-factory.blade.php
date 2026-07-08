<?php

declare(strict_types=1);

/** @var \ReflectionClass $reflection */
/** @var array<string, string> $properties */
?>
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
@isset($properties['remember_token'])
use Illuminate\Support\Str;
@endisset
use {{ $reflection->getName() }};

class {{ $reflection->getShortName() }}Factory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = {{ $reflection->getShortName() }}::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
@foreach ($properties as $name => $property)
            '{{ $name }}' => {!! $property !!},
@endforeach
        ];
    }
}
