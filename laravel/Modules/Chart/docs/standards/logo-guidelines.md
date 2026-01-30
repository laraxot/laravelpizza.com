# Linee Guida per i Loghi

## Introduzione
Questo documento definisce gli standard e le linee guida per la gestione dei loghi nei progetti basati sui nostri moduli.

## Standard dei Loghi

### 1. Struttura dei File
```
Modules/
└── [NomeModulo]/
    └── resources/
        └── images/
            ├── logo.svg         # Logo principale
            ├── logo-dark.svg    # Versione dark
            └── favicon.ico      # Favicon
```

### 2. Formati Richiesti
- **SVG**: Logo principale e varianti (preferito per la scalabilità)
- **PNG**: Per fallback e casi specifici
- **ICO**: Per favicon
- **WebP**: Per ottimizzazione web

### 3. Dimensioni Standard
- Logo Header: 200x50px (proporzione 4:1)
- Logo Footer: 150x40px
- Favicon: 32x32px, 16x16px
- Touch Icon: 180x180px

### 4. Varianti Richieste
- Logo principale (light)
- Versione dark
- Versione monocromatica
- Versione icon-only
- Favicon

### 5. Specifiche Tecniche
- Formato vettoriale SVG
- Colori in RGB e CMYK
- Spazio di rispetto definito
- Griglia di allineamento
- Versioni responsive

## Implementazione

### 1. Configurazione
```php
// config/[domain]/metatag.php
return [
    'logo_header' => 'module::images/logo.svg',
    'logo_header_dark' => 'module::images/logo-dark.svg',
    'favicon' => 'module::images/favicon.ico',
    'touch_icon' => 'module::images/touch-icon.png'
];
```

### 2. Best Practices
- Utilizzare sempre percorsi relativi al modulo
- Fornire tutte le varianti richieste
- Mantenere la coerenza tra i formati
- Ottimizzare per il web
- Testare su diversi dispositivi

## Gestione Multi-tenant

### 1. Override dei Loghi
- Ogni tenant può avere i propri loghi
- Mantenere la stessa struttura di file
- Rispettare le specifiche tecniche
- Documentare le personalizzazioni

### 2. Struttura Tenant
```
config/
└── [tenant]/
    └── metatag.php    # Override configurazioni logo
```

## Accessibilità
- Fornire testo alternativo
- Mantenere contrasto sufficiente
- Testare con screen reader
- Supportare high contrast mode
- Implementare dark mode

## Performance
- Ottimizzare file SVG
- Comprimere PNG/JPG
- Utilizzare WebP con fallback
- Implementare lazy loading
- Caching appropriato

## Collegamenti
- [Configurazione Domini](../../laravel/Modules/Xot/docs/DOMAIN_CONFIGURATION.md)
- [Gestione Asset](../../laravel/Modules/Xot/docs/assets.md)
- [Gestione Media](../../laravel/Modules/Media/docs/README.md)
- [Standard UI](interface_guidelines.md)
- [Best Practices](best_practices.md)

## Vedi Anche
- [Documentazione UI](../../laravel/Modules/UI/docs/README.md)
- [Documentazione Temi](../../laravel/Modules/Cms/docs/themes.md)
- [Gestione Risorse](../../laravel/Modules/Xot/docs/ASSETS.md)
- [Configurazione Moduli](../../laravel/Modules/Xot/docs/MODULE_CONFIGURATION.md)

## Specifiche Tecniche SVG

1. **Struttura Base**:
   ```xml
   <svg viewBox="0 0 150 32" xmlns="http://www.w3.org/2000/svg">
       <!-- Icona -->
       <g id="icon">
           <!-- Paths dell'icona -->
       </g>
       
       <!-- Testo -->
       <g id="text">
           <!-- Testo come paths, non come elemento text -->
       </g>
   </svg>
   ```

2. **Requisiti**:
   - Utilizzare `viewBox` invece di dimensioni fisse
   - Convertire il testo in paths
   - Includere attributi di accessibilità
   - Supportare dark mode con classi CSS

3. **Accessibilità**:
   ```xml
   <svg role="img" aria-label="Base">
       <title>Base</title>
       <!-- Contenuto SVG -->
   </svg>
   ```

4. **Dark Mode**:
   ```xml
   <svg class="logo-light dark:logo-dark">
       <!-- Paths con classi per colore -->
       <path class="fill-primary-600 dark:fill-primary-400" />
   </svg>
   ```

## Best Practices

1. **Dimensioni**:
   - Mantenere aspect ratio 4.6875:1 (150:32)
   - Utilizzare viewBox per scalabilità
   - Evitare dimensioni fisse

2. **Colori**:
   - Light mode: Primary-600 (#3B82F6)
   - Dark mode: Primary-400 (#60A5FA)
   - Testo: Gray-900 (#1F2937) / Gray-100 (#F3F4F6)

3. **Accessibilità**:
   - Includere sempre `role="img"`
   - Fornire `aria-label`
   - Aggiungere `<title>`
   - Mantenere contrasto minimo 4.5:1

4. **Performance**:
   - Ottimizzare paths
   - Minimizzare il codice
   - Utilizzare classi CSS per colori
   - Evitare elementi text

## Esempio di Implementazione

```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg viewBox="0 0 150 32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Base">
    <title>Base</title>
    
    <!-- Icona -->
    <g id="icon" class="fill-primary-600 dark:fill-primary-400">
        <path d="M16 4C9.37258 4 4 9.37258 4 16C4 22.6274 9.37258 28 16 28C22.6274 28 28 22.6274 28 16C28 9.37258 22.6274 4 16 4ZM16 6C21.5228 6 26 10.4772 26 16C26 21.5228 21.5228 26 16 26C10.4772 26 6 21.5228 6 16C6 10.4772 10.4772 6 16 6Z"/>
        <!-- Altri paths -->
    </g>
    
    <!-- Testo come paths -->
    <g id="text" class="fill-gray-900 dark:fill-gray-100">
        <!-- Paths del testo -->
    </g>
</svg>
```

## Verifica

Prima di utilizzare un logo SVG:
1. Verificare la scalabilità
2. Testare dark mode
3. Controllare accessibilità
4. Ottimizzare performance
5. Validare con validator.w3.org 

## Generazione dei Paths del Testo

1. **Strumenti**:
   - Utilizzare [FontForge](https://fontforge.org/) per convertire testo in paths
   - Oppure [SVGOMG](https://jakearchibald.github.io/svgomg/) per ottimizzare i paths
   - O [Inkscape](https://inkscape.org/) per la conversione manuale

2. **Processo**:
   ```bash
   # Esempio con Inkscape
   inkscape --export-text-to-path --export-filename=logo-text.svg logo.svg
   ```

3. **Ottimizzazione**:
   - Rimuovere nodi non necessari
   - Unire paths sovrapposti
   - Semplificare curve complesse
   - Mantenere la leggibilità

4. **Verifica**:
   - Controllare la leggibilità a diverse dimensioni
   - Verificare la qualità dei bordi
   - Assicurarsi che i paths siano chiusi
   - Testare la scalabilità

## Esempio di Paths Ottimizzati

```xml
<!-- Testo "Base" ottimizzato -->
<g id="text" class="fill-gray-900 dark:fill-gray-100">
    <!-- Lettera S -->
    <path d="M40 8c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2v2c0 1.1-.9 2-2 2H42c-1.1 0-2-.9-2-2V8z"/>
    <!-- Altre lettere con paths ottimizzati -->
</g>
```

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Configurazione e Risoluzione dei Loghi](../configurazione-logo.md) - Indice generale sulla gestione dei loghi
- [Struttura dei Moduli in Base](../struttura-moduli.md) - Struttura dei moduli nel progetto
- [Architettura Folio + Volt in Base](../architettura-folio-volt.md) - Implementazione di Folio e Volt

### Collegamenti ai Moduli
- [Risoluzione dei Loghi](../../laravel/Modules/Xot/docs/LOGO_RESOLUTION.md) - Processo tecnico di risoluzione dei loghi
- [Gestione Domini e Configurazioni](../../laravel/Modules/Xot/docs/DOMAIN_CONFIGURATION.md) - Struttura delle configurazioni specifiche per dominio
- [Struttura Standard dei Moduli](../../laravel/Modules/Xot/docs/MODULE_STRUCTURE.md) - Convenzioni di naming e struttura
- [Architettura Folio + Volt](../../laravel/Modules/Xot/docs/FOLIO_VOLT_ARCHITECTURE.md) - Documentazione generale su Folio e Volt

---

### Nota Importante
Queste linee guida si applicano a tutti i loghi SVG utilizzati nel progetto. Assicurarsi di seguire queste specifiche per garantire coerenza, accessibilità e supporto per la dark mode.
