# LLM Wiki Karpathy - Struttura Documentazione

## Introduzione

Questa struttura basata sul modello Karpathy LLM Wiki viene utilizzata per organizzare la documentazione in modo sistematico e ricercabile attraverso tutto il progetto PTVX.

## Struttura delle Cartelle

```
docs/
├── raw/                    # Documenti grezzi e fonti primarie
│   ├── decisions/          # Decisioni architettoniche
│   ├── papers/            # Ricerche e paper
│   ├── code-examples/     # Esempi di codice
│   ├── articles/          # Articoli tecnici
│   └── concepts/          # Concetti fondamentali
├── wiki/                  # Wiki principale (generato automaticamente)
│   ├── concepts/          # Concetti spiegati
│   ├── how-to/            # Guide pratiche
│   ├── tutorials/         # Tutorial passo-passo
│   └── reference/         # Riferimenti API
├── source/                # Sorgenti della documentazione
│   └── docs/              # Documenti sorgente
└── generated/             # Documenti generati automaticamente
    ├── api/               # Documentazione API
    └── guides/            # Guide generate
```

## Principi Karpathy LLM Wiki

1. **Documentazione come Codice**: La documentazione è versionata e gestita come il codice sorgente
2. **Ricerca Semantica**: Utilizza embeddings per la ricerca contestuale
3. **Interconnessioni**: I documenti sono linkati tra loro per creare una rete di conoscenza
4. **Aggiornamento Automatico**: La documentazione si aggiorna con il codice

## Implementazione nei Moduli

Ogni modulo e tema deve seguire questa struttura:

```
[MODULE_NAME]/
├── docs/
│   ├── raw/               # Documenti grezzi specifici del modulo
│   │   ├── decisions/      # Decisioni di progetto per il modulo
│   │   ├── api/           # Specifiche API del modulo
│   │   └── concepts/     # Concetti specifici del modulo
│   ├── wiki/              # Wiki del modulo
│   │   ├── guides/        # Guide specifiche
│   │   ├── how-to/       # How-to specifici
│   │   └── reference/     # Riferimenti interni
│   └── source/            # Sorgenti documentazione
│       └── docs/         # File sorgente
└── ...                    # Altre cartelle del modulo
```

## Utilizzo di QMD

QMD (Queryable Markdown Database) è configurato per:
- Indizzare tutti i documenti raw
- Generare embeddings per la ricerca semantica
- Creare un wiki navigabile
- Supportare ricerche ibride (keyword + semantica)

## Comandi Utili

```bash
# Inizializzare QMD per un nuovo modulo
qmd collection add docs/raw

# Generare embeddings
qmd embed

# Ricercare nella documentazione
qmd query "come funziona l'autenticazione?"

# Avviare il MCP server
qmd mcp
```

## Best Practices

1. **Documenta mentre scrivi**: Aggiungi documentazione durante lo sviluppo
2. **Usa link interni**: Collega i concetti tra loro
3. **Mantieni aggiornati**: Aggiorna la documentazione con le modifiche
4. **Usa esempi**: Fornisci esempi pratici
5. **Sii conciso**: Vai dritto al punto con spiegazioni chiare