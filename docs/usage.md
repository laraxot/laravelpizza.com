# Utilizzo Base e Layout

Questa sezione descrive l'utilizzo di base della libreria, come istanziare la classe `Html2Pdf` e come gestire il layout delle pagine con i tag speciali.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 🔧 Utilizzo Base

### Istanza Html2Pdf
```php
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf(
    orientation: 'P',              // P=Portrait, L=Landscape
    format: 'A4',                 // A4, Letter, Legal, A3, etc.
    lang: 'it',                   // Lingua per traduzioni
    unicode: true,                // Supporto Unicode
    encoding: 'UTF-8',            // Encoding
    margins: [10, 10, 10, 10]     // Margini [top, right, bottom, left] mm
);
```

### Generazione PDF Semplice
```php
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'it');
    $html2pdf->writeHTML('<h1>Hello World</h1><p>Contenuto PDF</p>');
    $html2pdf->output('documento.pdf');
} catch (Html2PdfException $e) {
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
```

---

## 📄 Gestione Pagine e Layout

### Tag Speciali Html2Pdf

#### `<page>` - Controllo Pagina
Il tag `<page>` è il contenitore principale per ogni pagina del documento e permette di definirne le proprietà.

```html
<page backtop="10mm" backbottom="10mm" backleft="15mm" backright="15mm"
      orientation="P" format="A4">
    <page_header>
        <h1>Intestazione</h1>
    </page_header>

    <page_footer>
        <p>Pagina [[page_cu]] di [[page_nb]]</p>
    </page_footer>

    <h1>Contenuto Principale</h1>
    <p>Testo del documento...</p>
</page>
```

#### Attributi `<page>`
| Attributo | Default | Descrizione |
|-----------|---------|-------------|
| `backtop` | 0 | Margine superiore (mm, px, pt, %) |
| `backbottom` | 0 | Margine inferiore |
| `backleft` | 0 | Margine sinistro |
| `backright` | 0 | Margine destro |
| `orientation` | - | P=Portrait, L=Landscape |
| `format` | - | A4, Letter, Legal, A3, etc. |
| `pageset` | new | `old` riutilizza il layout della pagina precedente. |
| `pagegroup` | old | `new` crea un nuovo gruppo di pagine. |

#### `<page_header>` e `<page_footer>`
Questi tag definiscono contenuti che verranno ripetuti in cima e in fondo a ogni pagina.

```html
<page backtop="20mm" backbottom="20mm">
    <page_header>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">Logo Azienda</td>
                <td style="width: 50%; text-align: right;">Data: [[date_d/m/Y]]</td>
            </tr>
        </table>
    </page_header>

    <page_footer>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">Documento Confidenziale</td>
                <td style="width: 50%; text-align: right;">Pag. [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>

    <!-- Contenuto principale -->
</page>
```

#### `<nobreak>` - Evita Interruzioni Pagina
Il contenuto all'interno di questo tag non verrà spezzato tra due pagine.

```html
<nobreak>
    <h2>Sezione Importante</h2>
    <table>
        <tr><td>Riga 1</td></tr>
        <tr><td>Riga 2</td></tr>
        <!-- Questa sezione rimarrà unita -->
    </table>
</nobreak>
```
