---
title: changelog analytics report
type: report
tags: [changelog, contributors, ci, analytics]
generated: 2026-06-03T12:39:12.456Z
---

# Changelog analytics

- **Repository:** `local/repo`
- **Range:** `v1.0.0..HEAD`
- **Commits (no merge):** 2
- **Generato:** 2026-06-03T12:39:12.456Z

## Contributori

| Contributore | Email | Commit | % |
|-------------|-------|--------|---|
| marco76tv | marco.sottana@gmail.com | 2 | 100.0% |

```mermaid
pie showData
    title Commit per contributore (top 10)
    "marco76tv" : 2
```

```mermaid
xychart-beta
    title "Commit per contributore"
    x-axis ["marco76tv"]
    y-axis "Commit" 0 --> 3
    bar [2]
```


## Tipi di commit (Conventional Commits)

```mermaid
pie showData
    title Distribuzione per tipo
    "other" : 2
```


| Tipo | Commit |
|------|--------|
| other | 2 |

## Moduli / temi toccati

```mermaid
xychart-beta
    title "Commit per area"
    x-axis ["root/other"]
    y-axis "Commit" 0 --> 3
    bar [2]
```


| Area | Commit |
|------|--------|
| root/other | 2 |

## Ultimi commit

| Hash | Autore | Tipo | Messaggio |
|------|--------|------|-----------|
| `41c6ceb` | marco76tv | other | Update semantic-release workflow to trigger on all branches |
| `298ed1c` | marco76tv | other | Add push trigger for all branches in semantic versioning workflow |

_Report generato da `bashscripts/ci/generate-changelog-report.mjs`._
