---
title: "File parcheggiati — Geo"
document_type: index
category: documentation
module: Geo
status: active
updated_at: '2026-11-18'
---

# File parcheggiati

File `.wip` spostati qui da `app/` il 2026-11-12
([module_<nome progetto>_fila5#61](https://github.com/laraxot/module_<nome progetto>_fila5/issues/61)).
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

---

## Aggiunti il 2026-11-18 — estensioni finte sotto `app/`

I file qui sopra sono `.wip`. Il 2026-11-18 ne sono arrivati altri con
estensioni diverse — `.up`, `.test`, `.disabled`, `.boh`, `.to_migra` — trovati
cercando **tutte** le estensioni finte sotto `app/`, non solo `.wip`: erano 64
in dodici moduli. Un'estensione finta non tiene un file fuori dal codice, lo
rende invisibile a chi cerca e vivo per chi lo trova.

Per questi il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove venivano.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Filament/Pages/DotswanMap.php.disabled` | 2300 |
| `app/Filament/Pages/WebbingbrasilMap.php.disabled` | 537 |
| `app/Filament/Widgets/LocationMapTableWidget.php.disabled` | 6699 |
| `app/Filament/Widgets/LocationMapWidget.php.disabled` | 5860 |
| `app/Filament/Widgets/OSMMapWidget.php.disabled` | 3913 |
| `app/Filament/Widgets/WebbingbrasilMap.php.disabled` | 825 |

Sei pagine e widget di mappa. **Non sono disabilitati per una dipendenza
mancante**: `dotswan/filament-map-picker` e `webbingbrasil/filament-maps` sono
entrambi dichiarati in `Geo/composer.json` (righe 39-40).

Il motivo vero non e' scritto da nessuna parte, e questo e' il punto: chi li
riprende deve prima capire perche' erano stati messi da parte, perche' la
spiegazione piu' ovvia — "manca il pacchetto" — e' falsa.

**Questi non sono stati esaminati riga per riga**, a differenza dei `.wip` qui
sopra: sono stati spostati, non giudicati. Prima di copiarne uno nel codice
vivo, confrontalo con quello che c'e' adesso.

