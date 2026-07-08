# Guida agli Stili, Tabelle e Immagini

Questa guida illustra come applicare stili CSS, creare layout con tabelle e gestire le immagini nei PDF generati con Html2Pdf.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 🎨 Stili e CSS

Html2Pdf ha un supporto limitato per i CSS. La regola fondamentale è utilizzare **esclusivamente CSS inline** tramite l'attributo `style`. Tag `<style>` e fogli di stile esterni (`<link>`) non sono supportati.

#### ✅ CSS Inline Corretto
```html
<div style="font-family: Arial; font-size: 12pt; color: #333;">
    <h1 style="font-size: 18pt; text-align: center;">Titolo</h1>
    <p style="margin: 10pt 0;">Paragrafo con <strong style="font-weight: bold;">testo grassetto</strong></p>
</div>
```

#### ❌ Esempi di CSS Non Supportato
```html
<!-- NON FUNZIONA -->
<style>
    .title { font-size: 18pt; }
</style>
<link rel="stylesheet" href="styles.css">
```

### Proprietà CSS Principali

#### Testo e Font
```html
<p style="font-family: Arial; font-size: 12pt; font-weight: bold; font-style: italic; color: #FF0000; text-decoration: underline;">
    Testo formattato
</p>
```

#### Bordi e Sfondo
```html
<div style="border: 1px solid #000; background-color: #F0F0F0; padding: 5mm;">
    Contenuto con bordo e sfondo
</div>
```

#### Dimensioni e Allineamento
```html
<div style="width: 50%; text-align: right; margin: auto;">
    Contenuto allineato a destra, largo al 50%.
</div>
```

---

## 📊 Tabelle e Layout

Le tabelle HTML sono il metodo più affidabile per creare layout complessi e multi-colonna.

### Layout a Colonne con Tabelle
```html
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #E0E0E0;">
            <th style="border: 1px solid #000; padding: 5pt; text-align: left;">Colonna 1</th>
            <th style="border: 1px solid #000; padding: 5pt; text-align: left;">Colonna 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #000; padding: 5pt;">Dato 1</td>
            <td style="border: 1px solid #000; padding: 5pt;">Dato 2</td>
        </tr>
    </tbody>
</table>
```

### Tabelle Nidificate per Layout Complessi
```html
<table style="width: 100%;">
    <tr>
        <td style="width: 50%; vertical-align: top;">
            <table style="width: 100%; border: 1px solid #000;">
                <tr><td>Tabella interna 1</td></tr>
            </table>
        </td>
        <td style="width: 50%; vertical-align: top;">
            <table style="width: 100%; border: 1px solid #000;">
                <tr><td>Tabella interna 2</td></tr>
            </table>
        </td>
    </tr>
</table>
```

---

## 🖼️ Immagini

### Formati Supportati
- **JPEG/JPG**
- **PNG** (con trasparenza)
- **GIF**
- **SVG** (supporto limitato, la conversione in Base64 è consigliata)

### Metodi di Inclusione

#### 1. Path Relativo al Filesystem
```html
<img src="./images/logo.png" style="width: 50mm;" />
```

#### 2. URL Assoluta (più lenta e richiede configurazione di sicurezza)
```html
<img src="https://example.com/logo.png" style="width: 50mm;" />
```

#### 3. Base64 Embedded (Raccomandato per performance e portabilità)
Questo metodo include l'immagine direttamente nel codice HTML, evitando richieste esterne.
```html
<img src="data:image/png;base64,iVBORw0KGgoAAAANS..." style="width: 50mm;" />
```

### Generazione Base64 da Laravel
È buona pratica convertire le immagini in Base64 prima di passarle alla view.

```php
// In un Controller o Action
$imagePath = public_path('images/logo.png');
$imageData = base64_encode(file_get_contents($imagePath));
$src = 'data:image/png;base64,' . $imageData;

// Passa la stringa $src alla view
return view('pdf.template', compact('src'));
```
