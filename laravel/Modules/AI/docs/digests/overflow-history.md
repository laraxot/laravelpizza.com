---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 2 file oltre target 100.

### `ollama.md` — ollama


link 
https://ripeseed.io/blog/fine-tuning-open-source-llm-llama-3-mistral-and-gemma

---------------


config/ollama.php

~~~php
return [
    'model' => env('OLLAMA_MODEL', 'llama2'),
    'url' => env('OLLAMA_URL', 'http://127.0.0.1:11434'),
    'default_prompt' => env('OLLAMA_DEFAULT_PROMPT', 'Hello, how can I assist you today?'),
    'connection' => [
        'timeout' => env('OLLAMA_CONNECTION_TIMEOUT', 300),
    ],
];
~~~


### `stories/done-log.md` — Done log: story BMAD chiuse del modulo AI

# Done log: story BMAD chiuse del modulo AI

Una voce per story chiusa: id, titolo, esito in 1-3 righe. Il testo completo delle story
originali e' nel backup `~/backups/laravelpizza-docs-md-before-cap100.tar.gz` (sola lettura).
Le story attive restano in `stories/*.story.md`.

## Voci

- **agents-a2ui-surfaces** - Interfacce generate A2UI per gli agenti (epic integrazione laravelday-2026, Passaparola 2). Esito: validatore, builder e tool A2UI con test Pest; rendering verificato (KPI, grafico, tabella). Contenuto migrato in `agents.md#interfacce-generate-a2ui`.
- **agents-ag-ui-base** - Base agnostica per agenti neuron-ai con AG-UI (Passaparola 2.3). Esito: `McpToolAdapter` riusa i tool MCP come tool dell'agente, con errori restituiti come risultato del tool. Vedi `agents.md`.
- **ai-mixed-
