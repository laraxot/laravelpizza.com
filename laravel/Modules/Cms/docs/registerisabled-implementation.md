# Implementazione Pagina Register Disabled

## Panoramica

Questo documento descrive l'implementazione completa della pagina "register_disabled" nel sistema Content Blocks di <main module>, utilizzando il Filament Builder per creare una pagina dinamica informativa per quando le registrazioni sono temporaneamente disabilitate.

## Struttura Implementata

### 1. Configurazione JSON
**File**: `config/local/<directory progetto>/database/content/pages/register_disabled.json`

La pagina è configurata con due blocchi principali:

#### Hero Block
- **Tipo**: `hero`
- **Vista**: `pub_theme::components.blocks.hero.register_disabled`
- **Funzionalità**:
  - Titolo principale con messaggio di sospensione registrazioni
  - Sottotitolo esplicativo
  - Immagine di sfondo con overlay
  - Bottone CTA per tornare alla home
  - Informazioni di contatto opzionali (email e telefono)
  - Icona di avviso prominente

#### Feature Sections Block
- **Tipo**: `feature_sections`
- **Vista**: `pub_theme::components.blocks.feature_sections.register_disabled_info`
- **Sezioni**:
  1. **Perché le registrazioni sono sospese?** - Spiegazione delle possibili cause
  2. **Quando sarà possibile registrarsi nuovamente?** - Informazioni sui tempi
  3. **Hai già un account?** - Link per il login
  4. **Hai bisogno di assistenza?** - Contatti per supporto

### 2. View Blade Create

#### Hero View
**File**: `Themes/One/resources/views/components/blocks/hero/register_disabled.blade.php`

**Caratteristiche**:
- Layout responsive con design moderno
- Icona di avviso centrale con sfondo colorato
- Supporto per immagine di sfondo con overlay
- Sezione informazioni di contatto condizionale
- Link di ritorno alla home
- Personalizzazione completa di colori e stili

**Proprietà supportate**:
- `title` - Titolo principale
- `subtitle` - Sottotitolo descrittivo
- `image` - URL immagine di sfondo
- `cta_text` - Testo bottone principale
- `cta_link` - Link bottone principale
- `background_color` - Colore di sfondo
- `text_color` - Colore del testo
- `cta_color` - Colore del bottone
- `show_contact_info` - Mostra sezione contatti
- `contact_email` - Email di contatto
- `contact_phone` - Telefono di contatto

#### Feature Sections View
**File**: `Themes/One/resources/views/components/blocks/feature_sections/register_disabled_info.blade.php`

**Caratteristiche**:
- Grid responsive (1 colonna su mobile, 2 su desktop)
- Card design con shadow e hover effects
- Supporto icone SVG personalizzate per ogni sezione
- Call-to-action opzionali per sezione
- Sezione informativa aggiuntiva in evidenza

**Proprietà supportate**:
- `title` - Titolo della sezione
- `description` - Descrizione opzionale
- `sections` - Array di sezioni con:
  - `title` - Titolo sezione
  - `description` - Descrizione (supporta HTML)
  - `icon` - Nome icona SVG
  - `cta_text` - Testo link opzionale
  - `cta_link` - URL link opzionale

### 3. Traduzioni

Create traduzioni complete per italiano, inglese e tedesco:

**File**:
- `Themes/One/lang/it/register_disabled.php`
- `Themes/One/lang/en/register_disabled.php`
- `Themes/One/lang/de/register_disabled.php`

**Chiavi tradotte**:
- `contact_info.title` - Titolo sezione contatti
- `back_to_home` - Testo link ritorno home
- `additional_info.title` - Titolo informazioni aggiuntive
- `additional_info.description` - Descrizione informazioni aggiuntive

### 4. Icone Supportate

Il sistema supporta le seguenti icone SVG:
- `information-circle` - Informazioni generali
- `clock` - Tempo/attesa
- `user-circle` - Account utente
- `support` - Assistenza/supporto
- `calendar` - Calendario/appuntamenti
- `check-circle` - Conferma/completato
- `exclamation-triangle` - Avviso/attenzione

## Configurazione Multilingua

La pagina supporta completamente la localizzazione con content_blocks separati per ogni lingua:

```json
{
    "content_blocks": {
        "it": [ /* blocchi in italiano */ ],
        "en": [ /* blocchi in inglese */ ]
    }
}
```

## Personalizzazione

### Colori e Stili
I colori possono essere personalizzati tramite le proprietà del blocco hero:
- `background_color`: Classe Tailwind per lo sfondo
- `text_color`: Classe Tailwind per il testo
- `cta_color`: Classe Tailwind per il bottone

### Contenuti Dinamici
- Tutti i testi possono essere personalizzati tramite il JSON
- Le icone possono essere cambiate modificando il valore `icon` nelle sezioni
- I link possono utilizzare helper Laravel come `{{ route('home') }}`

## Responsive Design

Entrambe le view sono completamente responsive:
- **Mobile**: Layout a colonna singola, testi ridotti
- **Tablet**: Layout intermedio con spacing ottimizzato
- **Desktop**: Layout completo con grid a 2 colonne per le feature sections

## Accessibilità

Le view includono:
- Attributi ARIA appropriati
- Contrasto colori adeguato
- Navigazione keyboard-friendly
- Icone con significato semantico
- Struttura HTML semantica

## Testing e Validazione

Per testare l'implementazione:

1. Verificare che le view esistano nei percorsi corretti
2. Controllare che le traduzioni siano caricate
3. Testare il rendering su diversi dispositivi
4. Validare che i link funzionino correttamente
5. Verificare l'accessibilità con screen reader

## Manutenzione

Per aggiornamenti futuri:
- Modificare il JSON per cambiare contenuti
- Aggiornare le view Blade per modifiche di layout
- Estendere le traduzioni per nuove lingue
- Aggiungere nuove icone nel switch delle feature sections

## Collegamenti

- [Sistema Content Blocks](./content_blocks_system.md)
- [Architettura Content Blocks](./content_blocks_architecture.md)
- [Documentazione Filament Builder](https://filamentphp.com/docs/3.x/forms/fields/builder)

*Implementazione completata: gennaio 2025*
