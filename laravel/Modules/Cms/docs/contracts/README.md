---
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

<<<<<<< HEAD
=======
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `CMS-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

>>>>>>> laraxot/dev
Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

<<<<<<< HEAD
=======
- [ResolvePageAction](page-resolution-action.md)
- [ResolvePageMetaAction](page-meta-resolution-action.md)
- [SaveFooterConfigAction](save-footer-config-action.md)
- [SaveHeadernavConfigAction](save-headernav-config-action.md)

- [Contratto `PageSlugMiddleware`](page-slug-middleware.md)
- [ADR ownership della risoluzione](../adr/cms-owns-page-resolution.md)

=======
title: "Contratti — Cms"
type: index
tags: [contracts, actions, cms]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Cms

Cosa promettono le Action di Cms che decidono cosa un URL pubblico puo' mostrare e che riscrivono la config dell'aspetto del
tenant. Le Action `Head/*`, `Get*` e i resolver di blocchi calcolano valori per le viste e non hanno contratto.

Leggili prima di toccare la risoluzione delle pagine `[container0]/[slug0]`, i middleware dei JSON di pagina o il
salvataggio di testata e piede dal pannello.

Formato (6 sezioni, invarianti con ID e group Pest): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
Lanciare le invarianti coperte: `vendor/bin/pest Modules/Cms/tests/<file> --group=<ID>`.

## Contratti

- [ResolvePageAction](resolve-page-action.md) — modello solo da elenco e con policy `view`, poi pagina CMS esatta o generica.
- [ValidatePageMiddlewareAction](validate-page-middleware-action.md) — allowlist dei middleware dichiarati nel JSON di pagina.
- [SaveHeadernavConfigAction](save-headernav-config-action.md) — salva la testata nella chiave `headernav` di `appearance.php` del tenant.
- [SaveFooterConfigAction](save-footer-config-action.md) — salva il piede nella chiave `footer` di `appearance.php` del tenant.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
