# Guida a Flux UI - Laraxot PTVX

Flux UI è la libreria di componenti ufficiale per Livewire, integrata nel progetto per garantire accessibilità e stile coerente.

## 1. Principi di Base
- **Tailwind v4**: Tutti i componenti Flux sono ottimizzati per l'engine v4.
- **Accessibilità**: I componenti seguono gli standard WAI-ARIA.
- **Coerenza**: Usare Flux per TUTTI gli elementi UI del frontend (tema Zero).

## 2. Componenti Comuni
### Button
```blade
<flux:button wire:click="save" variant="primary">
    Salva Survey
</flux:button>
```

### Input & Form
```blade
<flux:field>
    <flux:label>Nome Utente</flux:label>
    <flux:input wire:model="name" placeholder="Inserisci nome..." />
    <flux:error name="name" />
</flux:field>
```

### Modal
```blade
<flux:modal name="confirm-deletion">
    <div class="p-6">
        <flux:heading>Sei sicuro?</flux:heading>
        <flux:subheading>L'azione è irreversibile.</flux:subheading>
        <div class="mt-4 flex gap-2">
            <flux:button x-on:click="$modal.close('confirm-deletion')">Annulla</flux:button>
            <flux:button variant="danger">Elimina</flux:button>
        </div>
    </div>
</flux:modal>
```

## 3. Customizzazione
Evitare di sovrascrivere gli stili base di Flux con CSS custom. Usare invece le utility classes di Tailwind v4 direttamente sui componenti tramite l'attributo `class`.
