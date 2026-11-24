---
<<<<<<< HEAD
bmad_status: active
scope: ui-docs
=======
>>>>>>> laraxot/dev
title: "Epic e story — UI"
type: epics
status: review
bmad_status: active
scope: ui-docs
updated: 2026-11-16
module: UI
qmd: "epic story BMAD UI audit P0 P1 policy"
---

# Epic e story — UI

<<<<<<< HEAD
<<<<<<< HEAD
Scopo del modulo: vocabolario visivo condiviso (componenti, widget, colonne, layout tabella) consumato da tutti i moduli ([purpose.md](./purpose.md)).
=======
Scopo del modulo: vocabolario visivo condiviso (componenti, widget, colonne, layout tabella) consumato da tutti i moduli ([purpose.md](../wiki/purpose.md)).
>>>>>>> laraxot/dev
=======
Scopo del modulo: vocabolario visivo condiviso (componenti, widget, colonne, layout tabella) consumato da tutti i moduli ([purpose.md](./purpose.md)).
>>>>>>> laraxot/dev

## Epic da audit 2026-11-16

Ogni story nasce da un finding di [audits/ui-audit.md](./audits/ui-audit.md); prima del fix:
lock (`bashscripts/lock/lock.sh`), Pest rosso, PHPStan max, poi `unlock.sh`. Nessun `migrate:fresh`, solo migrate additivo.

### Epic UI-A — Rimuovere demo e dati finti (P1)

| Story (da creare) | Cosa | Criterio di accettazione |
|---|---|---|
| `ui-dashboard-real-widgets` | Dashboard con soli widget reali o vuota | nessun valore letterale in `Dashboard.php`; `TestWidget` solo in tests |
| `ui-remove-phantom-model-tests` | Eliminare Asset/Component/ThemeModelTest | 0 `@phpstan-ignore` in `tests/Unit/Models`; PHPStan 0 |

### Epic UI-B — Igiene (P2)

| Story (da creare) | Cosa | Criterio di accettazione |
|---|---|---|
| `ui-personform-lang-or-delete` | PersonForm tradotto via Lang o eliminato | 0 `->label('testo')` in `app/` |
| `ui-policy-base-xot` | UiBasePolicy → XotBasePolicy + test `before` | test Pest `ui::admin`/utente estraneo |
| `ui-cleanup-stray-files` | Rimuovere `.disabled/.disabled2/.fila3`, `ComponentService` vuoto | file assenti, PHPStan 0 |

