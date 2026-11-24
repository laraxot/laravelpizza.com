---
title: Xot behavioral contract index
---

# Xot behavioral contract index

This is the machine-readable inventory of behavioral contracts owned by the **Xot** module.

A contract describes an existing public operation or boundary. It names the owner, input, output, stable invariants, side effects and their order, errors, and non-goals. Every invariant gets a stable ID and a Pest group when a test exists; missing coverage is recorded as debt instead of being implied away.

## Contracts

- [Bootstrap provider registry](bootstrap-provider-registry.md)

- [contract-authoring-standard](contract-authoring-standard.md)
- [xotbase-classes](xotbase-classes.md)

## Authoring

Use [Xot contract authoring standard](../../Xot/docs/contracts/contract-authoring-standard.md) and the shared template. Legacy behavior is documented as-is and is not a model for new code.

---
title: "INDEX — Xot"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->
# <!-- Titolo: indice operativo Xot -->

## Contratti di comportamento

Xot è il modulo base: estende `XotBasePage`, `XotBaseResource`, `XotBaseServiceProvider`,
`XotBaseMigration` e i relativi RelationManager. I contratti qui descritti sono la
superficie di estensione per tutti i moduli figli.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| Bootstrap provider registry | [bootstrap-provider-registry](bootstrap-provider-registry.md) | `Modules\Xot\Providers\XotServiceProvider` | BOOTSTRAP-PROVIDERS-001..003 |
| XotBase class surface | [xotbase-classes](xotbase-classes.md) | `XotBasePage`, `XotBaseResource`, `XotBaseServiceProvider`, `XotBaseMigration` | XOTBASE-001..004 |
| Behavioral contract authoring | [behavioral-contract-template](behavioral-contract-template.md) | template standard | CONTRACT-AUTHOR-001 |
| Contract authoring standard | [contract-authoring-standard](contract-authoring-standard.md) | standard | CONTRACT-AUTHOR-002 |

- [README dei contratti](README.md) — indice e convenzioni storiche del package.
- [Standard di authoring](contract-authoring-standard.md) — regole di formato e
  verifica.
- [Regola Action Behavioral Contract](../rules/action-behavioral-contract.md) —
  quando il contratto è obbligatorio.
