# JpGraph e Librerie Simili per la Generazione di Grafici

## Cos'è JpGraph

JpGraph è una libreria PHP orientata agli oggetti per la creazione di grafici. È una libreria server-side che genera immagini (PNG, GIF, JPG) direttamente sul server. Consente di creare grafici con un minimo di codice ma anche grafici complessi che richiedono un controllo preciso.

## Funzionalità Principali di JpGraph

### Tipi di Grafici Supportati
- **Line/Bar charts**: Grafici a linee e a barre, inclusi versioni riempite e accumulate
- **Pie charts**: Grafici a torta in 2D e 3D, inclusi grafici esplosi
- **Scatter plots**: Grafici a dispersione
- **Gantt charts**: Grafici di pianificazione progetti
- **Radar plots**: Grafici radar
- **Polar plots**: Grafici polari
- **Error plots**: Grafici con barre di errore
- **Stock charts**: Grafici per dati finanziari
- **Contour plots**: Grafici di curve di livello
- **Windrose plots**: Grafici di direzione del vento (versione Pro)
- **Matrix visualization**: Visualizzazione di matrici (versione Pro)

### Funzionalità Avanzate
- **Sistemi di coordinate flessibili**: Supporta scale testo-lineare, testo-logaritmica, lineare-lineare, lineare-logaritmica, logaritmica-lineare e logaritmica-logaritmica
- **Multiple Y-axes**: Supporto per un numero illimitato di assi Y
- **Client-side image maps**: Supporto per mappe immagine lato client per grafici drill-down
- **Interpolazione spline cubica**: Curve lisce ottenute da pochi punti dati
- **Supporto per caratteri TTF**: Supporto per caratteri TrueType personalizzati
- **Supporto per lingue asiatiche**: Supporto per caratteri cinesi e giapponesi
- **Caching automatico**: Supporto per caching dei grafici generati
- **Supporto per oltre 200 bandiere nazionali**: Come icone o marcatori nei grafici

### Caratteristiche Tecniche
- **Formati immagine**: Supporta PNG, GIF e JPG (dipende dall'installazione PHP)
- **Dimensione file ottimizzata**: Immagini di piccole dimensioni (media 2-5KB)
- **Supporto per trasparenza**: Supporto per alpha blending
- **Oltre 400 colori nominati**: Ampia palette di colori
- **Sistema modulare**: Include solo il codice necessario
- **Convenzioni di denominazione ortogonali**: Coerenza nell'API (es. SetColor() per tutti gli oggetti)

## Alternative a JpGraph

### 1. Chart.js
- **Tipo**: Libreria JavaScript lato client
- **Rendering**: Canvas HTML5
- **Caratteristiche**:
  - Interattività nativa (zoom, hover, animazioni)
  - Responsività automatica
  - Leggera e veloce
  - Ottima documentazione
  - Supporto per molti tipi di grafici
- **Vantaggi**: 
  - Interattività avanzata
  - Bassa larghezza di banda (solo dati JSON)
  - Rendering lato client
- **Svantaggi**:
  - Richiede JavaScript abilitato
  - Non adatto per PDF statici
  - Limitazioni in ambienti con restrizioni JS

### 2. pChart
- **Tipo**: Libreria PHP server-side
- **Rendering**: Immagini PNG
- **Caratteristiche**:
  - Supporto per grafici 2D e 3D
  - Ottimo per grafici statistici
  - Buona qualità visiva
- **Vantaggi**:
  - Simile a JpGraph ma con API diversa
  - Leggero
- **Svantaggi**:
  - Manutenzione minore
  - Documentazione meno completa

### 3. FusionCharts
- **Tipo**: Libreria JavaScript con wrapper PHP
- **Rendering**: SVG e VML
- **Caratteristiche**:
  - Molti tipi di grafici e mappe
  - Supporto enterprise
  - Interattività avanzata
- **Vantaggi**:
  - Ricca interattività
  - Supporto professionale
  - Ottima documentazione
- **Svantaggi**:
  - Non completamente gratuito
  - Richiede licenza per uso commerciale

### 4. Google Charts
- **Tipo**: Libreria JavaScript con API
- **Rendering**: SVG e VML
- **Caratteristiche**:
  - Molti tipi di grafici
  - Integrazione con servizi Google
  - Supporto per grandi dataset
- **Vantaggi**:
  - Molto versatile
  - Free
  - Supporto per dati in tempo reale
- **Svantaggi**:
  - Richiede connessione a Google
  - Privacy limitata

## Comparison: Server-side vs Client-side Rendering

### JpGraph (Server-side)
**Vantaggi**:
- Compatibilità universale (non richiede JavaScript)
- Sicurezza dei dati (dati non esposti al client)
- Ottimizzazione per stampa e PDF
- Controllo completo sul rendering
- Performance del server per elaborazioni complesse

**Svantaggi**:
- Maggiore utilizzo risorse server
- Grafici statici (nessuna interattività)
- Maggiore larghezza di banda per immagini
- Cache necessaria per performance

### Chart.js (Client-side)
**Vantaggi**:
- Interattività avanzata (zoom, hover, animazioni)
- Bassa larghezza di banda (solo dati JSON)
- Rendering veloce lato client
- Esperienza utente ricca

**Svantaggi**:
- Richiede JavaScript
- Esposizione dati al client
- Non adatto per stampa/PDF statici
- Limitazioni con dataset grandi

## Integrazione con Laravel

### Integrazione JpGraph in Laravel
```php
// Creazione di un service provider per JpGraph
class JpGraphServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('jpgraph', function () {
            return new JpGraphManager();
        });
    }
}

// Utilizzo in un controller o action
class ChartController extends Controller
{
    public function generateChart()
    {
        // Preparazione dati dal modello
        $data = MyModel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                     ->groupBy('date')
                     ->get();
        
        // Generazione del grafico
        $graph = new Graph(600, 400);
        $graph->img->setMargin(60, 40, 40, 80);
        $graph->setScale("textint");
        
        // Aggiunta dati e rendering
        $lineplot = new LinePlot($data->pluck('count')->toArray());
        $graph->add($lineplot);
        
        // Output come immagine
        $graph->stroke();
    }
}
```

### Integrazione Chart.js in Laravel
```php
// Controller che fornisce dati
class ChartDataController extends Controller
{
    public function getData()
    {
        $data = MyModel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                     ->groupBy('date')
                     ->get();
        
        return response()->json([
            'labels' => $data->pluck('date'),
            'datasets' => [
                [
                    'label' => 'My Dataset',
                    'data' => $data->pluck('count'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ]
            ]
        ]);
    }
}

// Nella view
<canvas id="myChart"></canvas>
<script>
fetch('/api/chart-data')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Chart Title'
                    }
                }
            }
        });
    });
</script>
```

## Utilizzo per la Generazione di PDF

### JpGraph + PDF
JpGraph è particolarmente adatto per la generazione di grafici in PDF perché:
- Genera immagini direttamente
- Può salvare grafici come file immagine
- Le immagini possono essere facilmente incorporate in PDF

```php
// Esempio di utilizzo con TCPDF o altri generatori PDF
$graph->stroke('path/to/chart.png'); // Salva grafico come immagine
$pdf->Image('path/to/chart.png', $x, $y, $width, $height); // Incorpora in PDF
```

### Chart.js + PDF
Richiede approcci più complessi:
- Utilizzo di headless browser (Puppeteer, PhantomJS)
- Conversione da canvas a immagine
- Rendering in ambiente server

## Confronto con il Sistema Esistente

Nel sistema Quaeris attuale:
- I grafici vengono già utilizzati con Chart.js e il plugin datalabels
- Esiste già un'infrastruttura per la generazione di PDF
- I dati provengono da LimeSurvey e vengono elaborati con TrendX

L'utilizzo di JpGraph potrebbe essere vantaggioso per:
- Grafici che devono apparire in PDF
- Grafici dove la sicurezza dei dati è critica
- Ambienti con limitazioni JavaScript
- Report stampabili con alta qualità

Mentre Chart.js è migliore per:
- Interattività in tempo reale
- Dashboard web dinamiche
- Bassa larghezza di banda

## Considerazioni Architetturali

### Quando Utilizzare JpGraph
- Generazione di report in PDF
- Ambienti enterprise con restrizioni JS
- Necessità di grafici statici ad alta qualità
- Sicurezza dei dati critica
- Ambiente di stampa

### Quando Utilizzare Chart.js
- Dashboard interattive
- Real-time data visualization
- Web application moderne
- Bassa larghezza di banda richiesta
- Esperienza utente interattiva

## Best Practices di Utilizzo

### Con JpGraph
- Utilizzare il caching per prestazioni migliori
- Controllare l'utilizzo della memoria con dataset grandi
- Verificare la disponibilità delle estensioni GD
- Ottimizzare le dimensioni immagine per la larghezza di banda

### Con Chart.js
- Implementare lazy loading per prestazioni
- Gestire correttamente la protezione CSRF
- Ottimizzare la dimensione dei dati JSON
- Implementare fallback per utenti senza JS