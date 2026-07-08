# Icone dei Moduli Laravel

## Struttura e Convenzioni

### 1. Posizione File SVG
Le icone SVG devono essere posizionate nella cartella `resources/svg` del modulo:
```
ModuloEsempio/
├── resources/
│   └── svg/
│       ├── icon1.svg
│       └── icon2.svg
```

### 2. Convenzione Nomi
Per garantire la corretta associazione tra file SVG e riferimenti nelle traduzioni:

1. **File SVG**: 
   - Nome in inglese
   - Kebab-case (parole separate da trattini)
   - Esempio: `team-work.svg`

2. **Riferimento nelle Traduzioni**:
   ```php
   // ✅ CORRETTO
   'navigation' => [
       'label' => 'Gruppo di Lavoro',
       'icon' => 'incentivi-team-work' // {module-name}-{svg-name}
   ]
   ```

### 3. Integrazione con Filament
Per far funzionare le icone in Filament:

1. **Registrazione Icone**
   Nel service provider del modulo:
   ```php
   use Filament\Support\Assets\Svg;
   use Filament\Support\Facades\FilamentAsset;

   public function boot()
   {
       FilamentAsset::register([
           Svg::make('incentivi-team-work', __DIR__ . '/../resources/svg/team-work.svg'),
           // Registra altre icone...
       ]);
   }
   ```

2. **Uso nelle Traduzioni**
   ```php
   return [
       'navigation' => [
           'label' => 'Gruppo di Lavoro',
           'icon' => 'incentivi-team-work',
       ]
   ];
   ```

### 4. Requisiti SVG
Le icone SVG devono:
1. Usare `class="fill-current"` per il colore
2. Avere dimensioni 24x24 pixels
3. Usare `viewBox="0 0 24 24"`
4. Non includere colori hardcoded

Esempio SVG corretto:
```svg
<svg 
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24" 
    viewBox="0 0 24 24"
    fill="none"
>
    <path 
        class="fill-current"
        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
    />
</svg>
```

### 5. Errori Comuni da Evitare
❌ **NON FARE**:
- Usare animazioni CSS/SVG complesse che potrebbero impattare le performance
- Includere stili inline o `<style>` tag
- Usare colori fissi invece di `class="fill-current"`
- Dimenticare di registrare l'icona nel service provider
- Usare nomi di file diversi dal riferimento nelle traduzioni

✅ **FARE**:
- Usare SVG semplici e ottimizzati
- Mantenere la consistenza tra nome file e riferimento
- Registrare tutte le icone nel service provider
- Testare le icone in modalità light e dark
# Documentazione Icone Modulo Incentivi

## Linee Guida per le Icone SVG

### 1. Struttura Base
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" 
     width="24" 
     height="24" 
     viewBox="0 0 24 24" 
     fill="none" 
     stroke="currentColor" 
     stroke-width="2" 
     stroke-linecap="round" 
     stroke-linejoin="round">
    <!-- Stili e contenuto -->
</svg>
```

### 2. Stile Outline
- Utilizzare `stroke="currentColor"` invece di `fill="currentColor"`
- Impostare `fill="none"` per elementi che devono essere solo outline
- Mantenere uno `stroke-width="2"` uniforme
- Usare `stroke-linecap="round"` e `stroke-linejoin="round"` per angoli smussati

### 3. Animazioni
```xml
<style>
    .main-element {
        transform-origin: center;
        transition: all 0.3s ease-in-out;
    }
    svg:hover .main-element {
        transform: scale(1.1);
    }
    .secondary-element {
        transition: transform 0.3s ease-in-out;
        transform-origin: center;
    }
    svg:hover .secondary-element {
        transform: rotate(15deg);
    }
</style>
```

### 4. Convenzioni di Nomenclatura
- File: `kebab-case.svg` (es. `capital-percentage.svg`)
- Riferimenti nei file di traduzione: `incentivi-nome-icona`
- Classi CSS: `kebab-case` per elementi multipli (es. `main-element`)

### 5. Organizzazione del Codice
```xml
<!-- Gruppo principale con animazione di scala -->
<g class="main-element">
    <!-- Elementi di base -->
</g>

<!-- Elementi secondari con animazioni specifiche -->
<g class="secondary-element">
    <!-- Dettagli animati -->
</g>
```

### 6. Best Practices per le Animazioni
- Scala principale: `transform: scale(1.1)`
- Rotazioni: tra 10° e 180° in base al contesto
- Traslazioni: `translateY(-2px)` per effetto di sollevamento
- Durata transizione: `0.3s` con `ease-in-out`
- Origine trasformazione: `transform-origin: center`

### 7. Esempi di Icone

#### Activity Icon
```xml
<g class="checklist">
    <rect x="4" y="2" width="16" height="20" rx="2" class="stroke-current" fill="none"/>
    <line x1="8" y1="6" x2="16" y2="6" class="stroke-current"/>
</g>
<g class="check">
    <line x1="8" y1="11" x2="16" y2="11" class="stroke-current"/>
    <polyline points="6,11 7,12 9,10" class="stroke-current"/>
</g>
```

#### Project Board
```xml
<g class="board">
    <rect x="3" y="3" width="18" height="18" rx="2" class="stroke-current" fill="none"/>
    <line x1="9" y1="3" x2="9" y2="21" class="stroke-current"/>
</g>
<g class="cards">
    <rect x="4" y="6" width="4" height="3" rx="1" class="stroke-current" fill="none"/>
</g>
```

### 8. File di Traduzione
```php
'navigation' => [
    'name' => 'Nome Sezione',
    'plural' => 'Nomi Sezioni',
    'group' => [
        'name' => 'Incentivi',
    ],
    'label' => 'Nome Sezione',
    'icon' => 'incentivi-nome-icona',
    'sort' => 50,
],
```

### 9. Dimensioni e Viewport
- Dimensione file: 24x24 pixel
- ViewBox: "0 0 24 24"
- Area di lavoro effettiva: 18x18 pixel (margine di 3px)
- Raggio angoli: 2px per elementi principali, 1px per elementi secondari

### 10. Compatibilità
- Testare le icone in modalità chiara e scura
- Verificare la visibilità con diversi spessori di stroke
- Assicurarsi che le animazioni non interferiscano con il layout
- Mantenere le dimensioni dei file SVG ottimizzate
