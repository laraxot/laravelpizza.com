# Best Practice di Validazione

## Principi Fondamentali

### 1. Validazione Email
- Validare SEMPRE l'unicità dell'email prima della creazione
- Usare unique indexes nella tabella base
- Implementare validazione lato client e server

### 2. Validazione Campi Richiesti
- Verificare SEMPRE la presenza dei campi obbligatori
- Usare regole di validazione appropriate
- Implementare messaggi di errore chiari

### 3. Validazione Unicità
- Verificare SEMPRE l'unicità dei campi unici
- Usare unique indexes nella tabella base
- Implementare validazione lato client e server

## Esempio di Implementazione

### 1. Validazione Email
```php
<?php

namespace Modules\Doctor\Actions;

use Illuminate\Support\Facades\Validator;
use Modules\Doctor\Models\Doctor;

class CreateDoctorAction
{
    public function execute(array $data): Doctor
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users,email',
            // altre regole
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Doctor::create($data);
    }
}
```

### 2. Validazione Campi Richiesti
```php
<?php

namespace Modules\Doctor\Actions;

use Illuminate\Support\Facades\Validator;
use Modules\Doctor\Models\Doctor;

class UpdateDoctorAction
{
    public function execute(Doctor $doctor, array $data): Doctor
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->id,
            // altre regole
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $doctor->update($data);
        return $doctor;
    }
}
```

### 3. Validazione Unicità
```php
<?php

namespace Modules\Doctor\Actions;

use Illuminate\Support\Facades\Validator;
use Modules\Doctor\Models\Doctor;

class CreateDoctorAction
{
    public function execute(array $data): Doctor
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            // altre regole
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Doctor::create($data);
    }
}
```

## Errori Comuni

### 1. Validazione Email Mancante
❌ Non validare l'unicità dell'email
✅ Implementare validazione e unique index

### 2. Validazione Campi Richiesti Mancante
❌ Non verificare la presenza dei campi obbligatori
✅ Implementare regole di validazione appropriate

### 3. Validazione Unicità Mancante
❌ Non verificare l'unicità dei campi unici
✅ Implementare validazione e unique index

## Checklist

### Prima di Creare un Nuovo Modello
- [ ] Validazione email implementata
- [ ] Validazione campi richiesti implementata
- [ ] Validazione unicità implementata
- [ ] Test di integrazione

### Prima di Modificare un Modello Esistente
- [ ] Verifica compatibilità con validazione esistente
- [ ] Aggiorna la documentazione
- [ ] Test di regressione 
