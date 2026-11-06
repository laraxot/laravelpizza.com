---
qmd: "qwen"
issues: []
discussions: []
title: "Qwen Added Memories (Modular)"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# Qwen Added Memories (Modular)

Questa documentazione è stata divisa in moduli per una gestione più efficiente del contesto.

## Moduli Memorie

- [Sistema Documentazione](./.agents/docs/main-rules/qwen-docs-index.md)
- [Stato BMad-METHOD](./.agents/docs/main-rules/qwen-bmad-status.md)
- [Progetto Design Comuni](./.agents/docs/main-rules/qwen-design-comuni.md)
- [Tema & Vite](./.agents/docs/main-rules/qwen-theme-vite.md)
- [Architettura](./.agents/docs/main-rules/qwen-architecture.md)
- [Regole Critiche](./.agents/docs/main-rules/qwen-critical-rules.md): body plain, header parity, stepper responsive, multilingual
- [Regole Critiche](../../../ai-agents/qwen-critical-rules.md): body plain, header parity, stepper responsive, multilingual
- [Filament Wizard Rule](./laravel/Modules/App/docs/filament-wizard-rule.md): NO Blade step management, use Filament Wizard Schema
- [Module Boundary Philosophy](./laravel/Modules/App/docs/MODULE-BOUNDARY-PHILOSOPHY.md): Geo OWNS geolocation, NO Blade::render hacks, use AddressInput
- [Filament Wizard Rule](./laravel/Modules/<nome progetto>/docs/filament-wizard-rule.md): NO Blade step management, use Filament Wizard Schema
- [Module Boundary Philosophy](./laravel/Modules/<nome progetto>/docs/MODULE-BOUNDARY-PHILOSOPHY.md): Geo OWNS geolocation, NO Blade::render hacks, use AddressInput
- [Token Efficiency](./docs/token-efficiency-religion.md): Reduce tokens 50-90% via grep-first, diffs, scoping, tables, batch
- [LLM Wiki Pattern](./docs/wiki/README.md): Karpathy-style persistent knowledge base with raw/wiki/AGENTS architecture
- [Token Efficiency](../../../token-efficiency-religion.md): Reduce tokens 50-90% via grep-first, diffs, scoping, tables, batch
- [LLM Wiki Pattern](../../README.md): Karpathy-style persistent knowledge base with raw/wiki/AGENTS architecture

---
**See also:**
- [CLAUDE.md](./CLAUDE.md)
- [agents.md](./agents.md)
- [GEMINI.md](./GEMINI.md)

*Ultimo aggiornamento: Aprile 2026*

## Qwen Added Memories
- FILAMENT COMPONENTS: `Filament\Schemas\Components\Text` NON ESISTE. `Placeholder` per HTML statico, `TextEntry` (Infolists) per dati read-only. Rules: laravel/Modules/App/docs/rules/filament-wizard-rules.md. Guide: laravel/Modules/App/docs/filament-components-guidelines.md
- WIZARD VISUAL PARITY: CSS scoped `.ticket-wizard-root` in `filament-wizard-parity.css`. Entry: `app-test.css`. Safelist `.fi-*` in tailwind.config.js. Doc: laravel/Modules/App/docs/wizard-visual-parity.md
- WIDGET NO LOOP: `getFormModel() → null`. Stato via `$data`, NO model binding. Rules: laravel/Modules/App/docs/rules/filament-wizard-rules.md
- REGOLA CRITICA FILAMENT: NON usare MAI ->label() o ->placeholder() su componenti Filament. LangServiceProvider applica automaticamente label, placeholder, helpText, description via traduzioni. Script pre-commit bashscripts/check-auto-label-violations.sh blocca violazioni. Documento: laravel/Modules/Xot/docs/filament/widgets/no-label-placeholder-religion.md
- TOKEN EFFICIENCY RELIGION: Grep-first (70-90% saving), Diffs vs full files (70-85%), Scope context precisely (50-70%), Reference don't repeat (60%), Tables vs prose (20-30%), /clear between tasks (30-60%), Batch related requests (40%), Use code not LLM (100%). Documento: docs/token-efficiency-religion.md. Memoria: .qwen/memories/token-efficiency.md
- TRANSLATION NAMESPACE RELIGION: Use DOMAIN not UI component for translations. CORRECT: __('laraxot::ticket.sections.summary.label'). WRONG: __('laraxot::create_ticket_wizard.summary.label'). Domain = ticket/user/order (business concept), NOT widget/form/page (UI component). Files: docs/translation-namespace-religion.md, Modules/App/lang/{it,en}/ticket.php
- FILAMENT COMPONENTS: `Filament\Schemas\Components\Text` NON ESISTE. `Placeholder` per HTML statico, `TextEntry` (Infolists) per dati read-only. Rules: laravel/Modules/<nome progetto>/docs/rules/filament-wizard-rules.md. Guide: laravel/Modules/<nome progetto>/docs/filament-components-guidelines.md
- WIZARD VISUAL PARITY: CSS scoped `.ticket-wizard-root` in `filament-wizard-parity.css`. Entry: `app-test.css`. Safelist `.fi-*` in tailwind.config.js. Doc: laravel/Modules/<nome progetto>/docs/wizard-visual-parity.md
- WIDGET NO LOOP: `getFormModel() → null`. Stato via `$data`, NO model binding. Rules: laravel/Modules/<nome progetto>/docs/rules/filament-wizard-rules.md
- REGOLA CRITICA FILAMENT: NON usare MAI ->label() o ->placeholder() su componenti Filament. LangServiceProvider applica automaticamente label, placeholder, helpText, description via traduzioni. Script pre-commit bashscripts/check-auto-label-violations.sh blocca violazioni. Documento: laravel/Modules/Xot/docs/filament/widgets/no-label-placeholder-religion.md
- TOKEN EFFICIENCY RELIGION: Grep-first (70-90% saving), Diffs vs full files (70-85%), Scope context precisely (50-70%), Reference don't repeat (60%), Tables vs prose (20-30%), /clear between tasks (30-60%), Batch related requests (40%), Use code not LLM (100%). Documento: docs/token-efficiency-religion.md. Memoria: .qwen/memories/token-efficiency.md
- TRANSLATION NAMESPACE RELIGION: Use DOMAIN not UI component for translations. CORRECT: __('<nome progetto>::ticket.sections.summary.label'). WRONG: __('<nome progetto>::create_ticket_wizard.summary.label'). Domain = ticket/user/order (business concept), NOT widget/form/page (UI component). Files: docs/translation-namespace-religion.md, Modules/<nome progetto>/lang/{it,en}/ticket.php
- TRANSCHOICE DRY RELIGION: Use ONE trans_choice key for all cases (0, 1, many). CORRECT: 'images_uploaded' => '{0} Nessuna|{1} :count immagine|[2,*] :count immagini'. WRONG: Separate keys like 'no_images', 'one_image', 'many_images'. Messages go under messages.*, rules go under rules.*. NEVER duplicate. Docs: docs/trans-choice-dry-religion.md
- FILAMENT V5 UNIFIED SCHEMA RELIGION: Filament v5 unifies Forms + Infolists. TextEntry for read-only, Placeholder is DEPRECATED. All components mixable in same schema[]. Doc: laravel/Modules/Xot/docs/filament/widgets/infolist-for-summary.md
- VISUAL PARITY RELIGION: 4-level parity (HTML → Content → Visual → Behavioral). Screenshot-driven dev. CSS `.wizard-` scoped. Cards `#f0f4f8` + shadow. Headings 24px bold. Description under heading. Buttons: `← Indietro`, `Salva Richiesta`, `Avanti →`. Doc: _bmad-output/implementation-artifacts/7-45-segnalazione-crea-step2-ultra-visual-parity.md. CSS: Themes/Sixteen/resources/css/segnalazione-wizard.css
- CONTAINER LOOP PREVENTION: Corrupted compiled view cache (null bytes). Fix: `php artisan view:clear && php artisan optimize:clear`. Doc: laravel/Modules/Xot/docs/filament/widgets/container-loop-prevention.md
- Design Comuni Wizard Parity: Widget uses Section->aside()->compact() for Design Comuni card-like sections. Blade view has .cmp-wizard-widget wrapper. CSS parity file at Themes/Sixteen/resources/css/components/wizard-parity.css. Translation keys use laraxot::segnalazione.sections.* for section labels. Rebuild: cd Themes/Sixteen && npm run build. Docs: docs/design-comuni-wizard-parity.md
- Design Comuni Wizard Parity: Widget uses Section->aside()->compact() for Design Comuni card-like sections. Blade view has .cmp-wizard-widget wrapper. CSS parity file at Themes/Sixteen/resources/css/components/wizard-parity.css. Translation keys use <nome progetto>::segnalazione.sections.* for section labels. Rebuild: cd Themes/Sixteen && npm run build. Docs: docs/design-comuni-wizard-parity.md
- WORKFLOW POST-MODIFICA OBBLIGATORIO: Dopo OGNI modifica file: 1) Aggiornare docs moduli/temi (prima del codice), 2) Aggiornare indici docs, 3) Aggiornare rules/memories/skills (prevenire duplicati), 4) phpstan analyse sul file/modulo, 5) phpmd analyse, 6) phpinsights analyse, 7) pest tests, 8) Commit atomico. SEMPRE in questo ordine. DRY + KISS + anti-ridondanze. Task paralleli: coordinare con altri agenti AI, unire forze, non duplicare lavoro.
- LLM WIKI RELIGION: Karpathy-style persistent knowledge base. raw/ = IMMUTABLE (never modify), wiki/ = WRITE-ALLOWED (LLM-generated), agents.md = schema file. Workflows: ingest (source→wiki pages), query (synthesize with citations), lint (resolve contradictions/orphans/stale). All pages MUST use frontmatter schema. DRY knowledge (one concept = one page). Link heavily (3+ incoming, 3+ outgoing). Atomic commits (one ingestion = one commit). Module wikis in Modules/{Name}/docs/llm-wiki/. Project wiki in ./docs/wiki/. Docs: docs/wiki/README.md, docs/wiki/agents.md, docs/wiki/QUICK-REFERENCE.md

---

<!-- Merged from qwen.md, which collided with this file on case-insensitive filesystems. -->

---
title: "Qwen Added Memories (Modular)"
type: concept
tags: [qwen]
created: 2026-07-14
updated: 2026-07-14
qmd: "qwen qwen added memories (modular)"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-notify-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Qwen Added Memories (Modular)

Questa documentazione è stata divisa in moduli per una gestione più efficiente del contesto.

## Moduli Memorie

- [Sistema Documentazione](./.agents/docs/main-rules/qwen-docs-index.md)
- [Stato BMad-METHOD](./.agents/docs/main-rules/qwen-bmad-status.md)
- [Progetto Design Comuni](./.agents/docs/main-rules/qwen-design-comuni.md)
- [Tema & Vite](./.agents/docs/main-rules/qwen-theme-vite.md)
- [Architettura](./.agents/docs/main-rules/qwen-architecture.md)
- [Regole Critiche](./.agents/docs/main-rules/qwen-critical-rules.md): body plain, header parity, stepper responsive, multilingual
- [Filament Wizard Rule](./laravel/Modules/<nome progetto>/docs/filament-wizard-rule.md): NO Blade step management, use Filament Wizard Schema
- [Module Boundary Philosophy](./laravel/Modules/<nome progetto>/docs/MODULE-BOUNDARY-PHILOSOPHY.md): Geo OWNS geolocation, NO Blade::render hacks, use AddressInput
- [Token Efficiency](./docs/token-efficiency-religion.md): Reduce tokens 50-90% via grep-first, diffs, scoping, tables, batch
- [LLM Wiki Pattern](./docs/wiki/README.md): Karpathy-style persistent knowledge base with raw/wiki/AGENTS architecture
- [Regole Critiche](../../../ai-agents/qwen-critical-rules.md): body plain, header parity, stepper responsive, multilingual
- [Filament Wizard Rule](./laravel/Modules/<nome progetto>/docs/filament-wizard-rule.md): NO Blade step management, use Filament Wizard Schema
- [Module Boundary Philosophy](./laravel/Modules/<nome progetto>/docs/MODULE-BOUNDARY-PHILOSOPHY.md): Geo OWNS geolocation, NO Blade::render hacks, use AddressInput
- [Token Efficiency](../../../token-efficiency-religion.md): Reduce tokens 50-90% via grep-first, diffs, scoping, tables, batch
- [LLM Wiki Pattern](../../README.md): Karpathy-style persistent knowledge base with raw/wiki/AGENTS architecture

---
**See also:**
- [claude.md](./claude.md)
- [agents.md](./agents.md)
- [gemini.md](./gemini.md)

*Ultimo aggiornamento: Aprile 2026*

## Qwen Added Memories
- FILAMENT COMPONENTS: `Filament\Schemas\Components\Text` NON ESISTE. `Placeholder` per HTML statico, `TextEntry` (Infolists) per dati read-only. Rules: laravel/Modules/<nome progetto>/docs/rules/filament-wizard-rules.md. Guide: laravel/Modules/<nome progetto>/docs/filament-components-guidelines.md
- WIZARD VISUAL PARITY: CSS scoped `.ticket-wizard-root` in `filament-wizard-parity.css`. Entry: `app-test.css`. Safelist `.fi-*` in tailwind.config.js. Doc: laravel/Modules/<nome progetto>/docs/wizard-visual-parity.md
- WIDGET NO LOOP: `getFormModel() → null`. Stato via `$data`, NO model binding. Rules: laravel/Modules/<nome progetto>/docs/rules/filament-wizard-rules.md
- REGOLA CRITICA FILAMENT: NON usare MAI ->label() o ->placeholder() su componenti Filament. LangServiceProvider applica automaticamente label, placeholder, helpText, description via traduzioni. Script pre-commit bashscripts/check-auto-label-violations.sh blocca violazioni. Documento: laravel/Modules/Xot/docs/filament/widgets/no-label-placeholder-religion.md
- TOKEN EFFICIENCY RELIGION: Grep-first (70-90% saving), Diffs vs full files (70-85%), Scope context precisely (50-70%), Reference don't repeat (60%), Tables vs prose (20-30%), /clear between tasks (30-60%), Batch related requests (40%), Use code not LLM (100%). Documento: docs/token-efficiency-religion.md. Memoria: .qwen/memories/token-efficiency.md
- TRANSLATION NAMESPACE RELIGION: Use DOMAIN not UI component for translations. CORRECT: __('<nome progetto>::ticket.sections.summary.label'). WRONG: __('<nome progetto>::create_ticket_wizard.summary.label'). Domain = ticket/user/order (business concept), NOT widget/form/page (UI component). Files: docs/translation-namespace-religion.md, Modules/<nome progetto>/lang/{it,en}/ticket.php
- TRANSCHOICE DRY RELIGION: Use ONE trans_choice key for all cases (0, 1, many). CORRECT: 'images_uploaded' => '{0} Nessuna|{1} :count immagine|[2,*] :count immagini'. WRONG: Separate keys like 'no_images', 'one_image', 'many_images'. Messages go under messages.*, rules go under rules.*. NEVER duplicate. Docs: docs/trans-choice-dry-religion.md
- FILAMENT V5 UNIFIED SCHEMA RELIGION: Filament v5 unifies Forms + Infolists. TextEntry for read-only, Placeholder is DEPRECATED. All components mixable in same schema[]. Doc: laravel/Modules/Xot/docs/filament/widgets/infolist-for-summary.md
- VISUAL PARITY RELIGION: 4-level parity (HTML → Content → Visual → Behavioral). Screenshot-driven dev. CSS `.wizard-` scoped. Cards `#f0f4f8` + shadow. Headings 24px bold. Description under heading. Buttons: `← Indietro`, `Salva Richiesta`, `Avanti →`. Doc: _bmad-output/implementation-artifacts/7-45-segnalazione-crea-step2-ultra-visual-parity.md. CSS: Themes/Sixteen/resources/css/segnalazione-wizard.css
- CONTAINER LOOP PREVENTION: Corrupted compiled view cache (null bytes). Fix: `php artisan view:clear && php artisan optimize:clear`. Doc: laravel/Modules/Xot/docs/filament/widgets/container-loop-prevention.md
- Design Comuni Wizard Parity: Widget uses Section->aside()->compact() for Design Comuni card-like sections. Blade view has .cmp-wizard-widget wrapper. CSS parity file at Themes/Sixteen/resources/css/components/wizard-parity.css. Translation keys use <nome progetto>::segnalazione.sections.* for section labels. Rebuild: cd Themes/Sixteen && npm run build. Docs: docs/design-comuni-wizard-parity.md
- WORKFLOW POST-MODIFICA OBBLIGATORIO: Dopo OGNI modifica file: 1) Aggiornare docs moduli/temi (prima del codice), 2) Aggiornare indici docs, 3) Aggiornare rules/memories/skills (prevenire duplicati), 4) phpstan analyse sul file/modulo, 5) phpmd analyse, 6) phpinsights analyse, 7) pest tests, 8) Commit atomico. SEMPRE in questo ordine. DRY + KISS + anti-ridondanze. Task paralleli: coordinare con altri agenti AI, unire forze, non duplicare lavoro.
- LLM WIKI RELIGION: Karpathy-style persistent knowledge base. raw/ = IMMUTABLE (never modify), wiki/ = WRITE-ALLOWED (LLM-generated), agents.md = schema file. Workflows: ingest (source→wiki pages), query (synthesize with citations), lint (resolve contradictions/orphans/stale). All pages MUST use frontmatter schema. DRY knowledge (one concept = one page). Link heavily (3+ incoming, 3+ outgoing). Atomic commits (one ingestion = one commit). Module wikis in Modules/{Name}/docs/llm-wiki/. Project wiki in ./docs/wiki/. Docs: docs/wiki/README.md, docs/wiki/agents.md, docs/wiki/quick-reference.md
