<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Prompt;

use Spatie\QueueableAction\QueueableAction;

final class BuildTicketClassificationPromptAction
{
    use QueueableAction;

    public function execute(string $title, string $description): string
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
}
