<?php

declare(strict_types=1);

/*
 * Debito di architettura di Modules\AI: classi che oggi violano una regola di Modules/Xot/tests/Arch/ArchitectureTest.php.
 * Misurato il 2026-11-18. Solo in discesa: chi corregge una classe la toglie, chi aggiunge una voce lo spiega nella PR.
 * Ogni voce deve stare nel namespace di questo pacchetto (lo verifica ArchitectureTest).

 * ADR: Modules/Xot/docs/adr/architecture-tests-pest-arch.md
 */

return [
    // md5/sha1/uniqid/rand/extract nel codice di produzione: quasi sempre usi non crittografici (chiavi di cache, id), da rivedere uno per uno; factory e seeder sono esclusi a parte
    'security' => [
        'Modules\AI\Actions\ClassifyTicketAction',
        'Modules\AI\Actions\SuggestSolutionsAction',
    ],
    // classi in un namespace Services (regola No Services, DCP-270); NoServicesTest le vede come cartelle
    'services' => [
        'Modules\AI\Services\AIChatCompletionClient',
        'Modules\AI\Services\AIService',
        'Modules\AI\Services\AIServiceJsonDecoder',
        'Modules\AI\Services\AIServicePromptBuilder',
        'Modules\AI\Services\AIServicePromptTemplates',
    ],
];
