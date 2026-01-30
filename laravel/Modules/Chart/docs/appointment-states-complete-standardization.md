# Standardizzazione Completa degli Stati degli Appuntamenti

## Terminologia Corretta

**IMPORTANTE**: In italiano, "report" si traduce come "referto", specialmente in ambito medico/odontoiatrico.

### Traduzioni per Lingua

- **Italiano**: "Referto" (non "Report")
- **Inglese**: "Report" 
- **Tedesco**: "Bericht"

## File di Traduzione Aggiornati

### 1. Stati degli Appuntamenti - Tema One

#### Italiano (`laravel/Themes/One/lang/it/appointment_states.php`)
```php
'report_pending' => [
    'label' => 'Referto in attesa',
    'color' => 'warning',
    'bg_color' => 'warning',
    'icon' => 'heroicon-o-document-text',
    'modal_heading' => 'Referto in attesa',
    'modal_description' => 'Il referto odontoiatrico è in attesa di compilazione',
],
'report_completed' => [
    'label' => 'Referto completato',
    'color' => 'success',
    'bg_color' => 'success',
    'icon' => 'heroicon-o-document-check',
    'modal_heading' => 'Referto completato',
    'modal_description' => 'Il referto odontoiatrico è stato completato',
],
```

#### Inglese (`laravel/Themes/One/lang/en/appointment_states.php`)
```php
'report_pending' => [
    'label' => 'Report Pending',
    'modal_description' => 'The dental report is pending completion',
],
'report_completed' => [
    'label' => 'Report Completed',
    'modal_description' => 'The dental report has been completed',
],
```

#### Tedesco (`laravel/Themes/One/lang/de/appointment_states.php`)
```php
'report_pending' => [
    'label' => 'Bericht ausstehend',
    'modal_description' => 'Der zahnärztliche Bericht wartet auf Vervollständigung',
],
'report_completed' => [
    'label' => 'Bericht abgeschlossen',
    'modal_description' => 'Der zahnärztliche Bericht wurde abgeschlossen',
],
```

### 2. Modulo SaluteMo - Traduzioni Referti

#### Italiano (`laravel/Modules/SaluteMo/lang/it/report.php`)
```php
'model' => [
    'label' => 'Referto Odontoiatrico',
    'plural' => 'Referti Odontoiatrici',
    'description' => 'Gestione completa dei referti odontoiatrici',
],
'navigation' => [
    'label' => 'Referti Odontoiatrici',
    'group' => 'Gestione Referti',
    'tooltip' => 'Gestisci tutti i referti odontoiatrici del sistema',
],
```

## Stati Completi Implementati

### Stati Base (16 totali)

1. **pending** - In attesa di conferma
2. **confirmed** - Confermato
3. **rejected** - Rifiutato
4. **cancelled** - Annullato
5. **no_show** - Non presentato
6. **banned** - Bannato
7. **in_progress** - In corso
8. **scheduled** - Programmato
9. **rescheduled** - Riprogrammato
10. **completed** - Completato
11. **report_pending** - Referto in attesa
12. **report_completed** - Referto completato
13. **refund_pending** - Rimborso in attesa
14. **refund_accepted** - Rimborso accettato
15. **refund_to_integrate** - Rimborso da integrare
16. **refund_completed** - Rimborso completato
17. **pro_bono** - Pro bono

### Workflow degli Stati

```
pending → confirmed → in_progress → completed
    ↓
rejected/cancelled

completed → report_pending → report_completed

completed → refund_pending → refund_accepted → refund_completed
    ↓
refund_to_integrate

no_show → banned
```

## Utilizzo negli Stati Concrete

### Pattern Standardizzato

```php
class ReportPendingState extends AppointmentState
{
    public function label(): string
    {
        return __('pub_theme::appointment_states.report_pending.label');
    }

    public function color(): string
    {
        return __('pub_theme::appointment_states.report_pending.color');
    }

    public function icon(): string
    {
        return __('pub_theme::appointment_states.report_pending.icon');
    }

    public function modalHeading(): string
    {
        return __('pub_theme::appointment_states.report_pending.modal_heading');
    }

    public function modalDescription(): string
    {
        return __('pub_theme::appointment_states.report_pending.modal_description');
    }
}
```

### Metodi Generici per Gestione Stati

```php
trait HasAppointmentStates
{
    public function getStateLabel(): string
    {
        return $this->state->label();
    }

    public function getStateColor(): string
    {
        return $this->state->color();
    }

    public function getStateIcon(): string
    {
        return $this->state->icon();
    }

    public function getStateModalHeading(): string
    {
        return $this->state->modalHeading();
    }

    public function getStateModalDescription(): string
    {
        return $this->state->modalDescription();
    }

    public function canTransitionTo(AppointmentState $newState): bool
    {
        return $this->state->canTransitionTo($newState);
    }

    public function transitionTo(AppointmentState $newState): void
    {
        if ($this->canTransitionTo($newState)) {
            $this->state = $newState;
            $this->save();
        }
    }
}
```

## Utilizzo nei Widget

### Widget Calendario

```php
class AppointmentCalendarWidget extends BaseCalendarWidget
{
    protected function getEventData(Appointment $appointment): array
    {
        return [
            'id' => $appointment->id,
            'title' => $appointment->getStateLabel(),
            'start' => $appointment->start_time,
            'end' => $appointment->end_time,
            'backgroundColor' => $appointment->getStateColor(),
            'borderColor' => $appointment->getStateColor(),
            'textColor' => '#ffffff',
            'extendedProps' => [
                'state' => $appointment->state->value,
                'modal_heading' => $appointment->getStateModalHeading(),
                'modal_description' => $appointment->getStateModalDescription(),
            ],
        ];
    }
}
```

### Widget Stati

```php
class AppointmentStatesWidget extends BaseWidget
{
    protected function getStateCards(): array
    {
        return [
            'pending' => [
                'label' => __('pub_theme::appointment_states.pending.label'),
                'count' => Appointment::where('state', 'pending')->count(),
                'color' => __('pub_theme::appointment_states.pending.color'),
                'icon' => __('pub_theme::appointment_states.pending.icon'),
            ],
            'report_pending' => [
                'label' => __('pub_theme::appointment_states.report_pending.label'),
                'count' => Appointment::where('state', 'report_pending')->count(),
                'color' => __('pub_theme::appointment_states.report_pending.color'),
                'icon' => __('pub_theme::appointment_states.report_pending.icon'),
            ],
            // ... altri stati
        ];
    }
}
```

## Checklist di Conformità

- [x] Tutte le traduzioni usano la terminologia corretta per lingua
- [x] Stati completi implementati (16 stati)
- [x] Workflow degli stati documentato
- [x] Pattern standardizzato per tutti gli stati
- [x] Metodi generici per gestione stati
- [x] Utilizzo nei widget documentato
- [x] Traduzioni complete in italiano, inglese e tedesco
- [x] Terminologia corretta: "Referto" in italiano, "Report" in inglese, "Bericht" in tedesco

## Benefici dell'Architettura

1. **Consistenza**: Tutti gli stati seguono lo stesso pattern
2. **Localizzazione**: Traduzioni complete in tutte le lingue
3. **Manutenibilità**: Facile aggiungere nuovi stati
4. **Flessibilità**: Stati personalizzabili per ogni modulo
5. **Terminologia Corretta**: Uso appropriato di "referto" in italiano

## Collegamenti

- [Regole Traduzioni](translation-preservation-rules.md)
- [Best Practice Filament](filament-best-practices.md)
- [Documentazione Moduli](module-documentation.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Terminologia Corretta**: "Referto" in italiano, "Report" in inglese, "Bericht" in tedesco 