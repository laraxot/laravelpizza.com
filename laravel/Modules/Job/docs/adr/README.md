---
title: "ADR del modulo Job"
type: index
module: Job
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "Job adr architecture decision records madr formato"
---

# ADR del modulo Job

Un ADR registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale, e il suo perche'.
Non e' un diario ne' una spiegazione retroattiva: se la decisione non e' dimostrabile dal codice o da una story/doc del repo, non si scrive.
Il nome del file e' l'argomento in kebab-case, senza date (la data sta nella frontmatter).

## Formato (MADR breve)

Frontmatter: `title`, `type: decision`, `status` (`proposed` | `accepted` | `superseded` | `deprecated`), `created`, `updated`, `decision-makers`, `module`, `qmd`.

Sezioni obbligatorie, in quest'ordine:

```markdown
## Contesto
## Driver della decisione
## Alternative scartate
## Decisione
## Conseguenze
## Conferma
```

Template condiviso: `laravel/Modules/Xot/docs/adr/0000-template.md`. Guard: `Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`.
Chi cambia una decisione scrive un nuovo ADR e segna il precedente `superseded by <file>`.

## ADR presenti

- [0001-controlli-operativi-solo-super-admin-e-whitelist](0001-controlli-operativi-solo-super-admin-e-whitelist.md)
- [job-operations-are-whitelisted](job-operations-are-whitelisted.md): stessa decisione del precedente in forma breve; overlap da consolidare (non marcato superseded da questa sessione).

Elenco con stato: [INDEX.md](INDEX.md).
