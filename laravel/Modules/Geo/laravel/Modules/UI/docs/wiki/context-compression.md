---
title: "Context Compression Setup"
module: "UI"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
related:
  - "[[UI Operating Model]]"
---

# Context Compression Setup

## Panoramica
Il sistema di compressione del contesto ora usa il setup reale del progetto:

- `qmd` per retrieval mirato
- `@ooples/token-optimizer-mcp` per comprimere e cache-izzare output MCP e tool payload ripetitivi

Questo sostituisce la precedente nota speculativa con una configurazione effettivamente installata.

## Configurazione Reale

- config condivisa: `/.mcp.json`
- config compatibilita': `/.claude/mcp_servers.json`
- config Kilo progetto: `/.kilo/kilo.jsonc`
- ignore Kilo progetto: `/.kilocodeignore`
- cache locale: `/.claude/token-optimizer-cache`
- installazione package: `bashscripts/mcp/package.json`

## Strumenti Utilizzati

### 1. QMD per Ricerca Semantica
- **Strumento**: `mcp__plugin_qmd_qmd__query`
- **Scopo**: Comprimere documenti lunghi in query semantiche concise
- **Configurazione**: 
  ```json
  {
    "searches": [
      {"type": "lex", "query": "keyword1 keyword2"},
      {"type": "vec", "query": "domanda naturale"}
    ],
    "limit": 5,
    "intent": "specific area"
  }
  ```

### 2. MCP Token Optimizer
- **Strumento**: `token-optimizer`
- **Scopo**: comprimere output voluminosi, ridurre repeated context, spostare contenuti pesanti in cache locale

### 3. Bash per Scripting
- **Strumento**: `Bash`
- **Scopo**: Automatizzare processi di compressione

## Note Operative

### script/compress-context.sh
```bash
#!/bin/bash
# Script di compressione contesto per Claude Code

# Comprimere documenti usando QMD
qmd query "$1" -c wiki --limit 3 > compressed_result.md

# Estrai keyword principali
qmd search "$1" -c fixcity-docs | head -5 > keywords.txt

# Genera sommario
qmd multi-get $(qmd search "$1" -c main_docs | head -10) | awk '/^# / {print; getline; print; print ""}' > summary.md
```

### script/compress-prompt.py
```python
#!/usr/bin/env python3
import json
import re

def compress_prompt(prompt, max_tokens=4000):
    """Comprime un mantenendo informazioni essenziali"""
    
    # Estrai e rimuovi codice non essenziale
    code_blocks = re.findall(r'```(?:\w+)?\n(.*?)\n```', prompt, re.DOTALL)
    
    # Estrai istruzioni chiave
    instructions = re.findall(r'#([^#]+)', prompt)
    
    # Comprimi mantenendo struttura
    compressed = {
        "instructions": instructions[:5],  # Prime 5 istruzioni
        "code_blocks": code_blocks[:3],   # Prime 3 code blocks
        "essential_context": extract_essential_context(prompt)
    }
    
    return json.dumps(compressed, indent=2)

def extract_essential_context(text):
    """Estrae contesto essenziale"""
    lines = text.split('\n')
    essential = []
    
    for line in lines:
        if any(keyword in line.lower() for keyword in ['import', 'use', 'require', 'config']):
            essential.append(line)
    
    return essential[:10]  # Prime 10 linee essenziali
```

Claude Code deve rileggere la config MCP dopo il riavvio del client.

Kilo Code deve invece:

- partire da `AGENTS.md` come unica istruzione extra di progetto
- usare `compaction.auto`, `compaction.prune`, `compaction.reserved`
- limitare gli MCP a `qmd` e `token-optimizer`
- ignorare `.agents`, `.kilo`, `.opencode` e cartelle runtime equivalenti
- lasciare `managedIndexingEnabled=false` finche' non esiste una scelta esplicita tra local indexing e cloud indexing
- se serve local indexing, il repo ha gia' `nomic-embed-text` e Qdrant locale con bootstrap script dedicato
- l'ultimo binding di Kilo verso embeddings e vector store va comunque verificato nel client Kilo in esecuzione

## Utilizzo

### Query Compressa
```bash
# Comprimere prima di inviare
qmd query "come configurare un form in Filament" -c wiki --limit 3

# Usare risultati nella sessione
mcp__plugin_qmd_qmd__get "compressed_result.md"
```

### Compressione Automatica
La compressione automatica dipende dal server MCP configurato, non da una variabile shell locale.

## Monitoraggio

Controlli minimi:

```bash
node -v
npm view @ooples/token-optimizer-mcp version
claude mcp list
claude mcp get token-optimizer
```

## Best Practices

1. **Wiki first**: leggere `docs/wiki/` prima dei raw docs
2. **QMD first**: preferire retrieval mirato a full-read massivi
3. **Tool compression**: lasciare al token optimizer gli output voluminosi e ripetitivi
4. **Persistenza**: riportare risultati durevoli nel wiki locale

## Troubleshooting

### Errori Comuni
- **Compressione eccessiva**: Aumentare `max_context_ratio`
- **Perdita di informazioni**: Aggiungere keyword specifiche
- **Performance**: Ottimizzare query con `limit` appropriato

### Log di Debug

Verificare:

- eseguibilita' del binario `token-optimizer-mcp`
- correttezza di `/.mcp.json`
- correttezza di `/.claude/mcp_servers.json`

## Prossimi Passi

1. usare il server su workload reali Claude Code
2. osservare se diminuiscono i read massivi di raw docs
3. continuare la riduzione dei file contesto troppo verbosi
4. per Kilo, valutare Codebase Indexing solo dopo che i path rumorosi sono esclusi

## Riferimenti

- `../../../../../docs/ai/claude/context-compression-mcp.md`
- `../../../../../docs/wiki/sources/context-compression-mcp-setup.md`
