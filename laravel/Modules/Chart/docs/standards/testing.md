# Best Practice di Test

## Principi Fondamentali

### 1. Test di Integrazione
- Testare SEMPRE l'integrazione tra moduli
- Testare SEMPRE le migrazioni
- Testare SEMPRE le validazioni

### 2. Test di Unità
- Testare SEMPRE le azioni
- Testare SEMPRE i modelli
- Testare SEMPRE le risorse Filament

### 3. Test di Regressione
- Testare SEMPRE dopo modifiche
- Testare SEMPRE dopo aggiornamenti
- Testare SEMPRE dopo refactoring

## Esempio di Implementazione

### 1. Test di Integrazione
```php
<?php

namespace Modules\Doctor\Tests\Integration;

use Tests\TestCase;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Actions\CreateDoctorAction;

class DoctorIntegrationTest extends TestCase
{
    public function test_can_create_doctor()
    {
        $action = new CreateDoctorAction();
        $doctor = $action->execute([
            'email' => 'test@example.com',
            'name' => 'Test Doctor',
        ]);

        $this->assertInstanceOf(Doctor::class, $doctor);
        $this->assertEquals('test@example.com', $doctor->email);
        $this->assertEquals('Test Doctor', $doctor->name);
    }
}
```

### 2. Test di Unità
```php
<?php

namespace Modules\Doctor\Tests\Unit;

use Tests\TestCase;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Actions\UpdateDoctorAction;

class DoctorUnitTest extends TestCase
{
    public function test_can_update_doctor()
    {
        $doctor = Doctor::factory()->create();
        $action = new UpdateDoctorAction();
        $updated = $action->execute($doctor, [
            'name' => 'Updated Doctor',
        ]);

        $this->assertInstanceOf(Doctor::class, $updated);
        $this->assertEquals('Updated Doctor', $updated->name);
    }
}
```

### 3. Test di Regressione
```php
<?php

namespace Modules\Doctor\Tests\Regression;

use Tests\TestCase;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Actions\CreateDoctorAction;

class DoctorRegressionTest extends TestCase
{
    public function test_email_uniqueness()
    {
        $action = new CreateDoctorAction();
        $doctor1 = $action->execute([
            'email' => 'test@example.com',
            'name' => 'Test Doctor 1',
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $doctor2 = $action->execute([
            'email' => 'test@example.com',
            'name' => 'Test Doctor 2',
        ]);
    }
}
```

## Errori Comuni

### 1. Test Mancanti
❌ Non testare l'integrazione
✅ Testare SEMPRE l'integrazione

### 2. Test Incompleti
❌ Non testare tutti i casi
✅ Testare SEMPRE tutti i casi

### 3. Test Non Aggiornati
❌ Non aggiornare i test dopo modifiche
✅ Aggiornare SEMPRE i test dopo modifiche

## Checklist

### Prima di Creare un Nuovo Test
- [ ] Test di integrazione
- [ ] Test di unità
- [ ] Test di regressione
- [ ] Test di validazione

### Prima di Modificare un Test Esistente
- [ ] Verifica compatibilità
- [ ] Aggiorna la documentazione
- [ ] Test di regressione 
