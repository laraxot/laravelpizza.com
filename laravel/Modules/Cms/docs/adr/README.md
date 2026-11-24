---
<<<<<<< .merge_file_fEWBfK
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
title: "Architecture Decision Records"
=======
title: "ADR del modulo Cms"
>>>>>>> .merge_file_eWRiYb
type: index
tags: [adr, decisioni, cms]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Cms

<<<<<<< .merge_file_fEWBfK
<<<<<<< HEAD
=======
## Metodo Harness
=======
Il **perche'** del routing delle pagine pubbliche: chi monta Folio, chi risolve lo slug, cosa puo' raggiungere un URL
`/{container0}/{slug0}`, quali protezioni puo' chiedere il JSON di una pagina. Sono decisioni di sicurezza (DCP-283) che
sembrano rigidita' inutili. Una decisione per file, con le alternative scartate; il nome del file e' l'argomento, senza date
ne' numeri (la data sta nella frontmatter).
>>>>>>> .merge_file_eWRiYb

Leggili prima di: aggiungere un provider o un percorso Folio, esporre un modello da URL, aggiungere un middleware a una pagina.

## Metodo

<<<<<<< .merge_file_fEWBfK
>>>>>>> laraxot/dev
Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).
=======
Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale; non e' un diario ne'
una spiegazione retroattiva inventata. Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea
un nuovo ADR e segna il precedente `superseded` o `deprecated`. Regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md)
e [ADR di Xot](../../../Xot/docs/adr/README.md).
>>>>>>> .merge_file_eWRiYb

## Formato

```markdown
---
title: "ADR - <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.

<<<<<<< .merge_file_fEWBfK
## Decisioni

<<<<<<< HEAD
=======
- [CMS e Folio risolvono le pagine tramite slug](cms-owns-page-resolution.md)

=======
title: "ADR — Cms"
type: index
tags: [adr, decisioni, cms]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Cms

Il **perche'** del routing delle pagine pubbliche: chi monta Folio, cosa puo' raggiungere un URL `/{container0}/{slug0}`,
quali protezioni puo' chiedere il JSON di una pagina. Sono decisioni di sicurezza (DCP-283) che sembrano rigidita' inutili.

Leggili prima di: aggiungere un provider o un percorso Folio, esporre un modello da URL, aggiungere un middleware a una pagina.
=======
## Verifica
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```
>>>>>>> .merge_file_eWRiYb

Un ADR "sostanziale" aggiunge `## Driver della decisione` e `## Conferma`.

## Decisioni

- [CMS e Folio risolvono le pagine tramite slug](cms-owns-page-resolution.md) — il Cms possiede slug, contenuto e middleware di pagina; il tema e' una shell senza logica di dominio.
- [FolioVoltServiceProvider e' l'unico owner di Folio e Volt](folio-volt-sole-owner.md) — niente `App\Providers\FolioServiceProvider`, niente `Folio::path` nei moduli.
- [Modelli da URL solo da un elenco esplicito e con la policy view](container0-model-allowlist.md) — `cms.config.container0_models`, nessuna euristica, nessun oracolo di esistenza.
- [Middleware dei JSON di pagina da un'allowlist](page-middleware-allowlist.md) — solo nomi in `cms.config.page_middleware_allowlist`; protezione incerta = 503.
<<<<<<< .merge_file_fEWBfK
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_eWRiYb
