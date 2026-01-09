# AssignModuleCommand - Gestione Moduli Utente

## Descrizione
Il comando `user:assign-module` permette di assegnare o revocare moduli a/da un utente tramite un'interfaccia interattiva con multiselect.

## Funzionalità

### Caratteristiche Principali
- **Multiselect Interattivo**: Mostra tutti i moduli disponibili con checkbox
- **Stato Corrente**: I moduli già assegnati all'utente sono pre-checked
- **Assegnazione/Revoca**: Permette di assegnare nuovi moduli e revocare quelli esistenti
- **Feedback Visivo**: Mostra chiaramente le operazioni eseguite
- **Gestione Errori**: Controlli preventivi per utenti non trovati

### Comportamento
1. **Input Email**: Richiede l'email dell'utente
2. **Verifica Utente**: Controlla che l'utente esista
3. **Mostra Stato Corrente**: Visualizza i moduli attualmente assegnati
4. **Multiselect**: Presenta tutti i moduli con quelli assegnati pre-checked
5. **Elaborazione**: Assegna nuovi moduli e revoca quelli dechecked
6. **Feedback**: Mostra un riepilogo delle operazioni eseguite

## Utilizzo

### Comando Base
```bash
php artisan user:assign-module
```

### Flusso Interattivo
```
email ? admin@example.com
Current modules for admin@example.com: User, Xot, UI

Select modules (checked = assigned, unchecked = will be revoked):
 ◉ User
 ◉ Xot
 ◉ UI
 ◯ Performance
 ◯ Patient
 ◯ Dental
```

### Output di Esempio
```
✓ Assigned module: Performance
✗ Revoked module: UI
Module assignment updated for admin@example.com
```

## Implementazione Tecnica

### Struttura del Comando
```php
class AssignModuleCommand extends Command
{
    protected $name = 'user:assign-module';
    protected $description = 'Assign or revoke modules to/from user';

    public function handle(): void
    {
        // Implementazione del flusso
    }

    private function getUserModuleRoles(UserContract $user): array
    {
        // Estrazione ruoli modulo dell'utente
    }
}
```

### Logica di Assegnazione
1. **Recupero Moduli Disponibili**: `Module::all()` per tutti i moduli
2. **Estrazione Ruoli Correnti**: Filtra ruoli con pattern `{module}::admin`
3. **Calcolo Differenze**:
   - `$modulesToAssign = array_diff($selectedModules, $currentModules)`
   - `$modulesToRevoke = array_diff($currentModules, $selectedModules)`
4. **Assegnazione**: `$user->assignRole($role)` per nuovi moduli
5. **Revoca**: `$user->removeRole($role_name)` per moduli dechecked

### Pattern dei Ruoli
- **Formato**: `{module}::admin` (es. `user::admin`, `performance::admin`)
- **Creazione**: `Role::firstOrCreate()` per ruoli non esistenti
- **Guard**: Utilizza il guard di default (web)

## Gestione Errori

### Controlli Implementati
- **Utente Non Trovato**: Verifica esistenza prima dell'elaborazione
- **Ruoli Non Esistenti**: Creazione automatica tramite `firstOrCreate()`
- **Input Vuoto**: Permette selezione vuota (revoca tutti i moduli)

### Messaggi di Feedback
- **Info**: Operazioni di assegnazione completate
- **Warn**: Operazioni di revoca completate
- **Error**: Errori critici (utente non trovato)

## Best Practices

### Filosofia Laraxot
- **Strict Types**: `declare(strict_types=1);` obbligatorio
- **Laravel Prompts**: Solo `text()` e `multiselect()` moderni
- **XotData**: Accesso utente tramite `XotData::make()->getUserByEmail()`
- **Contracts**: Utilizzo di `UserContract` per type safety
- **Error Handling**: Controlli preventivi e messaggi chiari

### Pattern di Codice
```php
// Recupero utente con controllo
$user = XotData::make()->getUserByEmail($email);
if (!$user) {
    $this->error("User with email '{$email}' not found.");
    return;
}

// Estrazione ruoli modulo
$userModuleRoles = $this->getUserModuleRoles($user);
$currentModules = array_keys($userModuleRoles);

// Multiselect con default
$selectedModules = multiselect(
    label: 'Select modules (checked = assigned, unchecked = will be revoked)',
    options: $modules_opts,
    default: $currentModules, // Pre-checked
    required: false,
    scroll: 10,
);
```

## Esempi di Utilizzo

### Scenario 1: Assegnazione Nuovi Moduli
```
Input: admin@example.com
Current: User, Xot
Selected: User, Xot, Performance, Patient
Result: ✓ Assigned Performance, ✓ Assigned Patient
```

### Scenario 2: Revoca Moduli
```
Input: admin@example.com
Current: User, Xot, Performance, Patient
Selected: User, Xot
Result: ✗ Revoked Performance, ✗ Revoked Patient
```

### Scenario 3: Nessuna Modifica
```
Input: admin@example.com
Current: User, Xot
Selected: User, Xot
Result: No changes made to user modules.
```

## Collegamenti
- [Console Commands Philosophy](console_commands_philosophy.md)
- [User Models](models/README.md)
- [Role Management](models/role-management.md)
- [README.md](../README.md)

## Aggiornamenti

### Versione 2025-01-27
- ✅ **Multiselect con Pre-checked**: I moduli già assegnati sono pre-checked
- ✅ **Revoca Moduli**: Possibilità di revocare moduli dechecking
- ✅ **Feedback Migliorato**: Messaggi chiari per assegnazioni e revoche
- ✅ **Gestione Errori**: Controlli preventivi per utenti non trovati
- ✅ **Documentazione**: Documentazione completa con esempi

*Ultimo aggiornamento: 2025-01-27*
