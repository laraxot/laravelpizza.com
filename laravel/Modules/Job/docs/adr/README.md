---
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
