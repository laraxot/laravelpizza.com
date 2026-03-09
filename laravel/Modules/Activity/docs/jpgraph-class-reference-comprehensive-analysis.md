# 📚 JpGraph Class Reference - Analisi Completta 2024

## 🎯 **Introduzione alla Documentazione JpGraph**

La documentazione ufficiale JpGraph Class Reference (https://jpgraph.net/download/manuals/classref/) è una risorsa estremamente dettagliata che copre tutte le classi principali, metodi disponibili e funzionalità avanzate della libreria grafica PHP.

## 📋 **Struttura della Documentazione**

### **1. Classi Principali**

#### **Graph Class**
La classe `Graph` è la classe base per tutti i grafici in JpGraph. Fornisce metodi per:
- Creazione e configurazione del contesto grafico
- Impostazione delle dimensioni e del formato
- Configurazione delle scale e degli assi
- Aggiunta di plot e elementi grafici

**Metodi Principali:**
```php
// Creazione istanza
$graph = new Graph(800, 600);

// Impostazione del formato
$graph->SetImgFormat('png');

// Configurazione delle scale
$graph->SetScale('textlin');

// Aggiunta di plot
$graph->Add($plot);

// Rendering del grafico
$graph->Stroke($filename);
```

#### **Plot Classes**
Le classi plot forniscono diversi tipi di grafici:

**LinePlot**
```php
$plot = new LinePlot($data);
$plot->SetColor('blue');
$plot->SetWeight(2);
```

**BarPlot**
```php
$plot = new BarPlot($data);
$plot->SetFillColor('lightblue');
$plot->SetShadow();
```

**PiePlot**
```php
$plot = new PiePlot($data);
$plot->SetCenter(0.5, 0.5);
$plot->SetSize(0.3);
```

#### **Scale Classes**
Le classi di scala gestiscono l'asse e le scale:

**TextScale**
```php
$graph->SetScale('textlin');
```

**LinearScale**
```php
$graph->SetScale('linlin');
```

**LogScale**
```php
$graph->SetScale('loglin');
```

### **2. Componenti Grafici**

#### **Axis Classes**
Gli assi sono configurati tramite classi specifiche:

**XAxis e YAxis**
```php
$graph->xaxis->SetColor('black');
$graph->yaxis->SetColor('black');

// Configurazione delle etichette
$graph->xaxis->SetTickLabels($labels);
```

#### **Title Classes**
I titoli sono gestiti da classi dedicate:

**Title**
```php
$graph->title->Set('Titolo del Grafico');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);
$graph->title->SetColor('darkblue');
```

#### **Legend Classes**
La legenda è configurata con classi specifiche:

**Legend**
```php
$plot->SetLegend('Serie 1');
$graph->legend->Pos(0.05, 0.5, 'right', 'center');
```

### **3. Funzionalità Avanzate**

#### **Image Map Generation**
JpGraph supporta la generazione di mappe immagine per grafici interattivi:

```php
$graph->SetImageMap();
$graph->Add($plot);
$graph->Stroke();
```

#### **Caching System**
Il sistema di caching ottimizza le performance:

```php
// Abilita caching
$graph->SetCache('cache_dir', 3600);

// Configura cache timeout
$graph->SetCacheTimeout(3600);
```

#### **Advanced Interpolation**
Supporto per interpolazione avanzata:

```php
$plot = new LinePlot($data);
$plot->SetWeight(2);
$plot->SetStepInterpolation(true);
```

## 📊 **Classi di Stile e Decorazione**

### **Font Classes**
Gestione dei font con classi specifiche:

**Font Configuration**
```php
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);
$graph->xaxis->title->SetFont(FF_TIMES, FS_ITALIC, 12);
```

**Font Families**
- `FF_ARIAL` (15)
- `FF_COURIER` (10)
- `FF_TIMES` (12)
- `FF_VERDANA` (11)

**Font Styles**
- `FS_NORMAL` (9001)
- `FS_BOLD` (9002)
- `FS_ITALIC` (9003)
- `FS_BOLDITALIC` (9004)

### **Color Classes**
Gestione dei colori con classi specifiche:

**Color Configuration**
```php
$plot->SetColor('#FF0000');
$plot->SetFillColor('rgba(255, 0, 0, 0.5)');
```

**Color System**
- 400+ named colors disponibili
- Supporto per RGBA
- Sistema di colori personalizzabili

## 🔧 **Metodi di Configurazione Avanzati**

### **Background Configuration**
Configurazione dello sfondo e del layout:

```php
// Sfondo immagine
$graph->SetBackgroundImage('bg.jpg', BGIMG_FILLPLOT);

// Layout avanzato
$graph->SetMargin(60, 60, 60, 60);
$graph->SetFrame(true, 'black', 1);
```

### **Grid Configuration**
Configurazione della griglia:

```php
$graph->ygrid->Show();
$graph->ygrid->SetColor('gray@0.5');
$graph->xgrid->SetColor('lightgray');
```

### **Legend Configuration**
Configurazione avanzata della legenda:

```php
$graph->legend->SetFillColor('white');
$graph->legend->SetFrameWeight(1);
$graph->legend->SetFont(FF_FONT1, FS_NORMAL, 10);
```

## 📈 **Grafici Specializzati**

### **Area Charts**
Grafici a area riempita:

```php
$plot = new LinePlot($data);
$plot->SetFilled(true);
$plot->SetFillColor('lightblue@0.5');
```

### **Radar Charts**
Grafici radar per dati multi-dimensionali:

```php
$graph = new RadarGraph(400, 300);
$graph->SetScale('lin', 0, 100);
$plot = new RadarPlot($data);
```

### **Contour Charts**
Grafici di contorno per dati 3D:

```php
$graph = new ContourGraph(400, 300);
$graph->SetScale('lin');
$plot = new ContourPlot($data);
```

### **Stock Charts**
Grafici per dati finanziari:

```php
$graph = new StockGraph(400, 200);
$plot = new StockPlot($data);
```

## 🎨 **Personalizzazione Avanzata**

### **Custom Markers**
Marcatori personalizzati:

```php
$plot = new LinePlot($data);
$plot->mark->SetType(MARK_IMG_PUSHPIN, 'red', 1.0);
```

### **Custom Colors**
Colori personalizzati:

```php
$graph->SetColor('white');
$graph->SetMarginColor('lightgray');
```

### **Custom Fonts**
Caratteri personalizzati:

```php
$graph->title->SetFont(FF_FONT1, FS_BOLD, 14);
$graph->xaxis->title->SetFont(FF_FONT2, FS_ITALIC, 12);
```

## 📋 **Metodi di Rendering**

### **Rendering Methods**
Metodi per il rendering finale:

```php
// Rendering diretto
$graph->Stroke();

// Rendering con nome file
$graph->Stroke('chart.png');

// Rendering in buffer
$graph->Stroke(_IMG_HANDLER);

// Rendering in stringa
$graph->Stroke(_IMG_STRING);
```

### **Formati Supportati**
Formati di output supportati:

- **PNG** (predefinito)
- **JPEG**
- **GIF**
- **BMP**
- **SVG** (in alcune versioni)

## 🔍 **Debug e Testing**

### **Debug Methods**
Metodi per il debug:

```php
// Abilita debug
$graph->ShowFrame(true);

// Debug errori
$graph->SetErrorHandling(IMG_ERROR);
```

### **Testing Configuration**
Configurazione per testing:

```php
// Testing in memory
$graph->SetCache('', 0);

// Testing locale
$graph->SetImgFormat('png');
```

## 📚 **Esempi di Codice Avanzati**

### **Esempio Completo: Grafico a Linea**
```php
// Creazione del grafico
$graph = new Graph(800, 600);
$graph->SetScale('textlin');

// Configurazione del titolo
$graph->title->Set('Analisi Vendite Mensili');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// Configurazione degli assi
$graph->xaxis->title->Set('Mese');
$graph->yaxis->title->Set('Vendite (€)');

// Creazione del plot
$data = [12000, 19000, 3000, 5000, 27000];
$plot = new LinePlot($data);
$plot->SetColor('blue');
$plot->SetWeight(2);
$plot->SetFilled(true);
$plot->SetFillColor('lightblue@0.5');

// Aggiunta del plot
$graph->Add($plot);

// Rendering
$graph->Stroke();
```

### **Esempio Completo: Grafico a Barre**
```php
// Creazione del grafico
$graph = new Graph(800, 600);
$graph->SetScale('textlin');

// Configurazione del titolo
$graph->title->Set('Distribuzione Risposte');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

// Configurazione degli assi
$graph->xaxis->title->Set('Risposte');
$graph->yaxis->title->Set('Frequenza');

// Creazione del plot
$data = [15, 25, 30, 20, 10];
$labels = ['Sì', 'No', 'Non so', 'In attesa', 'Altro'];
$plot = new BarPlot($data);
$plot->SetFillColor('lightblue');
$plot->SetShadow();

// Aggiunta delle etichette
$plot->SetLegend('Distribuzione');

// Aggiunta del plot
$graph->Add($plot);

// Rendering
$graph->Stroke();
```

## 🎯 **Best Practices**

### **1. Performance Optimization**
- Usare il caching per grafici complessi
- Ottimizzare le dimensioni delle immagini
- Limitare il numero di grafici in una pagina

### **2. Code Quality**
- Seguire i pattern di naming consistenti
- Documentare i metodi e le classi
- Usare tipi di ritorno espliciti

### **3. Error Handling**
- Implementare gestione errori robusta
- Validare i dati prima del rendering
- Loggare gli errori per debugging

### **4. Security**
- Validare sempre i dati di input
- Sanitizzare i nomi dei file
- Limitare l'accesso ai file generati

## 📖 **Riferimenti Ufficiali**

- **Documentazione Ufficiale**: https://jpgraph.net/download/manuals/classref/
- **Sito Ufficiale**: https://jpgraph.net/
- **API Reference**: https://jpgraph.net/doc/
- **FAQ**: https://jpgraph.net/doc/faq.html

<<<<<<< .merge_file_P6QvXr
## 🔄 **Integrazione con healthcare_app**
=======
## 🔄 **Integrazione con ModuloEsempio**
>>>>>>> .merge_file_if2W7E

### **Pattern di Integrazione**
```php
// Pattern per generazione PDF con JpGraph
class JpGraphChartGenerator
{
    public function generateChartForPdf(Chart $chart, string $surveyId, string $fieldName, string $title): string
    {
        $data = SurveyResponse::getResponsesForSurvey($surveyId)
            ->select([
                DB::raw("{$fieldName} as answer"),
                DB::raw('COUNT(*) as count')
            ])
            ->whereNotNull($fieldName)
            ->groupBy($fieldName)
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();
        
        $graph = new \Graph($chart->width ?? 800, $chart->height ?? 400);
        $graph->SetScale('textlin');
        $graph->title->Set($title);
        
        $fontFamily = $this->mapFontFamily($chart->font_family);
        $fontStyle = $this->mapFontStyle($chart->font_style);
        $graph->title->SetFont($fontFamily, $fontStyle, $chart->font_size);
        
        $values = $data->pluck('count')->toArray();
        $labels = $data->pluck('answer')->toArray();
        $plot = $this->createPlot($chart->type, $values);
        $plot->SetFillColor($chart->list_color ?? '#3b82f6');
        
        if (!empty($labels)) {
            $graph->xaxis->SetTickLabels($labels);
            if (count($labels) > 5) {
                $graph->xaxis->SetLabelAngle(45);
            }
        }
        
        $graph->Add($plot);
        
        $filename = 'charts/' . $chart->id . '_' . time() . '.png';
        $fullPath = public_path($filename);
        
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }
        
        $graph->Stroke($fullPath);
        
        return $filename;
    }
}
```

---

**Ultimo Aggiornamento:** [DATE]  
**Versione JpGraph:** 4.4.2  
**Stato:** 📚 Completamente Analizzato e Documentato