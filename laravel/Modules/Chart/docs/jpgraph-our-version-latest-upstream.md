# JpGraph: come fare una nostra versione con l’ultima JpGraph

Questo documento descrive il contesto attuale (amenadiel/jpgraph non aggiornato) e le opzioni per avere una “nostra” versione basata sull’ultima JpGraph disponibile (mitoteam/jpgraph o sorgenti jpgraph.net).

**Approccio consigliato (naming coerente con JpGraph):** usare **mitoteam/jpgraph** come dipendenza e creare **le nostre classi che estendono le classi di JpGraph**, esposte sotto il namespace `Amenadiel\JpGraph\*`. Così si mantiene il naming preferito (tipo amenadiel/jpgraph) senza adottare il naming mitoteam, e le Actions non cambiano. Guida completa: [jpgraph-nostre-classi-estendono-jpgraph](jpgraph-nostre-classi-estendono-jpgraph.md).

## Situazione attuale

| Pacchetto           | Ultimo aggiornamento | PHP       | Namespace / API        |
|---------------------|----------------------|-----------|-------------------------|
| **amenadiel/jpgraph** | v4.1.1 (aprile 2021) | 7.2+      | PSR-4 `Amenadiel\JpGraph\*` |
| **mitoteam/jpgraph**  | 10.5.2 (dic 2025)    | 5.5–8.5   | Include file, classi in globale |
| **jpgraph.net**       | 4.4.3 (tarball)      | —         | Sorgenti ufficiali, no Composer |

Il progetto oggi usa **amenadiel/jpgraph** (^4.1) e le Actions del modulo Chart referenziano `Amenadiel\JpGraph\Graph\Graph`, `Amenadiel\JpGraph\Plot\BarPlot`, ecc. amenadiel/jpgraph non è aggiornato da anni; mitoteam/jpgraph è mantenuto e compatibile con PHP 8.5 ma espone l’API “classica” (include + classi globali), non namespace PSR-4 come amenadiel.

Obiettivo: continuare a usare l’ultima versione di JpGraph (bugfix, PHP 8.x) riducendo al minimo le modifiche al codice esistente (Actions, GetGraphAction, ApplyPlotStyleAction, ecc.).

---

## Opzione 1: Passare a mitoteam/jpgraph e adattare il codice

Sostituire amenadiel/jpgraph con mitoteam/jpgraph e modificare tutte le Actions per usare le classi globali (o l’API esposta da mitoteam).

**Pro:** nessun fork da mantenere; aggiornamenti da Packagist.  
**Contro:** cambio massiccio di `use` e possibili differenze API (nomi classi, costanti, metodi).

**Passi sintetici:**

1. In `laravel/Modules/Chart/composer.json`: rimuovere `amenadiel/jpgraph`, aggiungere `mitoteam/jpgraph` (es. `^10.5`).
2. Nelle Actions JpGraph: rimuovere tutti gli `use Amenadiel\JpGraph\...` e usare le classi globali (`Graph`, `BarPlot`, `LinePlot`, `PiePlotC`, ecc.) dopo aver caricato i moduli con `MtJpGraph::load(['bar','line','pie',...])` dove serve.
3. Verificare costanti (FF_ARIAL, FS_BOLD, ecc.) e eventuali differenze di metodo tra amenadiel e mitoteam; adattare GetGraphAction, ApplyPlotStyleAction e Actions in V1.
4. Eseguire test e PHPStan; aggiornare [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) e doc correlate.

---

## Opzione 2: Fork locale (path repository) con nostro namespace

Creare un fork di mitoteam/jpgraph (o dei sorgenti jpgraph.net) dentro il monorepo, aggiungere PSR-4 con namespace `Amenadiel\JpGraph\*` per compatibilità con il codice esistente, e usarlo come path repository Composer.

**Pro:** nessun cambio negli `use` delle Actions; stesso namespace di oggi.  
**Contro:** fork da mantenere (merge/rebase da mitoteam o jpgraph.net); dimensioni e struttura del fork da definire.

**Passi sintetici:**

1. Creare una cartella per il fork, es. `laravel/Modules/Chart/packages/jpgraph` (o `laravel/packages/jpgraph` se condiviso).
2. Clonare mitoteam/jpgraph:  
   `git clone https://github.com/mitoteam/jpgraph.git <path_packages>/jpgraph`
3. Nel fork:
   - Aggiungere `composer.json` con nome package (es. `our-org/jpgraph` o `laraxot/jpgraph`) e autoload PSR-4 `Amenadiel\\JpGraph\\` → `src/`.
   - Portare il codice da `lib/` (struttura mitoteam) in `src/` con namespace `Amenadiel\JpGraph\Graph`, `Amenadiel\JpGraph\Plot`, ecc., mantenendo i nomi di classe (Graph, BarPlot, LinePlot, PiePlotC, …) e la logica identica.
   - Oppure: lasciare la struttura mitoteam e aggiungere uno strato sottile di file in `src/` che re-esportano le classi globali sotto `Amenadiel\JpGraph\*` (adapter minimo).
4. In root Laravel (o nel modulo Chart se il merge-plugin lo permette): registrare path repository:
   ```json
   "repositories": [
     { "type": "path", "url": "Modules/Chart/packages/jpgraph", "options": { "symlink": true } }
   ]
   ```
5. In `laravel/Modules/Chart/composer.json`: sostituire `amenadiel/jpgraph` con il nome del package del fork (es. `"our-org/jpgraph": "@dev"`).
6. `composer update` dalla root Laravel; verificare che le Actions continuino a usare `Amenadiel\JpGraph\...` senza modifiche.
7. Documentare in [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) che il progetto usa il fork locale e dove si trova; indicare come aggiornare il fork (rebase su mitoteam, ecc.).

---

## Opzione 3: Fork in repo separato (package nostro)

Stesso approccio dell’opzione 2, ma il fork vive in un repository Git separato (es. su GitHub/GitLab) e viene installato come dipendenza Composer (repo privato o pubblico).

**Pro:** package riutilizzabile; versioning chiaro (tag); possibile condivisione tra progetti.  
**Contro:** gestione di un repo in più; processo di release (tag, Composer) da definire.

**Passi sintetici:**

1. Creare un nuovo repo (es. `our-org/jpgraph` o `laraxot/jpgraph`).
2. Basare il contenuto su mitoteam/jpgraph (clone, storico opzionale).
3. Introdurre namespace PSR-4 `Amenadiel\JpGraph\*` come in opzione 2 (refactor o thin wrapper).
4. Aggiungere `composer.json` con autoload PSR-4 e nome package.
5. Registrare il repo in Composer (root Laravel o Chart):
   ```json
   "repositories": [
     { "type": "vcs", "url": "https://github.com/our-org/jpgraph" }
   ]
   ```
6. In Chart: `"our-org/jpgraph": "^1.0"` (o versione scelta).
7. Documentare in docs che la “nostra versione” è quel package e dove si aggiorna (upstream mitoteam/jpgraph).

---

## Opzione 4: Nostre classi che estendono JpGraph (consigliata)

Usare mitoteam/jpgraph come dipendenza e, nel modulo Chart, fornire un layer che espone le stesse classi/namespace che il codice usa oggi (`Amenadiel\JpGraph\*`), delegando alle classi globali di mitoteam.

**Pro:** nessun fork del codice JpGraph; aggiornamenti mitoteam tramite Composer.  
**Contro:** layer da mantenere; possibili edge case (costanti, metodi statici, tipi di ritorno).

**Passi sintetici:**

1. Aggiungere `mitoteam/jpgraph` (es. `^10.5`) in `Modules/Chart/composer.json`; rimuovere `amenadiel/jpgraph`.
2. Nel modulo Chart, creare uno strato di “facade” o alias:
   - **Variante A – class_alias:** in un ServiceProvider (o file incluso al bootstrap), dopo aver caricato i moduli necessari con `MtJpGraph::load(...)`, definire:
     ```php
     class_alias(\Graph::class, \Amenadiel\JpGraph\Graph\Graph::class);
     class_alias(\BarPlot::class, \Amenadiel\JpGraph\Plot\BarPlot::class);
     // ... per tutte le classi usate
     ```
     Le classi globali di mitoteam devono avere gli stessi nomi (Graph, BarPlot, …). Se mitoteam usa nomi diversi, questa variante non è applicabile senza wrapper.
   - **Variante B – classi wrapper:** in `Modules/Chart/app/JpGraph/` (o simile), definire classi che estendono le classi globali e sono nello namespace `Amenadiel\JpGraph\Graph`, `Amenadiel\JpGraph\Plot`, ecc.:
     ```php
     namespace Amenadiel\JpGraph\Graph;
     class Graph extends \Graph { }
     ```
     e analogamente per BarPlot, LinePlot, PiePlotC, ecc. Richiede che le classi globali siano caricabili prima (MtJpGraph::load).
3. Assicurarsi che il bootstrap del modulo Chart carichi MtJpGraph e poi registri alias o autoload delle wrapper.
4. Verificare costanti (FF_*, FS_*) e, se necessario, definirle in un file comune o nelle wrapper.
5. Test e PHPStan; aggiornare [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) indicando che si usa mitoteam con adapter/alias nel modulo Chart.

---

## Confronto rapido

| Criterio           | Opzione 1 (mitoteam diretto) | Opzione 2 (fork path) | Opzione 3 (fork repo) | Opzione 4 (adapter) |
|--------------------|------------------------------|------------------------|------------------------|----------------------|
| Modifiche al codice Chart | Molte (tutti gli use) | Nessuna (stesso namespace) | Nessuna | Nessuna (alias/wrapper) |
| Manutenzione fork  | No                           | Sì (locale)            | Sì (repo)              | No                   |
| Aggiornamenti upstream | Sì (composer update)   | Manuale (merge/rebase)  | Manuale (merge/rebase) | Sì (composer update) |
| Complessità        | Media                        | Alta                   | Alta                   | Media                |

---

## Raccomandazione

- **Approccio preferito (naming coerente con JpGraph):** **Opzione 4 – nostre classi che estendono JpGraph.** Si usa mitoteam/jpgraph come backend ma nel progetto si referenziano solo le nostre classi sotto `Amenadiel\JpGraph\*`; il naming resta quello desiderato (tipo amenadiel/jpgraph) e le Actions non cambiano. Guida: [jpgraph-nostre-classi-estendono-jpgraph](jpgraph-nostre-classi-estendono-jpgraph.md).
- **Se si vuole evitare qualsiasi fork e qualsiasi layer:** opzione 1 (passare a mitoteam e adattare tutto il codice alle classi globali).
- **Se si vuole mantenere il namespace senza dipendere da mitoteam a runtime:** opzione 2 (fork path) o 3 (fork repo).

Prima di procedere con un’opzione è utile:

1. Verificare in un branch la struttura reale di mitoteam/jpgraph (nomi classi in `lib/`, presenza di Graph, BarPlot, PiePlotC, ecc.).
2. Decidere se l’adapter (opzione 4) è sostenibile nel tempo (compatibilità API tra versioni mitoteam).
3. Aggiornare [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) e l’indice della documentazione JpGraph non appena si adotta una soluzione.

---

## Riferimenti

- [jpgraph-nostre-classi-estendono-jpgraph](jpgraph-nostre-classi-estendono-jpgraph.md) – **Guida consigliata:** nostre classi che estendono JpGraph, naming coerente, namespace `Amenadiel\JpGraph\*`.
- [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) – Installazione e namespace attuali (amenadiel/jpgraph).
- [jpgraph-4-4-3-reference](jpgraph-4-4-3-reference.md) – Riferimento versione e pacchetti alternativi.
- [mitoteam/jpgraph su Packagist](https://packagist.org/packages/mitoteam/jpgraph).
- [JpGraph ufficiale](https://jpgraph.net/) – Download sorgenti (es. 4.4.3).
