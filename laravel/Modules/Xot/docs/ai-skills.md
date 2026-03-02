 # Agent skills nei moduli

## Scopo

Questo documento spiega **come usare in modo efficace le agent skills** (file in `.windsurf/skills/`, `.cursor/skills/` e `.cursor/skills-cursor/`) quando si lavora sui moduli di questo sistema, con ottica **DRY + KISS** e nel pieno rispetto delle regole Laraxot.

Le skills non sono business logic: sono **contratti di comportamento** per l’agente AI (come deve ragionare, quali tool usare, quali standard rispettare) e servono a rendere il lavoro sui moduli più coerente e ripetibile.

## Dove vivono le skills

- **Skills di progetto (Windsurf)**: cartella `.windsurf/skills/` alla radice del repository.
  - Qui vivono le skill personalizzate che usiamo in questo workspace, ad esempio `phpstan-module-workflow` e `joke`.
  - Qui possono vivere altre skill specifiche del repository (es. per moduli, temi, workflow particolari).
- **Skills di progetto (Cursor)**: cartella `.cursor/skills/` alla radice.
  - Usa la stessa struttura Markdown delle skill Windsurf; mantieni i contenuti sincronizzati.
- **Skills di sistema**: cartella `.cursor/skills-cursor/` (solo lettura).
  - Contiene skill generiche fornite dall’ambiente (es. gestione docs, PHPStan, testing).
  - Non va modificata: va solo usata come riferimento operativo.

## Famiglie di skill utili per i moduli

Quando si interviene su un modulo (es. `User`, `Xot`, `Performance`, ecc.), è utile ragionare per **famiglie di skill**:

- **Qualità del codice e PHPStan**
  - `phpstan-level10`, `phpstan-fix`, `phpstan-fix-log`, ecc.
  - **Quando usarle**: ogni volta che si tocca codice PHP in un modulo; prima di considerare “finito” un fix o una feature.
  - Collegate alla documentazione di questo modulo su PHPStan (es. `phpstan-documentation-complete.md`, `phpstan-errors-resolution-roadmap.md`).

- **Testing e Pest**
  - `pest-testing`, `laraxot-testing-pest`.
  - **Quando usarle**: quando si aggiunge o modifica logica applicativa; prima di correggere bug complessi; quando si estendono Resource/Widget/Action critiche.

- **Filament e XotBase**
  - `laraxot-filament-rules`, `xotbase-check`.
  - **Quando usarle**: ogni volta che si crea/modifica Resource, Page, Widget, RelationManager; quando si migra codice Filament esistente verso XotBase.
  - Collegate ai documenti di questo modulo come `filament/filament-resource-rules.md` e `filament-class-extension-rules.md`.

- **Traduzioni e UI**
  - `translation-check`, `laraxot-translation-files`.
  - **Quando usarle**: quando si tocca qualsiasi componente che prima usava `->label()`, `->placeholder()`, `->helperText()` o file di traduzione.

- **Documentazione e roadmap**
  - `documentation-sync`, `module-docs`, `module-roadmap`.
  - **Quando usarle**: prima e dopo modifiche significative a un modulo (nuove feature, refactor, bugfix strutturali) per aggiornare `docs/` e le roadmap mantenendo naming, link relativi e neutralità.

- **Integrità del dominio**
  - `never-simplify-domain`, `model-integrity`, `laraxot-model-rules`, `module-audit`.
  - **Quando usarle**: quando si è tentati di “semplificare” tabelle, enum, colonne, actions o blade include; quando si fa refactor di modelli, Actions, DTO.

- **Conflitti git e manutenzione**
  - `laraxot-git-conflicts`, `git-maintenance`, `git-push-pack-repair`.
  - **Quando usarle**: in presenza di conflitti complessi tra moduli, refactor multipli o problemi di push/pull.

## Skill principali del progetto

### `phpstan-module-workflow`
- **Percorso**: `.windsurf/skills/phpstan-module-workflow/SKILL.md` (replica, se necessario, in `.cursor/skills/`).
- **Scopo**: guidare l’analisi PHPStan/Larastan su un modulo o tema (pre-check, analyse, batch fixing, quality gates, documentazione e commit).
- **Uso consigliato**:
  1. Invoca la skill (`@phpstan-module-workflow`) prima di toccare il codice per ricordare pre-check e documentazione da studiare.
  2. Segui i passi indicati nel file della skill e collega sempre il lavoro ai documenti del modulo (README, patterns, phpstan-roadmap).
  3. Aggiorna i log in `storage/logs/phpstan/<target>.log` come indicato dalla skill.

### `joke`
- **Percorso**: `.windsurf/skills/joke/SKILL.md` (può essere replicata in `.cursor/skills/` per altri editor).
- **Scopo**: far raccontare all’agente **una sola barzelletta breve in italiano**, non offensiva.
- **Quando usarla**:
  - Solo quando l’utente chiede esplicitamente una barzelletta / qualcosa di divertente.
  - Mai per generare esempi di codice o testi di documentazione.
- **Implicazioni per i moduli**:
  - Non modifica logica di business né struttura dei moduli.
  - Non va citata nelle specifiche funzionali: è uno strumento di “pausa mentale” per l’utente, non un requisito applicativo.

## Workflow consigliato con le skills quando lavori su un modulo

1. **Capisci lo scopo del cambiamento**  
   - Leggi i file in `docs/` del modulo (roadmap, bug fixing guide, architettura).
   - Se necessario, usa la famiglia `module-audit` / `module-docs` per allinearti.

2. **Aggiorna o allinea la documentazione del modulo**  
   - Usa `documentation-sync` e `module-docs` come riferimento.
   - Assicurati che il nuovo lavoro sia coerente con gli obiettivi del modulo.

3. **Implementa il cambiamento nel codice**  
   - Se tocchi Filament, consulta `laraxot-filament-rules` e `xotbase-check`.
   - Se tocchi modelli o dominio, consulta `model-integrity` e `never-simplify-domain`.

4. **Verifica qualità e test**  
   - Esegui il giro `phpstan-level10` + `pest-testing` (almeno sui file/modulo toccati).

5. **Rifinisci documentazione e roadmap**  
   - Usa di nuovo `documentation-sync`, `module-docs` e, quando serve, `module-roadmap` per registrare il lavoro fatto.

6. **Solo se serve una pausa**  
   - Se l’utente chiede qualcosa di leggero, la skill `joke` può essere usata per una barzelletta, senza mai contaminare esempi tecnici o specifiche.

## Collegamenti correlati

- Linee guida globali sull’uso delle skill: [`../../../../../../../docs/ai-guidelines.md`](../../../../../../../docs/ai-guidelines.md)
- Regole PHPStan di questo modulo: [`phpstan-documentation-complete.md`](phpstan-documentation-complete.md)
- Roadmap di correzione errori PHPStan: [`phpstan-errors-resolution-roadmap.md`](phpstan-errors-resolution-roadmap.md)
- Regole Filament/XotBase: [`filament/filament-resource-rules.md`](filament/filament-resource-rules.md)
- Regole di estensione classi Filament: [`filament-class-extension-rules.md`](filament-class-extension-rules.md)
