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
 * `SuggestSolutionsAction`). I testi dei prompt sono metodi privati qui: questa
 * Action e' l'unico consumatore (decisione della story 2026-10-08-services-to-actions-ai;
 * la classe statica `Actions/Prompt/AIPromptTemplates` riportata dalla sync e' stata tolta
 * il 2026-11-19 perche' sotto `Actions/` ogni classe deve essere una QueueableAction).
 *
 * @see Modules/AI/docs/queueable-actions.md
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
            'classification' => self::classificationPrompt(
                $title,
                $description,
            ),
            'solutions' => self::solutionsPrompt(
                $title,
                $description,
                $category,
            ),
            default => throw new \InvalidArgumentException("Unsupported AI prompt type: {$type}"),
        };
    }

    /**
     * Prompt per la classificazione automatica di un ticket.
     *
     * @see Modules/AI/docs/queueable-actions.md
     */
    private static function classificationPrompt(string $title, string $description): string
    {
        return "Classifica il seguente ticket per il servizio di gestione ticket cittadini:

Titolo: {$title}
Descrizione: {$description}

Categorie disponibili:
- infrastruttura (strade, ponti, illuminazione, segnaletica)
- ambiente (rifiuti, inquinamento, verde pubblico)
- trasporti (trasporto pubblico, parcheggi, ciclabili)
- sicurezza (sicurezza urbana, emergenze)
- servizi (uffici pubblici, documenti, pratiche)
- altro

Rispondi in formato JSON con:
{
  \"category\": \"categoria_principale\",
  \"subcategory\": \"sottocategoria\",
  \"confidence\": 0.95,
  \"tags\": [\"tag1\", \"tag2\"],
  \"urgency_indicators\": [\"indicatore1\", \"indicatore2\"]
}";
    }

    /**
     * Prompt per il suggerimento di soluzioni per un ticket.
     *
     * @see Modules/AI/docs/queueable-actions.md
     */
    private static function solutionsPrompt(string $title, string $description, string $category): string
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
