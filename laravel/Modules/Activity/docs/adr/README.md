---
title: "ADR del modulo Activity"
type: index
module: Activity
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "Activity adr architecture decision records madr formato"
tags: [adr, decisioni, activity]
---

# ADR del modulo Activity

Un ADR registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale, e il suo perche'.
Non e' un diario ne' una spiegazione retroattiva: se la decisione non e' dimostrabile dal codice o da una story/doc del repo, non si scrive.
Il nome del file e' `NNNN-argomento.md` (kebab-case, prefisso numerico come negli ADR di Xot), senza date: la data sta nella frontmatter. Eccezioni al prefisso: `README.md`, `index.md`, `0000-template.md`.

Il **perche'** delle forme di Activity che sembrano eccessive: i modelli su una connessione dedicata (`activity`) invece
della default, il visualizzatore dei log che fa passare ogni percorso scelto dall'utente da un solo risolutore, e la
cronologia di audit che non si riscrive. Una decisione per file, con le alternative scartate.

Leggili prima di: cambiare `$connection` di un modello del modulo o la configurazione `activitylog`, aggiungere un modo di
leggere o scaricare file da `storage/logs`, toccare i permessi del visualizzatore, o modificare righe di `activity_log` gia' scritte.

## Metodo

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Le decisioni si
verificano contro codice e test correnti. Chi cambia una decisione scrive un nuovo ADR e segna il precedente `superseded`
o `deprecated` (`superseded by <file>`). Regole: [behavioral-contract-governance](../../../Xot/docs/adr/0012-behavioral-contract-governance.md)
e [ADR di Xot](../../../Xot/docs/adr/README.md).

## Formato (MADR breve)

Frontmatter: `title`, `type: decision`, `status` (`proposed` | `accepted` | `superseded` | `deprecated`), `module`, `created`, `updated`, `qmd`; opzionali `tags`, `related`, `issues`, `decision-makers`.

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
module: Activity
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
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

## Verifica
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```

Un ADR "sostanziale" aggiunge `## Driver della decisione` e `## Conferma`.

Template condiviso: `laravel/Modules/Xot/docs/adr/0000-template.md` (copia locale: [0000-template.md](0000-template.md)). Guard: `Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`.

## ADR presenti

- [L'audit delle attivita' e' append-oriented](0001-activity-audit-is-append-oriented.md) — la cronologia non si riscrive per correggere una visualizzazione; le viste la interpretano.
- [I modelli di Activity usano la connessione 'activity'](0002-activity-models-on-dedicated-connection.md) — log separabile in un altro database e rollback dei test coerente; debito: Spatie scrive sulla default.
- [Visualizzatore dei log: un solo risolutore di percorsi](0003-log-viewer-single-path-resolver.md) — `realpath` e solo `.log` dentro `storage/logs`, una regola di accesso, download a blocchi.

Elenco con stato: [index.md](index.md).
