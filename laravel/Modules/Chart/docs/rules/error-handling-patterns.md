# Regole Critiche per Gestione Errori e Logging

## ⚠️ REGOLA CRITICA: NO LOG::WARNING() INUTILE

**ERRORE GRAVE**: Usare `Log::warning()` per errori che non sono realmente warning o per mascherare problemi di codice.

## Pattern Corretti per Gestione Errori

### 1. ✅ Gestione Errori Appropriata

```php
// ✅ CORRETTO - Gestione errori con fallback appropriato
protected function getCountForState(string $stateName): int
{
    try {
        return Appointment::where('state', $stateName)
            ->when(auth()->user()->hasRole('doctor'), function ($query) {
                return $query->where('doctor_id', auth()->id());
            })
            ->count();
    } catch (\Exception $e) {
        // Fallback appropriato senza logging inutile
        return 0;
    }
}
```

### 2. ✅ Logging Solo per Errori Reali

```php
// ✅ CORRETTO - Logging solo per errori critici
protected function calculateAppointmentStates(): array
{
    $states = [];
    $stateMapping = AppointmentState::getStateMapping()->toArray();
    
    foreach ($stateMapping as $name => $stateClass) {
        try {
            $appointment = new Appointment();
            $state = new $stateClass($appointment);
            
            $states[] = [
                'name' => $name,
                'label' => $state->label(),
                'icon' => $this->cleanIconName($state->icon()),
                'color' => $state->bgColor(),
                'count' => $this->getCountForState($name),
            ];
        } catch (\Exception $e) {
            // Solo se è un errore critico che impedisce il funzionamento
            if ($this->isCriticalError($e)) {
                Log::error("Errore critico nel calcolo stato {$name}: " . $e->getMessage(), [
                    'state' => $name,
                    'exception' => $e,
                ]);
            }
            // Fallback silenzioso per errori non critici
            continue;
        }
    }
    
    return $states;
}
```

### 3. ❌ ANTI-PATTERN DA EVITARE

```php
// ❌ ERRORE GRAVE - Logging inutile
protected function getCountForState(string $stateName): int
{
    try {
        return Appointment::where('state', $stateName)->count();
    } catch (\Exception $e) {
        Log::warning("Errore nel conteggio appuntamenti per stato {$stateName}: " . $e->getMessage());
        return 0; // Fallback appropriato
    }
}
```

## Regole di Logging

### Quando Usare Log::error()
- Errori critici che impediscono il funzionamento
- Errori di database che causano crash
- Errori di autenticazione/autorizzazione
- Errori di configurazione critici

### Quando Usare Log::warning()
- **MAI** per errori di codice
- Solo per situazioni esterne (API down, servizi terzi)
- Solo per problemi di configurazione non critici

### Quando NON Loggare
- Errori di validazione normale
- Fallback di routine
- Errori di UI/UX
- Errori di business logic normale

## Pattern di Gestione Errori

### 1. Fallback Silenzioso
```php
// ✅ CORRETTO
protected function getData(): array
{
    try {
        return $this->fetchData();
    } catch (\Exception $e) {
        return []; // Fallback silenzioso
    }
}
```

### 2. Fallback con Valore di Default
```php
// ✅ CORRETTO
protected function getCount(): int
{
    try {
        return Model::count();
    } catch (\Exception $e) {
        return 0; // Valore di default appropriato
    }
}
```

### 3. Gestione Errori con Context
```php
// ✅ CORRETTO - Solo per errori critici
protected function processCriticalOperation(): void
{
    try {
        $this->performCriticalOperation();
    } catch (\Exception $e) {
        Log::error('Operazione critica fallita', [
            'operation' => 'critical_operation',
            'user_id' => auth()->id(),
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        // Notifica utente appropriata
        Notification::make()
            ->title('Errore di sistema')
            ->body('Si è verificato un errore. Riprova più tardi.')
            ->danger()
            ->send();
    }
}
```

## Checklist di Verifica

Prima di aggiungere qualsiasi logging:

1. **È un errore critico?**
   - ✅ Sì → `Log::error()` con context completo
   - ❌ No → Fallback silenzioso

2. **È un warning reale?**
   - ✅ Sì → `Log::warning()` solo per problemi esterni
   - ❌ No → Non loggare

3. **Il fallback è appropriato?**
   - ✅ Sì → Implementa fallback
   - ❌ No → Rivedi la logica

4. **L'utente deve essere notificato?**
   - ✅ Sì → Notification appropriata
   - ❌ No → Fallback silenzioso

## Penalità per Violazioni

- **Prima violazione**: Correzione immediata + documentazione
- **Violazioni ripetute**: Rischio di perdita di fiducia
- **Logging eccessivo**: Degrado performance e rumore nei log

## Processo di Correzione

Se viene rilevato logging inappropriato:

1. **Rimuovere immediatamente** il logging inutile
2. **Implementare fallback appropriato**
3. **Aggiornare le regole** per evitare ripetizioni
4. **Documentare l'errore** per apprendimento futuro

## Note Importanti

- **MAI** usare `Log::warning()` per mascherare errori di codice
- **SEMPRE** implementare fallback appropriati
- **SEMPRE** considerare l'esperienza utente
- **SEMPRE** loggare solo errori critici con context completo 