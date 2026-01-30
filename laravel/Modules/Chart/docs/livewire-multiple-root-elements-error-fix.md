# Livewire Multiple Root Elements Error Fix

## Problema Identificato

### Errore
```
Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException
Livewire only supports one HTML element per component. Multiple root elements detected for component: [modules.salute-ora.filament.widgets.doctor-appointments-widget]
```

### Causa del Problema

Livewire richiede che ogni componente abbia **UN SOLO** elemento root HTML. Il widget `DoctorAppointmentsWidget` aveva multiple root elements:

1. **Elemento Principal**: `<x-filament::widget>`
2. **Elemento Secondario**: `<x-filament-actions::modals />`
3. **Script Tag**: `<script>` (che può anche essere considerato root)

### Template Problematico

```blade
<!-- ❌ ERRORE: Multiple root elements -->
<x-filament::widget>
    <!-- contenuto widget -->
</x-filament::widget> 

{{-- Script separato = secondo elemento root --}}
<script>
    document.addEventListener('livewire:init', function () {
        // logica notifiche
    });
</script>

<!-- ❌ ERRORE: Terzo elemento root -->
<x-filament-actions::modals />
```

## Soluzione Implementata

### Template Corretto - Single Root Element

```blade
<x-filament::widget>
    <div class="space-y-4 max-h-96 overflow-y-auto">
        @if($this->appointments->isNotEmpty())
            @each('pub_theme::appointment.doctor-pending-item', $this->appointments, 'appointment')
        @else
            <div class="text-center py-12">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-13.5h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008ZM5.25 15h.008v.008H5.25V15Zm0 2.25h.008v.008H5.25v-.008ZM3 15h.008v.008H3V15Zm0 2.25h.008v.008H3v-.008ZM14.25 15h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008ZM16.5 15h.008v.008H16.5V15Zm0 2.25h.008v.008H16.5v-.008ZM18.75 15h.008v.008H18.75V15Zm0 2.25h.008v.008H18.75v-.008ZM21 15h.008v.008H21V15Zm0 2.25h.008v.008H21v-.008Z" />
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ __('<nome progetto>::widgets.doctor_appointments.empty.title') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('<nome progetto>::widgets.doctor_appointments.empty.description') }}
                </p>
            </div>
        @endif
    </div>
    
    {{-- ✅ CORRETTO: Script dentro l'elemento root --}}
    @push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('notify', (event) => {
                const notification = event;
                if (window.$wireui) {
                    window.$wireui.notify({
                        title: notification.title || (notification.type === 'success' ? 'Successo' : 'Errore'),
                        description: notification.message,
                        icon: notification.type,
                    });
                } else if (window.notifier) {
                    window.notifier.show(notification.message, notification.type);
                } else {
                    console.log(`${notification.type}: ${notification.message}`);
                }
            });
        });
    </script>
    @endpush
    
    {{-- ✅ CORRETTO: Modals inclusi dentro l'elemento root --}}
    <x-filament-actions::modals />
</x-filament::widget>
```

### Correzione Problema Azione Missing

Il template `doctor-pending-item.blade.php` stava cercando `{{ $this->deleteAction }}` che non esisteva. Corretto rimuovendo la chiamata:

```blade
<!-- ❌ ERRORE nel doctor-pending-item.blade.php -->
{{ $this->deleteAction }}

<!-- ✅ CORRETTO: Rimosso, azioni gestite tramite Livewire calls -->
<!-- Le azioni sono già implementate tramite wire:click -->
```

## Principi della Soluzione

### 1. Single Root Element Rule
- **SEMPRE** un solo elemento root per componente Livewire
- **MAI** elementi sibling al livello root
- **SEMPRE** nidificare contenuti dentro l'elemento principale

### 2. Script Management
- **Usare** `@push('scripts')` per script esterni
- **Evitare** script tag a livello root
- **Incapsulare** logica JavaScript dentro l'elemento widget

### 3. Modals Integration
- **Includere** `<x-filament-actions::modals />` DENTRO l'elemento root
- **NON** posizionare come elemento sibling
- **Assicurarsi** che le azioni siano correttamente configurate nel widget

### 4. Actions Configuration
- **Implementare** `InteractsWithActions` trait nel widget
- **Definire** azioni come metodi che restituiscono `Action`
- **Gestire** chiamate tramite `wire:click` nei template

## Pattern Architetturale

### Widget con Azioni Filament
```php
class DoctorAppointmentsWidget extends XotBaseWidget
{
    use InteractsWithActions;
    
    // ✅ Azione definita correttamente
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->action(fn () => $this->handleDelete());
    }
    
    // ✅ Metodi Livewire per interazioni dirette
    public function confirmAppointment(int $appointmentId): void
    {
        // Logica conferma tramite wire:click
    }
}
```

### Template Structure ✅
```blade
<x-filament::widget>
    <!-- TUTTO il contenuto dentro UN SOLO root element -->
    <div class="widget-content">
        <!-- Contenuto principale -->
    </div>
    
    <!-- Scripts e modals DENTRO il root element -->
    @push('scripts')
    <script>
        // JavaScript logic
    </script>
    @endpush
    
    <x-filament-actions::modals />
</x-filament::widget>
```

## Debugging e Prevenzione

### Identificazione Problema
```bash

# Cerca elementi root multipli nei template
grep -n "^<" widget-template.blade.php

# Verifica struttura Livewire
php artisan livewire:list
```

### Testing
```php
// Test che il widget si renderizzi senza errori
public function test_widget_renders_without_multiple_root_elements()
{
    $this->actingAs($doctor)
        ->get('/doctor-dashboard')
        ->assertStatus(200)
        ->assertSeeLivewire(DoctorAppointmentsWidget::class);
}
```

### Linee Guida Preventive
1. **Template Validation**: Sempre verificare un solo elemento root
2. **Script Management**: Usare `@push('scripts')` o Alpine.js inline
3. **Component Structure**: Nidificare tutto dentro il root element
4. **Action Integration**: Usare trait `InteractsWithActions` correttamente

## Errori Comuni da Evitare

### ❌ Multiple Root Elements
```blade
<div>Content 1</div>
<div>Content 2</div>  <!-- ERRORE: Secondo root element -->
```

### ❌ Script Tag Separato
```blade
<x-filament::widget>...</x-filament::widget>
<script>...</script>  <!-- ERRORE: Script a livello root -->
```

### ❌ Modals Esterni
```blade
<x-filament::widget>...</x-filament::widget>
<x-filament-actions::modals />  <!-- ERRORE: Modals esterni -->
```

### ✅ Struttura Corretta
```blade
<x-filament::widget>
    <!-- Tutto nidificato qui -->
    <div>Content</div>
    
    @push('scripts')
    <script>...</script>
    @endpush
    
    <x-filament-actions::modals />
</x-filament::widget>
```

## Riferimenti

- [Livewire Documentation - Single Root Element](https://livewire.laravel.com/docs/components#single-root-element)
- [Filament Actions Documentation](https://filamentphp.com/docs/3.x/actions/overview)
- [laravel/Modules/<nome progetto>/docs/widgets/doctor-appointments-widget-fix.md](../laravel/Modules/<nome progetto>/docs/widgets/doctor-appointments-widget-fix.md)

*Ultimo aggiornamento: 2025-01-03*
*Autore: AI Assistant*
