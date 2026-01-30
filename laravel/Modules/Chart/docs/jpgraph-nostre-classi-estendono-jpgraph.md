# JpGraph: nostre classi che estendono JpGraph (naming coerente)

Questo documento descrive l’approccio consigliato per usare l’ultima JpGraph (mitoteam/jpgraph) mantenendo il naming e i namespace che preferiamo: **le nostre classi che estendono le classi di JpGraph**, esposte sotto il namespace `Amenadiel\JpGraph\*`. Così il codice resta coerente con JpGraph (e con lo stile di amenadiel/jpgraph), senza adottare il naming mitoteam, e senza modificare le Actions esistenti.

## Perché questo approccio

- **Naming:** mitoteam/jpgraph come nome pacchetto non è preferito; era più coerente amenadiel/jpgraph (e con “JpGraph”). Con le nostre classi che estendono JpGraph manteniamo i namespace `Amenadiel\JpGraph\*` nel progetto.
- **Ultima versione:** usiamo mitoteam/jpgraph come dipendenza (PHP 8.5, manutenzione attiva) ma nel codice referenziamo sempre le *nostre* classi.
- **Compatibilità:** le Actions e tutto il modulo Chart continuano a usare `use Amenadiel\JpGraph\Graph\Graph;`, `use Amenadiel\JpGraph\Plot\BarPlot;`, ecc. Nessun cambio negli `use` esistenti.
- **Estensibilità:** le classi nostre possono in futuro aggiungere override o helper senza toccare la libreria upstream.

## Idea in breve

1. **Dipendenze:** in `composer.json` del modulo Chart usare **mitoteam/jpgraph** (es. `^10.5`) al posto di amenadiel/jpgraph.
2. **Nostre classi:** nel modulo Chart creiamo classi sotto il namespace `Amenadiel\JpGraph\*` che **estendono** le classi globali di JpGraph (caricate da mitoteam). Esempio: `Amenadiel\JpGraph\Graph\Graph extends \Graph`.
3. **Bootstrap:** prima di usare JpGraph, caricare i moduli necessari con `MtJpGraph::load(['bar','line','pie',...])` (in un ServiceProvider o in un punto unico del modulo Chart).
4. **Uso:** il resto del codice (GetGraphAction, ApplyPlotStyleAction, Bar2Action, Pie1Action, ecc.) continua a usare `Amenadiel\JpGraph\...`; sotto il cofano vengono istanziate le nostre classi, che a loro volta estendono quelle di JpGraph.

## Dove mettere le nostre classi

Nel modulo Chart, conviene dedicare una cartella al solo namespace `Amenadiel\JpGraph\*` e registrarla in autoload.

**Struttura suggerita:**

```
Modules/Chart/
├── app/
│   ├── Actions/
│   │   └── JpGraph/           # (invariato) usa Amenadiel\JpGraph\*
│   ├── JpGraphNamespace/      # nostre classi che estendono JpGraph
│   │   ├── Graph/
│   │   │   ├── Graph.php      # namespace Amenadiel\JpGraph\Graph; class Graph extends \Graph
│   │   │   ├── PieGraph.php
│   │   │   ├── Axis.php
│   │   │   └── Legend.php
│   │   ├── Plot/
│   │   │   ├── BarPlot.php
│   │   │   ├── LinePlot.php
│   │   │   ├── PiePlotC.php
│   │   │   ├── GroupBarPlot.php
│   │   │   └── AccBarPlot.php
│   │   ├── Text/
│   │   │   └── Text.php
│   │   └── Themes/
│   │       └── UniversalTheme.php
│   └── ...
```

**Autoload nel modulo Chart** (`Modules/Chart/composer.json`):

Aggiungere un secondo mapping PSR-4 in modo che le classi in `app/JpGraphNamespace/` abbiano il namespace `Amenadiel\JpGraph\*`:

```json
"autoload": {
    "psr-4": {
        "Modules\\Chart\\": "app/",
        "Amenadiel\\JpGraph\\": "app/JpGraphNamespace/",
        "Modules\\Chart\\Database\\Factories\\": "database/factories/",
        "Modules\\Chart\\Database\\Seeders\\": "database/seeders/"
    }
}
```

La struttura delle sottocartelle sotto `JpGraphNamespace/` deve rispecchiare i sotto-namespace: `JpGraphNamespace/Graph/Graph.php` → `Amenadiel\JpGraph\Graph\Graph`, ecc.

## Esempi di classi (estensione pura)

Le classi sono thin wrapper: stesso namespace di amenadiel, estendono la classe globale corrispondente. Nessuna logica aggiuntiva se non serve.

**`app/JpGraphNamespace/Graph/Graph.php`:**

```php
<?php

declare(strict_types=1);

namespace Amenadiel\JpGraph\Graph;

/**
 * Nostra classe Graph: naming coerente con JpGraph, estende la classe globale di mitoteam/jpgraph.
 */
class Graph extends \Graph
{
}
```

**`app/JpGraphNamespace/Plot/BarPlot.php`:**

```php
<?php

declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Nostra classe BarPlot: estende la classe globale BarPlot di JpGraph.
 */
class BarPlot extends \BarPlot
{
}
```

**`app/JpGraphNamespace/Plot/LinePlot.php`:**

```php
<?php

declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

class LinePlot extends \LinePlot
{
}
```

**`app/JpGraphNamespace/Plot/PiePlotC.php`:**

```php
<?php

declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

class PiePlotC extends \PiePlotC
{
}
```

**`app/JpGraphNamespace/Themes/UniversalTheme.php`:**

```php
<?php

declare(strict_types=1);

namespace Amenadiel\JpGraph\Themes;

class UniversalTheme extends \UniversalTheme
{
}
```

Stesso schema per le altre classi usate nel modulo: `PieGraph`, `GroupBarPlot`, `AccBarPlot`, `Text`, `Axis`, `Legend` (se presenti in mitoteam con lo stesso nome globale). Nomi e path devono coincidere con quelli referenziati nelle Actions (vedi sotto).

## Bootstrap: caricare JpGraph prima dell’uso

mitoteam/jpgraph espone classi globali tramite `MtJpGraph::load($modules)`. Le nostre classi le estendono, quindi le classi globali devono essere già caricate quando il codice usa `new \Amenadiel\JpGraph\Graph\Graph(...)`.

**Dove:** nel `ChartServiceProvider` (o in un helper usato dalle Actions) eseguire il load una volta, per tutti i moduli JpGraph usati dal modulo Chart. Esempio:

```php
// In ChartServiceProvider::boot() o in un metodo chiamato prima delle Actions
use mitoteam\jpgraph\MtJpGraph;

MtJpGraph::load(['bar', 'line', 'pie', 'pie3d', 'axis', 'legend', 'text', 'theme']);
```

L’elenco esatto (`bar`, `line`, `pie`, …) va verificato sulla struttura di mitoteam/jpgraph (nomi file in `lib/`: `jpgraph_bar.php`, `jpgraph_line.php`, ecc.). In questo modo le classi globali `Graph`, `BarPlot`, `LinePlot`, `PiePlotC`, `UniversalTheme`, ecc. sono disponibili e le nostre classi possono estenderle.

## Classi da creare (checklist)

In base alle Actions attuali del modulo Chart, servono almeno queste nostre classi (estensione pura) sotto `Amenadiel\JpGraph\*`:

| Namespace (Amenadiel\JpGraph\) | Classe        | Estende (globale) |
|--------------------------------|---------------|-------------------|
| Graph                          | Graph         | \Graph            |
| Graph                          | PieGraph      | \PieGraph         |
| Graph                          | Axis          | \Axis             |
| Graph                          | Legend        | \Legend           |
| Plot                           | BarPlot       | \BarPlot          |
| Plot                           | LinePlot      | \LinePlot         |
| Plot                           | PiePlotC      | \PiePlotC         |
| Plot                           | GroupBarPlot  | \GroupBarPlot     |
| Plot                           | AccBarPlot    | \AccBarPlot       |
| Text                           | Text          | \Text             |
| Themes                         | UniversalTheme| \UniversalTheme   |

Verificare sui file `lib/jpgraph_*.php` di mitoteam i nomi esatti delle classi globali (es. `PiePlotC` vs `PiePlot`) e creare solo le classi effettivamente usate dalle Actions.

## Costanti (FF_ARIAL, FS_BOLD, ecc.)

JpGraph definisce costanti globali (font, stili). Se nel codice si usano `FF_ARIAL`, `FS_BOLD`, `FS_NORMAL`, esse vengono definite da mitoteam quando si caricano i moduli. Se in qualche punto si è usato il prefisso `Amenadiel\JpGraph\FF_ARIAL`, si può:

- continuare a usare le costanti globali dopo `MtJpGraph::load(...)`, oppure
- definire in un file del modulo Chart (es. nello stesso bootstrap) costanti con prefisso namespace, se richiesto da PHPStan o da stile di codice.

## Passi operativi (riepilogo)

1. Aggiungere **mitoteam/jpgraph** (es. `^10.5`) in `Modules/Chart/composer.json`; rimuovere **amenadiel/jpgraph**.
2. Aggiungere in autoload del modulo Chart il mapping `"Amenadiel\\JpGraph\\": "app/JpGraphNamespace/"`.
3. Creare la cartella `app/JpGraphNamespace/` e le sottocartelle `Graph/`, `Plot/`, `Text/`, `Themes/`.
4. Creare le classi che estendono le corrispondenti classi globali (Graph, BarPlot, LinePlot, PiePlotC, GroupBarPlot, AccBarPlot, PieGraph, UniversalTheme, Text, Axis, Legend), come negli esempi sopra.
5. Nel bootstrap del modulo Chart (es. `ChartServiceProvider::boot()`) chiamare `MtJpGraph::load([...])` con l’elenco dei moduli necessari.
6. Eseguire `composer dump-autoload` dalla root Laravel; verificare che le Actions continuino a funzionare senza modifiche agli `use`.
7. Aggiornare [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) indicando che si usa mitoteam/jpgraph con “nostre classi che estendono JpGraph” e namespace `Amenadiel\JpGraph\*`.

## Riferimenti

- [jpgraph-our-version-latest-upstream](jpgraph-our-version-latest-upstream.md) – Opzioni per usare l’ultima JpGraph; questa è l’opzione “nostre classi che estendono” (adapter con naming preferito).
- [jpgraph-composer-and-namespaces](jpgraph-composer-and-namespaces.md) – Installazione e namespace.
- [mitoteam/jpgraph](https://packagist.org/packages/mitoteam/jpgraph) – Pacchetto usato come backend.
