# 🎯 REGOLA SUPREMA: TESTING BUSINESS BEHAVIOR ONLY

## LA REGOLA PIÙ IMPORTANTE DA RICORDARE SEMPRE

**IL TESTING DEVE VERIFICARE IL COMPORTAMENTO BUSINESS, NON L'IMPLEMENTAZIONE!**

Questa è la regola fondamentale che ha precedenza su qualsiasi altra considerazione di testing.

## MANTRA ASSOLUTO

🔥 **"COMPORTAMENTO BUSINESS, NON IMPLEMENTAZIONE"** 🔥

Se un test si rompe quando rifattorizzi il codice SENZA cambiare il comportamento business, allora stai testando l'implementazione, non il comportamento!

## PRIORITÀ OPERATIVE ASSOLUTE

### 1. PRIMA PRIORITÀ: Sistemare Test Esistenti
- **MAI cancellare test esistenti**
- **SEMPRE** farli funzionare correggendo l'approccio
- Convertire da test implementativi a test comportamentali
- Mantenere la copertura ma migliorarne la qualità

### 2. SECONDA PRIORITÀ: Focus su Business Logic
- Testare solo comportamenti visibili all'utente finale
- Testare regole di business e validazioni
- Testare flussi completi (input → elaborazione → output)
- Testare autorizzazioni e permessi business

## COSA TESTARE (Business Behavior) ✅

- **Regole di Business**: Validazioni, constraint, policy
- **Flussi Utente**: Dall'input al risultato finale
- **Autorizzazioni**: Permessi e controlli di accesso
- **Effetti Collaterali**: Notifiche, log, cambi di stato
- **Calcoli Business**: Logiche di calcolo specifiche
- **Workflow**: Processi multi-step
- **API Endpoints**: Risposta e comportamento per l'utente
- **UI Interactions**: Comportamento dell'interfaccia

## COSA NON TESTARE (Implementation Details) ❌

- **Proprietà Modelli**: `$fillable`, `$casts`, `$hidden`, `$table`
- **Trait Usage**: Quali trait usa una classe
- **Relazioni Base**: `belongsTo`, `hasMany` basilari
- **Struttura Interna**: Come funziona internamente il codice
- **Framework Config**: Configurazioni di Laravel/Filament
- **Method Calls**: Se un metodo specifico viene chiamato
- **Database Schema**: Struttura delle tabelle (coperta dalle migrazioni)

## ESEMPI PRATICI

### ✅ CORRETTO (Business Behavior)
```php
it('creates appointment when doctor and patient are available', function() {
    $doctor = User::factory()->doctor()->create();
    $patient = User::factory()->patient()->create();
    $studio = Studio::factory()->create();
    
    $appointment = Appointment::create([
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'studio_id' => $studio->id,
        'start_time' => now()->addDay(),
        'duration' => 30,
    ]);
    
    expect($appointment->isConfirmed())->toBeTrue();
    expect($appointment->doctor->id)->toBe($doctor->id);
    expect($appointment->patient->id)->toBe($patient->id);
});

it('prevents double booking for same time slot', function() {
    $doctor = User::factory()->doctor()->create();
    $studio = Studio::factory()->create();
    $timeSlot = now()->addDay()->setTime(10, 0);
    
    // Prima prenotazione
    Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
        'start_time' => $timeSlot,
    ]);
    
    // Tentativo di doppia prenotazione
    expect(function() use ($doctor, $studio, $timeSlot) {
        Appointment::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'start_time' => $timeSlot,
        ]);
    })->toThrow(ValidationException::class);
});
```

### ❌ ERRATO (Implementation Details)
```php
it('model has fillable attributes', function() {
    expect(Appointment::class)->toHave('fillable');
    expect((new Appointment)->getFillable())->toContain('doctor_id');
});

it('uses specific trait', function() {
    expect(Appointment::class)->toUse(BelongsToTenant::class);
});

it('calls specific method internally', function() {
    $mock = Mockery::mock(AppointmentService::class);
    $mock->shouldReceive('calculateDuration')->once();
    // Test che verifica chiamate interne, non risultati business
});
```

## FILOSOFIA DI SISTEMAZIONE TEST ESISTENTI

Quando sistemo un test esistente che non funziona:

1. **Capire l'Intenzione**: Cosa voleva verificare il test originale?
2. **Identificare il Business Value**: Qual è il comportamento business sottostante?
3. **Riscrivere per il Comportamento**: Focus sul risultato, non sul meccanismo
4. **Mantenere la Copertura**: Non perdere controlli importanti
5. **Verificare la Resilienza**: Il test deve sopravvivere ai refactor

## REGOLE DI QUALITÀ

### Test Resilienti
- I test devono essere **black-box**: non devono conoscere l'implementazione interna
- Devono sopravvivere ai refactor che non cambiano il comportamento business
- Devono documentare il comportamento atteso del sistema

### Test di Valore
- Ogni test deve avere un chiaro valore business
- Deve proteggere da regressioni funzionali reali
- Deve essere comprensibile a un business analyst

### Test Efficienti
- Non usare `RefreshDatabase` se non strettamente necessario
- Setup leggero e focalizzato sullo scenario business
- Mock solo quando necessario per isolare il comportamento da testare

## RESPONSABILITÀ ASSOLUTE

- **MAI** cancellare test esistenti senza averli prima sistemati
- **SEMPRE** convertire test implementativi in test comportamentali
- **PRIORITÀ** ai test esistenti su quelli nuovi
- **FOCUS** sul valore business, non sulla copertura tecnica

## COLLEGAMENTI E RIFERIMENTI

- [Testing Priority Rule](testing-priority-rule.md)
- [Model Testing Philosophy](model-testing-philosophy.md)
- [Anti-patterns](anti-patterns.md)
- [Laravel Boost Guidelines](../laravel/.ai/guidelines/testing-business-behavior.md)
- [Testing Fundamental Rule](../laravel/.ai/guidelines/testing-fundamental-rule.md)

---

**Questa regola è SUPREMA e ha precedenza su qualsiasi altra considerazione di testing.**

**Ultimo aggiornamento**: Gennaio 2025  
**Status**: REGOLA ASSOLUTA E NON NEGOZIABILE  
**Applicabilità**: UNIVERSALE - ogni test, ogni modulo, ogni scenario
