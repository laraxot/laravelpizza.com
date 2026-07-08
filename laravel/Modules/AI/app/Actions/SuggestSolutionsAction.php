<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Facades\Cache;
use Modules\AI\Actions\Support\MakeAIRequestAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class SuggestSolutionsAction
{
    use QueueableAction;

    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly string $category,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function handle(): array
    {
        $cacheKey = 'ai:solutions:'.md5($this->title.$this->description.$this->category);

        $result = Cache::remember($cacheKey, 1800, function (): string {
            $prompt = $this->buildSolutionPrompt();
            return (new MakeAIRequestAction($prompt, 'solutions'))->handle();
        });

        Assert::isArray($result, 'Solutions result must be an array');

        return $result;
    }

    private function buildSolutionPrompt(): string
    {
        return "Suggerisci soluzioni per questo ticket di {$this->category}:

Titolo: {$this->title}
Descrizione: {$this->description}

Fornisci 3-5 soluzioni pratiche e concrete, specifiche per il contesto italiano e le amministrazioni pubbliche.

Rispondi in formato JSON:
{
  \"solutions\": [
    {
      \"title\": \"Titolo soluzione\",
      \"description\": \"Descrizione dettagliata\",
      \"steps\": [\"passo1\", \"passo2\"],
      \"estimated_time\": \"2-3 giorni\",
      \"required_resources\": [\"risorsa1\", \"risorsa2\"],
      \"priority\": \"high|medium|low\"
    }
  ],
  \"preventive_measures\": [\"misura1\", \"misura2\"],
  \"follow_up_actions\": [\"azione1\", \"azione2\"]
}";
    }
}
