---
<<<<<<< .merge_file_68spMn
<<<<<<< .merge_file_7DgO7a
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
=======
=======
>>>>>>> .merge_file_V0uNZu
title: "ADR — Job"
type: index
tags: [adr, decisioni, job]
created: 2026-11-18
updated: 2026-11-24
---

# ADR — Job

Le scelte di Job che sembrano eccessive o strane finché non si vede il rischio: comandi Artisan e `.env` scritti dal
pannello, una riga di shell passata a `exec()`, una tabella che il pannello non deve poter scrivere.

**Quando leggerli**: prima di aggiungere un pulsante che lancia un comando, un campo alle impostazioni del worker, o
una pagina a `JobResource`; e prima di "semplificare" un controllo di autorizzazione che sembra doppio.

Formato e regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md) (5 sezioni,
`## Verifica` obbligatoria, nome = argomento senza date).

## Decisioni

- [Comandi Artisan dalla UI: allowlist a match esatto](artisan-commands-from-ui-exact-match-allowlist.md) — solo super-admin, autorizzazione ripetuta nel metodo Livewire, nessun argomento libero.
- [Flag del worker dalle impostazioni del tenant](queue-worker-flags-from-tenant-settings.md) — `timeout/sleep/tries` per tenant, nella shell entrano solo interi.
- [Tabella jobs in sola lettura](jobs-table-read-only-in-admin.md) — `JobResource` senza create/edit: la coda la scrive il codice.
<<<<<<< .merge_file_68spMn
>>>>>>> .merge_file_79kwDv
=======
>>>>>>> .merge_file_V0uNZu
