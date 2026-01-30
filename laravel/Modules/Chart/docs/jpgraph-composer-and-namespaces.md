# JpGraph: installazione Composer e utilizzo namespace

Documento di riferimento per l’installazione di JpGraph con Composer e per l’uso corretto dei namespace nel progetto. Il modulo Chart è il punto unico di dipendenza da JpGraph; gli altri moduli usano le Actions del modulo Chart.

## Installazione con Composer

### Pacchetto usato

Nel progetto si usa il pacchetto **amenadiel/jpgraph** (namespace `Amenadiel\JpGraph\*`). Non usare il pacchetto `jpgraph/jpgraph` o altri fork.

### Dove è dichiarata la dipendenza

La dipendenza è dichiarata nel modulo Chart:

- `laravel/Modules/Chart/composer.json` → `"amenadiel/jpgraph": "^4.1"`

Con composer-merge-plugin, le dipendenze dei moduli vengono risolte dalla root Laravel. Non è necessario dichiarare JpGraph in altri moduli né nella root, a meno che non si voglia usare JpGraph senza il modulo Chart.

### Comandi di installazione

Dalla root dell’applicazione Laravel:

```bash
cd laravel
composer require amenadiel/jpgraph
```

Oppure, se il modulo Chart è già incluso nel merge:

```bash
cd laravel
composer update
```

Il pacchetto viene installato in `vendor/amenadiel/jpgraph` e l’autoload PSR-4 è fornito dal pacchetto stesso. **Non** aggiungere mapping manuali per `Amenadiel\JpGraph` in `autoload` di `composer.json`.

### Verifica installazione

```bash
cd laravel
composer show amenadiel/jpgraph
```

Verifica che le classi siano caricabili, ad esempio:

```php
use Amenadiel\JpGraph\Graph\Graph;
$graph = new Graph(400, 300);
```

## Utilizzo dei namespace

Tutte le classi JpGraph vanno referenziate con il namespace **Amenadiel\JpGraph**.

### Struttura principale dei namespace

| Namespace base        | Uso principale                          |
|-----------------------|-----------------------------------------|
| `Amenadiel\JpGraph\Graph`   | Graph, PieGraph, Axis, Legend           |
| `Amenadiel\JpGraph\Plot`     | BarPlot, LinePlot, PiePlotC, AccBarPlot, GroupBarPlot |
| `Amenadiel\JpGraph\Text`     | Text (titoli, assi, legende)            |
| `Amenadiel\JpGraph\Themes`   | UniversalTheme                         |

### Classi usate nel modulo Chart

Import tipici nelle Actions del modulo Chart:

```php
use Amenadiel\JpGraph\Graph\Axis;
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\Legend;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\AccBarPlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Plot\LinePlot;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Amenadiel\JpGraph\Text\Text;
use Amenadiel\JpGraph\Themes\UniversalTheme;
```

### Esempio minimo

```php
<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Themes\UniversalTheme;

$graph = new Graph(800, 400, 'auto');
$graph->SetScale('textlin');
$graph->SetTheme(new UniversalTheme());

$barPlot = new BarPlot([10, 20, 30]);
$graph->Add($barPlot);

$graph->Stroke('/path/to/output.png');
```

### Costanti font (JpGraph)

JpGraph espone costanti globali per font (es. `FF_ARIAL`, `FS_BOLD`). In alcuni contesti possono essere definite con prefisso namespace, ad esempio `Amenadiel\JpGraph\FF_ARIAL`. Nel codice del modulo Chart si usano fallback solo dove richiesto (vedi ad esempio `Pie1Action.php`).

## Ruolo del modulo Chart

- **Chart**: unica dipendenza Composer da `amenadiel/jpgraph`; contiene tutte le Actions JpGraph (`Modules\Chart\Actions\JpGraph\*`) e i DTO (es. `ChartData`, `AnswersChartData`).
- **Quaeris, Limesurvey, User, ecc.**: non dichiarano JpGraph in `composer.json`; usano le Actions e i servizi del modulo Chart per generare grafici (es. PDF, report).

**Nostra versione con ultima JpGraph:** amenadiel/jpgraph non è aggiornato da anni. Approccio consigliato: usare mitoteam/jpgraph e **le nostre classi che estendono le classi di JpGraph**, sotto il namespace `Amenadiel\JpGraph\*`, così il naming resta coerente con JpGraph (tipo amenadiel). Guida: [jpgraph-nostre-classi-estendono-jpgraph](jpgraph-nostre-classi-estendono-jpgraph.md). Panoramica opzioni: [jpgraph-our-version-latest-upstream](jpgraph-our-version-latest-upstream.md).

Per integrazioni avanzate, generazione PDF e tipi di chart supportati vedi:

- [jpgraph-installation](jpgraph-installation.md)
- [jpgraph-complete-guide](jpgraph-complete-guide.md)
- Regole JpGraph: `.cursor/rules/jpgraph-rules.mdc` (root progetto)
