<?php

declare(strict_types=1);

namespace Modules\Lang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Lang\Models\TranslationFile;

/**
 * @extends Factory<TranslationFile>
 */
class TranslationFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TranslationFile>
     */
    protected $model = TranslationFile::class;

    /**
     * Define the model's default state.
<<<<<<< HEAD
     *
     * @return array<string, mixed>
=======
>>>>>>> 11c7c7d (.)
     */
    public function definition(): array
    {
        return [];
    }
}
