<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Prompt;

use Spatie\QueueableAction\QueueableAction;

final class BuildTicketSolutionsPromptAction
{
    use QueueableAction;

    public function execute(string $title, string $description, string $category): string
    {
        return "Suggerisci soluzioni per questo ticket di {$category}:

Titolo: {$title}
Descrizione: {$description}

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
