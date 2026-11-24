---
title: "ADR del modulo Activity"
type: index
tags: [adr, decisioni, activity]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Activity

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
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non è stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
```

## Indice

- [I modelli di Activity usano la connessione 'activity'](activity-models-on-dedicated-connection.md) — log separabile in un altro database e rollback dei test coerente; debito: Spatie scrive sulla default.
- [Visualizzatore dei log: un solo risolutore di percorsi](log-viewer-single-path-resolver.md) — `realpath` e solo `.log` dentro `storage/logs`, una regola di accesso, download a blocchi.
