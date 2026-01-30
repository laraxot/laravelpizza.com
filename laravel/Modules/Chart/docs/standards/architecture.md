# Best Practice di Architettura

## Principi Fondamentali

### 1. Struttura Moduli
- Ogni modulo deve essere indipendente
- Ogni modulo deve avere una cartella `docs`
- Ogni modulo deve seguire le best practice

### 2. Modelli
- I modelli specializzati (Doctor, Patient, ecc.) estendono il modello User
- Usare SEMPRE il trait `Parental\HasParent` per lo STI
- Tutte le colonne dei modelli specializzati DEVONO essere nella tabella base

### 3. Risorse Filament
- Estendere SEMPRE `XotBaseResource`
- NON override di proprietà statiche
- Implementare SEMPRE le azioni necessarie

## Esempio di Implementazione

### 1. Struttura Modulo
```
modules/
├── doctor/
│   ├── docs/
│   │   ├── models.md
│   │   ├── actions.md
│   │   └── resources.md
│   ├── Models/
│   │   └── Doctor.php
│   ├── Actions/
│   │   ├── CreateDoctorAction.php
│   │   └── UpdateDoctorAction.php
│   └── Filament/
│       └── Resources/
│           └── DoctorResource.php
└── patient/
    ├── docs/
    │   ├── models.md
    │   ├── actions.md
    │   └── resources.md
    ├── Models/
    │   └── Patient.php
    ├── Actions/
    │   ├── CreatePatientAction.php
    │   └── UpdatePatientAction.php
    └── Filament/
        └── Resources/
            └── PatientResource.php
```

### 2. Modello Specializzato
```php
<?php

namespace Modules\Doctor\Models;

use Modules\Xot\Models\User;
use Parental\HasParent;

class Doctor extends User
{
    use HasParent;

    protected $fillable = [
        'email',
        // altri campi specifici
    ];
}
```

### 3. Risorsa Filament
```php
<?php

namespace Modules\Doctor\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Doctor\Models\Doctor;

class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
```

## Errori Comuni

### 1. Modulo Non Indipendente
❌ Dipendenze tra moduli
✅ Ogni modulo deve essere indipendente

### 2. Modello Non Specializzato
❌ Non estendere il modello User
✅ Estendere SEMPRE il modello User

### 3. Risorsa Filament Non Base
❌ Non estendere XotBaseResource
✅ Estendere SEMPRE XotBaseResource

## Checklist

### Prima di Creare un Nuovo Modulo
- [ ] Struttura cartelle corretta
- [ ] Documentazione aggiornata
- [ ] Modelli specializzati
- [ ] Risorse Filament
- [ ] Test di integrazione

### Prima di Modificare un Modulo Esistente
- [ ] Verifica compatibilità
- [ ] Aggiorna la documentazione
- [ ] Test di regressione 
