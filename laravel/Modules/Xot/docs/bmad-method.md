# bmad method in laraxot

## scopo

Integrare il **BMAD Method** (Build More Architect Dreams) come cornice di lavoro per tutte le attività di sviluppo Laraxot, mantenendo l'allineamento con le regole esistenti (`DRY + KISS`, focus su business logic, PHPStan livello 10).

BMAD viene usato come **metodo di pensiero** per guidare analisi, architettura e implementazione, e nel progetto è anche **installato come toolkit** (skills + workflow) per aumentare disciplina e tracciabilità.

## stato nel progetto

- installazione locale: `_bmad/`
- versione installata: v6.2.0 (vedi `_bmad/_config/manifest.yaml`)
- orchestratore primario: GSD (`.planning/`), BMAD è supplementare per deep-research e architettura (vedi `_bmad/bmap.md`)

## perché `bmad-help` “non funziona” in Cursor

Nel nostro repository `bmad-help` è una **skill BMAD** (file `SKILL.md` + `workflow.md` dentro `_bmad/`), non un comando Laravel o uno script di shell.

Quindi:

- se lo lanci in **terminal** (`bmad-help`), è normale che fallisca: non è un binario;
- se lo scrivi in **chat**, funziona solo se l’IDE ha un’integrazione che “registra” automaticamente le skill dal repo.

In questo progetto i file BMAD ci sono, ma Cursor può non esporre automaticamente le skill come comandi. In quel caso, il fallback corretto è:

- usare GSD come orchestratore (`/gsd-*`) e trattare BMAD come “workflow in repo”;
- oppure aprire e seguire manualmente `_bmad/core/skills/bmad-help/workflow.md` (la logica di routing è lì).

## principi chiave (adattati)

- **scale‑adaptive thinking**: la profondità dell'analisi dipende dalla scala del cambiamento
  - bugfix locale → ciclo breve, focus sul comportamento esatto
  - feature/modulo → analisi architetturale completa (moduli, temi, confini)
- **structured workflows**:
  - analisi → architettura → implementazione → test → documentazione
  - nessuna scorciatoia: ogni fix deve lasciare il sistema in stato migliore (codice + docs)
- **specialized roles (mental model)**:
  - *architect*: verifica impatti tra moduli (User, UI, Xot, dominio)
  - *developer*: implementa in modo minimale e tipizzato
  - *tester*: cerca regressioni e casi limite
  - *doc writer*: aggiorna sempre le `docs/` più vicine e crea backlink
- **ai‑assisted, human‑driven**:
  - l'AI non sostituisce le decisioni architetturali, le rende più veloci e tracciate in docs + rules

## mappa su laraxot

- **business first**: ogni task parte da:
  - quale problema di business del modulo sto risolvendo?
  - quali moduli/temi vengono toccati? (Meetup, Media, Lang, Geo, Seo, UI, User, Xot, ecc.)
- **moduli come domini BMAD**:
  - ogni modulo è un *dominio* con obiettivi chiari e confini documentati
  - Xot fornisce le *regole di gioco* (base classes, migrazioni, traduzioni, testing)
- **pipeline BMAD per ogni change**:
  1. **Understand**: leggere `docs/` del modulo + root Xot per capire scopo e regole
  2. **Plan**: identificare impatti (PHPStan, test, docs, confini modulo)
  3. **Implement**: cambiare il minimo indispensabile, rispettando XotBase pattern
  4. **Verify**: PHPStan livello 10 + test Pest + verifica comportamenti reali
  5. **Document**: aggiornare docs di modulo + eventuale doc di tema/frontoffice

## linee guida operative

- prima di qualunque refactor:
  - verificare se esiste già una regola Xot o una doc che copre il caso
  - se la regola non esiste, aggiornarla qui o in `rules.md` e creare backlink
- usare BMAD per:
  - decidere **quanto** dettaglio serve (scala del problema)
  - mantenere coerenza tra codice, test, docs, rules e memorie di progetto
- ogni documento di modulo che descrive workflow/architettura può fare riferimento a questo file:
  - es: “vedi `Xot/docs/bmad-method.md` per il workflow decisionale AI‑assistito usato nei moduli Laraxot”

## collegamenti

- metodo originale: <https://github.com/bmad-code-org/BMAD-METHOD>
- mappa BMAD ↔ GSD: `../../../../_bmad/bmap.md`
- regole generali laraxot: `Xot/docs/laraxot-rules.md` (e `.cursor/rules/laraxot-rules.mdc`)
- testing e qualità: `Xot/docs/testing-best-practices.md`, `Xot/docs/phpstan-code-quality-guide.md`

