# Single Table Inheritance (STI)

## Principi Fondamentali

### 1. Struttura Base
- Tutti i modelli specializzati (Doctor, Patient, ecc.) estendono il modello User
- Usare SEMPRE il trait `Parental\HasParent`
- Tutte le colonne dei modelli specializzati DEVONO essere nella tabella base

### 2. Migrazioni
- La colonna `type` va aggiunta SOLO nella migration della tabella base
- NON duplicare colonne nelle migration dei modelli specializzati
- Usare `tableUpdate()` e `hasColumn()` per modifiche

### 3. Validazione
- Validare SEMPRE l'unicità dell'email prima della creazione
- Usare unique indexes nella tabella base

## Esempio di Implementazione

### 1. Migration Base
```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up() {
        $this->tableUpdate('users', function (Blueprint $table) {
            if (!$this->hasColumn($table, 'type')) {
                $table->string('type')->nullable();
            }
            if (!$this->hasColumn($table, 'email')) {
                $table->string('email')->unique();
            }
            // altre colonne comuni
        });
    }
};
```

### 2. Modello Base
```php
<?php

namespace Modules\Xot\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'type',
        'email',
        // altri campi
    ];
}
```

### 3. Modello Specializzato
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

## Errori Comuni

### 1. Colonne Duplicate
❌ Aggiungere colonne già presenti nella tabella base
✅ Verificare sempre con `hasColumn()` prima di aggiungere

### 2. Colonna Type Mancante
❌ Non aggiungere la colonna `type` nella tabella base
✅ Aggiungere `type` nella migration della tabella base

### 3. Trait HasParent Mancante
❌ Non usare il trait `HasParent`
✅ Aggiungere `use HasParent;` nel modello specializzato

### 4. Validazione Email Mancante
❌ Non validare l'unicità dell'email
✅ Implementare validazione e unique index

## Checklist

### Prima di Creare un Nuovo Modello Specializzato
- [ ] Estende il modello User
- [ ] Usa il trait HasParent
- [ ] Tutte le colonne sono nella tabella base
- [ ] Validazione implementata
- [ ] Test di integrazione

### Prima di Modificare un Modello Esistente
- [ ] Verifica compatibilità con STI
- [ ] Aggiorna la documentazione
- [ ] Test di regressione 
