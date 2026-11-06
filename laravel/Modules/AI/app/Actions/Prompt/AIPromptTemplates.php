<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Prompt;

/**
 * Template dei prompt per le varie operazioni AI.
 *
 * Contiene i prompt costruiti in modo statico per tipo; i valori vengono iniettati
 * tramite placeholder. I template sono riusati da `BuildAIPromptAction` e da
 * `ClassifyTicketAction`/`SuggestSolutionsAction`.
 */
final class AIPromptTemplates
{
    /**
     * Prompt per la classificazione automatica di un ticket.
     */
    public static function classification(string $title, string $description): string
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
     */
    public static function solutions(string $title, string $description, string $category): string
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
