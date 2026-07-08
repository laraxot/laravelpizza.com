# Implementazione Chart.js Datalabels in Filament 5.x - Tema Zero

## Overview

Il tema Zero implementa il plugin `chartjs-plugin-datalabels` per migliorare l'esperienza utente nei widget grafici. L'implementazione segue i principi DRY + KISS e si integra perfettamente con l'architettura del modulo Chart.

## Pattern UI/UX Avanzato: Labels Multiple Centrate

Il tema supporta l'implementazione avanzata con **due labels centrate** per ogni barra:
- **Label "value"**: Posizionata centrata sopra la barra per mostrare il valore principale
- **Label "month"**: Posizionata centrata sotto la barra per mostrare l'etichetta temporale

### Configurazione UI/UX Ottimizzata

```javascript
{
  plugins: {
    datalabels: {
      clip: false,
      clamp: true,
      labels: {
        // Label principale centrata sopra la barra
        value: {
          anchor: 'end',
          align: 'center',
          offset: 8,
          color: '#1f2937',
          backgroundColor: 'rgba(255, 255, 255, 0.95)',
          borderColor: 'rgba(229, 231, 235, 1)',
          borderWidth: 1,
          borderRadius: 12,
          padding: {top: 4, bottom: 4, left: 10, right: 10},
          font: {weight: 'bold', size: 11},
          formatter: 'function(v) { return v || ""; }',
          display: 'function(ctx) { return (ctx.dataset.data[ctx.dataIndex] || 0) > 0; }'
        },
        // Label secondaria centrata sotto la barra
        month: {
          anchor: 'start',
          align: 'center',
          offset: 8,
          color: '#6b7280',
          backgroundColor: 'rgba(249, 250, 251, 0.9)',
          borderColor: 'rgba(229, 231, 235, 0.8)',
          borderWidth: 1,
          borderRadius: 10,
          padding: {top: 3, bottom: 3, left: 8, right: 8},
          font: {weight: '500', size: 10},
          formatter: 'function(v, ctx) {
            var labels = ctx.chart.data.labels || [];
            return labels[ctx.dataIndex] || "";
          }',
          display: 'function(ctx) {
            return (ctx.dataset.data[ctx.dataIndex] || 0) > 0;
          }'
        }
      }
    }
  }
}
```

### Vantaggi del Pattern Centrato

1. **Chiara Separazione**: Le informazioni principali e secondarie sono visivamente separate
2. **Allineamento Perfetto**: Le labels sono perfettamente allineate con le barre
3. **Gerarchia Visiva**: Diversi stili distinguono chiaramente i tipi di informazioni
4. **Migliore Leggibilità**: Spaziatura e stili ottimizzati migliorano la leggibilità

## Asset Registration

I plugin Chart.js sono centralizzati nel modulo Chart come definito dalla [chart-assets-centralization-rule.md](../../../Modules/Chart/docs/chart-assets-centralization-rule.md). Il tema Zero eredita automaticamente questi asset senza necessità di registrazione locale.

## Best Practices per lo Sviluppo

- Usa sempre il modulo Chart per la registrazione degli asset
- Segui il pattern delle labels multiple centrate per coerenza visiva
- Applica sfondi semi-trasparenti per migliorare il contrasto
- Usa angoli arrotondati e padding generoso per un aspetto moderno

## Riferimenti

- [Chart.js Documentation](https://www.chartjs.org/docs/latest/)
- [Filament 5.x Charts](https://filamentphp.com/docs/5.x/widgets/charts)
- [chartjs-plugin-datalabels](https://chartjs-plugin-datalabels.netlify.app/)
- [Multiple Labels Complete Guide](../../../Modules/Chart/docs/chartjs-datalabels-multiple-labels-complete-guide.md)