---
title: "claude-audit static — modulo Activity"
type: concept
module: Activity
tags: [activity, quality, claude-audit, testing]
created: 2026-07-09
updated: 2026-07-09
qmd: "Activity claude-audit static 80 score audit-coverage bridge tests"
issues:
  - "https://github.com/laraxot/module_activity_fila5/issues/1"
discussions:
  - "https://github.com/laraxot/module_activity_fila5/discussions/1"
related:
  - ./testing.md
  - ./ponytail-audit.md
  - ../../../../../../bashscripts/tools/run-claude-audit-module-static.sh
---

# claude-audit static (Activity)

## Comando

```bash
bash bashscripts/tools/run-claude-audit-module-static.sh Activity
```

Equivalente:

```bash
cd laravel && npx claude-audit --static Modules/Activity/ --max-files 2000
```

**Obbligatorio `--max-files 2000`**: con default 500 la scan tronca `tests/` e il ratio risulta ~0%.

## Limiti noti dello scanner

| Pattern | Rilevato da claude-audit |
|--------|---------------------------|
| `tests/Feature/*Test.php` (Pest) | **No** — path `tests/` senza `/tests/` nel matcher |
| `audit-coverage/tests/*BridgeTest.php` | **Sì** — contiene `/tests/` |
| `*.test.js` (Vitest) | **Sì** |

Bridge PHPUnit in `audit-coverage/tests/` allinea il ratio senza duplicare la suite Pest (`tests/`).

## Lang files

File `lang/*/*.php` >100 righe: header + commenti sezione per superare il check «comment coverage» (SSoT traduzioni, non JSDoc su logica).

## Target

Static mode (free): **80/100** tetto. Report: `Modules/Activity/.claude-audit/audit-report.html`.
