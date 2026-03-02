# Indice Regole Critiche - Tema Meetup

## 📚 Documentazione Regole Critiche

### Regole Consolidate

1. **[Regole Critiche Consolidate](./critical-rules-consolidated.md)**
   - Frontend Asset Management
   - Componenti Blade Anonimi
   - Vite Configuration
   - Metatags Component

### Regole Specifiche

2. **[Frontend Asset Management](./development-workflow-css-js-changes.md)**
   - Workflow build e copy
   - Dev mode vs Production
   - Troubleshooting
   - Verifica modifiche

3. **[Componenti Blade Anonimi](./pub-theme-component-namespace-error-analysis.md)**
   - Sintassi corretta
   - Analisi errore namespace
   - Soluzione implementata

4. **[Vite Configuration](./vite-theme-asset-loading-fix.md)**
   - Path tema corretto
   - Build output directory
   - Copy workflow

5. **[Metatags Component](./metatags-component-usage.md)**
   - Uso obbligatorio
   - Cosa include automaticamente
   - Slot per contenuti aggiuntivi

6. **[Build e Copy Workflow](./build-and-copy-workflow.md)**
   - Struttura directory
   - Comando copy corretto
   - Verifica asset

7. **[Risoluzione tema e workflow](./theme-resolution-and-workflow.md)**
   - Catena: APP_URL → config tenant → xra.php → pub_theme → Themes/Meetup
   - **Per modifiche CSS/JS standard**: `npm run build && npm run copy`
   - **Per setup iniziale o modifiche PHP**: `composer update -W`, `npm install`, `npm run build`, `npm run copy`
   - Regola agenti: `.cursor/rules/theme-resolution-critical.md`

8. **[Filament 5 – riferimento tema](./filament-5-theme-reference.md)**
   - Requisiti Filament 5 (PHP 8.2+, Laravel 11.28+, Tailwind v4.1+)
   - Panel builder vs componenti singoli; nostro setup (CSS nel tema, admin in app)
   - Riferimento: https://filamentphp.com/docs/5.x/introduction/installation

9. **[Grafica vs laravelpizza.com](./grafica-confronto-laravelpizza.md)**, **[Differenze grafica e miglioramenti](./differenze-grafica-e-miglioramenti.md)**, **[Approfondimento tecnico](./differenze-grafica-approfondimento.md)** (file, codice, checklist), **[Footer logo confronto](./footer-logo-confronto.md)**
   - Confronto struttura e contenuti; uso MCP o `npm run screenshots` / `npm run screenshots:footer` (Playwright)
   - Screenshot in [screenshots/grafica-confronto](screenshots/grafica-confronto/), [screenshots/footer-logo-confronto](screenshots/footer-logo-confronto/readme.md)

10. **[Accessibilità & WCAG](./wcag.md)**
    - Checklist WCAG 2.2 Level AA
    - Focus states, contrasto colore, navigazione tastiera
    - Strumenti di verifica


### Riferimenti Cross-Module

11. **[Regole Xot](../../modules/xot/docs/critical-rules-consolidated.md)**
    - Regole generali Laraxot
    - Filosofia Migrazioni
    - Estensioni Filament

12. **[Regole Modulo Meetup](../../modules/meetup/docs/critical-rules-consolidated.md)**
    - Architettura Frontoffice
    - Folio + Volt pattern

13. **[CMS Theme Runtime Memory](./memories/cms-theme-runtime-memory.md)**
   - Verità runtime persistenti per debug rapido
   - Breakpoint ad alta probabilità sotto chaos

14. **[Chaos Monkey Debug Skills](./chaos-monkey-debug-skills.md)**
   - Skill operative per incident response su template/theme/CMS
   - Checklist di recovery in 5 punti

15. **[Chaos Monkey Incident Playbook](./chaos-monkey-incident-playbook.md)**
   - Protocollo operativo ridotto per recovery rapido
   - Guardrail per non introdurre regressioni durante fix urgenti

16. **[Chaos Monkey Theme Recovery Playbook](./chaos-monkey-theme-recovery-playbook.md)**
   - Runbook operativo per guasti su layout, section e blocchi tema
   - Procedure di ripristino rapido senza rompere la pipeline CMS

## 🔄 Aggiornamenti Recenti

- Aggiunta regola Risoluzione tema e workflow (APP_URL → config → pub_theme; build e copy)
- Aggiunta regola Frontend Asset Management
- Aggiunta regola Componenti Blade Anonimi
- Consolidata Vite Configuration
- Consolidata Metatags Component
- Aggiunti Filament 5 theme reference e Grafica vs laravelpizza.com (MCP)
- Aggiunto Chaos Monkey Incident Playbook
- Aggiunto Chaos Monkey Theme Recovery Playbook
