# Integrazione con Laravel e Best Practices

Questa guida si concentra su come integrare e utilizzare `Html2Pdf` in un'applicazione Laravel, seguendo le best practice specifiche del progetto Laraxot.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 🔗 Integrazione con Laravel

### Service Provider
È consigliabile registrare `Html2Pdf` nel container di servizi di Laravel per una facile dependency injection.

```php
// In un ServiceProvider, ad esempio PdfServiceProvider.php
public function register()
{
    $this->app->bind(Html2Pdf::class, function () {
        // Imposta qui la configurazione di default per tutto il progetto
        return new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [10, 15, 10, 15]);
    });
}
```

### Facade (Opzionale)
Se preferisci un accesso statico, puoi creare una Facade.

```php
// 1. Crea la classe Facade
// app/Facades/Pdf.php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;
use Spipu\Html2Pdf\Html2Pdf;

class Pdf extends Facade
{
    protected static function getFacadeAccessor() { return Html2Pdf::class; }
}

// 2. Registra l'alias in config/app.php
'aliases' => Facade::defaultAliases()->merge([
    'Pdf' => App\Facades\Pdf::class,
])->toArray(),
```

---

## 🎯 Best Practices in Laraxot

### 1. Template Blade Puliti e Riusabili
Crea template Blade specifici per i PDF, separando la logica dalla presentazione.

```blade
{{-- resources/views/pdf/documento.blade.php --}}
<page backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm">
    <page_header>
        @include('pdf.partials.header')
    </page_header>
    <page_footer>
        @include('pdf.partials.footer')
    </page_footer>

    <h1 style="font-size: 18pt; text-align: center;">{{ $title }}</h1>

    <div style="margin: 10mm 0;">
        {!! $content !!}
    </div>
</page>
```

### 2. Gestione delle Immagini
Converti sempre le immagini in Base64 prima di passarle alla view per evitare problemi di path e permessi.

```php
// In un Controller o Action
public function generatePdf()
{
    $logoPath = public_path('images/logo.png');
    $logoBase64 = file_exists($logoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
        : null;

    $view = view('pdf.report', compact('logoBase64'))->render();
    // ... genera PDF
}
```

### 3. Test di Generazione PDF
Includi test automatici per verificare che i PDF vengano generati correttamente.

```php
/** @test */
public function it_generates_a_valid_pdf_document()
{
    // Prepara i dati per la view
    $data = ['title' => 'Test Report', 'content' => '<p>Test content</p>'];

    // Usa l'Action di progetto per generare il contenuto del PDF
    $pdfContent = app(ContentPdfAction::class)->execute(
        view: 'pdf.documento',
        data: $data
    );

    // Asserzioni base
    $this->assertIsString($pdfContent);
    $this->assertStringStartsWith('%PDF', $pdfContent); // Controlla l'header del file PDF
    $this->assertGreaterThan(1000, strlen($pdfContent)); // Controlla che il file non sia vuoto
}
```

### 4. Gestione dell'Output
Utilizza i diversi metodi di output in base al contesto.

```php
// Per il download diretto
$html2pdf->output('documento.pdf', 'D');

// Per salvare il file sul server
$html2pdf->output(storage_path('app/pdfs/documento.pdf'), 'F');

// Per allegarlo a una email
$pdfContent = $html2pdf->output(null, 'S');
Mail::to('user@example.com')->send(new ReportMail($pdfContent));
```

---

## 🚨 Troubleshooting Comune

### Errore: "Too many tag closures found for [style]"
**Causa:** Presenza di tag `<style>` nel codice HTML.
**Soluzione:** Rimuovi tutti i tag `<style>` e utilizza solo CSS inline (`style="..."`).

### Errore: Immagine non trovata o non visualizzata
**Causa:** Path errato o problemi di permessi del server web.
**Soluzione:** Usa immagini in formato Base64 embedded nell'HTML.

### Errore: HTML Parsing Exception / Tag non bilanciati
**Causa:** HTML malformato (es. `<div>` non chiuso, `<table>` senza `</table>`).
**Soluzione:** Assicurati che l'HTML sia valido e ben formato. Strumenti come `tidy` possono aiutare a identificare gli errori prima di passarlo a Html2Pdf.

### Problema: Il testo o una tabella vengono spezzati male tra le pagine
**Causa:** Contenuto troppo grande per rimanere in una singola pagina.
**Soluzione:** Usa il tag `<nobreak>` per forzare un blocco di contenuto a rimanere unito, oppure rivedi la struttura per renderla più flessibile.
