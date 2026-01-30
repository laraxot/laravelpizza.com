# Chart Module - Icon Design

## Concetto Design
L'icona del modulo Chart rappresenta la visualizzazione e analisi dei dati attraverso grafici interattivi.

## Elementi Visivi
- **Assi cartesiani**: Base per tutti i grafici
- **Barre colorate**: Rappresentano dati categorici con altezze variabili
- **Linea di trend**: Mostra l'andamento temporale dei dati
- **Punti dati**: Evidenziano valori specifici sulla linea di trend

## Animazioni
### drawLine (2s, infinite alternate)
- **Effetto**: La linea di trend si disegna progressivamente
- **Tecnica**: `stroke-dasharray` che passa da `0 20` a `20 0`
- **Scopo**: Simula il caricamento dinamico dei dati

### growBar (1.5s, infinite alternate)
- **Effetto**: Le barre crescono e si riducono leggermente
- **Tecnica**: `scaleY` da `0.8` a `1.0`
- **Scopo**: Indica l'aggiornamento continuo dei dati

### pulse (2s, infinite)
- **Effetto**: I punti dati pulsano e cambiano dimensione
- **Tecnica**: `scale` e `opacity` combinati
- **Scopo**: Attira l'attenzione sui valori importanti

## Accessibilità
- Supporto `prefers-reduced-motion` per disabilitare animazioni
- Uso di `currentColor` per adattamento automatico ai temi
- Opacità variabile per creare profondità senza dipendere dal colore

## Utilizzo
```php
// Nel ServiceProvider del modulo Chart
FilamentIcon::register([
    'chart-icon' => 'chart-icon',
]);
```

## Collegamenti
- [Design System Globale](../../../../docs/module-icons-design-system.md)
- [Chart Module Documentation](./README.md)

*Creato: Agosto 2025*
