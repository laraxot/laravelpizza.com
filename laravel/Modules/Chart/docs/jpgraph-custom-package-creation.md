# Creazione Package Custom JpGraph con Namespace PSR-4

**Versione**: 2.0.0
**Ultimo Aggiornamento**: Gennaio 2026

---

## Il Problema

| Package | Versione | PHP | Namespace | Stato |
|---------|----------|-----|-----------|-------|
| `amenadiel/jpgraph` | 4.1.1 (Apr 2021) | 7.2+ | `Amenadiel\JpGraph\*` (PSR-4) | Abbandonato |
| `mitoteam/jpgraph` | 10.5.2 (Dic 2025) | 5.5-8.5 | Classi globali (`\Graph`, `\BarPlot`) | Attivo |

- `amenadiel/jpgraph` ha il naming PSR-4 migliore ma non e' aggiornato da 5 anni
- `mitoteam/jpgraph` ha il codice JpGraph 4.4.3 aggiornato ma usa classi globali senza namespace

---

## La Soluzione: Package Custom Ibrido

Creare un **package Composer locale** che:

1. Usa `mitoteam/jpgraph` come dipendenza (codice JpGraph 4.4.3 aggiornato, PHP 8.5)
2. Espone classi PSR-4 con namespace `Amenadiel\JpGraph\*` (naming che preferiamo)
3. Le classi wrapper delegano alle classi globali di JpGraph caricate via `MtJpGraph::load()`
4. **Zero modifiche** al codice esistente: gli `use` statement restano identici

### Flusso Architetturale

```text
mitoteam/jpgraph (Composer, v10.5.x)
    ↓ MtJpGraph::load() carica classi globali (\Graph, \BarPlot, etc.)
    ↓
Package Custom: amenadiel/jpgraph (locale, v4.4.3)
    ↓ Wrapper PSR-4: Amenadiel\JpGraph\Graph\Graph extends \Graph
    ↓
Codice Applicazione (ZERO MODIFICHE)
    use Amenadiel\JpGraph\Graph\Graph;  ← rimane identico!
    use Amenadiel\JpGraph\Plot\BarPlot; ← rimane identico!
```

---

## Struttura del Package

### Posizione

```text
Modules/Chart/packages/amenadiel-jpgraph/
```

Segue il pattern gia' usato nel progetto per i package locali (vedi `Modules/Lang/packages/`, `Modules/Xot/packages/`).

### Directory Structure

```text
Modules/Chart/packages/amenadiel-jpgraph/
├── composer.json
├── README.md
├── src/
│   ├── Graph/
│   │   ├── Graph.php           # extends \Graph
│   │   ├── PieGraph.php        # extends \PieGraph
│   │   ├── Axis.php            # (type alias, non istanziato direttamente)
│   │   └── Legend.php          # (type alias, non istanziato direttamente)
│   ├── Plot/
│   │   ├── BarPlot.php         # extends \BarPlot
│   │   ├── LinePlot.php        # extends \LinePlot
│   │   ├── PiePlotC.php        # extends \PiePlotC
│   │   ├── GroupBarPlot.php    # extends \GroupBarPlot
│   │   ├── AccBarPlot.php      # extends \AccBarPlot
│   │   └── ScatterPlot.php     # extends \ScatterPlot
│   ├── Text/
│   │   └── Text.php            # extends \Text
│   └── Themes/
│       └── UniversalTheme.php  # extends \UniversalTheme
└── bootstrap.php               # Auto-load di MtJpGraph::load()
```

### File: `composer.json`

```json
{
    "name": "amenadiel/jpgraph",
    "description": "JpGraph 4.4.3 con namespace PSR-4 - Wrapper su mitoteam/jpgraph",
    "type": "library",
    "license": "QPL-1.0",
    "version": "4.4.3",
    "require": {
        "php": "^8.2",
        "ext-gd": "*",
        "mitoteam/jpgraph": "^10.5"
    },
    "autoload": {
        "psr-4": {
            "Amenadiel\\JpGraph\\": "src/"
        },
        "files": [
            "bootstrap.php"
        ]
    },
    "authors": [
        {
            "name": "Marco Sottana",
            "email": "marco.sottana@gmail.com"
        }
    ],
    "keywords": ["chart", "graph", "jpgraph", "laraxot", "psr-4"]
}
```

### File: `bootstrap.php`

```php
<?php declare(strict_types=1);

/**
 * Bootstrap: carica automaticamente JpGraph con tutti i moduli necessari.
 *
 * mitoteam/jpgraph espone classi globali (\Graph, \BarPlot, etc.)
 * tramite MtJpGraph::load(). Questo file le carica all'avvio.
 */

use mitoteam\jpgraph\MtJpGraph;

// Carica il core + tutti i moduli usati nel progetto
MtJpGraph::load('bar');    // BarPlot, GroupBarPlot, AccBarPlot
MtJpGraph::load('line');   // LinePlot
MtJpGraph::load('pie');    // PiePlot, PiePlotC, PieGraph
MtJpGraph::load('scatter'); // ScatterPlot (opzionale, per uso futuro)
```

---

## Implementazione Classi Wrapper

### Principio: Estensione Diretta

Le classi wrapper **estendono** direttamente le classi globali di JpGraph. Questo approccio:

- Eredita tutti i metodi e le proprieta' originali
- Non richiede `__call()`, `__get()`, `__set()` magic methods
- E' type-safe: `$graph instanceof \Graph` resta `true`
- Permette di aggiungere metodi custom senza modificare JpGraph

```php
// Il wrapper e' semplicemente:
namespace Amenadiel\JpGraph\Graph;
class Graph extends \Graph { }

// Cosi' il codice esistente funziona SENZA MODIFICHE:
use Amenadiel\JpGraph\Graph\Graph;
$graph = new Graph(800, 400);    // ← crea un \Graph (esteso)
$graph->SetScale('textlin');     // ← metodo ereditato
$graph->title->Set('Titolo');    // ← proprieta' ereditata
```

### 1. `src/Graph/Graph.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Graph;

/**
 * Wrapper PSR-4 per JpGraph Graph.
 *
 * Estende la classe globale \Graph caricata da mitoteam/jpgraph.
 * Mantiene piena compatibilita' con amenadiel/jpgraph namespace.
 *
 * Proprieta' ereditate: $title, $subtitle, $footer, $xaxis, $yaxis,
 *   $ygrid, $yscale, $img, $legend
 *
 * @property \Text $title
 * @property \Text $subtitle
 * @property object $footer
 * @property \Axis $xaxis
 * @property \Axis $yaxis
 * @property object $ygrid
 * @property object $yscale
 * @property object $img
 * @property \Legend $legend
 */
class Graph extends \Graph
{
    // Eredita tutto da \Graph.
    // Aggiungere qui eventuali metodi custom Laraxot.
}
```

### 2. `src/Graph/PieGraph.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Graph;

/**
 * Wrapper PSR-4 per JpGraph PieGraph.
 *
 * Usato per grafici a torta e donut (PiePlotC).
 *
 * @property \Text $title
 * @property \Text $subtitle
 * @property object $footer
 */
class PieGraph extends \PieGraph
{
    // Eredita tutto da \PieGraph.
}
```

### 3. `src/Graph/Axis.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Graph;

/**
 * Wrapper PSR-4 per JpGraph Axis.
 *
 * Nota: Axis non viene istanziato direttamente nel codice.
 * Viene usato come type hint per $graph->xaxis e $graph->yaxis.
 *
 * Metodi usati nel progetto:
 * - SetFont($family, $style, $size)
 * - SetLabelAngle($angle)
 * - SetLabelMargin($margin)
 * - SetTickLabels($labels)
 * - Hide(), HideZeroLabel(), HideLine($show), HideTicks($major, $minor)
 *
 * @property object $scale  Scale object con SetGrace(), SetAutoMin(), SetAutoMax()
 */
class Axis extends \Axis
{
    // Eredita tutto da \Axis.
}
```

### 4. `src/Graph/Legend.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Graph;

/**
 * Wrapper PSR-4 per JpGraph Legend.
 *
 * Nota: Legend non viene istanziato direttamente.
 * Viene acceduto tramite $graph->legend.
 *
 * Metodi usati nel progetto:
 * - SetFrameWeight($weight)
 * - SetColor($bgColor, $textColor)
 * - SetMarkAbsSize($size)
 */
class Legend extends \Legend
{
    // Eredita tutto da \Legend.
}
```

### 5. `src/Plot/BarPlot.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Wrapper PSR-4 per JpGraph BarPlot.
 *
 * Metodi usati nel progetto:
 * - SetFillColor($color)     Colore riempimento (supporta trasparenza: 'red@0.6')
 * - SetColor($color)         Colore bordo
 * - SetWidth($width)         Larghezza relativa (0.0-1.0)
 * - SetValuePos($position)   Posizione valori: 'center', 'top', 'bottom'
 * - SetLegend($legend)       Testo legenda
 *
 * @property object $value  Value labels (Text-like object con Show(), SetFont(), SetFormat(), etc.)
 */
class BarPlot extends \BarPlot
{
    // Eredita tutto da \BarPlot.
}
```

### 6. `src/Plot/GroupBarPlot.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Wrapper PSR-4 per JpGraph GroupBarPlot.
 *
 * Raggruppa piu' BarPlot affiancati (side-by-side).
 * Costruttore accetta array di BarPlot.
 */
class GroupBarPlot extends \GroupBarPlot
{
    // Eredita tutto da \GroupBarPlot.
}
```

### 7. `src/Plot/AccBarPlot.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Wrapper PSR-4 per JpGraph AccBarPlot.
 *
 * Barre impilate (stacked bar chart).
 * Costruttore accetta array di BarPlot.
 *
 * Metodi usati nel progetto:
 * - SetWidth($width)  Larghezza relativa (0.0-1.0)
 */
class AccBarPlot extends \AccBarPlot
{
    // Eredita tutto da \AccBarPlot.
}
```

### 8. `src/Plot/LinePlot.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Wrapper PSR-4 per JpGraph LinePlot.
 *
 * Metodi usati nel progetto:
 * - SetColor($color)      Colore linea
 * - SetLegend($legend)    Testo legenda
 * - SetCenter()           Centra la linea
 *
 * @property object $mark  PlotMark con SetType(), SetColor()
 */
class LinePlot extends \LinePlot
{
    // Eredita tutto da \LinePlot.
}
```

### 9. `src/Plot/PiePlotC.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Wrapper PSR-4 per JpGraph PiePlotC (Center/Donut Pie).
 *
 * Metodi usati nel progetto:
 * - SetSliceColors($colors)          Colori fette
 * - SetLegends($labels)              Etichette legenda
 * - SetGuideLines($radial, $horiz)   Guide lines
 * - SetGuideLinesAdjust($adjust)     Distanza guide
 * - SetLabelType($type)              Tipo etichetta (PIE_VALUE_PER)
 * - SetMidSize($size)                Dimensione buco donut (0.0-1.0)
 * - SetMidColor($color)              Colore centro donut
 * - SetStartAngle($angle)            Angolo iniziale in gradi
 * - SetLabelPos($pos)                Posizione etichette (0 = centro)
 *
 * @property object $value     Value labels (Text-like: Show(), SetFont(), SetFormat(), SetColor())
 * @property object $midtitle  Testo al centro del donut (Text-like: Set(), SetFont())
 */
class PiePlotC extends \PiePlotC
{
    // Eredita tutto da \PiePlotC.
}
```

### 10. `src/Plot/ScatterPlot.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Plot;

/**
 * Wrapper PSR-4 per JpGraph ScatterPlot.
 *
 * Non attualmente usato nel progetto ma incluso per completezza.
 *
 * @property object $mark  PlotMark con SetType(), SetFillColor(), SetSize()
 */
class ScatterPlot extends \ScatterPlot
{
    // Eredita tutto da \ScatterPlot.
}
```

### 11. `src/Text/Text.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Text;

/**
 * Wrapper PSR-4 per JpGraph Text.
 *
 * Metodi usati nel progetto:
 * - Set($text)                           Imposta testo
 * - SetFont($family, $style, $size)      Font
 * - SetColor($color)                     Colore testo
 * - SetAlign($horizontal, $vertical)     Allineamento
 * - SetPos($x, $y)                       Posizione
 * - setAngle($angle)                     Rotazione
 * - Show($show = true)                   Mostra/nascondi
 * - SetFormat($format)                   Formato numerico (es. '%.1f %%')
 */
class Text extends \Text
{
    // Eredita tutto da \Text.
}
```

### 12. `src/Themes/UniversalTheme.php`

```php
<?php declare(strict_types=1);

namespace Amenadiel\JpGraph\Themes;

/**
 * Wrapper PSR-4 per JpGraph UniversalTheme.
 *
 * Tema predefinito applicato via $graph->SetTheme($theme).
 */
class UniversalTheme extends \UniversalTheme
{
    // Eredita tutto da \UniversalTheme.
}
```

---

## Registrazione nel Progetto

### 1. Aggiungere Repository Path nel `composer.json` Root

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "Modules/Chart/packages/amenadiel-jpgraph",
            "options": { "symlink": true }
        },
        {
            "type": "composer",
            "url": "https://repo.packagist.org",
            "canonical": false
        }
    ]
}
```

**Nota**: Il repository `path` DEVE essere dichiarato PRIMA di Packagist con `"canonical": false`, altrimenti Composer tentera' di scaricare `amenadiel/jpgraph` da Packagist (la versione vecchia 4.1.1).

### 2. Aggiornare `Modules/Chart/composer.json`

```json
{
    "require": {
        "amenadiel/jpgraph": "4.4.3"
    }
}
```

La versione cambia da `"^4.1"` a `"4.4.3"` (match esatto con il package locale).

### 3. Installazione

```bash
cd laravel

# Rimuovi il vecchio amenadiel/jpgraph da Packagist
composer remove amenadiel/jpgraph

# Installa il nuovo package locale (che dipende da mitoteam/jpgraph)
composer require amenadiel/jpgraph:4.4.3

# Verifica
composer show amenadiel/jpgraph
# Deve mostrare: version 4.4.3, source: path (Modules/Chart/packages/amenadiel-jpgraph)
```

---

## Migrazione: Zero Modifiche al Codice

### Perche' funziona senza modifiche?

Il codice esistente nelle Actions usa:

```php
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;
```

Il package custom espone esattamente lo **stesso namespace**. La differenza e' solo interna:

| Prima | Dopo |
|-------|------|
| `Amenadiel\JpGraph\Graph\Graph` era una classe autonoma in amenadiel/jpgraph | `Amenadiel\JpGraph\Graph\Graph` estende `\Graph` da mitoteam/jpgraph |
| JpGraph 4.1.1 (PHP 7.2+) | JpGraph 4.4.3 (PHP 8.5) |
| Package Packagist (abbandonato) | Package locale (controllato da noi) |

### File che NON richiedono modifiche (9 file)

```text
Modules/Chart/app/Actions/JpGraph/V1/GetGraphAction.php
Modules/Chart/app/Actions/JpGraph/V1/ApplyGraphStyleAction.php
Modules/Chart/app/Actions/JpGraph/V1/ApplyPlotStyleAction.php
Modules/Chart/app/Actions/JpGraph/V1/Bar2Action.php
Modules/Chart/app/Actions/JpGraph/V1/Bar3Action.php
Modules/Chart/app/Actions/JpGraph/V1/Horizbar1Action.php
Modules/Chart/app/Actions/JpGraph/V1/LineSubQuestionAction.php
Modules/Chart/app/Actions/JpGraph/V1/Pie1Action.php
Modules/Chart/app/Actions/JpGraph/V1/PieAvgAction.php
```

Tutti questi file mantengono i loro `use Amenadiel\JpGraph\*` statement invariati.

---

## Costanti JpGraph

Le costanti JpGraph sono globali e vengono caricate automaticamente da `MtJpGraph::load()`:

```php
// Font Families
FF_ARIAL      // Arial
FF_FONT1      // Font bitmap 1
FF_FONT2      // Font bitmap 2
FF_TIMES      // Times New Roman
FF_COURIER    // Courier
FF_VERDANA    // Verdana

// Font Styles
FS_NORMAL     // Normale
FS_BOLD       // Grassetto
FS_ITALIC     // Corsivo
FS_BOLDITALIC // Grassetto corsivo

// Pie Label Types
PIE_VALUE_PER // Mostra percentuale

// Scale Types
// Usati come stringhe, non costanti:
// 'textlin', 'linlin', 'datlin'
```

**Nota sulla compatibilita'**: Nel codice attuale (Pie1Action.php linee 22-25), le costanti sono definite nel namespace `Amenadiel\JpGraph\` per PHPStan. Con il nuovo package, le costanti sono globali (caricate da mitoteam/jpgraph), quindi quelle definizioni manuali non saranno piu' necessarie.

---

## Vantaggi di Questo Approccio

| Aspetto | Vantaggio |
|---------|-----------|
| **Naming** | Mantiene `Amenadiel\JpGraph\*` — coerente con JpGraph |
| **Aggiornamenti** | mitoteam/jpgraph attivamente mantenuto (PHP 8.5) |
| **Migrazione** | Zero modifiche al codice esistente |
| **Estensibilita'** | Possiamo aggiungere metodi custom alle classi wrapper |
| **Type Safety** | `instanceof \Graph` funziona (extends) |
| **PHPStan** | PHPDoc `@property` per proprieta' magic |
| **Manutenzione** | Solo 12 file minimal da mantenere (classi vuote) |
| **Composer** | Segue pattern gia' usato nel progetto (path packages) |

---

## Confronto con le Alternative

| Criterio | amenadiel/jpgraph (vecchio) | mitoteam/jpgraph (diretto) | Package Custom (nostro) |
|----------|---------------------------|---------------------------|------------------------|
| Namespace PSR-4 | `Amenadiel\JpGraph\*` | Nessuno (classi globali) | `Amenadiel\JpGraph\*` |
| PHP Support | 7.2+ (no 8.3+) | 5.5-8.5 | 8.2-8.5 |
| JpGraph Version | 4.1.1 | 4.4.3 | 4.4.3 |
| Mantenuto | No (5 anni) | Si (attivo) | Si (da noi) |
| Modifiche codice | Nessuna | 9 file da modificare | **Nessuna** |
| Naming style | Elegante | `MtJpGraph::load()` | Elegante |

---

## Inventario Completo: Classi e Metodi Usati

### 11 Classi

| # | Namespace PSR-4 | Classe Globale | Usata in |
|---|----------------|----------------|----------|
| 1 | `Amenadiel\JpGraph\Graph\Graph` | `\Graph` | 7 file |
| 2 | `Amenadiel\JpGraph\Graph\PieGraph` | `\PieGraph` | 2 file |
| 3 | `Amenadiel\JpGraph\Graph\Axis` | `\Axis` | 3 file (type hint) |
| 4 | `Amenadiel\JpGraph\Graph\Legend` | `\Legend` | 1 file (type hint) |
| 5 | `Amenadiel\JpGraph\Plot\BarPlot` | `\BarPlot` | 5 file |
| 6 | `Amenadiel\JpGraph\Plot\GroupBarPlot` | `\GroupBarPlot` | 1 file |
| 7 | `Amenadiel\JpGraph\Plot\AccBarPlot` | `\AccBarPlot` | 1 file |
| 8 | `Amenadiel\JpGraph\Plot\LinePlot` | `\LinePlot` | 1 file |
| 9 | `Amenadiel\JpGraph\Plot\PiePlotC` | `\PiePlotC` | 2 file |
| 10 | `Amenadiel\JpGraph\Text\Text` | `\Text` | 7 file |
| 11 | `Amenadiel\JpGraph\Themes\UniversalTheme` | `\UniversalTheme` | 1 file |

### ~45 Metodi Unici

**Graph** (8 metodi): `SetScale`, `SetShadow`, `SetTheme`, `SetBox`, `Add`, `AddText`, `Set90AndMargin`, `Stroke`

**Axis** (8 metodi): `SetFont`, `SetLabelAngle`, `SetLabelMargin`, `SetTickLabels`, `Hide`, `HideZeroLabel`, `HideLine`, `HideTicks`

**BarPlot** (5 metodi): `SetFillColor`, `SetColor`, `SetWidth`, `SetValuePos`, `SetLegend`

**LinePlot** (3 metodi): `SetColor`, `SetLegend`, `SetCenter`

**PiePlotC** (9 metodi): `SetSliceColors`, `SetLegends`, `SetGuideLines`, `SetGuideLinesAdjust`, `SetLabelType`, `SetMidSize`, `SetMidColor`, `SetStartAngle`, `SetLabelPos`

**Text** (8 metodi): `Set`, `SetFont`, `SetColor`, `SetAlign`, `SetPos`, `setAngle`, `Show`, `SetFormat`

**GroupBarPlot** (0 metodi, solo costruttore)

**AccBarPlot** (1 metodo): `SetWidth`

**Legend** (3 metodi): `SetFrameWeight`, `SetColor`, `SetMarkAbsSize`

**UniversalTheme** (0 metodi, solo costruttore)

---

## Testing

### Verifica Post-Migrazione

```bash
cd laravel

# 1. Verifica che il package sia installato correttamente
composer show amenadiel/jpgraph
# Output atteso: amenadiel/jpgraph 4.4.3 (path)

# 2. Verifica che mitoteam/jpgraph sia installato come dipendenza
composer show mitoteam/jpgraph
# Output atteso: mitoteam/jpgraph v10.5.x

# 3. Verifica autoload
composer dump-autoload

# 4. Test: genera un grafico di prova
php artisan tinker --execute="
use Amenadiel\JpGraph\Graph\Graph;
\$g = new Graph(100, 100);
echo 'OK: ' . get_class(\$g) . ' extends ' . get_parent_class(\$g);
"
# Output atteso: OK: Amenadiel\JpGraph\Graph\Graph extends Graph

# 5. PHPStan
./vendor/bin/phpstan analyse Modules/Chart --level=10
```

---

## Riferimenti

- [Wrapper Classes PSR-4 (dettaglio)](./jpgraph-wrapper-classes.md) - Documentazione dettagliata di ogni classe wrapper
- [JpGraph 4.4.3 Reference](./jpgraph-4-4-3-reference.md) - Reference completa versione 4.4.3
- [JpGraph Installation e Namespace](./jpgraph-installation-and-namespaces.md) - Guida installazione e namespace
- [JpGraph Chart Types Gallery](./jpgraph-chart-types-gallery.md) - Galleria completa tipi di grafici
- [mitoteam/jpgraph su GitHub](https://github.com/mitoteam/jpgraph) - Package base attivamente mantenuto
- [amenadiel/jpgraph su Packagist](https://packagist.org/packages/amenadiel/jpgraph) - Package originale (abbandonato)
- [Composer Merge Plugin](../../../docs/composer-merge-plugin.md) - Configurazione path packages

---

**Versione Documentazione**: 2.0.0
**Data**: Gennaio 2026
