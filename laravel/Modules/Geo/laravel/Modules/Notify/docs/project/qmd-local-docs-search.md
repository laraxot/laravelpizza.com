# QMD — ricerca locale su documentazione e note

**Riferimento upstream**: [github.com/tobi/qmd](https://github.com/tobi/qmd) (MIT). Documentazione dettagliata: [README](https://github.com/tobi/qmd/blob/main/README.md), [CHANGELOG](https://github.com/tobi/qmd/blob/main/CHANGELOG.md), sintassi query: [docs/SYNTAX.md](https://github.com/tobi/qmd/blob/main/docs/SYNTAX.md) (se presente nel tag che usi).

## Scopo (business logic)

[QMD](https://github.com/tobi/qmd) (“Query Markup Documents”) è un **motore di ricerca tutto locale** per file Markdown (e contenuti indicizzabili): note, trascrizioni, knowledge base, **`docs/` di repository**. Non sostituisce la comprensione del dominio: **accelera il retrieval** quando il corpus cresce.

Pipeline tipica (da upstream):

- **BM25** full-text (SQLite FTS5);
- **ricerca vettoriale** (embedding locali);
- **fusione** dei risultati (es. RRF — Reciprocal Rank Fusion);
- opzionale **reranking** via LLM locale (**node-llama-cpp** + modelli **GGUF**).

Output pensati per **flussi agentici** (CLI con `--json` / `--files`, **SDK** `@tobilu/qmd`, server **MCP**).

## Relazione con il pattern LLM Wiki (Karpathy)

| Layer | Ruolo | Dove sta in FixCity |
|-------|--------|---------------------|
| **Wiki compilato** | Sintesi persistente, link, contraddizioni segnalate | [`karpathy-llm-wiki-adoption.md`](./karpathy-llm-wiki-adoption.md), [`../wiki/index.md`](../wiki/index.md), topic pages in `docs/wiki/` |
| **Ricerca (QMD)** | Trovare *rapidamente* file e passaggi rilevanti nel corpus `.md` | Questo documento + indice locale |
| **Fonti raw** | Immutabili, materiali grezzi | `.planning/`, `design-artifacts/`, allegati, ecc. (vedi adozione Karpathy) |

QMD risolve il problema “**in quale file era scritto X?**” a scala grande. Il wiki risolve “**cosa abbiamo deciso e come si collega?**”. L’agente può: query QMD → leggere i file → aggiornare `docs/wiki/` e il log.

## Perché nel progetto FixCity

- Indicizzare `docs/`, `laravel/Modules/*/docs/`, `laravel/Themes/*/docs/` senza inviare il corpus a servizi esterni.
- Dare agli agenti **query** e **retrieve** allineati alla policy “docs come memoria”.
- Opzionale: server **MCP** (`qmd mcp`) con strumenti orientati al retrieval (vedi [README upstream — MCP](https://github.com/tobi/qmd#mcp-server)).

## Requisiti e versioni

- Upstream evolve rapidamente (release **v2.x** dal 2026: SDK stabile `QMDStore`, MCP come consumer del SDK). Verificare la propria installazione:

```bash
qmd --version
```

- In molti ambienti è consigliato **Node.js ≥ 22** (upstream ha sistemato packaging e ABI per moduli nativi); se usi versioni minori, preferisci `npx @tobilu/qmd` con Node aggiornato o leggi il CHANGELOG del tuo tag.
- **Embedding multilingua**: variabile ambiente `QMD_EMBED_MODEL` (vedi README upstream) per corpora non inglesi.

## Installazione

```bash
npm install -g @tobilu/qmd
# oppure
bun install -g @tobilu/qmd
```

Esecuzione senza install globale: `npx @tobilu/qmd` / `bunx @tobilu/qmd`.

### Configurazione locale consigliata in questo repository

In ambienti con `~/.config` in sola lettura, usa percorsi locali scrivibili:

```bash
export XDG_CONFIG_HOME=/var/www/_bases/base_fixcity_fila5/.cache/qmd-config
export XDG_CACHE_HOME=/var/www/_bases/base_fixcity_fila5/.cache/qmd-cache
export HOME=/var/www/_bases/base_fixcity_fila5/.cache/qmd-home
```

Con questa configurazione, l'indice attivo vive sotto `.cache/qmd-cache/qmd/index.sqlite` invece che nella home utente.

## Flusso minimo (CLI)

Dalla root del clone (adattare i path):

```bash
# Collezioni: una o più directory di .md
qmd collection add ./docs --name fixcity-root-docs
qmd collection add ./laravel/Modules --name fixcity-modules --mask "**/docs/**/*.md"

# Contesto testuale (migliora rilevanza nelle spiegazioni lato tool)
qmd context add qmd://fixcity-root-docs "Documentazione progetto FixCity (root docs/)"
qmd context add qmd://fixcity-modules "Documentazione moduli Laravel (path Modules/*/docs/)"

# Indicizzazione e embedding (embedding = modelli locali, vedi upstream)
qmd update
qmd embed

# Ricerca: preferire il comando unificato hybrid dove disponibile (nomi esatti dipendono dalla versione)
qmd query "filament wizard ticket"
# Alcune versioni espongono anche ricerca lessicale / vettoriale separata — consultare `qmd --help`

# Recupero documento per path
qmd get "docs/project/karpathy-llm-wiki-adoption.md" --full

# Stato indice
qmd status
```

**Query strutturate (versioni recenti)**: upstream documenta **query document** con righe tipizzate (`lex:`, `vec:`, `hyde:`) per combinare precisione lessicale e recall semantico. Vedi [SYNTAX](https://github.com/tobi/qmd/blob/main/docs/SYNTAX.md) nel repository alla revisione installata.

## MCP (Model Context Protocol)

Avvio server **stdio** (default integrazione Cursor/Claude):

```bash
qmd mcp
```

**HTTP** (porta default **8181**; mantiene modelli caldi tra le richieste — utile per latenza):

```bash
qmd mcp --http
# oppure daemon in background (dettagli in README upstream)
```

Strumenti tipici esposti (naming esatto dipende dalla versione; in v2.x il tool unificato è spesso **`query`** per ricerca hybrid + **`get`** / **`multi_get`** per retrieval):

- **`query`** — ricerca con sotto-query tipizzate e combinazione risultati;
- **`get`** — contenuto per path o docid;
- **`status`** — stato indice.

Configurazione client: [sezione MCP del README QMD](https://github.com/tobi/qmd#mcp-server). Indice MCP del progetto: [docs/mcp/index.md](../mcp/index.md).

**Plugin Claude Code** (opzionale): upstream menziona marketplace `tobi/qmd` — utile se lavori in quell’ecosistema.

## SDK (Node/Bun)

Da **v1.1.6+** / **v2.0+**: `import { createStore } from '@tobilu/qmd'` con `dbPath` esplicito per integrare QMD in tool interni senza shell out. Utile solo se costruiamo automazioni custom; per gli agenti nel repo bastano CLI + MCP.

## Dipendenze e limiti

- **Modelli GGUF** e **node-llama-cpp**: primo avvio può scaricare modelli; serve spazio disco e RAM/VRAM compatibili con la macchina.
- Indice e database sono **locali** (cache sotto `~/.cache/qmd` o path documentato upstream): **non versionare** l’indice nel repo salvo esigenze esplicite.
- QMD non “capisce” il dominio Laravel da solo: indicizza testo. La **governance** resta in [`docs-governance.md`](./docs-governance.md) e nel wiki layer.

## Miglioramento continuo (suggerimenti operativi)

1. **Aggiornare** `@tobilu/qmd` periodicamente e rieseguire `qmd update && qmd embed` dopo grandi merge su `docs/`.
2. **Una collezione per area** (root `docs/`, `Modules`, `Themes`) per filtrare le query e ridurre rumore.
3. **Dopo ingest importante** nel senso Karpathy, aggiornare [`../wiki/log.md`](../wiki/log.md) e, se serve, [`../wiki/index.md`](../wiki/index.md) — QMD non sostituisce il catalogo manuale.
4. **Lint wiki** (periodicità definita in adozione Karpathy): QMD può aiutare a trovare file correlati, ma la coerenza semantica resta un compito guidato.

## Collegamenti

- Pattern wiki persistente: [karpathy-llm-wiki-adoption.md](./karpathy-llm-wiki-adoption.md)
- Catalogo nodi wiki: [../wiki/index.md](../wiki/index.md)
- Indice documentazione progetto: [README.md](./README.md)
- MCP index: [../mcp/index.md](../mcp/index.md)
- Repository: [tobi/qmd](https://github.com/tobi/qmd)
- Gist Karpathy (LLM Wiki): <https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f>
