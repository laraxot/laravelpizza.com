# Factory Best Practices - Laraxot <nome progetto>

## 🎯 **Obiettivo**
Definire best practices per la creazione e manutenzione dei factory Laravel, basate sui problemi identificati e risolti nel progetto <nome progetto>.
# Factory Best Practices - Laraxot <nome progetto>

## 🎯 **Obiettivo**
Definire best practices per la creazione e manutenzione dei factory Laravel, basate sui problemi identificati e risolti nel progetto <nome progetto>.

## 🚨 **Problemi Comuni Identificati**

### **1. Type Safety Issues**

#### ❌ **ERRATO - Metodi che restituiscono `mixed`**
```php
// ❌ MAI fare questo
public function getRandomFirstName(): mixed
{
    return $this->faker->randomElement($this->italianFirstNames);
}
```

#### ✅ **CORRETTO - Metodi con return type specifico**
```php
// ✅ SEMPRE fare questo
public function getRandomFirstName(): string
{
    $firstName = $this->faker->randomElement($this->italianFirstNames);
    return (string) $firstName;
}
```

### **2. Operazioni Binarie con `mixed` Types**

#### ❌ **ERRATO - Concatenazione con mixed**
```php
// ❌ MAI fare questo
public function getRandomLastName(): mixed
{
    return $this->faker->randomElement($this->italianFirstNames) . ' ' . $this->faker->randomElement($this->italianLastNames);
}
```

#### ✅ **CORRETTO - Cast esplicito prima delle operazioni**
```php
// ✅ SEMPRE fare questo
public function getRandomLastName(): string
{
    $firstName = (string) $this->faker->randomElement($this->italianFirstNames);
    $lastName = (string) $this->faker->randomElement($this->italianLastNames);
    return $firstName . ' ' . $lastName;
}
```

### **3. Schema Mismatch**

#### ❌ **ERRATO - Campi non esistenti nelle migrazioni**
```php
// ❌ MAI fare questo - verifica sempre la migrazione
return [
    'dentist_id' => null, // Campo non esistente
    'start_time' => $startTime, // Campo non esistente
    'end_time' => $endTime, // Campo non esistente
];
```

#### ✅ **CORRETTO - Schema allineato con migrazione**
```php
// ✅ SEMPRE fare questo - usa solo campi esistenti
return [
    'starts_at' => $startTime, // Campo esistente nella migrazione
    'ends_at' => $endTime, // Campo esistente nella migrazione
];
```

### **4. Duplicazione Records nelle Relazioni**

#### ❌ **ERRATO - Nuovo record per ogni relazione**
```php
// ❌ MAI fare questo - causa conflitti email UNIQUE
return [
    'patient_id' => User::factory()->patient()->create()->id, // Nuovo user ogni volta
    'doctor_id' => User::factory()->doctor()->create()->id, // Nuovo user ogni volta
    'studio_id' => Studio::factory()->create()->id, // Nuovo studio ogni volta
];
```

#### ✅ **CORRETTO - Pattern anti-duplicazione**
```php
// ✅ SEMPRE fare questo - riutilizza record esistenti
public function definition(): array
{
    // Crea User e Studio una sola volta per evitare duplicati
    static $patientId = null;
    static $doctorId = null;
    static $studioId = null;
    
    if ($patientId === null) {
        $patientId = User::factory()->patient()->create()->id;
    }
    
    if ($doctorId === null) {
        $doctorId = User::factory()->doctor()->create()->id;
    }
    
    if ($studioId === null) {
        $studioId = Studio::factory()->create()->id;
    }

    return [
        'patient_id' => $patientId,
        'doctor_id' => $doctorId,
        'studio_id' => $studioId,
        // ... altri campi
    ];
}
```

## 🔧 **Best Practices Implementate**

### **1. Type Safety**

#### **Return Types Espliciti**
```php
/**
 * Restituisce un nome italiano casuale.
 *
 * @return string Nome italiano casuale
 */
public function getRandomFirstName(): string
{
    $firstName = $this->faker->randomElement($this->italianFirstNames);
    return (string) $firstName;
}
```

#### **Type Casting Esplicito**
```php
/**
 * Restituisce un cognome italiano casuale.
 *
 * @return string Cognome italiano casuale
 */
public function getRandomLastName(): string
{
    $firstName = (string) $this->faker->randomElement($this->italianFirstNames);
    $lastName = (string) $this->faker->randomElement($this->italianLastNames);
    return $firstName . ' ' . $lastName;
}
```

#### **Union Types per Valori Nullable**
```php
/**
 * Restituisce un numero di telefono italiano.
 *
 * @return string|null Numero di telefono o null
 */
public function getRandomPhoneNumber(): ?string
{
    if ($this->faker->boolean(80)) { // 80% chance
        return (string) $this->faker->phoneNumber();
    }
    
    return null;
}
```

### **2. Schema Validation**

#### **Verifica Campi Esistenti**
```php
/**
 * @return array<string, mixed>
 */
public function definition(): array
{
    // Verifica sempre che i campi esistano nella migrazione
    return [
        'name' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'phone' => $this->faker->optional()->phoneNumber(),
        'address' => $this->faker->address(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
```

#### **Campi Opzionali con Faker**
```php
/**
 * @return array<string, mixed>
 */
public function definition(): array
{
    return [
        'required_field' => $this->faker->required()->text(),
        'optional_field' => $this->faker->optional(0.7)->text(), // 70% chance
        'conditional_field' => $this->faker->optional(0.5, 'default')->text(), // 50% chance o default
    ];
}
```

### **3. Relazioni e Dependencies**

#### **Factory States per Relazioni**
```php
/**
 * Factory per un utente con ruolo specifico.
 */
public function doctor(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'doctor',
        'specialization' => $this->faker->randomElement(['Cardiologia', 'Dermatologia', 'Neurologia']),
    ]);
}

/**
 * Factory per un utente paziente.
 */
public function patient(): static
{
    return $this->state(fn (array $attributes) => [
        'role' => 'patient',
        'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
    ]);
}
```

#### **Factory per Relazioni Esistenti**
```php
/**
 * Factory per un appuntamento con paziente esistente.
 */
public function forPatient(User $patient): static
{
    return $this->state(fn (array $attributes) => [
        'patient_id' => $patient->id,
    ]);
}

/**
 * Factory per un appuntamento con dottore esistente.
 */
public function forDoctor(User $doctor): static
{
    return $this->state(fn (array $attributes) => [
        'doctor_id' => $doctor->id,
    ]);
}
```

### **4. Performance e Ottimizzazione**

#### **Lazy Loading per Relazioni**
```php
/**
 * Factory con lazy loading per relazioni.
 */
public function withRelations(): static
{
    return $this->afterCreating(function ($model) {
        $model->load(['patient', 'doctor', 'studio']);
    });
}
```

#### **Batch Creation per Dataset Grandi**
```php
/**
 * Crea un batch di records con performance ottimizzata.
 */
public function createBatch(int $count): Collection
{
    $records = collect();
    
    for ($i = 0; $i < $count; $i++) {
        $records->push($this->create());
    }
    
    return $records;
}
```

### **5. Error Handling e Validazione**

#### **Validazione Dati Faker**
```php
/**
 * Valida che i dati generati siano corretti.
 */
public function validateData(): static
{
    return $this->afterCreating(function ($model) {
        if (empty($model->name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }
        
        if (!filter_var($model->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }
    });
}
```

#### **Fallback per Dati Mancanti**
```php
/**
 * Genera dati con fallback per valori mancanti.
 */
public function getRandomSpecialization(): string
{
    $specializations = [
        'Cardiologia', 'Dermatologia', 'Neurologia', 'Ortopedia',
        'Ginecologia', 'Pediatria', 'Psichiatria', 'Radiologia'
    ];
    
    return $this->faker->randomElement($specializations) ?? 'Medicina Generale';
}
```

## 📊 **Pattern di Testing**

### **1. Test di Base**
```php
#[Test]
#[Group('factory')]
public function it_creates_valid_user(): void
{
    $user = User::factory()->create();
    
    $this->assertNotNull($user->id);
    $this->assertNotEmpty($user->name);
    $this->assertNotEmpty($user->email);
    $this->assertTrue(filter_var($user->email, FILTER_VALIDATE_EMAIL));
}
```

### **2. Test di Relazioni**
```php
#[Test]
#[Group('factory')]
public function it_creates_user_with_doctor_role(): void
{
    $doctor = User::factory()->doctor()->create();
    
    $this->assertEquals('doctor', $doctor->role);
    $this->assertNotEmpty($doctor->specialization);
}
```

### **3. Test di Performance**
```php
#[Test]
#[Group('factory')]
public function it_creates_100_users_efficiently(): void
{
    $startTime = microtime(true);
    
    $users = User::factory()->count(100)->create();
    
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    
    $this->assertCount(100, $users);
    $this->assertLessThan(5.0, $executionTime); // Max 5 secondi
}
```

## 🚨 **Anti-Pattern da Evitare**

### **1. Metodi Senza Return Type**
```php
// ❌ MAI fare questo
public function getRandomData()
{
    return $this->faker->randomElement($this->data);
}

// ✅ SEMPRE fare questo
public function getRandomData(): string
{
    $data = $this->faker->randomElement($this->data);
    return (string) $data;
}
```

### **2. Operazioni Binarie con Mixed**
```php
// ❌ MAI fare questo
public function getFullName(): mixed
{
    return $this->faker->firstName . ' ' . $this->faker->lastName;
}

// ✅ SEMPRE fare questo
public function getFullName(): string
{
    $firstName = (string) $this->faker->firstName;
    $lastName = (string) $this->faker->lastName;
    return $firstName . ' ' . $lastName;
}
```

### **3. Campi Non Esistenti**
```php
// ❌ MAI fare questo - verifica sempre la migrazione
return [
    'non_existent_field' => $this->faker->text(),
];

// ✅ SEMPRE fare questo - usa solo campi esistenti
return [
    'existing_field' => $this->faker->text(),
];
```

### **4. Creazione Record per Ogni Relazione**
```php
// ❌ MAI fare questo - causa conflitti e performance scarse
return [
    'patient_id' => User::factory()->patient()->create()->id, // Nuovo record ogni volta
];

// ✅ SEMPRE fare questo - riutilizza record esistenti
static $patientId = null;
if ($patientId === null) {
    $patientId = User::factory()->patient()->create()->id;
}
return [
    'patient_id' => $patientId,
];
```

## 📋 **Checklist Implementazione**

### **Fase 1: Type Safety**
- [ ] Tutti i metodi hanno return type esplicito
- [ ] Nessun metodo restituisce `mixed`
- [ ] Type casting esplicito per operazioni binarie
- [ ] Union types per valori nullable

### **Fase 2: Schema Validation**
- [ ] Verifica campi esistenti nelle migrazioni
- [ ] Rimozione campi non esistenti
- [ ] Allineamento factory con schema database
- [ ] Test con migrazioni corrette

### **Fase 3: Performance Optimization**
- [ ] Pattern anti-duplicazione implementato
- [ ] Lazy loading per relazioni
- [ ] Batch creation per dataset grandi
- [ ] Performance testing completato

### **Fase 4: Error Handling**
- [ ] Validazione dati generati
- [ ] Fallback per valori mancanti
- [ ] Error handling per casi edge
- [ ] Logging per debugging

## 🎯 **Risultati Attesi**

Al completamento di tutte le best practices:

1. **PHPStan Livello 10** raggiunto
2. **Type Safety 100%** per tutti i factory
3. **Performance Ottimizzata** per creazione records
4. **Schema Alignment 100%** per tutte le migrazioni
5. **Error Handling Robusto** per tutti i casi edge
6. **Testing Completo** per tutti i pattern

## 📚 **Documentazione Correlata**

- [PHPStan Analysis Business Logic](../phpstan-analysis-business-logic.md)
- [Business Logic Factory & Seeder Audit](../business-logic-factory-seeder-audit.md)
- [Testing Business Behavior Supreme Rule](../testing-business-behavior-supreme-rule.md)
- [<nome progetto> Factory Issues Analysis](../laravel/Modules/<nome progetto>/docs/factory-issues-analysis.md)
- [<nome progetto> Factory Issues Analysis](../laravel/Modules/<nome progetto>/docs/factory-issues-analysis.md)

---

**Stato**: Best practices definite, implementazione in corso
**Priorità**: Type safety e schema alignment (ALTA)
**Responsabile**: AI Assistant
**Ultimo Aggiornamento**: 2025-01-06







