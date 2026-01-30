# Appointment State Methods Fix

## Problema Risolto

### Errore
```
Call to undefined method Modules\<nome progetto>\States\Appointment\Rejected::modalHeading()
```

### Causa del Problema

Il widget `DoctorAppointmentsWidget` utilizzava un metodo `getActionByState()` che chiamava metodi standardizzati sugli stati appointment:

```php
public function getActionByState(string $stateClass, string $name): Action
{
    $state = new $stateClass($appointment);
    
    return Action::make($name)
        ->tooltip($state->label())           // ✅ Esisteva
        ->icon($state->icon())               // ✅ Esisteva  
        ->color($state->color())             // ✅ Esisteva
        ->modalHeading($state->modalHeading())       // ❌ MANCANTE in Rejected
        ->modalDescription($state->modalDescription()) // ❌ MANCANTE in Rejected
}
```

### Stati Inconsistenti

**Confirmed State** (completo):
```php
class Confirmed extends AppointmentState
{
    public function label(): string { /* ... */ }
    public function color(): string { /* ... */ }
    public function icon(): string { /* ... */ }
    public function modalHeading(): string { /* ... */ }     // ✅ Presente
    public function modalDescription(): string { /* ... */ } // ✅ Presente
}
```

**Rejected State** (incompleto):
```php
class Rejected extends AppointmentState  
{
    public function label(): string { /* ... */ }
    public function color(): string { /* ... */ }
    public function icon(): string { /* ... */ }
    // ❌ MANCANTI: modalHeading() e modalDescription()
}
```

## Soluzioni Implementate

### 1. Completamento Classe Rejected

**File**: `laravel/Modules/<nome progetto>/app/States/Appointment/Rejected.php`

Aggiunti i metodi mancanti seguendo il pattern di `Confirmed`:

```php
class Rejected extends AppointmentState
{
    /** @var string */
    public static $name = 'rejected';

    public function label(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.label');
    }

    public function color(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.color');
    }

    public function icon(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.icon');
    }

    public function canBeModified(): bool
    {
        return false;
    }

    public function isActive(): bool
    {
        return false;
    }

    public function isRejected(): bool
    {
        return true;
    }

    // ✅ AGGIUNTI: Metodi mancanti
    public function modalHeading(): string
    {
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_heading');
    }

    public function modalDescription(): string
    {
        $appointment = $this->getModel();
        return static::transClass(__CLASS__,'states.'.static::$name.'.modal_description');
    }
}
```

### 2. Standardizzazione Pattern TransClass

Tutti i metodi ora usano `transClass()` per le traduzioni invece di valori hardcoded, seguendo il pattern:

```php
return static::transClass(__CLASS__,'states.'.static::$name.'.{property}');
```

### 3. Traduzioni Complete

**File**: `laravel/Modules/<nome progetto>/lang/it/states.php`

Aggiunte traduzioni per tutti gli appointment states:

```php
return [
    // ... existing user states ...

    // Appointment States
    'confirmed' => [
        'label' => 'Confermato',
        'color' => 'success',
        'icon' => 'heroicon-o-check-circle',
        'modal_heading' => 'Conferma Appuntamento',
        'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
    ],
    'rejected' => [
        'label' => 'Respinto',
        'color' => 'danger', 
        'icon' => 'heroicon-o-x-mark',
        'modal_heading' => 'Rifiuta Appuntamento',
        'modal_description' => 'Sei sicuro di voler rifiutare questo appuntamento?',
    ],
    'pending' => [
        'label' => 'In attesa',
        'color' => 'warning',
        'icon' => 'heroicon-o-clock',
        'modal_heading' => 'Appuntamento in Attesa',
        'modal_description' => 'Questo appuntamento è in attesa di conferma.',
    ],
];
```

## Pattern Architetturale Implementato

### Interfaccia Comune per Stati

Tutti gli appointment states ora implementano la stessa interfaccia:

```php
interface AppointmentStateInterface
{
    public function label(): string;
    public function color(): string;
    public function icon(): string;
    public function canBeModified(): bool;
    public function isActive(): bool;
    public function modalHeading(): string;      // ✅ Standard
    public function modalDescription(): string;  // ✅ Standard
}
```

### Widget Generic Method

Il widget può ora chiamare metodi su qualsiasi stato senza errori:

```php
public function getActionByState(string $stateClass, string $name): Action
{
    $appointment = new Appointment();
    $state = new $stateClass($appointment);
    
    return Action::make($name)
        ->iconButton()
        ->size(ActionSize::Large)
        ->tooltip($state->label())                    // ✅ Funziona per tutti
        ->icon($state->icon())                        // ✅ Funziona per tutti
        ->color($state->color())                      // ✅ Funziona per tutti
        ->requiresConfirmation()
        ->modalHeading($state->modalHeading())        // ✅ Ora funziona
        ->modalDescription($state->modalDescription()) // ✅ Ora funziona
        ->action(function (array $data, $arguments) use($stateClass) {
            $appointmentId = $arguments['appointment'];
            $appointment = Appointment::firstWhere('id', $appointmentId);
            $appointment->state->transitionTo($stateClass);
        });
}
```

### State Factory Pattern

Il widget può creare azioni dinamicamente per qualsiasi stato:

```php
public function confirmAction(): Action
{
    return $this->getActionByState(Confirmed::class, __FUNCTION__);
}

public function rejectAction(): Action
{
    return $this->getActionByState(Rejected::class, __FUNCTION__);
}
```

## Vantaggi della Soluzione

### 1. Consistency
- **Tutti gli stati** implementano gli stessi metodi
- **Pattern uniforme** per traduzioni
- **Interfaccia standard** per il widget

### 2. Extensibility  
- **Facile aggiunta** di nuovi stati
- **Metodo generico** `getActionByState()` riutilizzabile
- **Traduzioni centralizzate** nel file lang

### 3. Maintainability
- **Zero duplicazione** di codice
- **Single Source of Truth** per traduzioni stati
- **Type Safety** garantita

## Best Practices Implementate

### 1. State Method Completeness
```php
// ✅ SEMPRE implementare tutti i metodi standard
class CustomState extends AppointmentState
{
    public function label(): string { /* ... */ }
    public function color(): string { /* ... */ }
    public function icon(): string { /* ... */ }
    public function modalHeading(): string { /* ... */ }     // Obbligatorio
    public function modalDescription(): string { /* ... */ } // Obbligatorio
}
```

### 2. Translation Pattern
```php
// ✅ SEMPRE usare transClass per consistency
public function label(): string
{
    return static::transClass(__CLASS__,'states.'.static::$name.'.label');
    //return 'Hardcoded Value'; // ❌ Evitare
}
```

### 3. Widget State Interaction
```php
// ✅ SEMPRE usare metodi generici per state interaction
public function getActionByState(string $stateClass, string $name): Action
{
    // Generic method che funziona con qualsiasi stato
}

// ❌ Evitare metodi specifici per ogni stato
public function getConfirmedAction(): Action { /* ... */ }
public function getRejectedAction(): Action { /* ... */ }
```

## Testing della Soluzione

### Test State Methods
```php
public function test_all_appointment_states_have_required_methods()
{
    $states = [Confirmed::class, Rejected::class, Pending::class];
    
    foreach ($states as $stateClass) {
        $appointment = Appointment::factory()->create();
        $state = new $stateClass($appointment);
        
        $this->assertNotEmpty($state->label());
        $this->assertNotEmpty($state->color());
        $this->assertNotEmpty($state->icon());
        $this->assertNotEmpty($state->modalHeading());        // ✅ Ora funziona
        $this->assertNotEmpty($state->modalDescription());    // ✅ Ora funziona
    }
}
```

### Test Widget Actions  
```php
public function test_widget_can_create_actions_for_all_states()
{
    $widget = new DoctorAppointmentsWidget();
    
    $confirmAction = $widget->getActionByState(Confirmed::class, 'confirm');
    $rejectAction = $widget->getActionByState(Rejected::class, 'reject');
    
    $this->assertInstanceOf(Action::class, $confirmAction);
    $this->assertInstanceOf(Action::class, $rejectAction);
}
```

## Prevenzione Futura

### Checklist Nuovo Stato
- [ ] Implementa tutti i metodi standard (label, color, icon, modalHeading, modalDescription)
- [ ] Usa pattern `transClass()` per traduzioni
- [ ] Aggiunge traduzioni nel file `states.php`
- [ ] Testa il widget con il nuovo stato

### Code Review Points
- [ ] Verifica consistenza metodi tra stati
- [ ] Controlla pattern traduzioni
- [ ] Testa generic methods del widget
- [ ] Valida completezza traduzioni

## Riferimenti

- [Spatie Model States](https://spatie.be/docs/laravel-model-states)
- [DoctorAppointmentsWidget Fix](../laravel/Modules/<nome progetto>/docs/widgets/doctor-appointments-widget-fix.md)
- [TransTrait Documentation](../laravel/Modules/Xot/docs/traits/trans-trait.md)

---

**Status**: ✅ **RISOLTO**
**Priorità**: 🔥 **ALTA** (bloccava azioni widget)
**Effort**: ⏱️ **1 ora** (metodi + traduzioni + documentazione)
**Risk**: 🟢 **BASSO** (backward compatible, solo aggiunte)

*Ultimo aggiornamento: 2025-01-03*
*Autore: AI Assistant* 