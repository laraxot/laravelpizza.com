# Componente Calendar Frontend per <nome progetto>

## Panoramica

Il componente `pub_theme::components.blocks.calendar` fornisce un'interfaccia frontend **semplificata** per richiamare i widget FullCalendar del modulo <nome progetto>. 

**IMPORTANTE**: Il componente NON ricrea il calendario, ma richiama direttamente i widget Filament esistenti tramite Livewire.

## Filosofia di Design

### Principio DRY (Don't Repeat Yourself)
- **NON ricreare** la logica del calendario nel frontend
- **Riutilizzare** i widget Filament già implementati
- **Mantenere** una singola fonte di verità per la logica del calendario

### Principio KISS (Keep It Simple, Stupid)
- Il componente Blade deve essere **minimalista**
- **Delegare** tutta la logica ai widget Filament
- **Evitare** duplicazione di codice e configurazioni

## Architettura Corretta

### Struttura Semplificata
```blade
{{-- laravel/Themes/One/resources/views/components/blocks/calendar.blade.php --}}
@props([
    'type' => 'patient', // patient|doctor|admin
])

@php
    $widgetClass = match($type) {
        'patient' => \Modules\<nome progetto>\Filament\Widgets\PatientCalendarWidget::class,
        'doctor' => \Modules\<nome progetto>\Filament\Widgets\DoctorCalendarWidget::class,
        'admin' => \Modules\<nome progetto>\Filament\Widgets\AdminCalendarWidget::class,
        default => \Modules\<nome progetto>\Filament\Widgets\PatientCalendarWidget::class,
    };
@endphp

<div class="calendar-container">
    @livewire($widgetClass)
</div>
```

### Widget Filament Utilizzati
1. **PatientCalendarWidget**: Vista sola lettura per pazienti
2. **DoctorCalendarWidget**: CRUD completo per dottori
3. **AdminCalendarWidget**: Vista globale per amministratori

## Integrazione Frontend-Backend

### Livewire Integration
- **Richiamo diretto**: `@livewire($widgetClass)`
- **Nessuna duplicazione**: Tutta la logica nei widget Filament
- **Controllo accessi**: Gestito dai widget tramite `canView()`
- **Multi-tenancy**: Gestita automaticamente dai widget

### Queueable Actions
I widget utilizzano **Queueable Actions** per la logica di business:

```php
// Esempi di Actions utilizzate dai widget
CreateAppointmentAction::make()->execute($patient, $doctor, $data);
UpdateAppointmentAction::make()->execute($appointmentId, $data);
GetAppointmentsForCalendarAction::make()->execute($startDate, $endDate, $filters);
SendAppointmentReminderAction::make()->onQueue('notifications')->execute($appointment);
```

**Vantaggi**:
- Logica di business incapsulata e testabile
- Supporto nativo per code asincrone
- Migliore separazione delle responsabilità
- Facilità di testing e mocking

## Errori da Evitare

### ❌ Approccio Sbagliato
- Ricreare tutto il calendario nel componente Blade
- Duplicare configurazioni FullCalendar
- Implementare logica di business nel frontend
- Gestire API calls direttamente nel componente
- Duplicare controlli di accesso

### ✅ Approccio Corretto
- Richiamare i widget Filament esistenti
- Delegare tutta la logica ai widget
- Mantenere il componente minimalista
- Utilizzare Livewire per l'integrazione
- Rispettare il principio DRY

## Configurazione

### Props Supportate
```php
@props([
    'type' => 'patient',     // Tipo di widget da richiamare
    'class' => '',           // Classi CSS aggiuntive
])
```

### Controllo Accessi
Il controllo accessi è gestito automaticamente dai widget tramite:
- `PatientCalendarWidget::canView()`: Solo pazienti autenticati
- `DoctorCalendarWidget::canView()`: Solo dottori con tenancy
- `AdminCalendarWidget::canView()`: Solo amministratori

## Testing

### Test del Componente
```php
// tests/Feature/CalendarComponentTest.php
class CalendarComponentTest extends TestCase
{
    public function test_renders_patient_widget_for_patient_type()
    {
        $component = Blade::render('<x-blocks.calendar type="patient" />');
        
        $this->assertStringContains('PatientCalendarWidget', $component);
    }
    
    public function test_renders_doctor_widget_for_doctor_type()
    {
        $component = Blade::render('<x-blocks.calendar type="doctor" />');
        
        $this->assertStringContains('DoctorCalendarWidget', $component);
    }
}
```

## Documentazione Correlata

- [Widget FullCalendar Backend](../../laravel/Modules/<nome progetto>/docs/fullcalendar_widget_implementation.mdc)
- [Configurazione FullCalendar](../../laravel/Modules/<nome progetto>/docs/fullcalendar_configuration.md)
- [Implementazione Multi-Tenant](../../laravel/Modules/<nome progetto>/docs/fullcalendar_parental_widgets.md)
- [Regole Queueable Actions](../../.cursor/rules/queueable-actions.mdc)

## Zen del Componente Calendar

### Semplicità
> "La perfezione si raggiunge non quando non c'è più nulla da aggiungere, ma quando non c'è più nulla da togliere." - Antoine de Saint-Exupéry

Il componente calendar incarna questo principio: fa una sola cosa (richiamare widget) e la fa bene.

### Responsabilità Unica
Ogni elemento ha la sua responsabilità:
- **Componente Blade**: Routing verso il widget corretto
- **Widget Filament**: Logica del calendario e controlli accesso
- **Queueable Actions**: Logica di business
- **Modelli**: Gestione dati

### Manutenibilità
Un componente semplice è:
- **Facile da testare**: Pochi punti di fallimento
- **Facile da debuggare**: Logica lineare
- **Facile da estendere**: Aggiungere nuovi tipi di widget
- **Facile da mantenere**: Meno codice = meno bug
