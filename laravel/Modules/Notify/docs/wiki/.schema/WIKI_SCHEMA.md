# LLM Wiki Schema

Questo documento istruisce l'LLM su come costruire e mantenere la Wiki Knowledge Base secondo il pattern Karpathy.

## Architettura

Il sistema wiki si articola in tre layer:

### Layer 1: Raw Sources (`raw/`)
- **Posizione**: `docs/raw/` nella root e `docs/raw/` in ogni modulo/tema
- **Contenuto**: Documenti sorgente grezzi (articoli, paper, RFC, documentazione, note)
- **Regola**: IMMUTABILI - l'LLM legge ma non modifica mai questi file
- **Scopo**: Fonte di verità verificabile

### Layer 2: Wiki (`wiki/`)
- **Posizione**: `docs/wiki/` nella root e `docs/wiki/` in ogni modulo/tema
- **Contenuto**: File markdown generati e mantenuti dall'LLM
- **Tipi di pagina**:
  - `concepts/` - Pagine concetto (pattern, architettura, metodologie)
  - `entities/` - Pagine entità (moduli, classi, componenti)
  - `summaries/` - Sommari (sintesi di documenti complessi)
  - `comparisons/` - Confronti (tabelle comparativas)
  - `overviews/` - Panoramiche (sintesi di aree tematiche)
- **Regola**: L'LLM SCrive e mantiene; l'umano legge e naviga

### Layer 3: Schema (questo file)
- **Posizione**: `docs/.schema/WIKI_SCHEMA.md`
- **Scopo**: Istruisce l'LLM su convenzioni, workflow e struttura

## Operazioni

### Ingest
Quando aggiungi un nuovo sorgente:
1. Leggi il documento sorgente
2. Estrai i punti chiave
3. Crea/aggiorna pagine nella wiki:
   - Sommario del documento
   - Entity pages rilevanti
   - Concept pages se necessario
4. Aggiorna l'INDEX.md
5. Appendi a LOG.md

### Query
Quando rispondi a domande:
1. Consulta INDEX.md per trovare pagine rilevanti
2. Leggi le pagine identificate
3. Sintetizza una risposta con citazioni
4. **Opzionale**: Salva la risposta come nuova pagina wiki

### Lint
Periodicamente:
- Cerca contraddizioni tra pagine
- Verifica link funzionanti
- Identifica pagine orfane
- Proponi nuove connessioni

## Convenzioni di Naming

### File Wiki
```
# Formato: kebab-case
nome-concetto.md
nome-entita.md
nome-panoramica.md
```

### Frontmatter
```yaml
---
title: Nome Visualizzato
type: concept|entity|summary|comparison|overview
tags: [tag1, tag2]
sources: [relative/path/to/source.md]
created: 2026-04-15
updated: 2026-04-15
related: [altra-pagina.md, ancora-un-altra.md]
---
```

### Link Interni
```markdown
<!-- Usa path relativi -->
Vedi [[../entities/module-x|Module X]]

<!-- O path assoluti dalla root wiki -->
Vedi [[concepts/dependency-injection]]
```

## Struttura Directory

```
docs/
├── index.md              # Indice principale della wiki
├── log.md                # Log cronologico
├── .schema/
│   └── WIKI_SCHEMA.md   # Questo file
├── raw/                  # Sorgenti globali
│   ├── articles/
│   ├── papers/
│   └── notes/
└── wiki/                 # Wiki LLM-maintained
    ├── index.md         # Indice locale
    ├── concepts/
    ├── entities/
    ├── summaries/
    ├── comparisons/
    └── overviews/
```

## Formato INDEX.md

```markdown
# Wiki Index

## Concepts
- [[concepts/nome-concetto]] - Descrizione breve

## Entities
- [[entities/nome-entita]] - Descrizione breve

## Summaries
- [[summaries/nome-sommario]] - Fonte: [[raw/...]]

## Last Updated
- [[log.md|Vedi log completo]]
```

## Formato LOG.md

```markdown
# Wiki Log

## [2026-04-15] ingest | Titolo Fonte
- Aggiunto [[wiki/summary/titolo-fonte]]
- Aggiornato [[wiki/concepts/concetto-correlato]]

## [2026-04-15] query | Domanda sintetica
- Risposto consultando [[wiki/concepts/...]]

## [2026-04-15] lint | Health Check
- Trovate 2 contraddizioni, risolte
```

## Regole di Mantenimento

1. **Cross-reference**: Ogni pagina deve linkare almeno 2 altre pagine
2. **Citazioni**: Ogni claim deve avere almeno un source in frontmatter
3. **Aggiornamento**: Quando un source viene aggiornato, rivedi le pagine correlate
4. **Consistenza**: Mantieni lo stesso stile e formato in tutte le pagine

## Integrazione con il Progetto

### Moduli
Ogni modulo in `laravel/Modules/<Nome>/docs/` avrà:
- `wiki/` - Wiki specifica del modulo
- `raw/` - Sorgenti specifici del modulo
- `INDEX.md` - Indice locale

### Temi
Ogni tema in `laravel/Themes/<Nome>/docs/` avrà:
- `wiki/` - Wiki specifica del tema
- `raw/` - Sorgenti specifici del tema
- `INDEX.md` - Indice locale

### Reference Bidirezionale
- Ogni INDEX locale punta all'INDEX globale
- L'INDEX globale ссылается a tutti gli INDEX locali

## Workflow Raccomandato

1. **Bootstrap**: Genera pagine iniziali per ogni modulo
2. **Ingest Incrementale**: Processa sorgenti uno alla volta
3. **Manutenzione Settimanale**: Esegui lint e aggiorna cross-references
4. **Esplorazione**: Salva domande interessanti come pagine wiki

## Tools Raccomandati

- **qmd**: Motore di ricerca locale (BM25 + vector search)
- **Obsidian**: Per navigare e visualizzare la wiki
- **Git**: Version history automatico per la wiki

---

Ultimo aggiornamento: 2026-04-15
