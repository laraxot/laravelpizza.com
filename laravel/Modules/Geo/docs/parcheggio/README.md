---
title: "File parcheggiati — Geo"
document_type: index
category: documentation
module: Geo
status: active
updated_at: '2026-11-12'
---

# File parcheggiati

File `.wip` spostati qui da `app/` il 2026-11-12
([module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61)).
In `app/` sta solo codice che gira.

| File | Stato | Cosa c'e' dentro |
|---|---|---|
| `ClusterLocationsAction.wip` | esiste anche viva, e differisce | Versione che lavora su `Collection<LocationData\|LocationDTO>` con una distanza massima in metri, piu' annotata di quella attiva |
| `ImprovedLocationMapWidget.wip` | **nessuna versione viva** | Un widget mappa che non e' mai stato attivato: zero riferimenti in tutto il monorepo |

## Attenzione: queste due esistevano in doppia copia

Fino al 2026-11-12 accanto a ognuna c'era un gemello identico byte per byte col
nome in minuscolo — `clusterlocationsaction.wip`, `improvedlocationmapwidget.wip`.
Su un filesystem case-insensitive (macOS, Windows) sono **lo stesso percorso**:
git ne vede due, il disco uno. E' la classe di problema che in questo monorepo
ha gia' prodotto 35 conflitti modify/delete in un rebase, con la cartella
`ISSUE_CONTENT`/`issue_content` di Notify. I duplicati sono stati cancellati;
sono rimaste le versioni in CamelCase.

## Se riprendi uno di questi

`diff docs/parcheggio/ClusterLocationsAction.wip app/Actions/ClusterLocationsAction.php`
prima di copiare. Quando il lavoro e' finito, cancella il `.wip`.
