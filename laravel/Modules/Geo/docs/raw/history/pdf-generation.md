# Generazione PDF con HTML2PDF

> **NOTA IMPORTANTE**: Come da decisione tecnica del 2025-03-20, il modulo Performance utilizza esclusivamente [HTML2PDF](https://github.com/spipu/html2pdf) per la generazione dei PDF, abbandonando altre soluzioni come DomPDF.

## Configurazione

### 1. Installazione
```bash
composer require spipu/html2pdf
```

### 2. Configurazione del Service Provider
Creare un nuovo service provider:

```php
<?php

namespace Modules\Performance\Providers;

use Illuminate\Support\ServiceProvider;
use Spipu\Html2Pdf\Html2Pdf;

class Html2PdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('html2pdf', function ($app) {
            return new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [0, 0, 0, 0]);
        });
    }
}
```

### 3. Registrazione del Service Provider
In `config/app.php`:
```php
'providers' => [
    // ...
    Modules\Performance\Providers\Html2PdfServiceProvider::class,
],
```

## Utilizzo

### 1. Nel Controller
```php
use Spipu\Html2Pdf\Html2Pdf;

class PerformanceController extends Controller
{
    public function generatePdf()
    {
        $html2pdf = app('html2pdf');
        
        // Impostazioni del PDF
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->setTestIsImage(false);
        $html2pdf->setTestTdInOnePage(false);
        
        // Contenuto HTML
        $html = view('performance::pdf.template')->render();
        
        // Generazione PDF
        $html2pdf->writeHTML($html);
        
        // Output
        return $html2pdf->output('performance.pdf', 'D');
    }
}
```

### 2. Template HTML
```php
// resources/views/pdf/template.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Performance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Performance Report</h1>
        <p>Data: {{ now()->format('d/m/Y') }}</p>
    </div>
    
    <div class="content">
        <!-- Contenuto del report -->
    </div>
</body>
</html>
```

## Funzionalità Principali

### 1. Impostazioni Base
```php
$html2pdf->setDefaultFont('Arial');
$html2pdf->setTestIsImage(false);
$html2pdf->setTestTdInOnePage(false);
```

### 2. Orientamento e Dimensione
```php
// P = Portrait, L = Landscape
$html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [0, 0, 0, 0]);
```

### 3. Gestione delle Immagini
```php
// Abilitare il supporto per le immagini
$html2pdf->setTestIsImage(true);
```

### 4. Gestione delle Tabelle
```php
// Gestione automatica delle tabelle su più pagine
$html2pdf->setTestTdInOnePage(true);
```

## Best Practices

1. **Template Separati**
   - Mantenere i template HTML separati dal codice PHP
   - Utilizzare Blade per la generazione del contenuto

2. **Stili CSS**
   - Utilizzare stili CSS inline per massima compatibilità
   - Evitare stili CSS esterni

3. **Immagini**
   - Utilizzare percorsi assoluti per le immagini
   - Ottimizzare le immagini prima dell'inserimento

4. **Performance**
   - Cacheare i PDF generati quando possibile
   - Utilizzare la compressione per file di grandi dimensioni

## Note
- HTML2PDF è più adatto per documenti semplici e statici
- Per documenti complessi o dinamici, considerare alternative come TCPDF o mPDF
- Testare sempre la generazione PDF su diversi contenuti e dimensioni 