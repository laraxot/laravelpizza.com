# Principi di Testing

## Regola Fondamentale
**I test devono verificare il comportamento business, NON l'implementazione.**

## Filosofia del Testing

### Testare COSA, non COME
- ✅ **Focus**: Risultati osservabili dall'utente finale
- ✅ **Obiettivo**: Verificare che il sistema faccia quello che deve fare
- ❌ **Evitare**: Testare dettagli interni di implementazione

### Esempi Pratici

#### Login System ✅
```php
// CORRETTO: Testa il comportamento business
test('user can login with valid credentials', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    
    $response = $this->post('/it/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    // Verifica il RISULTATO per l'utente
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
    expect(session()->has('user_logged_in_at'))->toBeTrue();
});
```

#### Appointment Management ✅
```php
// CORRETTO: Testa il valore business
test('doctor can create appointment for patient', function () {
    $doctor = User::factory()->doctor()->create();
    $patient = User::factory()->patient()->create();
    
    $this->actingAs($doctor)
        ->post('/appointments', [
            'patient_id' => $patient->id,
            'date' => '2024-01-15',
            'time' => '10:00',
            'type' => 'consultation',
        ]);
    
    // Verifica gli EFFETTI business
    $this->assertDatabaseHas('appointments', [
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => 'scheduled',
    ]);
    
    expect($patient->fresh()->appointments()->count())->toBe(1);
    Mail::assertSent(AppointmentConfirmation::class);
});
```

## Anti-Pattern da Evitare

### ❌ Non Testare Implementazione
```php
// SBAGLIATO: Testa COME il sistema fa le cose
test('login calls authentication service', function () {
    $authService = Mockery::mock(AuthService::class);
    $authService->shouldReceive('authenticate')->once();
    
    // Questo test è fragile e non utile per l'utente
});

// SBAGLIATO: Testa dettagli interni
test('widget sets internal properties correctly', function () {
    $widget = new PatientCalendarWidget();
    $widget->mount();
    
    expect($widget->appointments)->toBeArray();
    expect($widget->currentMonth)->toBe(now()->month);
});
```

## Gestione Test Esistenti

### Regola: NON Cancellare, Sistemare
1. **Analizzare** il valore business che il test vuole proteggere
2. **Riscrivere** per testare comportamento osservabile
3. **Mantenere** la copertura dei casi d'uso importanti
4. **Migliorare** leggibilità e manutenibilità

### Processo di Refactoring
```php
// PRIMA: Test implementazione
test('widget loads data correctly', function () {
    $widget = new PatientCalendarWidget();
    $widget->loadAppointments();
    
    expect($widget->appointments)->toHaveCount(5);
});

// DOPO: Test comportamento business
test('patient sees their appointments in calendar', function () {
    $patient = User::factory()->patient()->create();
    Appointment::factory()->count(5)->create(['patient_id' => $patient->id]);
    Appointment::factory()->count(3)->create(); // Altri pazienti
    
    $this->actingAs($patient);
    
    Livewire::test(PatientCalendarWidget::class)
        ->assertViewHas('appointments', function ($appointments) {
            return $appointments->count() === 5;
        });
});
```

## Benefici dell'Approccio Corretto

1. **Stabilità**: Test non si rompono per refactoring interni
2. **Documentazione**: Test documentano requisiti business
3. **Fiducia**: Maggiore confidenza nel sistema
4. **Manutenibilità**: Meno test da aggiornare
5. **Focus**: Concentrazione sui requisiti reali

## Checklist per Ogni Test

- [ ] Testa un comportamento osservabile dall'utente?
- [ ] Continuerebbe a funzionare se cambiassi l'implementazione?
- [ ] Documenta un requisito business reale?
- [ ] Fallisce solo quando il comportamento cambia?
- [ ] È leggibile senza conoscere l'implementazione?

## Architettura Testing per <nome progetto>
## Architettura Testing per <nome progetto>

### Separazione Test per Architettura
- **LoginTest.php**: Testa pagina `/it/auth/login` (routing, layout, middleware)
- **LoginVoltTest.php**: Testa componente Volt (state management, validation)
- **LoginWidgetTest.php**: Testa widget Filament (form logic)

### Pattern per Moduli Base vs Specifici
```php
// User/tests (modulo base): Test generici
test('user can have different types', function () {
    $user = User::factory()->create(['type' => 'generic']);
    expect($user->isType('generic'))->toBeTrue();
});

// <nome progetto>/tests (modulo specifico): Test dominio
// <nome progetto>/tests (modulo specifico): Test dominio
test('patient inherits user functionality', function () {
    $patient = Patient::factory()->create();
    expect($patient)->toBeInstanceOf(User::class);
    expect($patient->type)->toBe('patient');
});
```

## Collegamenti
- [Dettagli Tecnici](../laravel/.ai/guidelines/testing-business-behavior.md)
- [Architettura Modulare](./modular-architecture-principles.md)
- [Testing Guidelines](../laravel/.ai/guidelines/testing-guidelines.md)

---
**Ultima modifica**: 2025-01-06  
**Priorità**: CRITICA  
**Applicazione**: SEMPRE, TUTTI I TEST
