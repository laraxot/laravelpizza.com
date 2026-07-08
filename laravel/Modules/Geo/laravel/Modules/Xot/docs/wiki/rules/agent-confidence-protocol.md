---
name: agent-confidence-protocol-xot
description: Strategia operativa per massimizzare confidenza agentiva nel modulo Xot (core framework)
metadata:
  type: rule
  enforced: on-demand per task Xot
  updated: 2026-05-26
---

# Agent Confidence Protocol — Xot Module

> **Obiettivo:** Xot è core framework. Confidenza massimale richiede verification triple-layer: code + git + wiki canonici.

## 6 Strategie Operative (Xot-Specifiche)

### 1. Carico on-demand da Xot core

**Regola:** Xot ha 29+ moduli dipendenti. Non assumere trait/pattern senza verificare:
- `git log laravel/Modules/Xot --oneline | head -20` — cambi recenti core
- `grep -r "class.*XotBase" laravel/Modules/Xot/` — base class inheritance
- `ls laravel/Modules/Xot/Traits/` — trait disponibili

**Quando applico:**
- Estendere Filament resource via XotBase
- Aggiungere trait Xot-specific a modulo dipendente
- Refactor core Xot class (impatto 29+ moduli)

**Documento dubio:** Esempio in user-confidence-protocol.md § 1

---

### 2. Wikifi core patterns Xot

**Regola:** Ogni pattern Xot → `laravel/Modules/Xot/docs/wiki/concepts/`

**Pattern critici da wikificare:**
- `xotbase-critical-rules.md` — inheritance chain XotBase
- `xotbase-resource-zen-pattern.md` — minimalist resource extension
- `xotbase-never-extend-filament.md` — anti-pattern (extension must go via XotBase, not direct Filament)
- `laravel-13-modular-package-compatibility-matrix.md` — Xot version vs Laravel 13 compatibility

**Quando applico:**
- Scopri nuovo pattern XotBase non documentato
- Dubbio su inheritance vs composition con XotBase
- Cross-modulo dipendenza Xot non chiara

---

### 3. Verifico contro autorità Xot

**Autorità (in ordine):**

1. **XotBase source code** (laravel/Modules/Xot/src/)
   - `cat laravel/Modules/Xot/src/XotBaseResource.php` — Filament resource base
   - `cat laravel/Modules/Xot/src/Traits/*` — available traits
   - `git diff HEAD~5 laravel/Modules/Xot/src/ | grep "class\|function"` — recent changes

2. **QMD (Xot-specific search)**
   ```bash
   qmd search "XotBase pattern resource extension" --collection module_Xot --limit 5
   ```

3. **Moduli dipendenti (Activity, Job, Rating, User)**
   - Pattern di come Activity/Job estendono XotBase
   - `grep -r "extends XotBase" laravel/Modules/{Activity,Job,Rating}/`

4. **Memory + Filament versioning**
   - [[filament-version-policy]] — Xot usa v5, non v4
   - [[xotbase-never-extend-filament]] — memoria critica

**Documento dubio:**
```markdown
❓ **Non verificato — XotBase __construct inheritance chain**
- Code: `laravel/Modules/Xot/src/XotBaseResource.php:XX`
- Recent activity: `[[activity-xotbase-zen-pattern]]` (Activity module ha pattern)
- Memory: [[xotbase-never-extend-filament]]
- Conflitto potenziale: extension chain vs direct Filament

→ Risoluzione: leggi XotBase source + audit Activity/Job usage
```

---

### 4. Context-mode per cross-modulo Xot

**Regola:** Audit XotBase impact su 29 moduli → context-mode sandbox

**Scenario: Analizzare XotBase usage pattern**
```bash
ctx_batch_execute(
  commands: [
    {label: "XotBase classes extending", command: "grep -r 'extends XotBase' laravel/Modules/ | wc -l"},
    {label: "XotBase trait usage", command: "grep -r 'use.*Xot.*Trait' laravel/Modules/ | cut -d: -f1 | sort -u | wc -l"},
    {label: "Activity XotBase pattern", command: "grep -A5 'class.*Resource extends XotBaseResource' laravel/Modules/Activity/Filament/"}
  ],
  queries: ["Total XotBase extending count", "Cross-modulo trait pattern", "Activity ZEN pattern example"]
)
```

**Quando applico:**
- Cambiare XotBase signature (impact 29+ moduli)
- Audire trait adoption across moduli
- Documentare pattern ricorrente

---

### 5. Documento il dubbio su Xot core

**Regola:** Xot impatta tutti. Se non sicuro → documenta, non skippa.

✅ **Cosa fare:**
```markdown
## XotBase Resource Extension Pattern

Tutti i moduli (Activity, Job, Rating, User) estendono XotBaseResource.

❓ **Non verificato:**
- Se XotBase::definition() caching funziona con soft-deleted resources
- Se XotBase property visibility (protected $resource) è onorato dai child moduli
- → Verificare: `laravel/Modules/Xot/src/XotBaseResource.php` line XX

Pattern esempio: [[activity-xotbase-zen-pattern]]
Memoria: [[xotbase-never-extend-filament]]
```

---

### 6. Audito Xot dopo refactor

**Regola:** Post-edit Xot core → phpstan + impact audit + docs update

**Checklist post-modifica Xot:**

- [ ] **PHPStan on Xot + top 5 dipendenti:**
  ```bash
  ./tools/phpstan laravel/Modules/Xot
  ./tools/phpstan laravel/Modules/{Activity,User,Job,Rating,Media}
  ```
  - Zero errors Xot core
  - Segnala warnings su dipendenti (potrebbero essere breaking)

- [ ] **Audit cross-modulo:**
  - `git diff HEAD~1 laravel/Modules/Xot/src/` — che è cambiato
  - `grep -r "extends XotBase\|use.*Xot" laravel/Modules/` — chi dipende da cosa
  - Se trait signature changed: `grep -r "use.*XotChangedTrait" laravel/Modules/` tutti interessati?

- [ ] **Docs update:**
  - Aggiorna [[xotbase-critical-rules]] se breaking change
  - Crea issue GitHub per ogni modulo dipendente se needed
  - Aggiungi riga a `laravel/Modules/Xot/docs/wiki/log.md`

- [ ] **QMD reindex:**
  ```bash
  qmd index laravel/Modules/Xot/docs/wiki/
  ```

---

## Cross-Links (Xot-Critical)

- [[xotbase-critical-rules]] — Rules per XotBase inheritance
- [[xotbase-never-extend-filament]] — Memoria critica: NO direct Filament extend
- [[laravel-13-modular-package-compatibility-matrix]] — Xot + Laravel 13 compat
- [[activity-xotbase-zen-pattern]] — Reference pattern (Activity module)
- [[00-TRIGGER_MAP]] — Routing automatico Xot tasks
- [[agent-confidence-system]] — Strategia globale

---

## Governance

**Responsabile:** Laraxot architect
**Review:** Pre-ogni major Xot refactor (impact 29+ moduli)
**Audit:** Ogni 2 settimane, cross-modulo breakage check
**Critical:** Any XotBase signature change → issue GitHub a tutti dipendenti
