# Fix Critico: Errore HtmlParsingException - Tag Style Malformato + Guida Html2Pdf Completa

**Data**: 16 Gennaio 2025  
**Modulo**: Progressioni  
**File**: `resources/views/admin/schede/show/pdf.blade.php`  
**Stato**: ✅ RISOLTO - Tag style corretto

## 🚨 Errore Critico Identificato

### Stack Trace
```
Spipu\Html2Pdf\Exception\HtmlParsingException - Internal Server Error
Too many tag closures found for [style]

Riga 257: vendor/spipu/html2pdf/src/Parsing/Html.php
```

### Causa Root
**Tag HTML malformato** nella view PDF:

**PRIMA** (errore):
```blade
e type="text/css">    ❌ MANCA <styl all'inizio!
    /* CSS content */
</style>               ❌ Tag chiusura senza apertura corretta
```

**DOPO** (corretto):
```blade
<style type="text/css">  ✅ Tag apertura completo
    /* CSS content */
</style>                 ✅ Tag chiusura corrispondente
```

## 🔍 Analisi Approfondita

### Flusso dell'Errore
1. **PdfAction.php:26** → Chiama PdfByModelAction
2. **PdfByModelAction.php:42** → Genera HTML dalla view
3. **PdfByHtmlAction.php:24** → `$html2pdf->writeHTML($html)` riceve HTML malformato
4. **Html2Pdf parser** → Rileva tag `</style>` senza apertura corrispondente

### File Coinvolti
- **View problematica**: `Modules/Progressioni/resources/views/admin/schede/show/pdf.blade.php`
- **Action chiamante**: `Modules/Xot/app/Filament/Actions/Table/PdfAction.php`
- **Generazione HTML**: `Modules/Xot/app/Actions/Export/PdfByModelAction.php`
- **Parsing PDF**: `Modules/Xot/app/Actions/Export/PdfByHtmlAction.php`

### Costruzione View Name
```php
// In PdfByModelAction.php
$view_name = $module_low.'::'.Str::kebab($model_name).'.show.pdf';
// Risultato: "progressioni::schede.show.pdf"
```

## 🔧 Correzione Implementata

### Fix del Tag Style
```blade
<!-- PRIMA (errore alla riga 1) -->
e type="text/css">

<!-- DOPO (corretto) -->
<style type="text/css">
```

### Validazione HTML
Il file ora ha:
- ✅ Tag `<style>` di apertura corretto
- ✅ Tag `</style>` di chiusura corrispondente
- ✅ CSS valido all'interno
- ✅ Struttura HTML ben formata

## 🛡️ Strategia Prevenzione

### 1. Validazione HTML View PDF
```bash
#!/bin/bash
# Script: validate_pdf_html.sh

echo "🔍 Validazione HTML nelle view PDF..."

# Cerca view PDF
find laravel/Modules/*/resources/views -name "*pdf*.blade.php" | while read file; do
    echo "📄 Validando: $file"
    
    # Controlla tag style malformati
    if grep -q "^[^<]*type=\"text/css\">" "$file"; then
        echo "❌ ERRORE: Tag style malformato in $file"
    fi
    
    # Controlla bilanciamento tag style
    open_tags=$(grep -c "<style" "$file")
    close_tags=$(grep -c "</style>" "$file")
    
    if [ "$open_tags" -ne "$close_tags" ]; then
        echo "❌ ERRORE: Tag style non bilanciati in $file (aperti: $open_tags, chiusi: $close_tags)"
    fi
done
```

### 2. Test Generazione PDF
```bash
# Test automatico generazione PDF
cd laravel
php artisan test --filter=PDF
```

### 3. Validazione HTML con Tidy
```bash
# Validazione HTML con HTML Tidy
tidy -q -e file.html 2>&1 | grep -i error
```

## 🎯 Pattern di Errore Comune

### Cause Tipiche
1. **Copy-paste errato** di contenuto HTML
2. **Editing manuale** che corrompe tag
3. **Merge conflicts** mal risolti
4. **Encoding issues** che corrompono caratteri

### Sintomi
- `Too many tag closures found for [tag]`
- `Tag [tag] not opened`
- `Malformed HTML structure`
- Errori durante generazione PDF

### Prevenzione
- **Validazione HTML** prima del commit
- **Test PDF generation** automatici
- **Linting HTML** nelle view
- **Backup** prima di modifiche manuali

## 🎉 Risultato Finale

### ✅ Errore Risolto
- **Tag style corretto** nella view PDF
- **HTML ben formato** per parser Html2Pdf
- **Generazione PDF funzionante**
- **Nessun errore di parsing**

### 📚 Documentazione
- **Causa identificata**: Tag `<style>` malformato
- **Correzione implementata**: Tag apertura completo
- **Strategia prevenzione**: Script validazione automatica
- **Pattern riconosciuto**: Errore comune in view PDF

### 🧠 Lezioni Apprese
1. **HTML Validation**: Sempre validare HTML nelle view PDF
2. **Tag Balancing**: Verificare bilanciamento tag apertura/chiusura
3. **Parser Sensitivity**: Html2Pdf è sensibile a HTML malformato
4. **Prevention First**: Prevenire è meglio che correggere

## 🔗 Collegamenti

- [PDF View Corretta](../resources/views/admin/schede/show/pdf.blade.php)
- [PdfByHtmlAction](../../Xot/app/Actions/Export/PdfByHtmlAction.php)
- [CSS Template](../../Ptv/resources/views/pdf/css02.blade.php)

## 🚨 SECONDO ERRORE RISOLTO

### Nuovo Errore Identificato
```
Spipu\Html2Pdf\Exception\HtmlParsingException
Tags are closed in a wrong order for [table]
```

### Causa Root Identificata
1. **Include di view inesistenti**: `@include($view.'.head')` e `@include($view.'.food')`
2. **Struttura tabella incompleta**: Mancavano tag `<tbody>` e `<tfoot>`

### Correzioni Implementate
```blade
<!-- PRIMA (problematico) -->
@include($view.'.head')          ❌ File inesistente
<table>
    <thead>...</thead>
    @foreach...                  ❌ Righe senza tbody
    <tr>Totale</tr>             ❌ Riga footer senza tfoot
</table>
@include($view.'.food')         ❌ File inesistente

<!-- DOPO (corretto) -->
{{-- @include($view.'.head') --}}    ✅ Include commentato
<table>
    <thead>...</thead>
    <tbody>                          ✅ Tbody aggiunto
        @foreach...
    </tbody>
    <tfoot>                          ✅ Tfoot aggiunto
        <tr>Totale</tr>
    </tfoot>
</table>
{{-- @include($view.'.food') --}}   ✅ Include commentato
```

### ✅ Risultato Finale
- **HTML ben formato**: Struttura tabella corretta
- **Include sicure**: Rimosse include di file inesistenti
- **Parser compatibile**: HTML compatibile con Html2Pdf
- **Generazione PDF**: Ora funzionante senza errori

---
*Documentazione Fix HTML Parsing Error - Modulo Progressioni - Framework Laraxot*

---

## 📚 Guida Completa Html2Pdf per Progressioni

### Installazione e Setup

Html2Pdf è già integrato in Laraxot/PTVX tramite il modulo Xot:

```php
// Utilizzo base
use Modules\Xot\Actions\Pdf\ContentPdfAction;

$pdfContent = app(ContentPdfAction::class)->execute(
    html: '<h1>Documento PDF</h1>',
    filename: 'documento.pdf'
);
```

### Template PDF Corretti per Progressioni

#### Struttura Base PDF

```blade
{{-- resources/views/progressioni::schede.show.pdf.blade.php --}}
<page backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm">
    <page_header>
        <table width="100%" style="border-bottom: 1px solid #000;">
            <tr>
                <td width="60%">
                    <h1 style="font-size: 14pt; margin: 0;">Sistema Progressioni</h1>
                </td>
                <td width="40%" align="right">
                    <p style="font-size: 10pt; margin: 0;">Data: [[date_d/m/Y]]</p>
                </td>
            </tr>
        </table>
    </page_header>

    <h1 style="font-size: 16pt; text-align: center; margin: 20pt 0;">
        Scheda Progressione - {{ $scheda->codice }}
    </h1>

    {{-- Contenuto principale --}}
    <div style="margin: 10mm 0;">
        @include('progressioni::schede.partials.dati_anagrafici')
        @include('progressioni::schede.partials.dati_professionali')
    </div>

    <page_footer>
        <table width="100%" style="border-top: 1px solid #000; margin-top: 20pt;">
            <tr>
                <td width="60%">
                    <p style="font-size: 8pt; margin: 0;">Documento riservato</p>
                </td>
                <td width="40%" align="right">
                    <p style="font-size: 8pt; margin: 0;">Pag. [[page_cu]]/[[page_nb]]</p>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

#### CSS Inline (Solo Metodo Supportato)

```blade
{{-- ✅ CORRETTO - Solo CSS inline --}}
<div style="font-family: Arial; font-size: 12pt; color: #333; margin: 10pt 0;">
    <h2 style="font-size: 14pt; color: #0066CC; margin-bottom: 8pt;">
        Dati Anagrafici
    </h2>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid #CCC; padding: 5pt; background-color: #F9F9F9; font-weight: bold; width: 30%;">
                Nome:
            </td>
            <td style="border: 1px solid #CCC; padding: 5pt; width: 70%;">
                {{ $scheda->nome }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #CCC; padding: 5pt; background-color: #F9F9F9; font-weight: bold;">
                Cognome:
            </td>
            <td style="border: 1px solid #CCC; padding: 5pt;">
                {{ $scheda->cognome }}
            </td>
        </tr>
    </table>
</div>
```

### Errori Comuni e Soluzioni

#### 1. Tag `<style>` Non Consentiti

```blade
{{-- ❌ ERRORE - Tag style causano HtmlParsingException --}}
<style type="text/css">
    .header { font-size: 14pt; }
    .table { border-collapse: collapse; }
</style>

{{-- ✅ CORRETTO - Tutto inline --}}
<div style="font-size: 14pt;">Header</div>
<table style="border-collapse: collapse;">...</table>
```

#### 2. Immagini Rotte

```blade
{{-- ✅ SICURO - Base64 --}}
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" />

{{-- ❌ RISCHIOSO - Path relativo --}}
<img src="../images/logo.png" />
```

#### 3. Tabelle Non Chiuse

```blade
{{-- ❌ ERRORE - Tag non bilanciati --}}
<table>
    <tr><td>Cella</td></tr>
{{-- Manca </table> --}}

{{-- ✅ CORRETTO - Tag bilanciati --}}
<table>
    <tbody>
        <tr><td>Cella</td></tr>
    </tbody>
</table>
```

### Best Practices per Progressioni

#### 1. Struttura Template Organizzata

```
resources/views/progressioni/
├── schede/
│   ├── show/
│   │   ├── pdf.blade.php           # Template principale
│   │   └── partials/
│   │       ├── header.blade.php    # Intestazione
│   │       ├── dati.blade.php      # Dati scheda
│   │       └── footer.blade.php    # Piè pagina
│   └── pdf.blade.php               # Template alternativo
```

#### 2. Validazione Template

```bash
# Script validazione HTML PDF
#!/bin/bash
echo "🔍 Validazione template PDF Progressioni..."

find resources/views/progressioni -name "*pdf*.blade.php" | while read file; do
    echo "📄 Controllo: $file"

    # Verifica tag style vietati
    if grep -q "<style" "$file"; then
        echo "❌ ERRORE: Tag <style> trovato in $file - Usa solo CSS inline!"
    fi

    # Verifica tag non chiusi
    # (Ulteriori controlli possono essere aggiunti)
done
```

#### 3. Test Generazione PDF

```php
<?php
// In tests/Feature/Progressioni/PdfGenerationTest.php

namespace Tests\Feature\Progressioni;

use Tests\TestCase;
use Modules\Progressioni\Models\Scheda;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

class PdfGenerationTest extends TestCase
{
    /** @test */
    public function it_generates_valid_pdf_for_scheda()
    {
        $scheda = Scheda::factory()->create();

        $pdfAction = app(GetPdfContentByRecordAction::class);
        $pdfContent = $pdfAction->execute($scheda);

        // Validazione PDF
        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(1000, strlen($pdfContent));

        // Verifica contenuto specifico
        $this->assertStringContains($scheda->codice, $pdfContent);
    }

    /** @test */
    public function it_handles_missing_images_gracefully()
    {
        // Test con immagini mancanti
        $scheda = Scheda::factory()->create();

        $pdfAction = app(GetPdfContentByRecordAction::class);

        // Non dovrebbe lanciare eccezioni
        $pdfContent = $pdfAction->execute($scheda);

        $this->assertIsString($pdfContent);
    }
}
```

### Integrazione con Sistema Progressioni

#### Action PDF Personalizzata

```php
<?php

namespace Modules\Progressioni\Actions\Pdf;

use Modules\Xot\Actions\Pdf\ContentPdfAction;
use Modules\Progressioni\Models\Scheda;

class GenerateSchedaPdfAction
{
    public function execute(Scheda $scheda, array $options = []): string
    {
        $data = [
            'scheda' => $scheda,
            'includeDetails' => $options['include_details'] ?? true,
            'showLogo' => $options['show_logo'] ?? true,
        ];

        return app(ContentPdfAction::class)->execute(
            view: 'progressioni::schede.show.pdf',
            data: $data,
            filename: "scheda-{$scheda->codice}.pdf"
        );
    }
}
```

#### Controller con Download

```php
<?php

namespace Modules\Progressioni\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Actions\Pdf\GenerateSchedaPdfAction;

class SchedaController extends Controller
{
    public function downloadPdf($id)
    {
        $scheda = Scheda::findOrFail($id);

        $pdfContent = app(GenerateSchedaPdfAction::class)->execute($scheda);

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="scheda.pdf"');
    }
}
```

### Ottimizzazioni Performance

#### 1. Cache Template Compilati

```php
// In config/pdf.php
return [
    'cache_templates' => env('PDF_CACHE_TEMPLATES', true),
    'template_cache_path' => storage_path('pdf/templates'),
];
```

#### 2. Pool di Istanza Html2Pdf

```php
// ServiceProvider
public function register()
{
    $this->app->singleton('html2pdf.pool', function () {
        return new Html2PdfPool(5); // 5 istanze pre-create
    });
}
```

#### 3. Compressione PDF

```php
$html2pdf = new Html2Pdf('P', 'A4', 'it');
$html2pdf->setCompression(true); // Default true, riduce dimensione file
```

### Troubleshooting Avanzato

#### Debug Mode

```php
$html2pdf = new Html2Pdf();
$html2pdf->setModeDebug();

// Mostra informazioni dettagliate su:
// - Risorse utilizzate
// - Tempo di processamento
// - Errori di layout
```

#### Log Errori PDF

```php
try {
    $pdfContent = $html2pdf->output('', 'S');
} catch (Html2PdfException $e) {
    Log::error('Errore generazione PDF', [
        'exception' => $e->getMessage(),
        'scheda_id' => $scheda->id,
        'template' => 'progressioni::schede.show.pdf'
    ]);

    throw $e;
}
```

### Html2Pdf v5.3.3 - Nuove Funzionalità

#### 🔒 Security Service Avanzato
```php
// Inizializzazione sicura
$html2pdf = new Html2Pdf('P', 'A4', 'it');

// Configura host consentiti
$html2pdf->getSecurityService()->addAllowedHost('cdn.progressioni.it');
$html2pdf->getSecurityService()->addAllowedHost('images.laraxot.local');
```

#### 📄 Classe html2pdf-same-page
```blade
{{-- Previene divisione tabelle tra pagine --}}
<div class="html2pdf-same-page">
    <table>
        <tr><td>Dati scheda che non devono dividersi</td></tr>
        <!-- Questa tabella rimane sempre insieme -->
    </table>
</div>
```

#### 📝 Supporto Readonly Attributes
```blade
{{-- Ora supportato --}}
<input type="text" name="codice" value="{{ $scheda->codice }}" readonly />
```

#### 🎨 CSS con Variabili di Pagina
```blade
<style>
    {{-- Evidenzia pagina corrente --}}
    .page-header-[[page_cu]] {
        background-color: #0066CC;
        color: white;
    }
</style>
```

---

**Framework:** Laraxot/PTVX  
**Modulo:** Progressioni  
**Versione Html2Pdf:** 5.3.3  
**Ultimo Aggiornamento:** Gennaio 2026
