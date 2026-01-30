# Standard dei Percorsi

## Struttura Base Moduli

Ogni modulo Laravel deve seguire questa struttura standard:

```
ModuleName/
├── app/
│   ├── Actions/
│   ├── Commands/
│   ├── Console/
│   ├── Contracts/
│   ├── Data/
│   ├── Enums/
│   ├── Events/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Jobs/
│   ├── Listeners/
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Providers/
│   ├── Rules/
│   ├── Services/
│   └── Support/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/
├── lang/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
└── tests/
```

## Regole Generali

1. **Namespace e Percorsi**
   - Tutti i file devono essere nella cartella `app/` del modulo
   - Il namespace deve riflettere la struttura delle cartelle
   - Esempio: `Modules\<nome progetto>\App\Enums\AppointmentType`

2. **Enums**
   - Posizione corretta: `app/Enums/`
   - Namespace: `Modules\<nome progetto>\App\Enums`
   - Esempio: `AppointmentType.php` deve essere in `app/Enums/`

3. **Models**
   - Posizione corretta: `app/Models/`
   - Namespace: `Modules\<nome progetto>\App\Models`
   - Esempio: `Appointment.php` deve essere in `app/Models/`

4. **Controllers**
   - Posizione corretta: `app/Http/Controllers/`
   - Namespace: `Modules\<nome progetto>\App\Http\Controllers`
   - Esempio: `AppointmentController.php` deve essere in `app/Http/Controllers/`

## Esempi di Percorsi Corretti

```php
// Corretto
namespace Modules\<nome progetto>\App\Enums;
class AppointmentType extends Enum { ... }

// Corretto
namespace Modules\<nome progetto>\App\Models;
class Appointment extends Model { ... }

// Corretto
namespace Modules\<nome progetto>\App\Http\Controllers;
class AppointmentController extends Controller { ... }
```

## Esempi di Percorsi Errati

```php
// Errato - Enums fuori da app/
namespace Modules\<nome progetto>\Enums;
class AppointmentType extends Enum { ... }

// Errato - Models fuori da app/
namespace Modules\<nome progetto>\Models;
class Appointment extends Model { ... }

// Errato - Controllers fuori da app/
namespace Modules\<nome progetto>\Http\Controllers;
class AppointmentController extends Controller { ... }
```

## Best Practices

1. **Organizzazione**
   - Mantenere una struttura coerente in tutti i moduli
   - Seguire le convenzioni PSR-4
   - Utilizzare i namespace corretti

2. **Documentazione**
   - Documentare la struttura delle cartelle nel README del modulo
   - Mantenere aggiornata la documentazione dei percorsi
   - Includere esempi di utilizzo

3. **Validazione**
   - Verificare i percorsi prima del commit
   - Utilizzare strumenti di analisi statica
   - Mantenere test per la struttura del modulo

4. **Automazione**
   - Utilizzare comandi artisan per la creazione di file
   - Implementare script di validazione dei percorsi
   - Automatizzare la generazione della documentazione

## Strumenti di Validazione

1. **Comandi Artisan**
```bash

# Verifica struttura moduli
php artisan module:check-structure

# Genera file nel percorso corretto
php artisan make:module:enum <nome progetto> AppointmentType
```

2. **Script di Validazione**
```bash

# Verifica percorsi
./vendor/bin/phpstan analyse --paths-file=paths.txt

# Verifica namespace
./vendor/bin/phpcs --standard=PSR4
```

## Checklist

- [ ] Verificare che tutti i file siano nella cartella `app/`
- [ ] Controllare che i namespace siano corretti
- [ ] Validare la struttura delle cartelle
- [ ] Aggiornare la documentazione
- [ ] Eseguire test di validazione
- [ ] Verificare compatibilità con IDE

## Note Importanti

1. **IDE Support**
   - Configurare correttamente il file `.phpstorm.meta.php`
   - Aggiornare le configurazioni di VS Code
   - Mantenere aggiornati i file di configurazione

2. **Version Control**
   - Includere `.gitignore` appropriato
   - Mantenere la struttura nel repository
   - Documentare le modifiche alla struttura

3. **Deployment**
   - Verificare i percorsi in produzione
   - Mantenere la struttura in ambienti di staging
   - Documentare le configurazioni specifiche

---

