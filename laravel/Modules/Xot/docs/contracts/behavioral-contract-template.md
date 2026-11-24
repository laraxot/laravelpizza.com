---
title: "Template per Behavioral Contract"
type: contract-template
owner: Xot
status: active
updated: 2026-11-23
qmd: "behavioral contract template"
---

# `<scope>` — `<operazione>`

<!-- Copiare questo file per un contratto reale e rinominare in kebab-case.
     Non usare type: contract in questo template: il test documentale lo ignora. -->

```yaml
type: contract-template
action: Modules\\<Module>\\Actions\\<Action>
```

Nel docblock dell'Action aggiungere il riferimento machine-readable:

```text
@see docs/contracts/<contract-file>.md
@contract docs/contracts/<contract-file>.md
```

Ogni riga della tabella `Invarianti` deve avere un ID stabile nel formato
`<SCOPE>-INV-<N>`. Il test Pest associato usa lo stesso valore:
`->group('<SCOPE>-INV-<N>')`.

## Input

- `<parametro>` — tipo, origine e validazione.

## Output

- Valore restituito o stato osservabile dopo l'operazione.

## Invarianti

| ID | Regola verificabile | Group Pest |
| --- | --- | --- |
| `<SCOPE>-INV-1` | `<invariante osservabile>` | `<SCOPE>-INV-1` |

## Effetti collaterali

Descrivere cosa cambia e in quale ordine: transazione, commit, eventi, notifiche,
queue, storage e servizi esterni. Indicare cosa non deve accadere se fallisce.

## Errori

- `<condizione>` — eccezione, risposta o errore osservabile.

## Non fa

- Elencare responsabilità escluse e il documento/codice che le possiede.

## Verifica

```bash
cd laravel
vendor/bin/pest --group=<SCOPE>-INV-1
```

Il contratto va registrato in `docs/contracts/INDEX.md` e aggiornato insieme al
test quando cambia il comportamento.
