# Modulo Chart - Filosofia, Religione, Politica, Zen

## 📚 Documentazione Completa

- [Export Chart.js SVG/PNG - Guida Passo Passo](./chartjs-export-step-by-step.md) - Guida completa passo passo per export Chart.js
- [Export Chart.js SVG/PNG - Panoramica](./chartjs-export-svg-png.md) - Panoramica generale export Chart.js
- [Integrazione Grafici PDF](./pdf-charts-integration-complete.md) - Come integrare grafici nei PDF con Spipu PDF
- [Tecniche Avanzate PDF](./pdf-charts-advanced-techniques.md) - Ottimizzazioni e tecniche avanzate
- [JpGraph Guida Completa](./jpgraph-complete-guide.md) - Guida completa per JpGraph
- [Workflow PDF Quaeris](../../Quaeris/docs/pdf-generation-workflow.md) - Workflow completo generazione PDF

---

## 🎯 Panoramica

Il modulo Chart è il sistema di generazione e visualizzazione di grafici per l'architettura Laraxot, responsabile della trasformazione di dati in rappresentazioni visive. La sua filosofia è incentrata sulla **separazione dei dati dalla presentazione, la configurazione dichiarativa e la type safety**, garantendo che i grafici siano sempre accurati, performanti e facilmente personalizzabili.

## 🏛️ Filosofia: Dati e Presentazione Separati

### Principio: Il Grafico è una Vista dei Dati, Non i Dati Stessi

La filosofia di Chart si basa sull'idea che i grafici debbano essere generati da dati strutturati (`ChartData`) e configurati in modo dichiarativo, separando completamente la logica di business dalla rappresentazione visiva.

- **Data-Driven**: I grafici sono generati da `ChartData`, un DTO che contiene tutti i parametri di configurazione.
- **Engine Abstraction**: Supporto per diversi engine di rendering (JpGraph, Chart.js, ecc.) attraverso un sistema di action pluggable.
- **Type Safety**: Ogni parametro del grafico è tipizzato (`ChartData` con proprietà esplicite).
- **Configurazione Dichiarativa**: I grafici sono configurati attraverso proprietà del modello `Chart`, non attraverso codice imperativo.

## 📜 Religione: La Sacra Separazione Dati/Presentazione

### Principio: I Dati Non Conoscono la Presentazione

La "religione" di Chart si manifesta nella rigorosa separazione tra i dati (`Chart` model) e la loro presentazione (`ChartData` + Actions). Questo garantisce che i dati possano essere riutilizzati per diverse visualizzazioni senza modifiche.

- **Model come Storage**: Il modello `Chart` è solo storage, non contiene logica di rendering.
- **Data Transformation**: `ChartData` trasforma i dati del modello in una struttura ottimizzata per il rendering.
- **Action-Based Rendering**: Ogni tipo di grafico ha la sua action dedicata (`Horizbar1Action`, `PieAction`, ecc.).
- **Engine Isolation**: Gli engine di rendering sono completamente isolati, permettendo il cambio di engine senza modificare i dati.

### Esempio: Separazione Dati/Presentazione

```php
// Modules/Chart/app/Models/Chart.php
class Chart extends BaseModel
{
    // Solo storage - nessuna logica di rendering
    protected $fillable = [
        'type', 'width', 'height', 'color', 'bg_color',
        'font_family', 'font_size', 'font_style',
        // ... altri parametri di configurazione
    ];
}

// Modules/Chart/app/Datas/ChartData.php
class ChartData extends Data
{
    // DTO per la configurazione del grafico
    public string $type;
    public float $max;
    public float $min;
    public int $width;
    public int $height;
    // ... proprietà tipizzate per il rendering
}

// Modules/Chart/app/Actions/JpGraph/V1/Horizbar1Action.php
class Horizbar1Action
{
    // Logica di rendering isolata
    public function execute(ChartData $chartData, array $data): string
    {
        // Rendering del grafico usando JpGraph
    }
}
```
Questa separazione garantisce che i dati possano essere riutilizzati per diversi engine senza modifiche, un pilastro della "religione" di Chart.

## ⚖️ Politica: Type Safety e Configurazione Esplicita (PHPStan Livello 10)

### Principio: Ogni Parametro è Tipizzato, Ogni Configurazione è Esplicita

La "politica" di Chart è l'applicazione rigorosa della type safety, specialmente nella configurazione dei grafici e nella trasformazione dei dati. Ogni parametro deve essere esplicitamente tipizzato e validato.

- **PHPStan Livello 10**: Tutti i componenti del modulo Chart devono passare l'analisi statica al livello massimo.
- **ChartData Type Safety**: `ChartData` è un DTO con tutte le proprietà tipizzate, garantendo che i parametri siano sempre validi.
- **Color Management**: Gestione sicura dei colori con conversione HEX → RGBA attraverso `Spatie\Color\Hex`.
- **Engine Type Resolution**: Risoluzione dinamica ma type-safe del tipo di action basata sul `type` del grafico.

### Esempio: `ChartData` e Type Safety

```php
// Modules/Chart/app/Datas/ChartData.php
namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Spatie\Color\Hex;

class ChartData extends Data
{
    public string $type; // Tipo grafico (horizbar1, pie, ecc.)
    public float $max; // Valore massimo
    public float $min; // Valore minimo
    public int $width; // Larghezza grafico
    public int $height; // Altezza grafico
    public string $list_color; // Colori separati da virgola
    public ?string $bg_color = null; // Colore sfondo
    // ... tutte le proprietà sono esplicitamente tipizzate

    /**
     * @return array<int, string>
     */
    public function getColors(): array
    {
        return explode(',', $this->list_color);
    }

    /**
     * @return array<int, string>
     */
    public function getColorsRgba(float $alpha = 1): array
    {
        $colors = $this->getColors();
        return collect($colors)->map(function ($item) use ($alpha) {
            if (! Str::startsWith($item, '#')) {
                return $item;
            }
            $hex = Hex::fromString($item);
            if (is_object($hex) && method_exists($hex, 'toRgba')) {
                return (string) $hex->toRgba($alpha);
            }
            return (string) $item;
        })->all();
    }

    public function getActionClass(): string
    {
        $type = $this->type;
        $engine = 'JpGraph\V1';
        $action = Str::studly($type).'Action';
        return '\Modules\Chart\Actions\\'.$engine.'\\'.$action;
    }
}
```
Questo approccio garantisce che ogni parametro sia validato e tipizzato, un aspetto cruciale della "politica" di Chart.

## 🧘 Zen: Semplicità e Auto-Configurazione

### Principio: Il Grafico si Configura da Solo

Lo "zen" di Chart si manifesta nella preferenza per l'auto-configurazione e le convenzioni rispetto alla configurazione esplicita. Il modulo mira a rendere la creazione di grafici il più semplice possibile.

- **Default Sensati**: Valori di default per tutti i parametri (colori, dimensioni, font) che funzionano bene nella maggior parte dei casi.
- **Auto-Discovery Actions**: Le action di rendering sono scoperte automaticamente basandosi sul `type` del grafico.
- **Color Auto-Conversion**: Conversione automatica dei colori da HEX a RGBA quando necessario.
- **Engine Abstraction**: L'engine di rendering è astratto, permettendo il cambio senza modificare il codice che usa i grafici.

### Esempio: Auto-Configurazione e Default

```php
// Modules/Chart/app/Models/Chart.php
class Chart extends BaseModel
{
    /** @var array<string, mixed> */
    protected $attributes = [
        'list_color' => '#d60021', // Default rosso
        'color' => '#d60021',
        'font_family' => 15,
        'font_style' => 9002,
        'font_size' => 12,
        'x_label_angle' => 0,
        'show_box' => false,
        'x_label_margin' => 10,
        'plot_perc_width' => 90,
        'plot_value_show' => 1,
        'plot_value_pos' => 1,
        'plot_value_color' => '#000000',
    ];

    public function getTypeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }
        // Auto-discovery del tipo se non specificato
        $res = $this->attributes['type'] ?? (string) $this->getPanelRow('chart_type', 'type');
        return $res;
    }
}
```
Questo approccio incarna lo zen della semplicità, permettendo la creazione di grafici con configurazione minima.

## 📚 Riferimenti Interni

- [Documentazione Master del Progetto](../../../docs/project-master-analysis.md)
- [Filosofia Completa Laraxot](../../Xot/docs/philosophy-complete.md)
- [Regole Critiche di Architettura](../../Xot/docs/critical-architecture-rules.md)
- [Documentazione Chart README](./README.md)

