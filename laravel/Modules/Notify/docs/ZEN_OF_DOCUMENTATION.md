# 🧘 Zen of Documentation - Filosofia Unificata

## Premessa Fondamentale

> **"La migliore documentazione è quella che non deve essere mantenuta"**

Questo non significa non documentare. Significa documentare in modo **intelligente, sostenibile e automatico**.

---

## 🎯 I Cinque Principi dello Zen

### 1. 📦 **Single Source of Truth (SSOT)**

Ogni concetto viene documentato **UNA SOLA VOLTA** nel luogo più appropriato:

```
❌ SBAGLIATO:
- Stesso concetto in 10 file diversi
- Documentazione duplicata in moduli diversi
- README multipli con contenuto sovrapposto

✅ CORRETTO:
- Concetto documentato UNA volta
- Altri file linkano al concetto originale
- Cross-reference invece di duplicazione
```

**Regola del "Dove"**:
- **Architettura globale** → `docs/architecture/`
- **Pattern di modulo** → `laravel/Modules/*/docs/architecture/`
- **Configurazione specifica** → `laravel/Modules/*/docs/guides/`
- **Riferimento API** → `laravel/Modules/*/docs/reference/`
- **Temi** → `laravel/Themes/*/docs/`

### 2. 🔄 **Documentazione Viva (Living Docs)**

La documentazione deve essere **automaticamente aggiornata**:

```php
/**
 * Questa documentazione SI AGGIORNA DA SOLA
 * 
 * @see \Modules\Cms\Filament\Blocks\HeroBlock
 * @see tests/Unit/Blocks/HeroBlockTest.php
 */
```

**Strumenti**:
- **PHPDoc** → Genera documentazione API automaticamente
- **Test** → Documentano il comportamento esperado
- **Type hints** → Documentano i contratti
- **Git history** → Traccia cambiamenti temporali

### 3. 🗂️ **Indicizzazione Bidirezionale**

Ogni documento deve essere:
- **Trovabile** → Linkato da almeno un indice
- **Collegato** → Linka ad almeno un altro documento
- **Context-aware** → Sa dove si trova nella gerarchia

```markdown
# Hero Block

**Posizione**: CMS → Blocks → Content Blocks
**Genitore**: [Content Blocks System](../content-blocks-system.md)
**Figli**: [Hero Block Test](../../tests/blocks/hero-block.md)
**Correlati**: [BlockData Class](../../datas/BlockData.md)
```

### 4. 🚫 **No Temporal Strings**

**MAI** includere date nei nomi dei file o nel contenuto:

```bash
# ❌ CATTIVO
phpstan-analysis-2026-03-02.md
session-report-january.md
achievement-2025-10-10.md

# ✅ BUONO
phpstan-analysis.md
session-report.md
achievement.md

# Per la storia: usa git
git log --follow docs/phpstan-analysis.md
```

**Perché**:
- Le date scadono immediatamente
- Git già traccia quando è stato modificato
- Mantiene la documentazione "timeless"
- Riduce il churn dei file

### 5. 🤖 **Multi-Agent Collaboration**

La documentazione è progettata per **AI agents multipli**:

```markdown
## 🤖 AI Agent Notes

**Context**: Questo documento è stato creato per coordinare agenti AI multipli.
**Last Agent**: gsd-codebase-mapper
**Session**: 2026-03-30
**Next Steps**: Vedi issue #123 su GitHub

### Agent Coordination
- **OpenViking Context**: `openviking add-memory --title="Zen Doc"`
- **BMAD Thread**: `_bmad/threads/zen-documentation.md`
- **GSD Phase**: `.planning/phases/zen-docs/`
```

---

## 📐 Sistema di Indicizzazione Avanzato

### Indice a Strati (Layered Indexing)

```
livello-0/ (Root)
└── docs/MASTER_DOCUMENTATION_INDEX.md

livello-1/ (Module)
└── Modules/Cms/docs/00-index.md

livello-2/ (Category)
└── Modules/Cms/docs/blocks/00-index.md

livello-3/ (Specific)
└── Modules/Cms/docs/blocks/hero-block.md
```

### Regole di Indicizzazione

1. **Ogni livello ha UN indice** → `00-index.md`
2. **L'indice punta ai figli** → Lista completa
3. **I figli puntano al genitore** → Breadcrumb
4. **Cross-reference laterali** → Documenti correlati

### Controllo Ridondanza

Prima di creare un documento:

```bash
# 1. Cerca se esiste già
find . -name "*.md" -type f | xargs grep -l "Hero Block"

# 2. Controlla duplicati (90%+ similarità)
./bashscripts/docs/check-duplicates.sh

# 3. Se esiste, aggiungi cross-reference
# 4. Se non esiste, crea nel luogo appropriato
```

---

## 🎨 Pattern per Documentazione Multi-Blocco

### Problema Attuale

I file JSON delle pagine hanno **un solo blocco** `reference-page`:

```json
{
  "content_blocks": {
    "it": [
      {
        "type": "page_block",
        "data": {
          "view": "pub_theme::components.blocks.tests.reference-page"
        }
      }
    ]
  }
}
```

### Soluzione: Multi-Blocco Filament

Ogni pagina viene **spezzata in blocchi riutilizzabili**:

```json
{
  "content_blocks": {
    "it": [
      {
        "type": "hero",
        "data": {
          "title": "Appuntamento Confermato",
          "subtitle": "La tua richiesta è stata registrata",
          "image": "/images/confirmation-hero.jpg"
        }
      },
      {
        "type": "steps_summary",
        "data": {
          "steps": [
            {"title": "Dati richiedente", "status": "completed"},
            {"title": "Scelta appuntamento", "status": "completed"},
            {"title": "Verifica finale", "status": "completed"}
          ]
        }
      },
      {
        "type": "details_card",
        "data": {
          "service": "Carta d'identità",
          "location": "Municipio",
          "datetime": "2026-04-17 10:30",
          "code": "FC-AP-2026-0417"
        }
      },
      {
        "type": "cta_buttons",
        "data": {
          "primary": {"label": "Scarica PDF", "action": "download"},
          "secondary": {"label": "Torna alla home", "url": "/"}
        }
      }
    ]
  }
}
```

### Vantaggi

1. **Riutilizzabilità** → Stessi blocchi in pagine diverse
2. **Manutenibilità** → Modifica un blocco, aggiorna tutte le pagine
3. **Consistenza** → UX coerente attraverso il sito
4. **Filament-native** → Usa il Forms Builder come previsto

---

## 🔧 Strumenti e Integrazioni

### OpenViking (Global Context)

```bash
# Aggiungi contesto globale
openviking add-memory \
  --title="Zen of Documentation" \
  --content="Single source of truth, no temporal strings, multi-agent collaboration"

# Recupera contesto
openviking get-context --query="documentation philosophy"
```

### BMAD (Requirements & Architecture)

```
_bmad/
├── prd/
│   └── documentation-system.md
├── architecture/
│   └── documentation-architecture.md
├── epics/
│   └── doc-system-epics.md
└── threads/
    └── zen-documentation.md
```

### GSD (Execution)

```
.planning/
├── phases/
│   ├── 01-doc-audit/
│   ├── 02-deduplication/
│   ├── 03-indexing/
│   └── 04-multi-block-json/
└── roadmap.md
```

### Ralph Loop (Autonomous)

```bash
# Esecuzione autonoma di task ripetitivi
ralph-loop run \
  --task="Find and merge duplicate documentation files" \
  --until="No duplicates remain"
```

### NotebookLM (Knowledge Base)

```bash
# Crea source dalla documentazione
python scripts/notebooklm/create_source.py \
  --name="FixCity Documentation" \
  --files="docs/**/*.md"

# Fai domande contestuali
python scripts/run.py ask_question.py \
  --question="How do blocks work in Filament?"
```

---

## 📋 Checklist di Qualità

### Prima di Creare Documentazione

- [ ] Ho cercato se esiste già documentazione sull'argomento
- [ ] Ho identificato il luogo appropriato (SSOT)
- [ ] Ho definito lo scopo e il pubblico target
- [ ] Ho preparato esempi di codice reali
- [ ] Ho pianificato cross-reference

### Dopo Aver Creato Documentazione

- [ ] Ho aggiornato l'indice del modulo
- [ ] Ho aggiunto breadcrumb di navigazione
- [ ] Ho linkato documenti correlati
- [ ] Ho verificato che non ci siano duplicati
- [ ] Ho aggiunto note per AI agents (se applicabile)

### Manutenzione Continua

- [ ] Eseguo `check-duplicates.sh` settimanalmente
- [ ] Aggiorno gli indici mensilmente
- [ ] Archivia report temporanei trimestralmente
- [ ] Eseguo audit DRY/KISS semestralmente

---

## 🎯 Metriche di Successo

| Metrica | Attuale | Target | Come Misurare |
|---------|---------|--------|---------------|
| **Duplicate Content** | 43-57% | <1% | `check-duplicates.sh` |
| **Index Files per Modulo** | 5-10 | 1-2 | Count `*index*.md` |
| **Orphaned Files** | 43-57% | <5% | Link analysis |
| **Temporal Filenames** | 500+ | 0 | `find *-202*.md` |
| **Code Examples** | 60% | 80% | Sample audit |
| **Cross-References** | 50% | 90% | Link density |

---

## 🚀 Implementazione Roadmap

### Fase 1: Foundation (Settimana 1-2)
- [ ] Creare indici unificati per modulo
- [ ] Rimuovere nomi temporali dai file
- [ ] Configurare OpenViking globale
- [ ] Creare BMAD threads per coordinamento

### Fase 2: Deduplication (Settimana 3-4)
- [ ] Eseguire audit duplicati
- [ ] Unire contenuti duplicati
- [ ] Creare cross-reference
- [ ] Archiviare documenti storici

### Fase 3: Multi-Block JSON (Mese 2)
- [ ] Definire blocchi Filament per pagine statiche
- [ ] Convertire JSON da single-block a multi-block
- [ ] Testare rendering con Filament Forms Builder
- [ ] Documentare pattern di conversione

### Fase 4: Automation (Mese 3)
- [ ] Creare script di validazione automatica
- [ ] Integrare NotebookLM per query contestuali
- [ ] Configurare Ralph Loop per manutenzione
- [ ] Implementare quality gates in CI/CD

---

## 📚 Risorse Correlate

- [Documentation Governance](../../docs/DOCUMENTATION_GOVERNANCE.md)
- [Multi-Agent Collaboration](../../docs/MULTI_AGENT_COLLABORATION.md)
- [Filament Blocks System](../blocks/content-blocks-system.md)
- [OpenViking Global Context](../../bashscripts/ai/openviking.md)

---

**Stato**: ✅ Draft
**Ultima Revisione**: 2026-03-30
**Prossima Revisione**: Dopo Fase 1 completion
**Owner**: Multi-Agent Team (BMAD + GSD + Ralph)
