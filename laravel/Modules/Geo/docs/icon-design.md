# Geo Module - Icon Design

## Concetto Design
L'icona del modulo Geo rappresenta la localizzazione geografica attraverso un globo terrestre con pin di localizzazione.

## Elementi Visivi
- **Globo terrestre**: Rappresenta il contesto geografico globale
- **Linee di latitudine/longitudine**: Griglia geografica
- **Area di focus**: Cerchio che evidenzia una zona specifica
- **Pin di localizzazione**: Marcatore principale per la posizione
- **Punti di interesse**: Indicatori secondari sparsi sulla mappa

## Animazioni

### bounce (2s, infinite)
- **Effetto**: Il pin di localizzazione rimbalza delicatamente
- **Tecnica**: `translateY` da `0` a `-2px`
- **Scopo**: Attira l'attenzione sulla posizione principale

### ripple (3s, infinite)
- **Effetto**: L'area di focus si espande e contrae come un'onda
- **Tecnica**: `scale` da `1` a `1.1` con variazione di opacità
- **Scopo**: Simula la ricerca o il rilevamento di posizioni

### rotate (8s, linear infinite)
- **Effetto**: Il globo ruota lentamente su se stesso
- **Tecnica**: `rotate` da `0deg` a `360deg`
- **Scopo**: Indica la natura dinamica e globale del sistema

## Accessibilità
- Supporto `prefers-reduced-motion` per disabilitare animazioni
- Uso di `currentColor` per adattamento automatico ai temi
- Opacità variabile per distinguere elementi primari e secondari

## Utilizzo
```php
// Nel ServiceProvider del modulo Geo
FilamentIcon::register([
    'geo-icon' => 'geo-icon',
]);
```

## Collegamenti
- [Design System Globale](../../../../docs/module-icons-design-system.md)
- [Geo Module Documentation](./README.md)

*Creato: Agosto 2025*
