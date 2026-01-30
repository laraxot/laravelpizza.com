# JpGraph - Classi Wrapper con Namespace PSR-4

**Versione**: 2.0.0
**Ultimo Aggiornamento**: Gennaio 2026

---

## Strategia

Usare `mitoteam/jpgraph` (attivamente mantenuto, JpGraph 4.4.3, PHP 8.5) come dipendenza, ed esporre classi wrapper con namespace `Amenadiel\JpGraph\*` tramite **estensione diretta**.

Per la guida completa alla creazione del package, vedere: [Creazione Package Custom](./jpgraph-custom-package-creation.md)

---

## Perche' Estensione Diretta (non Composizione)

L'approccio precedente (v1.0) usava **composizione** (wrapper con `__call()/__get()/__set()`). Questo causava problemi:

- Type safety: `$graph instanceof \Graph` restituiva `false`
- Magic methods: overhead di performance e complessita'
- PHPStan: difficolta' nell'analisi statica dei magic methods

L'approccio attuale (v2.0) usa **estensione diretta**:

```php
// v1.0 - Composizione (DEPRECATO)
class Graph {
    private \Graph $graph;
    public function __call($method, $args) { ... }
}

// v2.0 - Estensione diretta (ATTUALE)
class Graph extends \Graph { }
```

Vantaggi:
- `$graph instanceof \Graph` restituisce `true`
- Tutti i metodi e proprieta' ereditati automaticamente
- PHPStan analizza correttamente
- Zero overhead di performance
- Classi vuote: nulla da mantenere

---

## Inventario Completo: 12 Classi Wrapper

Tutte le classi risiedono in `Modules/Chart/packages/amenadiel-jpgraph/src/`.

### Namespace `Amenadiel\JpGraph\Graph\` (4 classi)

#### 1. Graph

```php
namespace Amenadiel\JpGraph\Graph;
class Graph extends \Graph { }
```

**Usato in**: GetGraphAction, Bar2Action, Bar3Action, Horizbar1Action, LineSubQuestionAction, ApplyGraphStyleAction (7 file)

**Metodi usati** (8):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetScale` | `string $scale` | Scala assi: `'textlin'`, `'linlin'` |
| `SetShadow` | nessuno | Abilita ombra |
| `SetTheme` | `UniversalTheme $theme` | Applica tema colori |
| `SetBox` | `bool $show` | Mostra/nascondi bordo |
| `Add` | `Plot $plot` | Aggiunge plot al grafico |
| `AddText` | `Text $text` | Aggiunge annotazione testo |
| `Set90AndMargin` | `int $l, $r, $t, $b` | Ruota 90 gradi + margini |
| `Stroke` | `string $filename` | Renderizza grafico (salva PNG) |

**Proprieta' usate** (9):
| Proprieta' | Tipo | Accesso |
|------------|------|---------|
| `$title` | Text | `->title->Set()`, `->title->SetFont()` |
| `$subtitle` | Text | `->subtitle->Set()`, `->subtitle->SetFont()` |
| `$footer` | object | `->footer->center->Set()`, `->footer->right->SetFont()` |
| `$xaxis` | Axis | `->xaxis->SetTickLabels()`, `->xaxis->SetLabelAngle()` |
| `$yaxis` | Axis | `->yaxis->HideLine()`, `->yaxis->HideTicks()` |
| `$ygrid` | object | `->ygrid->SetFill()` |
| `$yscale` | object | `->yscale->ticks->SupressZeroLabel()` |
| `$img` | object | `->img->SetMargin()` |
| `$legend` | Legend | `->legend->SetFrameWeight()` |

---

#### 2. PieGraph

```php
namespace Amenadiel\JpGraph\Graph;
class PieGraph extends \PieGraph { }
```

**Usato in**: Pie1Action, PieAvgAction (2 file)

**Metodi usati**: Stesso di Graph (Add, title, subtitle, footer)

---

#### 3. Axis

```php
namespace Amenadiel\JpGraph\Graph;
class Axis extends \Axis { }
```

**Usato in**: GetGraphAction, ApplyGraphStyleAction, LineSubQuestionAction (3 file, come type hint)

**NON istanziato direttamente** - acceduto via `$graph->xaxis` e `$graph->yaxis`.

**Metodi usati** (8):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetFont` | `int $family, $style, $size` | Font etichette asse |
| `SetLabelAngle` | `int $angle` | Rotazione etichette |
| `SetLabelMargin` | `int $margin` | Spazio tra asse ed etichette |
| `SetTickLabels` | `array $labels` | Etichette personalizzate tick |
| `Hide` | nessuno | Nasconde asse intero |
| `HideZeroLabel` | nessuno | Nasconde etichetta zero |
| `HideLine` | `bool $show` | Mostra/nasconde linea asse |
| `HideTicks` | `bool $major, $minor` | Mostra/nasconde tick |

**Proprieta' usate**:
- `$scale` -> `SetGrace()`, `SetAutoMin()`, `SetAutoMax()`

---

#### 4. Legend

```php
namespace Amenadiel\JpGraph\Graph;
class Legend extends \Legend { }
```

**Usato in**: LineSubQuestionAction (1 file, come type hint)

**NON istanziato direttamente** - acceduto via `$graph->legend`.

**Metodi usati** (3):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetFrameWeight` | `int $weight` | Spessore bordo legenda |
| `SetColor` | `string $bg, $text` | Colori legenda |
| `SetMarkAbsSize` | `int $size` | Dimensione marcatori (px) |

---

### Namespace `Amenadiel\JpGraph\Plot\` (6 classi)

#### 5. BarPlot

```php
namespace Amenadiel\JpGraph\Plot;
class BarPlot extends \BarPlot { }
```

**Usato in**: ApplyPlotStyleAction, Bar2Action, Bar3Action, Horizbar1Action (5 file)

**Metodi usati** (5):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetFillColor` | `string $color` | Riempimento (es. `'red@0.6'`) |
| `SetColor` | `string $color` | Colore bordo |
| `SetWidth` | `float $width` | Larghezza relativa (0.0-1.0) |
| `SetValuePos` | `string $pos` | Posizione valori: `'center'`, `'top'` |
| `SetLegend` | `string $legend` | Testo legenda |

**Proprieta' usate**:
- `$value` (Text-like) -> `Show()`, `SetFont()`, `SetFormat()`, `SetColor()`, `SetAlign()`, `setAngle()`

---

#### 6. GroupBarPlot

```php
namespace Amenadiel\JpGraph\Plot;
class GroupBarPlot extends \GroupBarPlot { }
```

**Usato in**: Bar2Action (1 file)

**Solo costruttore**: `new GroupBarPlot(array $barPlots)`

---

#### 7. AccBarPlot

```php
namespace Amenadiel\JpGraph\Plot;
class AccBarPlot extends \AccBarPlot { }
```

**Usato in**: Bar3Action (1 file)

**Metodi usati** (1):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetWidth` | `float $width` | Larghezza relativa (0.0-1.0) |

---

#### 8. LinePlot

```php
namespace Amenadiel\JpGraph\Plot;
class LinePlot extends \LinePlot { }
```

**Usato in**: LineSubQuestionAction (1 file)

**Metodi usati** (3):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetColor` | `string $color` | Colore linea |
| `SetLegend` | `string $legend` | Testo legenda |
| `SetCenter` | nessuno | Centra la linea |

**Proprieta' usate**:
- `$mark` (PlotMark) -> `SetType($marker, '', 1.2)`, `SetColor($color)`

---

#### 9. PiePlotC

```php
namespace Amenadiel\JpGraph\Plot;
class PiePlotC extends \PiePlotC { }
```

**Usato in**: Pie1Action, PieAvgAction (2 file)

**Metodi usati** (9):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `SetSliceColors` | `array $colors` | Colori fette |
| `SetLegends` | `array $labels` | Etichette legenda |
| `SetGuideLines` | `bool $radial, $horiz` | Guide lines |
| `SetGuideLinesAdjust` | `float $adjust` | Distanza guide |
| `SetLabelType` | `int $type` | `PIE_VALUE_PER` per percentuale |
| `SetMidSize` | `float $size` | Buco donut (0.0-1.0) |
| `SetMidColor` | `string $color` | Colore centro donut |
| `SetStartAngle` | `int $angle` | Angolo iniziale (gradi) |
| `SetLabelPos` | `int $pos` | Posizione etichette (0 = centro) |

**Proprieta' usate**:
- `$value` (Text-like) -> `Show()`, `SetFont()`, `SetFormat()`, `SetColor()`
- `$midtitle` (Text-like) -> `Set()`, `SetFont()`

---

#### 10. ScatterPlot

```php
namespace Amenadiel\JpGraph\Plot;
class ScatterPlot extends \ScatterPlot { }
```

**Non usato attualmente** - incluso per completezza e uso futuro.

---

### Namespace `Amenadiel\JpGraph\Text\` (1 classe)

#### 11. Text

```php
namespace Amenadiel\JpGraph\Text;
class Text extends \Text { }
```

**Usato in**: GetGraphAction, ApplyGraphStyleAction, ApplyPlotStyleAction, Bar2Action, Bar3Action, Pie1Action, PieAvgAction (7 file)

**Metodi usati** (8):
| Metodo | Parametri | Descrizione |
|--------|-----------|-------------|
| `Set` | `string $text` | Imposta contenuto testo |
| `SetFont` | `int $family, $style, $size` | Font testo |
| `SetColor` | `string $color` | Colore testo |
| `SetAlign` | `string $h, $v` | Allineamento (`'left'`, `'center'`) |
| `SetPos` | `int $x, $y` | Posizione in pixel |
| `setAngle` | `int $angle` | Rotazione (nota: lowercase 's') |
| `Show` | `bool $show = true` | Mostra/nascondi |
| `SetFormat` | `string $fmt` | Formato numerico (es. `'%.1f %%'`) |

---

### Namespace `Amenadiel\JpGraph\Themes\` (1 classe)

#### 12. UniversalTheme

```php
namespace Amenadiel\JpGraph\Themes;
class UniversalTheme extends \UniversalTheme { }
```

**Usato in**: GetGraphAction (1 file)

**Solo costruttore**: `new UniversalTheme()`

Applicato via `$graph->SetTheme($universalTheme)`.

---

## Costanti Globali JpGraph

Caricate automaticamente da `MtJpGraph::load()` nel `bootstrap.php`:

```php
// Font Families
FF_ARIAL       // Arial (valore: 15)
FF_FONT1       // Font bitmap 1 (valore: 1)
FF_FONT2       // Font bitmap 2 (valore: 2)
FF_TIMES       // Times (valore: 12)
FF_COURIER     // Courier (valore: 10)
FF_VERDANA     // Verdana (valore: 11)

// Font Styles
FS_NORMAL      // Normale (valore: 9001)
FS_BOLD        // Grassetto (valore: 9002)
FS_ITALIC      // Corsivo (valore: 9003)
FS_BOLDITALIC  // Grassetto corsivo (valore: 9004)

// Pie Label Types
PIE_VALUE_PER  // Mostra percentuale sulle fette
```

---

## Esempio Completo: Bar2 Chart

```php
<?php declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

// Gli use statement restano IDENTICI a prima della migrazione:
use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Plot\GroupBarPlot;
use Amenadiel\JpGraph\Text\Text;
use Spatie\QueueableAction\QueueableAction;

final class Bar2Action
{
    use QueueableAction;

    public function execute(ChartData $chart): Graph
    {
        $graph = app(GetGraphAction::class)->execute($chart);

        // Tutto il codice resta identico - le classi wrapper
        // ereditano tutti i metodi dalle classi globali JpGraph
        if (is_object($graph->img)) {
            $graph->img->SetMargin(50, 50, 50, 100);
        }

        $barPlots = [];
        foreach ($seriesData as $i => $data) {
            $tmp = new BarPlot($data);
            $tmp->SetColor($colors[$i]);
            $tmp->SetFillColor($colors[$i] . '@' . $chart->transparency);
            $tmp->value->Show();
            $barPlots[] = $tmp;
        }

        $groupBarPlot = new GroupBarPlot($barPlots);
        $graph->Add($groupBarPlot);

        return $graph;
    }
}
```

---

## Riferimenti

- [Creazione Package Custom](./jpgraph-custom-package-creation.md) - Guida completa alla creazione del package
- [JpGraph 4.4.3 Reference](./jpgraph-4-4-3-reference.md) - Reference completa
- [JpGraph Chart Types Gallery](./jpgraph-chart-types-gallery.md) - Galleria tipi di grafici
- [Chart Module Actions](../app/Actions/JpGraph/) - Actions esistenti JpGraph

---

**Versione Documentazione**: 2.0.0
**Data**: Gennaio 2026
