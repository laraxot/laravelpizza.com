# LLM Wiki — Adozione per Moduli e Temi

> Stato: adottato
> Aggiornato: 2026-04-15
> Fonte originale: [gist Karpathy](https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f)
> Schema globale: [../../docs/.schema/WIKI_SCHEMA.md](../../docs/.schema/WIKI_SCHEMA.md)

## Mapping FixCity

Il pattern originale di Karpathy usa tre cartelle distinte alla root del progetto:

```
project/
├── raw/     # fonti immutabili
├── wiki/    # conoscenza compilata dall'LLM
└── schema/  # CLAUDE.md / AGENTS.md
```

Nel nostro caso, ogni modulo e tema ha già una cartella `docs/`. Il mapping naturale è:

```
laravel/Modules/<Name>/docs/       ← l'intera docs/ = layer "raw"
├── wiki/                          ← layer "wiki" (LLM-maintained)
│   ├── index.md                   # catalogo tematico
│   ├── log.md                     # log append-only (ingest|query|lint|decision)
│   ├── concepts/                  # pattern, architettura, metodologie
│   ├── entities/                  # classi, componenti, modelli
│   ├── summaries/                 # sintesi di documenti lunghi
│   ├── comparisons/               # tabelle comparative
│   └── overviews/                 # panoramiche tematiche
├── raw/                           # raw esplicito: HTML dump, JSON, asset analisi
├── stories/                       # raw: user stories, spec
├── archive/                       # raw: documenti superati
└── *.md                           # raw: tutta la documentazione esistente
```

Lo **schema globale** è centralizzato: `docs/.schema/WIKI_SCHEMA.md`.
Non serve uno schema locale per ogni modulo.

## Regola fondamentale

| Layer | Cartella | Chi scrive | Chi legge |
|-------|----------|-----------|-----------|
| Raw | `docs/` (root + sottocartelle eccetto `wiki/`) | Umano + agente | Agente |
| Wiki | `docs/wiki/` | Agente (LLM) | Umano + agente |
| Schema | `docs/.schema/WIKI_SCHEMA.md` | Umano | Agente |

**I file in `docs/` (layer raw) non vengono riscritti per "migliorarli".**
Se serve una sintesi, va in `docs/wiki/`, non nella fonte.

## Workflow per gli agenti

### Ingest — quando arriva una nuova fonte nel modulo

1. La fonte arriva in `docs/` (o `docs/raw/` se è un dump/asset)
2. L'agente legge la fonte
3. Crea o aggiorna pagine in `docs/wiki/` (sommario, entity, concept)
4. Aggiorna `docs/wiki/index.md` con il nuovo nodo
5. Appende a `docs/wiki/log.md`:
   ```
   ## [YYYY-MM-DD] ingest | <titolo fonte>
   - Sintesi di cosa è stato appreso
   - Pagine wiki create/aggiornate
   ```

### Query — quando si fa una domanda sul dominio del modulo

1. Apri `docs/wiki/index.md` — catalogo dei nodi disponibili
2. Apri le pagine wiki rilevanti
3. Scendi ai file raw solo per verifica puntuale
4. Se la risposta produce una sintesi riusabile → salva in `docs/wiki/`
5. Appende a `docs/wiki/log.md`:
   ```
   ## [YYYY-MM-DD] query | <domanda breve>
   - Risposta sintetizzata
   - Nuove pagine create se applicabile
   ```

### Lint — pulizia periodica

Controlla:
- Pagine `wiki/` senza backlink da `index.md`
- File duplicati con contenuto sovrapposto in `docs/`
- Pagine wiki con affermazioni superate da fonti più recenti
- Gap informativi: aree del modulo non ancora documentate nel wiki

Appende a `log.md`:
```
## [YYYY-MM-DD] lint | <scope>
- Problemi trovati
- Azioni eseguite
```

## Struttura minima per ogni modulo/tema

Ogni `docs/` di modulo e tema deve avere almeno:

```
docs/
├── wiki/
│   ├── index.md    # catalogo (obbligatorio)
│   └── log.md      # log append-only (obbligatorio)
├── raw/
│   └── index.md    # lista fonti raw esplicite
└── README.md       # o INDEX.md — entrypoint umano
```

## Priorità wiki per modulo

Non ogni modulo ha lo stesso volume documentale. Linea guida:

| Modulo | Priorità wiki | Motivazione |
|--------|--------------|-------------|
| Fixcity | Alta | Dominio principale, wizard complesso, ticket flow |
| Geo | Alta | Molti pattern, integrazioni mappe, enums |
| Xot | Alta | Base framework, pattern Laraxot fondamentali |
| Cms | Media | Folio routing, componenti condivisi |
| User | Media | Auth, permessi, profilo |
| Sixteen | Alta | Tema principale, design-comuni compliance |
| Altri | Bassa | Bootstrap minimo, crescono on-demand |

## Nota: docs/ come raw layer

La scelta di trattare `docs/` come layer raw è pragmatica:
i file già esistenti in `docs/` sono fonti scritte da umani o da agenti in sessioni precedenti.
Sono l'input per il wiki, non il wiki stesso.

Il wiki (`docs/wiki/`) è più piccolo, più stabile, più navigabile.
Deve contenere **sintesi ad alto riuso**, non archivi di report usa-e-getta.

Vedi anche: [karpathy-llm-wiki-adoption.md](./karpathy-llm-wiki-adoption.md) — adozione a livello root progetto.
