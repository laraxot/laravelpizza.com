# MetatagData

## Descrizione
La classe `MetatagData` gestisce i meta tag e le configurazioni visive dell'applicazione, inclusi colori, loghi e favicon.

## Pattern dei Getter
La classe segue un pattern specifico per l'accesso alle proprietà:

1. **Getter Base**: Per ogni proprietà pubblica, esiste un getter base che restituisce il valore raw della proprietà (es: `getColors()` per `$colors`)
2. **Getter Specializzati**: Per proprietà che richiedono formattazione speciale o logica aggiuntiva, esistono getter specifici (es: `getFilamentColors()`, `getAllColors()`)

### Gerarchia dei Getter per i Colori
- `getColors()`: Getter base che restituisce l'array raw dei colori
- `getFilamentColors()`: Getter specializzato che formatta i colori per Filament
- `getAllColors()`: Getter specializzato che restituisce una versione semplificata dei colori

## Motivazione per getColors()
Il metodo `getColors()` è necessario per:
1. Seguire il pattern consistente di getter base per tutte le proprietà
2. Permettere l'accesso ai dati raw quando necessario
3. Mantenere la coerenza con il principio di incapsulamento
4. Facilitare future modifiche alla struttura interna dei dati

## Utilizzo Corretto
```php
// Accesso raw ai colori
$rawColors = $metatag->getColors();

// Colori formattati per Filament
$filamentColors = $metatag->getFilamentColors();

// Versione semplificata dei colori
$simpleColors = $metatag->getAllColors();
```

## Metodi Disponibili

### getFilamentColors()
Restituisce i colori formattati per l'utilizzo con Filament.

### getAllColors()
Restituisce tutti i colori configurati nel formato chiave-valore.

### getLogoHeader()
Restituisce il percorso del logo dell'header.

### getLogoHeaderDark()
Restituisce il percorso del logo dell'header per la modalità scura.

### getFavicon()
Restituisce il percorso del favicon.

### getLogoHeight()
Restituisce l'altezza configurata per il logo.

### getBrandName(): string
Restituisce il nome del brand (title).

### getBrandLogo(): string  
Restituisce il percorso del logo del brand principale.

### getDarkModeBrandLogo(): string
Restituisce il percorso del logo del brand per tema scuro.

### getBrandLogoHeight(): string
Restituisce l'altezza configurata per il logo del brand.

### getBrandLogoBase64(): string
**🆕 NUOVO METODO**
Restituisce il logo del brand come data URI base64 per embedding inline.

**Utilizzi principali:**
- Email HTML con logo incorporato
- Generazione PDF con logo embedded  
- Riduzione richieste HTTP
- Utilizzo offline senza dipendenze esterne

**Esempio output:**
```
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...
```

**Gestione errori:** Restituisce stringa vuota se il file non esiste, con logging degli errori.

**Formati supportati:** PNG, JPG, JPEG, GIF, SVG, WebP, BMP, ICO

## Utilizzo con Filament Panel

Per applicare i colori al panel Filament, utilizzare il metodo `getFilamentColors()` invece di accedere direttamente alla proprietà `colors`:

```php
$panel->colors($metatag->getFilamentColors())
```

## Note Importanti
- Non utilizzare direttamente la proprietà `colors`
- Utilizzare sempre i metodi getter appropriati
- I colori devono essere configurati nel formato corretto per Filament

## Collegamenti
- [Filament Theming Documentation](docs/filament/theming.md)
- [Color Management Best Practices](docs/design/colors.md)

## Proprietà
- `title`: string - Titolo della pagina
- `sitename`: string - Nome del sito
- `colors`: array - Array associativo dei colori del tema
- ... (altre proprietà)

## Metodi
### getColors(): array
Restituisce l'array raw dei colori senza alcuna trasformazione.

### getFilamentColors(): array
Restituisce i colori formattati per l'uso con Filament Panel.

### getAllColors(): array
Restituisce una versione semplificata dei colori.

### getLogoHeader(): string
Restituisce il percorso del logo dell'header.

### getLogoHeaderDark(): string
Restituisce il percorso del logo dell'header per il tema scuro.

### getFavicon(): string
Restituisce il percorso del favicon.

## Errori PHPStan Comuni
1. Chiamata al metodo inesistente `getColors()`
   - **Problema**: Il metodo `getColors()` non esiste
   - **Soluzione**: Utilizzare `getFilamentColors()` per i colori formattati per Filament o `getAllColors()` per i colori non formattati

## Collegamenti
- [Filament Best Practices](../filament-best-practices.md)
- [PHPStan Common Exceptions](../PHPSTAN-COMMON-EXCEPTIONS.md)
- [Data Queableactions](../DATA-QUEABLEACTIONS.md) 