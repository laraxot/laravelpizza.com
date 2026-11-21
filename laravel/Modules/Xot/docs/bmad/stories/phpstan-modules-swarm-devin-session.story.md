---
title: "PHPStan Modules swarm session (Devin)"
status: in_progress
epic: code-quality
qmd: "phpstan analyse Modules swarm subagents devin session bmad second brain docs prompts pest gate"
acceptance_criteria:
  - "Gate full-tree: totals.file_errors=0 e banner [OK] No errors nello stesso run"
  - "Fix alla sorgente (scopo/funzione del codice), mixed solo ultima spiaggia, no ignore/baseline"
  - "Prompt bashscripts/docs/prompts auditati: frontmatter+qmd, naming senza date, stack Laravel13/Filament5 coerente"
  - "Docs moduli/temi: audit organizzazione, fix sicuri, nessun rename bulk"
  - "Pest mirato eseguito o skip documentato"
references:
  - bashscripts/docs/prompts/00-master-prompt.md
  - bashscripts/docs/prompts/11-phpstan.md
  - laravel/Modules/Xot/docs/bmad/stories/phpstan-modules-swarm-session.story.md
  - docs/sprint-status.yaml
related:
  - ./phpstan-modules-swarm-session.story.md
  - ./phpstan-modules-scan-remediation.story.md
  - ./docs-md-filename-date-debt.story.md
---

# PHPStan Modules swarm session (Devin)

## Scopo e perche'

Seconda sessione coordinata sullo stesso obiettivo della story
`phpstan-modules-swarm-session` (agent composer/claude): tenere `laravel/Modules`
a zero PHPStan come rete di sicurezza sulla logica di dominio PA. ogni segnale
PHPStan va letto come indizio sullo **scopo** del codice — cosa doveva fare, chi
lo chiama, quale contratto XotBase/Action rompe — non come errore da spegnere.

## Contesto sessione

- Host: WSL2 Linux (non `10.100.200.15`) → Pest ammesso se DB testing raggiungibile.
- Worktree CONDIVISO: full-tree phpstan gia' in corso da altra sessione
  (`phpstan_modules_baseline.txt` in scratchpad claude) + lock
  `bashscripts/lock/phpstan-modules-swarm-session.lock`.
- Lock modulo attivi: Pdnd, Sigma, Tenant, filament-pages-tables-audit.
- Baseline storica: 2026-11-16 full-tree 10669 file `[OK] No errors`.

## Strategia (swarm + BMAD + second brain)

1. Full-tree phpstan proprio (background) per lista errori indipendente.
2. Subagent paralleli su scope disgiunti: prompts (`bashscripts/docs/prompts`)
   e docs moduli/temi — indipendenti dall'esito phpstan.
3. Errori phpstan: lane per-modulo, max 3 concorrenti, flock/lock, ordine random.
4. Fix: scopo → causa radice → patch minima → `php -l` → phpstan lane → Pest.
5. Write-back: story + sprint-status + `qmd update` + memoria se fatto nuovo.

## Diario

- Avvio: `rm -rf /tmp/phpstan` fallito (race), rilanciato phpstan raw.
- Trovati processi phpstan concorrenti di altra sessione → nessun duplicato
  di edit, solo raccolta errori.
- Lanciati 2 subagent background: audit prompts e audit docs moduli/temi.

## Esito

- **PHPStan gate: 0 errori.** Run 1 (file in coda) ha riportato errori
  `class.notFound` in `Modules/Notify` (ZBateson\MailMimeParser, Mailtrap) —
  falsi positivi transitori: `composer install` di un peer era in corso e
  `vendor/` era incompleto a meta' run. Run 2 (output `/tmp/phpstan_full_raw.txt`,
  exit 0, 10637 file) pulito. Verificato `class_exists()` = true per tutte e
  tre le classi e mapping PSR-4 in `vendor/composer/autoload_psr4.php`.
  Lezione: `class.notFound` di massa su package vendor durante run concorrente
  a `composer install` = controllare `vendor/` prima di toccare codice.
- **Prompts** (`bashscripts/docs/prompts`, repo git `bashscripts/`):
  subagent ha ricostruito 52 file con frontmatter unificata (48 file erano
  multi-documento corrotti), 16 alias stub, link `INDEX.md`→`index.md`.
  Io: ripristinato `29-testing-standards.md` da HEAD (canonico
  `source_of_truth`, cancellato per errore da peer — 6 file lo referenziavano),
  fix riferimenti pendenti in `02`, `05`, `audit-professionale`,
  `filament-structure-rules` (uppercase `FILAMENT-STRUCTURE-RULES.md` →
  `filament-structure-rules.md`, `YAML-FRONTMATTER-CONVENTION.md` →
  `97-yaml-frontmatter-convention.md`).
- **Docs moduli/temi** (subagent): ~1180 frontmatter + ~900 chiavi `qmd`
  aggiunti in 12 moduli/temi liberi; 69 file .md vuoti non tracciati rimossi.
  Residui documentati: link interni rotti (migliaia, wave dedicata),
  case-duplicates (Notify 377, User 84, Lang 88), root docs/ piatti
  (User 1503, Notify 1313, UI 385, Lang 470), ~55 violazioni naming con anno.
- **Pest**: skip documentato — nessun file PHP toccato in questa sessione
  (solo .md in prompts e docs/).
- **Condivisione worktree**: peer attivo su `index.md`/`README.md` dei prompts
  e baseline phpstan proprio (fallito per cache write error, non per errori
  di codice). Locks `bashscripts/lock/` rispettati; nessun lock residuo mio.
