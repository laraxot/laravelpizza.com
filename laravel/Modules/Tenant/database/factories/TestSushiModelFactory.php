<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\TestSushiModel;

/**
 * @extends Factory<TestSushiModel>
 */
class TestSushiModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TestSushiModel>
     */
    protected $model = TestSushiModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => implode(' ', [['first', 'second', 'third'][array_rand(['first', 'second', 'third'])], ['word1', 'word2', 'word3'][array_rand(['word1', 'word2', 'word3'])], ['final', 'last', 'end'][array_rand(['final', 'last', 'end'])]]),
            'description' => ['This is a sample description', 'A brief explanation follows', 'Here is some info'][array_rand(['This is a sample description', 'A brief explanation follows', 'Here is some info'])],
            'status' => ['active', 'inactive', 'pending', 'completed'][array_rand(['active', 'inactive', 'pending', 'completed'])],
            'metadata' => [
                'priority' => ['low', 'medium', 'high'][array_rand(['low', 'medium', 'high'])],
                'category' => ['cat1', 'cat2', 'cat3'][array_rand(['cat1', 'cat2', 'cat3'])],
                'tags' => [['tag1', 'tag2', 'tag3'][array_rand(['tag1', 'tag2', 'tag3'])], ['tag4', 'tag5', 'tag6'][array_rand(['tag4', 'tag5', 'tag6'])], ['tag7', 'tag8', 'tag9'][array_rand(['tag7', 'tag8', 'tag9'])]],
            ],
            'created_at' => \Carbon\Carbon::now()->subDays(random_int(1, 365)),
            'updated_at' => \Carbon\Carbon::now()->subDays(random_int(0, 30)),
            'created_by' => random_int(1, 100),
            'updated_by' => random_int(1, 100),
        ];
    }

    /**
     * Indicate that the model is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the model is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the model is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'pending',
        ]);
    }

    /**
     * Set high priority metadata.
     */
    public function highPriority(): static
    {
        return $this->state(function (array $attributes
            /** @var array<string, mixed> $metadata */
            $metadata = is_array($attributes['metadata'] ?? null) ? $attributes['metadata'] : [];
            $metadata['priority'] = 'high';

            return [
                'metadata' => $metadata,
            ];
        });
    }
}
