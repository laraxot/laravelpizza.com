---
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
<<<<<<< .merge_file_FWVAV2
title: "Contratti — Cms"
=======
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
<<<<<<< .merge_file_SgDkme
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Contratti"
=======
title: "Contratti — Cms"
>>>>>>> .merge_file_u2et0L
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
>>>>>>> .merge_file_1p9BQF
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
type: index
tags: [contracts, actions, interfaces, cms]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Cms

<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
<<<<<<< .merge_file_FWVAV2
=======
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
<<<<<<< HEAD
=======
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `CMS-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

>>>>>>> laraxot/dev
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
>>>>>>> .merge_file_1p9BQF
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

Cosa promettono le Action di Cms che decidono cosa un URL pubblico puo' mostrare e che riscrivono la config dell'aspetto del
tenant. Le Action `Head/*`, `Get*` e i resolver di blocchi calcolano valori per le viste e non hanno contratto.

Leggili prima di toccare la risoluzione delle pagine `[container0]/[slug0]`, i middleware dei JSON di pagina o il
salvataggio di testata e piede dal pannello.

Formato (6 sezioni, invarianti con ID e group Pest): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
Lanciare le invarianti coperte: `vendor/bin/pest Modules/Cms/tests/<file> --group=<ID>`.

<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
<<<<<<< .merge_file_FWVAV2
## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio.
Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `CMS-<AREA>-INV-N` (per esempio `CMS-HEADERNAV-SAVE-INV-1`); il test Pest
corrispondente usa lo stesso ID come group.

=======
>>>>>>> .merge_file_1p9BQF
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
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

Il docblock dell'Action rimanda al file con il marker `@contract docs/contracts/<file>.md`; la riga legacy
`Contratto di comportamento: docs/contracts/<file>.md` può restare.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
<<<<<<< .merge_file_FWVAV2
- [ResolvePageAction](resolve-page-action.md) — modello solo da elenco e con policy `view`, poi pagina CMS esatta o generica (versione con tabella invarianti e ADR dell'allowlist).
- [ResolvePageAction, contratto di risoluzione Folio](page-resolution-action.md) — la stessa Action vista dalle rotte `[container0]/[slug0]`: `renderMode`, `item`, `pageSlug`; un contenitore fuori allowlist non carica modelli dall'URL.
- [ResolvePageMetaAction](page-meta-resolution-action.md) — titolo e descrizione della pagina in rendering: priorità modello poi blocchi, descrizioni da 160 caratteri al massimo, valore già registrato non sovrascritto.
=======
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
<<<<<<< .merge_file_SgDkme
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
=======
- [ResolvePageAction](resolve-page-action.md) — modello solo da elenco e con policy `view`, poi pagina CMS esatta o generica (versione con tabella invarianti e ADR dell'allowlist).
- [ResolvePageAction, contratto di risoluzione Folio](page-resolution-action.md) — la stessa Action vista dalle rotte `[container0]/[slug0]`: `renderMode`, `item`, `pageSlug`; un contenitore fuori allowlist non carica modelli dall'URL.
- [ResolvePageMetaAction](page-meta-resolution-action.md) — titolo e descrizione della pagina in rendering: priorità modello poi blocchi, descrizioni da 160 caratteri al massimo, valore già registrato non sovrascritto.
>>>>>>> .merge_file_u2et0L
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
>>>>>>> .merge_file_1p9BQF
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
- [ValidatePageMiddlewareAction](validate-page-middleware-action.md) — allowlist dei middleware dichiarati nel JSON di pagina.
- [Contratto `PageSlugMiddleware`](page-slug-middleware.md) — esegue i middleware dichiarati dal contenuto CMS e risponde 404 alle route legacy di profilo non risolvibili, 503 fail-closed se lo slug non è determinabile.
- [SaveHeadernavConfigAction](save-headernav-config-action.md) — salva la testata nella chiave `headernav` di `appearance.php` del tenant.
- [SaveFooterConfigAction](save-footer-config-action.md) — salva il piede nella chiave `footer` di `appearance.php` del tenant.
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
<<<<<<< .merge_file_FWVAV2
=======
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
<<<<<<< .merge_file_SgDkme
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
>>>>>>> .merge_file_1p9BQF
=======
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_ChfUGI
- [ADR ownership della risoluzione](../adr/cms-owns-page-resolution.md) — la risoluzione delle pagine è del Cms, non dei moduli applicativi.

## Indici e template

- [INDEX.md](INDEX.md) — inventario machine-readable dei contratti Cms (elenca solo i tre contratti di risoluzione e middleware, non le Action di salvataggio config).
- [_template.md](_template.md) — template minimo `type: contract` con `action: <FQCN>` e le sei sezioni.
<<<<<<< .merge_file_qmISRW
<<<<<<< .merge_file_6WgKws
<<<<<<< .merge_file_pgIabO
<<<<<<< .merge_file_FWVAV2
=======
>>>>>>> .merge_file_u2et0L
>>>>>>> .merge_file_1p9BQF
=======
>>>>>>> .merge_file_u2et0L
>>>>>>> .merge_file_xtU4lk
=======
>>>>>>> .merge_file_u2et0L
>>>>>>> .merge_file_AuYded
=======
>>>>>>> .merge_file_u2et0L
>>>>>>> .merge_file_ChfUGI
