# Sistema di Design per Icone SVG dei Moduli

## Principi di Design

### Coerenza Visiva

- **Viewbox standardizzato**: `0 0 24 24` per tutte le icone
- **Stroke width**: `1.5` come standard, `1` per dettagli fini, `2` per elementi enfatizzati
- **Colore**: Utilizzo di `currentColor` per adattarsi automaticamente al tema
- **Accessibilità**: `aria-hidden="true"` e `role="img"` per screen reader

### Animazioni Sottili

- **Durata**: 1.5-3 secondi per cicli completi
- **Easing**: `ease-in-out` per movimenti naturali
- **Rispetto accessibilità**: `@media (prefers-reduced-motion: reduce)` disabilita animazioni
- **Performance**: Animazioni CSS invece di JavaScript

### Supporto Dark Theme

- **Opacità variabile**: Utilizzata per creare profondità senza colori fissi
- **currentColor**: Si adatta automaticamente al tema corrente
- **Contrasti**: Testati sia in light che dark mode

## Icone per Modulo

### Chart Module
**Concetto**: Visualizzazione dati con grafici a barre e linee di trend
**Animazioni**:
- Barre che crescono (`growBar`)
- Linea che si disegna (`drawLine`)
- Punti che pulsano (`pulse`)

### CMS Module
**Concetto**: Gestione contenuti con documento e strumenti di editing
**Animazioni**:
- Pagina che scivola (`slideIn`)
- Testo che appare come macchina da scrivere (`typewriter`)
- Icona di modifica che pulsa (`editPulse`)

### Geo Module
**Concetto**: Localizzazione geografica con globo e pin
**Animazioni**:
- Pin che rimbalza (`bounce`)
- Cerchi di localizzazione che si espandono (`ripple`)
- Globo che ruota lentamente (`rotate`)

### <nome progetto> Module
**Concetto**: Salute e medicina con cuore e simboli medici
**Animazioni**:
- Cuore che batte (`heartbeat`)
- Croce medica che brilla (`glow`)
- Linea del battito cardiaco (`pulse`)

### FormBuilder Module (Migliorato)
**Concetto**: Costruzione form con campi e strumenti
**Animazioni**:
- Campi che scivolano verso l'alto (`slideUp`)
- Cursore che lampeggia (`blink`)
- Checkbox che si anima (`checkmark`)

## Linee Guida Tecniche

### Struttura File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img">
    <style>
        /* Animazioni CSS */
        @media (prefers-reduced-motion: reduce) {
            * { animation: none; }
        }
    </style>
    <!-- Contenuto SVG -->
</svg>
```

### Best Practices
1. **Posizionamento**: Ogni modulo deve avere `resources/svg/icon.svg`
2. **Naming**: File sempre chiamato `icon.svg`
3. **Dimensioni**: Ottimizzato per 24x24px ma scalabile
4. **Performance**: Animazioni leggere, max 3 elementi animati per icona
5. **Semantica**: Icona deve rappresentare chiaramente la funzione del modulo

### Registrazione nei ServiceProvider
```php
// Nel ServiceProvider del modulo
FilamentAsset::register([
    Svg::make('module-icon', __DIR__.'/../resources/svg/icon.svg'),
], $this->module_name);

FilamentIcon::register([
    'module-prefix-icon' => 'module-icon',
]);
```

### Utilizzo nei File di Traduzione
```php
// Modules/{ModuleName}/lang/it/navigation.php
return [
    'label' => 'Nome Modulo',
    'icon' => 'module-prefix-icon',
];
```

## Validazione Design

### Checklist Qualità
- [ ] Icona rappresenta chiaramente la funzione del modulo
- [ ] Animazioni sono sottili e non distraggono
- [ ] Supporta sia light che dark theme
- [ ] Rispetta le preferenze di accessibilità
- [ ] File ottimizzato (< 5KB)
- [ ] Testato su diverse dimensioni (16px, 24px, 32px)

### Test di Compatibilità
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Mobile browsers

## Manutenzione

### Aggiornamenti
- Mantenere coerenza con il design system esistente
- Testare sempre in entrambi i temi (light/dark)
- Validare accessibilità dopo ogni modifica
- Documentare cambiamenti significativi

### Troubleshooting
- **Icona non appare**: Verificare registrazione nel ServiceProvider
- **Animazione non funziona**: Controllare supporto CSS animations nel browser
- **Colori sbagliati**: Verificare uso di `currentColor` invece di colori fissi

## Collegamenti
- [UI Module Icons](../laravel/Modules/UI/docs/icons.md)
- [Filament Icon Registration](../laravel/Modules/Xot/docs/filament-assets.md)
- [Accessibility Guidelines](../docs/accessibility-standards.md)

*Ultimo aggiornamento: Agosto 2025*
