# Correzione della Struttura del Progetto

## Problemi Attuali
1. I modelli sono stati creati nella cartella `laravel/app/Models` invece che in `Modules/Patient/Entities`
2. Le risorse Filament sono state create in `laravel/app/Filament` invece che in `Modules/Patient/Filament`
3. Le migrazioni sono state create in `laravel/database/migrations` invece che in `Modules/Patient/Database/Migrations`
4. La configurazione è stata creata in `laravel/config` invece che in `Modules/Patient/Config`

## Azioni di Correzione

### 1. Spostamento dei Modelli
```bash

# Creare la struttura corretta
mkdir -p Modules/Patient/Entities

# Spostare i modelli
mv laravel/app/Models/Patient.php Modules/Patient/Entities/
mv laravel/app/Models/Document.php Modules/Patient/Entities/
mv laravel/app/Models/Anamnesis.php Modules/Patient/Entities/

# Aggiornare i namespace
namespace Modules\Patient\Entities;
```

### 2. Spostamento delle Risorse Filament
```bash

# Creare la struttura corretta
mkdir -p Modules/Patient/Filament/Resources

# Spostare le risorse
mv laravel/app/Filament/Resources/PatientResource.php Modules/Patient/Filament/Resources/
mv laravel/app/Filament/Resources/DocumentResource.php Modules/Patient/Filament/Resources/

# Aggiornare i namespace
namespace Modules\Patient\Filament\Resources;
```

### 3. Spostamento delle Migrazioni
```bash

# Creare la struttura corretta
mkdir -p Modules/Patient/Database/Migrations

# Spostare le migrazioni
mv laravel/database/migrations/2024_03_20_000001_create_patients_table.php Modules/Patient/Database/Migrations/
mv laravel/database/migrations/2024_03_20_000002_create_documents_table.php Modules/Patient/Database/Migrations/
mv laravel/database/migrations/2024_03_20_000003_create_anamnesis_table.php Modules/Patient/Database/Migrations/
```

### 4. Spostamento della Configurazione
```bash

# Creare la struttura corretta
mkdir -p Modules/Patient/Config

# Spostare la configurazione
mv laravel/config/patient.php Modules/Patient/Config/config.php

# Aggiornare i riferimenti nei file
```

## Aggiornamento dei Namespace
In tutti i file spostati, è necessario aggiornare i namespace e i riferimenti:

1. Nei modelli:
```php
use Modules\Patient\Entities\Patient;
use Modules\Patient\Entities\Document;
use Modules\Patient\Entities\Anamnesis;
```

2. Nelle risorse Filament:
```php
use Modules\Patient\Entities\Patient;
use Modules\Patient\Entities\Document;
```

3. Nella configurazione:
```php
'patient' => \Modules\Patient\Entities\Patient::class,
'document' => \Modules\Patient\Entities\Document::class,
'anamnesis' => \Modules\Patient\Entities\Anamnesis::class,
```

## Verifica Post-Correzione
1. Controllare che tutti i namespace siano corretti
2. Verificare che le dipendenze tra moduli siano corrette
3. Eseguire i test per assicurarsi che tutto funzioni
4. Verificare che le migrazioni possano essere eseguite
