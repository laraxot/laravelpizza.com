# JpGraph - Installazione e Namespace

**Versione**: 4.x
**Package Composer**: `amenadiel/jpgraph`
**Ultimo Aggiornamento**: Gennaio 2026

---

## Installazione

### Via Composer

Il progetto utilizza `amenadiel/jpgraph`, che espone namespace PSR-4 `Amenadiel\\JpGraph\\*`.

```bash
cd laravel
composer require amenadiel/jpgraph:"^4.1"
```

**Dove dichiararlo**: la dipendenza va dichiarata nel `composer.json` del modulo Chart:

```text
Modules/Chart/composer.json
```

```json
{
    "require": {
        "amenadiel/jpgraph": "^4.1"
    }
}
```

La dipendenza viene risolta automaticamente dal sistema `wikimedia/composer-merge-plugin` configurato nel `composer.json` root.

### Verifica Installazione

```bash
cd laravel
composer show amenadiel/jpgraph
```

Output atteso:

```text
name     : amenadiel/jpgraph
versions : 4.x.x
type     : library
```

---

## Namespace

### Root Namespace

```text
Amenadiel\JpGraph\
```

### Struttura Namespace Completa

```text
Amenadiel\JpGraph\
├── Graph\
│   ├── Graph          # Grafico cartesiano base
│   ├── PieGraph       # Grafico a torta (specializzato)
│   ├── Axis           # Asse (X, Y)
│   └── Legend         # Legenda
├── Plot\
│   ├── BarPlot        # Barre verticali
│   ├── LinePlot       # Linee
│   ├── PiePlot        # Torta 2D
│   ├── PiePlotC       # Torta con centro (donut)
│   ├── PiePlot3D      # Torta 3D
│   ├── GroupBarPlot   # Barre raggruppate
│   ├── AccBarPlot     # Barre impilate
│   ├── ScatterPlot    # Punti dispersi
│   ├── ErrorPlot      # Barre errore
│   └── RadarPlot      # Radar
├── Text\
│   └── Text           # Testo (titoli, labels, valori)
└── Themes\
    ├── UniversalTheme # Tema universale
    ├── OceanTheme     # Tema oceano
    └── PastelTheme    # Tema pastello
```

### Import Utilizzati nel Progetto

Queste sono le classi JpGraph importate nelle Action del progetto:

```php
// Graph
use Amenadiel\JpGraph\Graph\Graph;       // Grafico cartesiano
use Amenadiel\JpGraph\Graph\PieGraph;    // Grafico torta
use Amenadiel\JpGraph\Graph\Axis;        // Asse
use Amenadiel\JpGraph\Graph\Legend;       // Legenda

// Plot
use Amenadiel\JpGraph\Plot\BarPlot;      // Barre
use Amenadiel\JpGraph\Plot\LinePlot;     // Linee
use Amenadiel\JpGraph\Plot\PiePlotC;     // Torta con centro
use Amenadiel\JpGraph\Plot\GroupBarPlot; // Barre raggruppate
use Amenadiel\JpGraph\Plot\AccBarPlot;   // Barre impilate

// Text e Themes
use Amenadiel\JpGraph\Text\Text;          // Testo
use Amenadiel\JpGraph\Themes\UniversalTheme; // Tema default
```

---

## Utilizzo nel Progetto

### Struttura Actions

Le classi JpGraph NON vengono mai usate direttamente nel codice applicativo. Vengono incapsulate nelle Action del modulo Chart:

```text
Modules/Chart/app/Actions/JpGraph/
├── GetGraphAction.php          # Crea Graph base
│   └── Usa: Graph, Axis, Text, UniversalTheme
├── ApplyGraphStyleAction.php   # Applica stile al Graph
│   └── Usa: Graph, Axis, Text
├── ApplyPlotStyleAction.php    # Applica stile ai Plot
│   └── Usa: BarPlot, Text
└── V1/
    ├── Bar1Action.php          # Usa: BarPlot
    ├── Bar2Action.php          # Usa: Graph, BarPlot, GroupBarPlot, Text
    ├── Bar3Action.php          # Usa: Graph, BarPlot, AccBarPlot, Text
    ├── Horizbar1Action.php     # Usa: Graph, BarPlot
    ├── Pie1Action.php          # Usa: Graph, PieGraph, PiePlotC, Text
    ├── PieAvgAction.php        # Usa: Graph, PieGraph, PiePlotC, Text
    └── LineSubQuestionAction.php # Usa: Graph, Axis, Legend, LinePlot, Text
```

### Esempio Completo di Utilizzo

```php
<?php

namespace Modules\Chart\Actions\JpGraph\V1;

// Namespace JpGraph (amenadiel/jpgraph)
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;

// Namespace Progetto
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;

class Bar1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $chart = $answersChartData->chart;
        $answers = $answersChartData->answers;

        // 1. Estrai dati
        $data = $answers->toCollection()->pluck('value')->all();
        $labels = $answers->toCollection()->pluck('label')->all();

        // 2. Crea Graph base (incapsula Amenadiel\JpGraph\Graph\Graph)
        $graph = app(GetGraphAction::class)->execute($chart);

        // 3. Configura X-axis
        if (is_object($graph->xaxis)) {
            $graph->xaxis->SetTickLabels($labels);
        }

        // 4. Crea BarPlot (Amenadiel\JpGraph\Plot\BarPlot)
        $barPlot = new BarPlot($data);

        // 5. Applica stile
        $barPlot = app(ApplyPlotStyleAction::class)->execute($barPlot, $chart);

        // 6. Aggiungi al Graph
        $graph->Add($barPlot);

        return $graph;
    }
}
```

### Salvataggio PNG

```php
// Dal codice chiamante (es. MakeImgByQuestionChartModel2Action)
$graph = app(Bar1Action::class)->execute($answersChartData);

// Salva come file PNG
$filePath = public_path('chart/123.png');
$graph->Stroke($filePath);
```

---

## Costanti JpGraph

JpGraph definisce costanti globali per font, marker e scale:

### Font Family

```php
FF_ARIAL      // Arial
FF_TIMES      // Times New Roman
FF_COURIER    // Courier
FF_VERDANA    // Verdana
FF_GEORGIA    // Georgia
FF_TREBUCHE   // Trebuchet MS
FF_COMIC      // Comic Sans
FF_DEFAULT    // Font di sistema
```

### Font Style

```php
FS_NORMAL      // Normale
FS_BOLD        // Grassetto
FS_ITALIC      // Corsivo
FS_BOLDITALIC  // Grassetto Corsivo
```

### Scale Types

```php
// Per Graph->SetScale()
'textlin'   // X: testo, Y: lineare (piu' usato)
'linlin'    // X: lineare, Y: lineare
'loglin'    // X: logaritmico, Y: lineare
'datlin'    // X: date, Y: lineare
'intlin'    // X: intero, Y: lineare
```

### Marker Types

```php
MARK_SQUARE         // Quadrato
MARK_UTRIANGLE      // Triangolo su
MARK_DTRIANGLE      // Triangolo giu
MARK_DIAMOND        // Diamante
MARK_CIRCLE         // Cerchio
MARK_FILLEDCIRCLE   // Cerchio pieno
MARK_CROSS          // Croce
MARK_STAR           // Stella
```

### Pie Label Types

```php
PIE_VALUE_ABS       // Valori assoluti
PIE_VALUE_PER       // Percentuali
PIE_VALUE_ADJPER    // Percentuali aggiustate
PIE_VALUE_ADJABS    // Valori assoluti aggiustati
```

---

## Troubleshooting

### Errore: Class not found

```text
Class 'Amenadiel\JpGraph\Graph\Graph' not found
```

**Soluzione**: Verificare che il package sia installato:

```bash
cd laravel
composer require amenadiel/jpgraph:"^4.1"
```

### Errore: GD Extension

```text
Fatal error: JpGraph requires GD extension
```

**Soluzione**: Installare l'estensione GD:

```bash
# Ubuntu/Debian
sudo apt-get install php8.2-gd

# CentOS/RHEL
sudo yum install php-gd

# Riavvia PHP
sudo systemctl restart php8.2-fpm
```

### Errore: Font not found

```text
JpGraph Error: Can't find font file
```

**Soluzione**: Installare font TrueType:

```bash
# Ubuntu/Debian
sudo apt-get install fonts-liberation ttf-mscorefonts-installer
```

### Errore: Memory limit

```text
Fatal error: Allowed memory size exhausted
```

**Soluzione**: Aumentare memory limit nel codice:

```php
ini_set('memory_limit', '-1');
// ... generazione grafico ...
ini_restore('memory_limit');
```

---

## Riferimenti

- [amenadiel/jpgraph su Packagist](https://packagist.org/packages/amenadiel/jpgraph)
- [JpGraph Sito Ufficiale](https://jpgraph.net/)
- [JpGraph Manuale Online](https://jpgraph.net/download/manuals/chunkhtml/index.html)
- [JpGraph Class Reference](https://jpgraph.net/download/manuals/classref/index.html)
- [mitoteam/jpgraph su GitHub](https://github.com/mitoteam/jpgraph) (alternativa con PHP 8.5 patch)

---

**Versione Documentazione**: 1.0.0
**Data**: Gennaio 2026
