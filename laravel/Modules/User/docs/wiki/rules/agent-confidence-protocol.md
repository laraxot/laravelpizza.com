---
name: agent-confidence-protocol
description: Strategia operativa per massimizzare confidenza agentiva nel modulo User
metadata:
  type: rule
  enforced: on-demand per task User
  updated: 2026-05-26
related:
  - "./can-comment-retired-wrong-placement.md"
  - "./frontend-stack-canonical.md"
  - "./header-auth-flow.md"
  - "./header-design-colors.md"
  - "./module-commit-push-after-change.md"
  - "./navigation-properties.md"
  - "./no-filament-labels.md"
  - "./no-notifications-migration-in-user-module.md"
---

# Agent Confidence Protocol — User Module

> **Obiettivo:** Eliminare assunzioni, massimizzare verifiche, documentare il dubbio.

## 6 Strategie Operative

### 1. Carico on-demand, mai pre-assumo

**Regola:** Non carico files senza trigger specifico. Prima di modificare User code:
- Leggo `docs/wiki/rules/00-TRIGGER_MAP.md` (riga user-specifica)
- Uso `qmd search "User module pattern"` se non conosco il contesto
- Evito: "So che User ha X" — verifico con `Read` o git

**Quando applico:**
- Nuovo modulo User task
- Modifica a User resources/pages/models
- Cambio naming convention User

**Documento dubio:** Se la memoria dice User ha pattern X ma il codice mostra Y → creo issue git + commento `[[memory-conflict-resolved-2026-05-26]]`

---

### 2. Wikifi everything

**Regola:** Ogni decisione User → `laravel/Modules/User/docs/wiki/`

**Struttura canonica:**
```
docs/wiki/
├── rules/
│   ├── index.md (pointer)
│   ├── user-model-structure.md
│   └── user-filament-resource-pattern.md
├── concepts/
│   ├── user-role-hierarchy.md
│   └── user-permission-matrix.md
├── how-to/
│   ├── extend-user-model.md
│   └── add-user-factory.md
└── log.md (audit trail)
```

**Frontmatter obbligatorio:**
```yaml
---
name: kebab-case-slug
description: Una riga descrittiva
metadata:
  type: rule|concept|how-to
  enforced: automatic|on-demand|manual
  updated: YYYY-MM-DD
---
```

**Quando applico:**
- Post-modifica User code: aggiungi riga a `docs/wiki/log.md`
- Pattern ricorrente in User: crea `docs/wiki/concepts/...md`
- Dubbio mai risolto prima: crea `docs/wiki/how-to/...md` + link da `rules/index.md`

---

### 3. Verifico contro autorità canoniche

**Autorità (in ordine):**

1. **Git (source of truth del codice)**
   - `git log laravel/Modules/User --oneline | head -10` — ultimi cambi
   - `git diff HEAD~1 laravel/Modules/User/Models/User.php` — che è cambiato
   - `git blame laravel/Modules/User/Models/User.php | grep "line number"` — chi e quando

2. **QMD (search wiki + docs)**
   ```bash
   qmd search "User model structure pattern" --limit 5
   ```
   → Priorità: modulo docs > global wiki > memory

3. **Code (lettura diretta)**
   - Cerca trait ricorrenti: `grep -r "trait.*User" laravel/Modules/User/`
   - Policy pattern: `ls laravel/Modules/User/Policies/`
   - Factory: `grep -l "UserFactory" laravel/Modules/User/`

4. **Memory (ultime sessioni — transient)**
   - Consulta solo se git + wiki non hanno risposta
   - Se conflitto memory vs git: **aggiorna memoria**, cita commit

**Quando applico:**
- Prima di modificare User::class structure
- Estendere User Filament resource
- Aggiungere policy/permission User

**Documento dubio:**
```markdown
❓ **Non verificato — User->roles() relationship**
- Memory dice: "lazy-loaded via Role model"
- Git (HEAD): [inserisci commit ID]
- Code: `/Models/User.php:XX`
- Wiki: [[user-model-structure]] non copre relationships

→ Risoluzione: read `User.php`, aggiorna wiki
```

---

### 4. Context-mode per dati grandi

**Regola:** Dati >4KB → context-mode sandbox, non Read

**Scenario 1: Analizzare User migration history (100+ migrations)**
```bash
ctx_batch_execute(
  commands: [
    {label: "User migrations count", command: "find laravel/Modules/User/database/migrations -name '*.php' | wc -l"},
    {label: "User model files", command: "find laravel/Modules/User/Models -type f | wc -l"}
  ],
  queries: ["total migration count", "model file structure"]
)
```
→ Risultati indexati in sandbox, solo summaries in context

**Scenario 2: Grep User patterns (10+ files)**
```bash
ctx_batch_execute(
  commands: [
    {label: "User casts usage", command: "grep -r 'protected \\$casts' laravel/Modules/User/Models/"},
    {label: "User accessors", command: "grep -r 'function get.*Attribute' laravel/Modules/User/Models/"}
  ],
  queries: ["accessor pattern", "cast types used"]
)
```

**Quando applico:**
- Audit User model properties (>5 files)
- Analizzare User Filament resources ricorrenza
- Raccogliere User migration patterns

---

### 5. Documento il dubbio, non il "fatto"

**Regola:** Se non 100% sicuro → scrivo "❓ non verificato" in docs, non skip

**Esempi corretti:**

✅ **Cosa fare:**
```markdown
## User Role Hierarchy

User può avere multiple roles via `roles()` relationship.

❓ **Non verificato:**
- Se role deletion in UI elimina user_roles pivot
- Se soft-delete su User cascada a roles
- → Verificare: `laravel/Modules/User/Models/User.php` + policies

Vedi: [[user-permission-matrix]], [[user-filament-resource-pattern]]
```

❌ **Cosa NON fare:**
```markdown
## User Role Hierarchy

User ha roles (probabilmente, penso).
```

**Quando applico:**
- Post-documentazione nuovo pattern User
- Dubbio durante code review User resource
- Conflitto tra memory e git

**Processo:**
1. Scrivi dubbio in docs/wiki/ con `❓ Non verificato`
2. Cita fonte incompleta: "Based on: /Models/User.php, but..."
3. Aggiungi task issue: `Fix: verify User role cascade behavior`
4. Commenta issue quando risolto

---

### 6. Audito dopo ogni modifica

**Regola:** Post-edit User code → phpstan + phonmd + docs validate

**Checklist post-modifica User:**

- [ ] **PHPStan:** `./tools/phpstan laravel/Modules/User`
  - Zero errors prima di commit
  - Segnala "Unknown class User" come issue dedicata

- [ ] **PHPMD:** `./tools/phpmd laravel/Modules/User text codesize,cleancode`
  - Complexity ciclomatic User model
  - Duplication User traits

- [ ] **Markdown validate:**
  - `ls laravel/Modules/User/docs/*.md` — syntax check
  - Links interni: `grep -r "\.md" docs/wiki/` → valida `[[wiki-slug]]`

- [ ] **Git log update:**
  - Aggiungi riga a `docs/wiki/log.md` con timestamp + operazione
  - Formato: `2026-05-26 — User accessor pattern updated, [[user-model-structure]]`

- [ ] **QMD reindex (se nuovi `.md`):**
  ```bash
  qmd index laravel/Modules/User/docs/wiki/
  ```

**Quando applico:**
- Ogni commit User code
- Prima di merge pull request User
- Post-refactor User resources/models

---

## Cross-Links

- [[user-model-structure]] — Struttura canonica User model
- [[user-filament-resource-pattern]] — Extend User Filament resource
- [[00-TRIGGER_MAP]] — Routing automatico per task User
- [[llm-wiki-operational-discipline]] — Disciplina wiki globale
- [[agent-confidence-system]] — Strategia globale confidenza agentiva

---

## Governance

**Responsabile:** Laravel architect + User module owner
**Review:** Ogni 3 mesi, update con nuovi pattern User scoperti
**Audit:** QMD query "User confidence protocol violations" post-merge
