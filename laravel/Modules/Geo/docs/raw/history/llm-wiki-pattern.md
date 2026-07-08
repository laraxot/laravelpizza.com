# LLM Wiki - Karpathy Pattern

## Filosofia

Pattern per costruire knowledge base personali usando LLMs, originato da [Karpathy](https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f).

**Idea centrale**: Invece di fare RAG (recupero a query-time), l'LLM costruisce e mantiene una **wiki persistente** - una collezione strutturata e interconnessa di file markdown che sta tra te e le sorgenti raw.

## Architettura 3 Layer

```
┌─────────────────────────────────────────────────────────────┐
│                        LLM Wiki                             │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────┐     │
│  │    RAW      │    │    WIKI     │    │   SCHEMA    │     │
│  │  sources/   │───▶│   wiki/    │◀───│ AGENTS.md   │     │
│  └─────────────┘    └─────────────┘    └─────────────┘     │
│        │                  │                  │               │
│        │                  │                  │               │
│   Immutable           LLM Owned          LLM Instructions    │
│   Source of Truth     Maintained         & Conventions      │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### 1. Raw Sources (`./docs`)

Documenti sorgente curati - articoli, paper, immagini, dati. **Immutabili** - l'LLM legge ma non modifica. Fonte di verità.

```
docs/
├── papers/
├── articles/
├── notes/
└── assets/
```

### 2. Wiki (`./docs/wiki`)

File markdown generati dall'LLM - summary, entity pages, concept pages, comparisons. L'LLM possiede questo layer completamente.

```
docs/wiki/
├── index.md           # Catalogo di tutto
├── log.md             # Registro append-only
├── concepts/          # Pagine concetto
├── entities/          # Pagine entità (modelli, servizi)
├── sources/           # Riferimenti fonti
└── comparisons/       # Tabelle comparative
```

### 3. Schema (`./docs/wiki/SCHEMA.md`)

Documento che istruisce l'LLM su come è strutturata la wiki, convenzioni, e workflow.

## File Speciali

### index.md - Catalogo Contenuto

```markdown
# Wiki Index

## Entities
- [User Model](./entities/user-model.md) - User management

## Concepts
- [Authentication](./concepts/authentication.md) - OAuth flow

## Sources
- [Laravel Auth Docs](./sources/laravel-auth.md)
```

### log.md - Registro Cronologico

```markdown
# Wiki Log

## [2026-04-15] ingest | User Authentication
- Processed Laravel Sanctum documentation
- Updated auth-flow.md
- Created oauth-entities.md

## [2026-04-14] query | JWT vs Sessions
- Retrieved from concepts/authentication.md
- Answer synthesized
```

## Operazioni

### Ingest
1. Aggiungi sorgente a `docs/`
2. LLM legge il source
3. LLM crea/aggiorna pagine wiki
4. LLM aggiorna index.md
5. LLM appende a log.md

### Query
1. LLM legge index.md per trovare pagine rilevanti
2. LLM drill-down nelle pagine
3. LLM sintetizza risposta con citazioni

### Lint
1. LLM health-check della wiki
2. Cerca contraddizioni, claim stale, orphan pages
3. Suggerisce cross-references mancanti

## Tools

### qmd - Search Engine Locale

CLI per search engine markdown con BM25/vector search e MCP server.

```bash
# Install
npm install -g @tobilu/qmd

# Index docs
qmd add module-wydocs ./docs --name module

# Search
qmd search "authentication"
qmd query "how does auth work"
```

## Applicazione al Progetto

Per ogni modulo/tema:

```
<module>/
├── docs/                    # Raw sources (immutable)
│   ├── papers/
│   ├── articles/
│   └── notes/
└── docs/wiki/              # Wiki (LLM owned)
    ├── index.md
    ├── log.md
    ├── SCHEMA.md           # Istruzioni per LLM
    ├── concepts/
    ├── entities/
    ├── sources/
    └── comparisons/
```

## Reference

- [Karpathy LLM Wiki Gist](https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f)
- [qmd Repository](https://github.com/tobi/qmd)
