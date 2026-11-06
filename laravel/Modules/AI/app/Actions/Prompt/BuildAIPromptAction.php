<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Prompt;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Dispatcher dei prompt AI per tipo.
 *
 * Centralizza la costruzione del prompt in un'unica azione in modo da evitare
 * la duplicazione tra le azioni concreta (es. `ClassifyTicketAction`,
 * `SuggestSolutionsAction`).
 */
final class BuildAIPromptAction
{
    use QueueableAction;

    /**
     * Costruisce il prompt per il tipo richiesto.
     *
     * @param  array<string, mixed>  $params
     */
    public function execute(string $type, array $params): string
    {
        $title = $params['title'] ?? '';
        $description = $params['description'] ?? '';
        $category = $params['category'] ?? '';

        Assert::string($title, 'Title must be a string');
        Assert::string($description, 'Description must be a string');
        Assert::string($category, 'Category must be a string');

        return match ($type) {
            'classification' => AIPromptTemplates::classification(
                $title,
                $description,
            ),
            'solutions' => AIPromptTemplates::solutions(
                $title,
                $description,
                $category,
            ),
            default => throw new \InvalidArgumentException("Unsupported AI prompt type: {$type}"),
        };
    }
}
