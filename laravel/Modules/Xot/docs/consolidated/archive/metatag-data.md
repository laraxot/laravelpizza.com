# MetatagData

## Descrizione
La classe `MetatagData` gestisce i metadati del sito, inclusi loghi, colori e configurazioni SEO.

## Proprietà Principali

### Loghi e Branding
- `logo_header`: Logo principale del sito
- `logo_header_dark`: Logo per tema scuro
- `logo_square`: Logo quadrato per icone
- `logo_footer`: Logo per il footer
- `logo_alt`: Testo alternativo per i loghi
- `logo_height`: Altezza del logo

### Metadati SEO
- `title`: Titolo del sito
- `sitename`: Nome del sito
- `subtitle`: Sottotitolo
- `description`: Descrizione del sito
- `keywords`: Parole chiave
- `author`: Autore
- `generator`: Generatore del sito

### Colori
- `color_primary`: Colore primario
- `color_title`: Colore del titolo
- `color_megamenu`: Colore del megamenu
- `color_hamburger`: Colore dell'hamburger menu
- `color_banner`: Colore del banner

## Metodi Principali

### Gestione Loghi
```php
// Ottiene il logo del brand (metodo semantico)
$logo = $metatag->getBrandLogo();

// Ottiene il logo dell'header (implementazione di base)
$headerLogo = $metatag->getLogoHeader();

// Ottiene il logo per tema scuro
$darkLogo = $metatag->getLogoHeaderDark();

// Ottiene l'altezza del logo
$height = $metatag->getLogoHeight();

// 🆕 Ottiene il logo come data URI base64 per embedding inline
$base64Logo = $metatag->getBrandLogoBase64();
```

### Utilizzo del Logo Base64
Il metodo `getBrandLogoBase64()` è utile per:
- **Email HTML**: Incorporare il logo direttamente nelle email senza dipendenze esterne
- **PDF Generation**: Includere il logo nei PDF senza percorsi di file
- **Performance**: Ridurre richieste HTTP incorporando il logo nel HTML
- **Offline Usage**: Logo disponibile anche senza connessione internet

```php
// Esempio utilizzo in template Blade
<img src="{{ $metatag->getBrandLogoBase64() }}" alt="{{ $metatag->getBrandName() }}">

// Esempio utilizzo in PDF
$html = '<img src="' . $metatag->getBrandLogoBase64() . '" alt="Logo">';

// Esempio utilizzo in email
$emailHtml = '<img src="' . $metatag->getBrandLogoBase64() . '" alt="Company Logo" style="max-width: 200px;">';
```

**Formati supportati**: PNG, JPG, JPEG, GIF, SVG, WebP, BMP, ICO

**Gestione errori**: Il metodo restituisce stringa vuota se il file non esiste o ci sono errori, senza bloccare l'applicazione.

## Esempi Pratici

### Esempio 1: Logo in Email HTML
```php
use Modules\Xot\Datas\MetatagData;

$metatag = MetatagData::make();
$logoBase64 = $metatag->getBrandLogoBase64();

$emailHtml = "
<html>
<body>
    <div style='text-align: center;'>
        <img src='{$logoBase64}' alt='Logo Azienda' style='max-width: 200px; height: auto;'>
        <h1>Benvenuto!</h1>
        <p>Grazie per aver scelto i nostri servizi.</p>
    </div>
</body>
</html>
";

// Invia email con logo incorporato
Mail::html($emailHtml, function($message) {
    $message->to('utente@example.com')->subject('Benvenuto');
});
```

### Esempio 2: Logo in PDF 
```php
use Modules\Xot\Datas\MetatagData;

$metatag = MetatagData::make();
$logoBase64 = $metatag->getBrandLogoBase64();

$pdfHtml = "
<style>
    .header { text-align: center; margin-bottom: 30px; }
    .logo { max-width: 150px; height: auto; }
</style>
<div class='header'>
    <img src='{$logoBase64}' alt='Logo' class='logo'>
    <h2>Referto Medico</h2>
</div>
<div class='content'>
    <!-- Contenuto del PDF -->
</div>
";

$pdf = PDF::loadHTML($pdfHtml);
return $pdf->download('referto.pdf');
```

### Esempio 3: Logo in Blade Template
```blade
{{-- resources/views/components/header.blade.php --}}
@php
    $metatag = \Modules\Xot\Datas\MetatagData::make();
    $logoBase64 = $metatag->getBrandLogoBase64();
@endphp

<header class="company-header">
    @if($logoBase64)
        <img src="{{ $logoBase64 }}" 
             alt="{{ $metatag->getBrandName() }}" 
             class="company-logo"
             style="max-height: 60px; width: auto;">
    @else
        <h1>{{ $metatag->getBrandName() }}</h1>
    @endif
</header>
```

### Esempio 4: Verifica e Fallback
```php
use Modules\Xot\Datas\MetatagData;

function getCompanyLogo(): string 
{
    $metatag = MetatagData::make();
    $logoBase64 = $metatag->getBrandLogoBase64();
    
    if (empty($logoBase64)) {
        // Fallback: usa URL normale del logo
        return $metatag->getBrandLogo();
    }
    
    return $logoBase64;
}

// Utilizzo
$logoSrc = getCompanyLogo();
echo "<img src='{$logoSrc}' alt='Logo'>";
```

### Gestione Colori
```php
// Ottiene i colori per Filament
$colors = $metatag->getFilamentColors();

// Ottiene tutti i colori
$allColors = $metatag->getAllColors();

// Ottiene i colori personalizzati
$customColors = $metatag->getColors();
```

### Gestione Metadati
```php
// Ottiene i valori meta
$metaValues = $metatag->getMetaValues();

// Ottiene le card social
$socialCards = $metatag->getSocialCards();

// Ottiene i dati OpenGraph
$openGraph = $metatag->getOpenGraph();

// Ottiene i dati Twitter Cards
$twitterCards = $metatag->getTwitterCards();
```

## Best Practices

1. **Utilizzo dei Loghi**:
   - Preferire `getBrandLogo()` per operazioni relative al brand
   - Utilizzare `getLogoHeader()` solo per compatibilità
   - Verificare sempre la presenza del logo dark

2. **Gestione Colori**:
   - Utilizzare `getFilamentColors()` per l'integrazione con Filament
   - Mantenere coerenza nella palette colori
   - Documentare le variazioni di colore

3. **SEO**:
   - Mantenere descrizioni uniche e pertinenti
   - Utilizzare parole chiave rilevanti
   - Aggiornare regolarmente i metadati

## Note di Implementazione

1. **Singleton Pattern**:
   - La classe utilizza il pattern Singleton
   - Accesso tramite `MetatagData::make()`
   - Configurazione caricata da `TenantService`

2. **Gestione Errori**:
   - Fallback automatico per loghi mancanti
   - Logging degli errori
   - Valori predefiniti per campi obbligatori

3. **Tipizzazione**:
   - Tutte le proprietà sono tipizzate
   - I metodi hanno return type hint
   - Supporto per PHPStan livello 10

## Collegamenti
- [Configurazione Logo](../logo_resolution.md)
- [Gestione Colori](../colors.md)
- [SEO Best Practices](../seo.md)

## Caratteristiche principali

- Gestione dei meta tag SEO standard
- Supporto per Open Graph Protocol
- Configurazione Twitter Cards
- Integrazione con schema.org
- Gestione dei meta tag personalizzati

## Proprietà

| Proprietà | Tipo | Descrizione |
|-----------|------|-------------|
| title | string | Titolo della pagina |
| description | string | Descrizione della pagina |
| keywords | array | Parole chiave per SEO |
| robots | string | Direttive per i crawler |
| author | string | Autore del contenuto |
| ogTitle | string | Titolo per Open Graph |
| ogDescription | string | Descrizione per Open Graph |
| ogImage | string | URL immagine per Open Graph |
| twitterCard | string | Tipo di Twitter Card |
| twitterTitle | string | Titolo per Twitter |
| twitterDescription | string | Descrizione per Twitter |
| twitterImage | string | URL immagine per Twitter |

## Metodi

### Costruttore
```php
public function __construct(array $data)
```

### Factory Methods
```php
public static function fromArray(array $data): self
public static function make(array $data = []): self
```

### Metodi di generazione
```php
public function toHtml(): string
public function toArray(): array
```

## Esempio di utilizzo

```php
$metatags = MetatagData::make([
    'title' => 'Titolo della pagina',
    'description' => 'Descrizione della pagina',
    'ogTitle' => 'Titolo per social',
    'ogImage' => 'https://example.com/image.jpg',
]);

echo $metatags->toHtml();
```

## Validazione

La classe utilizza `Assert` per validare:
- Presenza dei campi obbligatori
- Formato corretto degli URL
- Lunghezza appropriata dei testi
- Valori validi per i tipi di card 
