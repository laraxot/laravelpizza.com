# Filosofia dei Test: Modelli "Slim" - NO Test Inutili

## Principio Fondamentale
I modelli Laraxot sono **"slim"** - testare i fillable, le relazioni base, o i cast è **INUTILE** e **STUPIDO**.

## Cosa NON Testare (VIETATO)
- ❌ `$fillable` - sono dettagli implementativi
- ❌ `$casts` - sono configurazioni base
- ❌ `$hidden` - sono dettagli implementativi
- ❌ Relazioni base (`belongsTo`, `hasMany`) - sono funzionalità Eloquent
- ❌ `$table` - è configurazione base
- ❌ `$connection` - è configurazione base

## Cosa Testare (LOGICA DI BUSINESS)
- ✅ Metodi custom di business logic
- ✅ Scopes personalizzati
- ✅ Accessors/Mutators custom
- ✅ Eventi di business
- ✅ Policy e autorizzazioni
- ✅ Validazioni custom
- ✅ Metodi di calcolo business

## Filosofia
- **Frontend**: Testa le azioni e i risultati
- **Dati**: Verifica che i dati ci siano e siano corretti
- **Business Logic**: Testa la logica di business, non i dettagli tecnici
- **Modelli**: Sono "slim", non "fat" - non testare l'infrastruttura

## Esempio Corretto
```php
// ✅ CORRETTO - Test business logic
public function test_calculate_appointment_duration(): void
{
    $appointment = Appointment::factory()->create([
        'start_time' => '09:00:00',
        'end_time' => '10:30:00'
    ]);

    $this->assertEquals(90, $appointment->getDurationInMinutes());
}
```

## Esempio Errato
```php
// ❌ ERRATO - Test inutile dei fillable
public function test_fillable_fields(): void
{
    $this->assertContains('name', (new Doctor)->getFillable());
    $this->assertContains('email', (new Doctor)->getFillable());
}
```

## Regola Assoluta
**Testa la LOGICA DI BUSINESS, non i DETTAGLI IMPLEMENTATIVI!**

## Collegamenti
- [Testing Priority Rule](testing-priority-rule.md)
- [No RefreshDatabase Rule](no-refresh-database-rule.md)
- [Laraxot Framework](../../laravel/modules/xot/docs/laraxot-framework.md)

---
**Versione**: 1.0
**Compatibilità**: Laraxot <nome progetto>, Testing Philosophy
**Compatibilità**: Laraxot <nome progetto>, Testing Philosophy
