# Widget Responsivi per Form di Registrazione

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo User.
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/blocks/filament-component-integration.md#layout-responsivo-dei-widget-filament).
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/project_docs/blocks/filament-component-integration.md#layout-responsivo-dei-widget-filament).
## Problema
Il form di registrazione alla rotta `/it/auth/patient/register` appare troppo stretto orizzontalmente, con un'esperienza utente non ottimale sui dispositivi desktop e altri schermi ampi.
## Causa
Il template `Themes/One/resources/views/filament/widgets/registration.blade.php` utilizzato dal `RegistrationWidget` utilizza una classe `max-w-lg` (32rem/512px) che limita eccessivamente la larghezza del form, specialmente per form complessi come quelli di registrazione multi-step.
```blade
<!-- Template attuale con limitazione di larghezza -->
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="max-w-lg mx-auto">
            <form wire:submit.prevent="register" class="space-y-6">
                {{ $this->form }}
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```
## Soluzione
Sostituire `max-w-lg` con `max-w-4xl` o rimuovere completamente la limitazione di larghezza per i form wizard multi-step.
<!-- Template migliorato con larghezza adeguata -->
        <div class="max-w-4xl mx-auto">
## Regola Applicativa
I form Filament complessi, in particolare quelli di registrazione e wizard multi-step, devono utilizzare le seguenti linee guida per la larghezza:
- Form semplici (1-3 campi): `max-w-lg` (32rem/512px)
- Form di media complessità (4-8 campi): `max-w-3xl` (48rem/768px)
- Form complessi (>8 campi o multi-step): `max-w-4xl` (56rem/896px)
- Wizard con layout a griglia complessi: Nessuna limitazione di larghezza
## Documentazione Correlata
- [Layout Responsivo dei Widget Filament](../../../UI/docs/blocks/filament-component-integration.md#layout-responsivo-dei-widget-filament)
- [Best Practices per i Form Filament](../../../UI/docs/filament/form-best-practices.md)
- [Implementazione Corretta dei Widget](../../../Xot/docs/filament-widgets.md)
- [Layout Responsivo dei Widget Filament](../../../UI/project_docs/blocks/filament-component-integration.md#layout-responsivo-dei-widget-filament)
- [Best Practices per i Form Filament](../../../UI/project_docs/filament/form-best-practices.md)
- [Implementazione Corretta dei Widget](../../../Xot/project_docs/filament-widgets.md)
