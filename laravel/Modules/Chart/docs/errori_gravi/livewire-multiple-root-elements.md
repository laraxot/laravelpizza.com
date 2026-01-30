# Errore: Livewire Multiple Root Elements

## Descrizione dell'Errore
```
Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException
Livewire only supports one HTML element per component. Multiple root elements detected for component: [modules.salute-ora.filament.widgets.patient.find-doctor-and-appointment-widget]
```

## Contesto
Questo errore si verifica quando un componente Livewire contiene più elementi HTML root nel suo template Blade. Livewire richiede che ci sia un solo elemento root che contenga tutti gli altri elementi.

## Cause Comuni
1. Div annidati non necessari
2. Commenti HTML che creano elementi root aggiuntivi
3. Struttura del template non ottimizzata
4. Stili CSS che richiedono wrapper aggiuntivi

## Impatto
- Il componente non viene renderizzato
- Interruzione del flusso utente
- Potenziale perdita di dati
- Degrado dell'esperienza utente

## Soluzione
1. Identificare tutti gli elementi root nel template
2. Consolidare gli elementi in un unico wrapper
3. Spostare gli stili CSS in un file separato o in un tag `<style>` all'interno dell'unico elemento root
4. Verificare che i commenti HTML non creino elementi root aggiuntivi

## Best Practices
1. Mantenere una struttura HTML pulita e semantica
2. Utilizzare classi CSS per lo styling invece di elementi wrapper aggiuntivi
3. Documentare la struttura del template per facilitare la manutenzione
4. Implementare test per verificare la corretta struttura del template

## Collegamenti Correlati
- [Livewire Documentation](https://livewire.laravel.com/docs/rendering-components)
- [Blade Templates Best Practices](../standards/blade-templates.md)
- [Component Structure Guidelines](../standards/component-structure.md)
- [Error Handling Standards](../standards/error-handling.md)
- [UI/UX Guidelines](../standards/ui-ux-guidelines.md)

## Esempio di Correzione
```blade
{{-- ❌ Errore: Multiple root elements --}}
<div class="wrapper">
<div class="content">
    {{ $slot }}
</div>
</div>

{{-- ✅ Corretto: Single root element --}}
<div class="wrapper">
    <div class="content">
        {{ $slot }}
    </div>
</div>
```

## Checklist di Verifica
- [ ] Identificato l'elemento root principale
- [ ] Rimossi elementi wrapper non necessari
- [ ] Consolidati gli stili CSS
- [ ] Verificata la semantica HTML
- [ ] Testato il componente
- [ ] Aggiornata la documentazione
- [ ] Verificata la compatibilità con altri componenti 