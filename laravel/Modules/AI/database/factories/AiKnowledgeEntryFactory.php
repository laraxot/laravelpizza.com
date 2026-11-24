<?php

declare(strict_types=1);

namespace Modules\AI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AI\Models\AiKnowledgeEntry;

/** @extends Factory<AiKnowledgeEntry> */
class AiKnowledgeEntryFactory extends Factory
{
    /** @var class-string<AiKnowledgeEntry> */
    protected $model = AiKnowledgeEntry::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'collection' => 'demo',
            'question' => $this->faker->sentence().'?',
            'answer' => $this->faker->paragraph(),
            'tags' => $this->faker->words(3),
            'is_active' => true,
        ];
    }
}
