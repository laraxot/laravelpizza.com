# Html2Pdf - Panoramica e Installazione

Questa sezione fornisce una panoramica generale della libreria Html2Pdf, le novità dell'ultima versione, le istruzioni per l'installazione e l'architettura di integrazione nel progetto.

**Menu di Navigazione:**
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)
*   [Configurazione della Sicurezza](./security.md)

---

## 📋 Panoramica

**Html2Pdf** è una libreria PHP per convertire HTML in PDF, utilizzata in Laraxot/PTVX per generare documenti PDF da template Blade. Basata su TCPDF, supporta PHP 7.2-8.4.

**Repository:** https://github.com/spipu/html2pdf
**Versione utilizzata:** ^5.2 → **Aggiornato a 5.3.3** (Giugno 2025)
**Licenza:** OSL-3.0

---

## 🆕 **Novità Versione 5.3.x (2025)**

### 🔒 **Security Service Avanzato**
Html2Pdf 5.3+ include un [servizio di sicurezza](./security.md) configurabile per proteggere da accessi non autorizzati.

### 📝 **Supporto Readonly Attributes**
Nuovo supporto per attributi `readonly` negli elementi input e textarea.

### 📄 **Classe html2pdf-same-page**
Previene la divisione di tabelle tra pagine multiple.

### 🎨 **CSS con Variabili di Pagina**
Utilizzo di `[[page_cu]]` nei nomi delle classi CSS.

### 🏷️ **Nuovi Tag HTML Supportati**
- `<strike>` - Testo barrato
- `<figure>` - Contenitori di figure

### 🔧 **Miglioramenti Tecnici**
- **PHP 8.4 Full Support**
- **TCPDF Updated**
- **Performance e Memory Usage migliorati**

---

## 🚀 Installazione e Configurazione

### Composer Installation
```bash
composer require spipu/html2pdf
```

### Dipendenze Richieste
```json
{
    "require": {
        "php": ">=7.2",
        "spipu/html2pdf": "^5.2",
        "tecnickcom/tcpdf": "^6.6"
    }
}
```

### Estensioni PHP Necessarie
```ini
extension=gd
extension=mbstring
```

---

## 🏗️ Architettura nel Progetto

### Struttura di Integrazione
```
Modules/Xot/
├── app/
│   ├── Actions/
│   │   ├── Pdf/
│   │   │   ├── GetPdfContentByRecordAction.php    # PDF da record
│   │   │   ├── ContentPdfAction.php               # PDF da HTML/view
│   │   │   ├── StreamDownloadPdfAction.php        # Download diretto
│   │   │   └── Engine/
│   │   │       ├── SpipuPdfByHtmlAction.php       # Engine spipu
│   │   │       └── SpatiePdfByHtmlAction.php      # Engine spatie
│   └── Datas/
│       └── PdfData.php                            # DTO PDF
```

### Engine Supportati
```php
enum PdfEngineEnum
{
    case SPIPU;    // spipu/html2pdf (default)
    case SPATIE;   // spatie/laravel-pdf (alternative)
}
```
