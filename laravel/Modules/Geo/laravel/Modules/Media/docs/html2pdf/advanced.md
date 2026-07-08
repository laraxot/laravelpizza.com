# Funzionalità Avanzate

Questa sezione copre funzionalità avanzate come la generazione di codici a barre, QR code, la creazione di segnalibri (bookmark), indici e altri metodi utili della libreria.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 📋 Codici a Barre e QR Code

### Barcode
Html2Pdf può generare diversi tipi di codici a barre direttamente nel PDF.

```html
<barcode type="C39" value="HTML2PDF" style="width: 40mm; height: 10mm; color: #000;"></barcode>
```

#### Tipi di Barcode Supportati
| Tipo | Descrizione |
|---|---|
| C39 | Code 39 |
| C128 | Code 128 |
| EAN13 | EAN-13 (richiede 12 cifre) |
| UPC-A | UPC-A (richiede 11 cifre) |
| ... e altri | (Vedi documentazione TCPDF) |

### QR Code
È possibile generare QR code per URL, testi o altri dati.

```html
<qrcode value="https://html2pdf.fr/" ec="H" style="width: 20mm; border: none;"></qrcode>
```

#### Attributi `qrcode`
- `value`: Il contenuto da codificare.
- `ec`: Livello di correzione d'errore (L, M, Q, H). `H` è il più alto.
- `style`: Per definire dimensioni, bordi, etc.

---

## 🔖 Segnalibri e Indice

### Creare Segnalibri (Bookmark)
I segnalibri creano un sommario navigabile nel lettore PDF.

```html
<bookmark title="Capitolo 1" level="0"></bookmark>
<h1>Capitolo 1</h1>
<p>Contenuto del capitolo 1...</p>

<bookmark title="Sezione 1.1" level="1"></bookmark>
<h2>Sezione 1.1</h2>
<p>Contenuto della sezione 1.1...</p>
```
L'attributo `level` definisce il livello di annidamento nell'indice.

### Generazione Automatica di un Indice
È possibile inserire un indice generato automaticamente basato sui segnalibri creati.

```html
<!-- Inserisci questo tag dove vuoi che appaia l'indice -->
<bookmarkcreate title="Indice Documento" />

<!-- I segnalibri successivi verranno aggiunti all'indice -->
<bookmark title="Introduzione" level="0"></bookmark>
<h1>Introduzione</h1>
```

---

## ⚙️ Metodi Utili della Classe `Html2Pdf`

### Modalità Debug
Attiva una modalità che mostra gli errori di parsing HTML in modo dettagliato.
```php
$html2pdf = new Html2Pdf();
$html2pdf->setModeDebug();
```

### Gestione delle Immagini
```php
// Disabilita il controllo sull'esistenza delle immagini (utile per test)
$html2pdf->setTestIsImage(false);

// Imposta un'immagine di fallback se un'immagine non viene trovata
$html2pdf->setFallbackImage('/path/to/fallback.png');
```

### Controllo Contenuto Tabelle
Per impostazione predefinita, Html2Pdf verifica che il contenuto di una cella `<td>` non superi una pagina. Questo può essere disabilitato, ma con cautela.
```php
// Disabilita il controllo (può causare problemi di layout)
$html2pdf->setTestTdInOnePage(false);
```

### Aggiungere Font Personalizzati
È possibile aggiungere e utilizzare font TrueType (.ttf) personalizzati.
```php
// Aggiunge un nuovo font
$html2pdf->addFont('MyCustomFont', '', '/path/to/myfont.ttf');

// Imposta il font come predefinito per il documento
$html2pdf->setDefaultFont('MyCustomFont');
```
Ora puoi usare `font-family: MyCustomFont;` nel tuo CSS inline.

### Impostare il Titolo del Documento
Imposta il titolo visibile nelle proprietà del file PDF.
```php
$html2pdf->pdf->SetTitle('Il Mio Bel Documento');
```
