---
title: Tests Location Rule: Non Ripetere Errore
type: rule
status: critical
created: 2026-10-15
tags: [tests, modularity, laravel, rule, bmad, second-brain]
source_of_truth: true
updated: 2026-10-19
qmd: "regola canonica: posizione dei test dei moduli xot"
---

# Regola canonica: posizione dei test dei moduli

I test appartenenti a un modulo vivono in:

```text
laravel/Modules/<Module>/tests/
```

La struttura reale del repository e i bootstrap dei moduli confermano questa
ownership. `laravel/tests/` resta riservato a test applicativi, trasversali e di
tema. Eventuali cartelle `laravel/tests/Modules/<Module>/` già presenti vanno
inventariate caso per caso: non sono una motivazione per creare nuovi test lì,
ma non vanno cancellate o spostate automaticamente.

## Origine dell'errore documentato

Questo file conteneva una regola opposta perché una nota storica aveva confuso
la posizione di alcuni test applicativi con la proprietà dei test Nwidart. La
regola era stata propagata senza verificare filesystem, namespace, bootstrap e
configurazione Pest dei moduli. È una correzione di processo: prima si verifica
la struttura effettiva, poi si aggiorna la documentazione.

Per la regola completa e il checklist operativo vedere
`rules/module-test-ownership.md`.
