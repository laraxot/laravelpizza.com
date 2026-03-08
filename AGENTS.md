# AGENTS.md - LaravelPizza Development Guide

Questo file ora funge da indice rapido. La guida completa e modulare e' stata suddivisa in piu' file dentro `./.agents/docs/agents-guide/`.

## Collegamenti principali

- [Indice completo](./.agents/docs/agents-guide/00-index.md)
- [Project overview](./.agents/docs/agents-guide/01-project-overview/project-overview.md)
- [Build, lint, test](./.agents/docs/agents-guide/02-tooling/build-lint-test-commands.md)
- [Code style guidelines](./.agents/docs/agents-guide/03-code-style/code-style-guidelines.md)
- [Critical architecture rules](./.agents/docs/agents-guide/04-architecture/critical-architecture-rules.md)
- [Database and models](./.agents/docs/agents-guide/05-database/database-and-models.md)
- [Filament admin patterns](./.agents/docs/agents-guide/06-filament-admin/filament-admin-patterns.md)
- [SVG icons](./.agents/docs/agents-guide/07-assets/svg-icons.md)
- [Testing guidelines](./.agents/docs/agents-guide/08-testing/testing-guidelines.md)
- [Piano Coverage 100%](./docs/testing/coverage-100-plan-2026-03-07.md)
- [Test Coverage Summary](./docs/testing/coverage-summary-2026-03-07.md)
- [Cursor rules summary](./.agents/docs/agents-guide/09-cursor-rules/cursor-rules-summary.md)
- [File patterns and docs standards](./.agents/docs/agents-guide/10-file-patterns/file-patterns-and-docs-standards.md)
- [MCP for autonomous agents](./.agents/docs/agents-guide/11-mcp/mcp-autonomous-agents.md)
- [Pre-commit checklist](./.agents/docs/agents-guide/12-checklist/pre-commit-checklist.md)
- [Key documentation references](./.agents/docs/agents-guide/13-references/key-documentation-references.md)
- [Theme: pub_theme namespace](./.agents/docs/agents-guide/14-theme/pub-theme-namespace-critical-rule.md)
- [Theme translations critical rule](./.agents/docs/agents-guide/14-theme/theme-translations-critical-rule.md)
- [Chaos Monkey readiness](./.agents/docs/agents-guide/15-chaos-monkey/chaos-monkey-readiness.md)
- [Bug Injection Recovery Playbook](./docs/bug-injection-recovery-playbook.md) - Quando bug/file infetti sono introdotti deliberatamente

## Comunicazione Multi-Agente (REGOLA CRITICA)

Questo progetto ha **multipli agenti AI** che lavorano in parallelo. La comunicazione tra agenti avviene **esclusivamente** tramite:

1. **GitHub Issues** - Per task, bug, feature, tracking del lavoro
2. **GitHub Discussions** - Per decisioni architetturali, strategie, dibattiti

### Workflow obbligatorio per ogni agente

1. **PRIMA di lavorare**: `gh issue list --state open` per verificare cosa e' gia' in corso
2. **DURANTE il lavoro**: commentare la Issue con progresso
3. **DOPO il lavoro**: aggiornare la Issue con risultato, chiudere se completata
4. **MAI duplicare** lavoro gia' fatto da un altro agente
5. **MAI cancellare file** creati da altri agenti (rinominare con `.old` se necessario)

Riferimento completo: [docs/rules/multi-agent-collaboration-rule.md](./docs/rules/multi-agent-collaboration-rule.md)

## Nota operativa

- Le regole originali sono state preservate nei file di sezione.
- Per modifiche future, aggiorna prima il file di sezione pertinente e poi l'indice `00-index.md`.

## Priorita operativa obbligatoria (sempre)

Prima di modificare qualunque file di codice:

1. Ragionare sul problema e sul perimetro della modifica.
2. Studiare la documentazione del modulo/tema coinvolto (`laravel/Modules/*/docs`, `laravel/Themes/*/docs`).
3. **VERIFICARE SE LA FUNZIONALITA' ESISTE GIA'** - NON creare nuovi moduli!
4. Aggiornare o creare la documentazione necessaria (regole, memory, skill operative) dentro:
   - `docs/rules`
   - `docs/memory`
   - `docs/skills`
5. Solo dopo procedere con le modifiche al codice.

Riferimento: `docs/rules/pre-edit-docs-first-rule.md`

## REGOLA CRITICA: NON Creare Nuovi Moduli

**Usare SEMPRE i moduli esistenti!**

### Esempio Sbagliato
```
❌ Creare Modules/EventRegistration/  # SBAGLIATO!
❌ Creare Modules/EventFeedback/     # SBAGLIATO!
```

### Esempio Corretto
```
✅ Usare Modules/Meetup/Models/Event
✅ Usare Modules/Meetup/Models/EventUser (pivot)
✅ Usare Modules/Meetup/Actions/Event/RegisterAttendeeToEventAction
```

Tutta la logica Meetup esiste gia' in `Modules/Meetup/`. Verificare sempre prima di creare qualcosa di nuovo!

Riferimento: `docs/memory/no-new-modules-use-existing-memory.md`

## 🚨 **CRITICAL RULE - 2026-03-07**

### **Regola Fondamentale da Ricordare SEMPRE**

**MAI** creare nuovi moduli - **SEMPRE** estendere quelli esistenti!

### **Moduli Esistenti da Estendere**
- **laravel/Modules/Activity/** - Sistema di attività e log
- **laravel/Modules/Cms/** - Content Management System
- **laravel/Modules/Gdpr/** - Conformità GDPR
- **laravel/Modules/Geo/** - Geolocalizzazione e mappe
- **laravel/Modules/Job/** - Gestione job e code
- **laravel/Modules/Lang/** - Gestione multilingua
- **laravel/Modules/Media/** - Gestione file e media
- **laravel/Modules/Meetup/** - Logica principale meetup
- **laravel/Modules/Notify/** - Sistema notifiche
- **laravel/Modules/Seo/** - Ottimizzazione SEO
- **laravel/Modules/Tenant/** - Multi-tenancy
- **laravel/Modules/UI/** - Componenti UI condivisi
- **laravel/Modules/User/** - Gestione utenti e autenticazione
- **laravel/Modules/Xot/** - Infrastruttura di base
- **laravel/Modules/Setting/** - Configurazione applicazione

### **Workflows Corretti**
1. **Cercare** nei moduli esistenti (`Modules/*/`)
2. **Verificare** se il modello/azione esiste già
3. **Estendere** invece di creare
4. **Solo se non esiste**, creare nel modulo appropriato

### **PROMEMORIA PER SEMPRE:**
> "MAI creare nuovi moduli. SEMPRE estendere quelli esistenti!"
