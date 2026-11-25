---
title: "ADR del modulo Activity"
type: index
<<<<<<< .merge_file_DydRB9
<<<<<<< .merge_file_RUJg3N
<<<<<<< .merge_file_Da8Tch
<<<<<<< .merge_file_C1B1vE
module: Activity
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "Activity adr architecture decision records madr formato"
=======
tags: [adr, decisioni, activity]
created: 2026-11-18
updated: 2026-11-24
>>>>>>> .merge_file_CRel7N
=======
tags: [adr, decisioni, activity]
created: 2026-11-18
updated: 2026-11-24
>>>>>>> .merge_file_sdNCPs
=======
tags: [adr, decisioni, activity]
created: 2026-11-18
updated: 2026-11-24
>>>>>>> .merge_file_FdGNGw
=======
tags: [adr, decisioni, activity]
created: 2026-11-18
updated: 2026-11-24
>>>>>>> .merge_file_2t9laO
---

# ADR del modulo Activity

<<<<<<< .merge_file_DydRB9
<<<<<<< .merge_file_RUJg3N
<<<<<<< .merge_file_Da8Tch
<<<<<<< .merge_file_C1B1vE
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

- [activity-audit-is-append-oriented](activity-audit-is-append-oriented.md)

Elenco con stato: [index-2.md](index-2.md).
=======
=======
>>>>>>> .merge_file_sdNCPs
=======
>>>>>>> .merge_file_FdGNGw
=======
>>>>>>> .merge_file_2t9laO
<<<<<<< HEAD
Il **perché** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate. Oggi spiegano due
forme di Activity che sembrano eccessive: i modelli su una connessione dedicata (`activity`) invece della default, e il
visualizzatore dei log che fa passare ogni percorso scelto dall'utente da un solo risolutore.

Leggili prima di: cambiare `$connection` di un modello del modulo o la configurazione `activitylog`, aggiungere un modo di
leggere o scaricare file da `storage/logs`, o toccare i permessi del visualizzatore.

## Formato

Una decisione per file; il nome del file è l'argomento, senza date né numeri (la data sta nella frontmatter). Cinque
sezioni, `type: decision`; regole complete in
[action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md).

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
=======
Il **perche'** delle forme di Activity che sembrano eccessive: i modelli su una connessione dedicata (`activity`) invece
della default, il visualizzatore dei log che fa passare ogni percorso scelto dall'utente da un solo risolutore, e la
cronologia di audit che non si riscrive. Una decisione per file, con le alternative scartate; il nome del file e' l'argomento,
senza date ne' numeri (la data sta nella frontmatter).

Leggili prima di: cambiare `$connection` di un modello del modulo o la configurazione `activitylog`, aggiungere un modo di
leggere o scaricare file da `storage/logs`, toccare i permessi del visualizzatore, o modificare righe di `activity_log` gia' scritte.

## Metodo

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale; non e' un diario ne'
una spiegazione retroattiva inventata. Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea
un nuovo ADR e segna il precedente `superseded` o `deprecated`. Regole: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md)
e [ADR di Xot](../../../Xot/docs/adr/README.md).

## Formato

```markdown
---
title: "ADR - <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
>>>>>>> laraxot/dev
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
<<<<<<< HEAD
Ogni alternativa seria, con il motivo per cui non è stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
```

## Indice

=======
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.

## Verifica
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```

Un ADR "sostanziale" aggiunge `## Driver della decisione` e `## Conferma`.

## Decisioni

- [L'audit delle attivita' e' append-oriented](activity-audit-is-append-oriented.md) — la cronologia non si riscrive per correggere una visualizzazione; le viste la interpretano.
>>>>>>> laraxot/dev
- [I modelli di Activity usano la connessione 'activity'](activity-models-on-dedicated-connection.md) — log separabile in un altro database e rollback dei test coerente; debito: Spatie scrive sulla default.
- [Visualizzatore dei log: un solo risolutore di percorsi](log-viewer-single-path-resolver.md) — `realpath` e solo `.log` dentro `storage/logs`, una regola di accesso, download a blocchi.
<<<<<<< .merge_file_DydRB9
<<<<<<< .merge_file_RUJg3N
<<<<<<< .merge_file_Da8Tch
>>>>>>> .merge_file_CRel7N
=======
>>>>>>> .merge_file_sdNCPs
=======
>>>>>>> .merge_file_FdGNGw
=======
>>>>>>> .merge_file_2t9laO
