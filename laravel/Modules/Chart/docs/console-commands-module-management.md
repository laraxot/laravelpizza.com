# Console Commands - Gestione Moduli

## Panoramica
I comandi console per la gestione dei moduli permettono di assegnare e revocare moduli agli utenti tramite interfacce interattive moderne.

## AssignModuleCommand

### Descrizione
Comando interattivo per assegnare o revocare moduli a/da un utente con multiselect pre-checked.

### Funzionalità Principali
- **Multiselect Interattivo**: Interfaccia moderna con Laravel Prompts
- **Stato Corrente**: I moduli già assegnati sono pre-checked
- **Assegnazione/Revoca**: Gestione bidirezionale dei moduli
- **Feedback Visivo**: Messaggi chiari per ogni operazione
- **Gestione Errori**: Controlli preventivi e robusti

### Utilizzo
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

### Architettura
- **Namespace**: `Modules\User\Console\Commands`
- **Estensione**: `Illuminate\Console\Command`
- **Prompts**: Laravel Prompts moderni (`text()`, `multiselect()`)
- **Contracts**: `UserContract` per type safety

### Logica di Assegnazione
1. **Recupero Utente**: `XotData::make()->getUserByEmail()`
2. **Estrazione Ruoli**: Filtra pattern `{module}::admin`
3. **Calcolo Differenze**: 
   - `array_diff($selectedModules, $currentModules)` per assegnazioni
   - `array_diff($currentModules, $selectedModules)` per revoche
4. **Operazioni**: `assignRole()` e `removeRole()`

### Pattern dei Ruoli
- **Formato**: `{module}::admin` (es. `user::admin`)
- **Creazione**: `Role::firstOrCreate()` automatica
- **Guard**: Default web guard

## Best Practices

### Filosofia Laraxot
- **Strict Types**: `declare(strict_types=1);` obbligatorio
- **Laravel Prompts**: Solo API moderne, no `ask()` legacy
- **XotData**: Accesso centralizzato ai dati
- **Contracts**: Type safety con interfacce
- **Error Handling**: Controlli preventivi

### Pattern di Codice
```php
// Recupero utente con controllo
$user = XotData::make()->getUserByEmail($email);
if (!$user) {
    $this->error("User with email '{$email}' not found.");
    return;
}

// Multiselect con default
$selectedModules = multiselect(
    label: 'Select modules (checked = assigned, unchecked = will be revoked)',
    options: $modules_opts,
    default: $currentModules, // Pre-checked
    required: false,
    scroll: 10,
);
```

## Gestione Errori

### Controlli Implementati
- **Utente Non Trovato**: Verifica esistenza prima dell'elaborazione
- **Ruoli Non Esistenti**: Creazione automatica tramite `firstOrCreate()`
- **Input Vuoto**: Permette selezione vuota (revoca tutti)

### Messaggi di Feedback
- **Info**: Operazioni di assegnazione completate
- **Warn**: Operazioni di revoca completate  
- **Error**: Errori critici (utente non trovato)

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

## Comandi Correlati

### AssignRoleCommand
- Assegnazione ruoli specifici
- Pattern: `php artisan user:assign-role`

### RemoveRoleCommand  
- Rimozione ruoli specifici
- Pattern: `php artisan user:remove-role`

### SuperAdminCommand
- Gestione super admin
- Pattern: `php artisan user:super-admin`

## Aggiornamenti

### Versione 2025-01-27
- ✅ **Multiselect con Pre-checked**: I moduli già assegnati sono pre-checked
- ✅ **Revoca Moduli**: Possibilità di revocare moduli dechecking
- ✅ **Feedback Migliorato**: Messaggi chiari per assegnazioni e revoche
- ✅ **Gestione Errori**: Controlli preventivi per utenti non trovati
- ✅ **Documentazione**: Documentazione completa con esempi

## Collegamenti
- [User Module Console Commands](../../laravel/Modules/User/docs/console_commands_philosophy.md)
- [AssignModuleCommand Details](../../laravel/Modules/User/docs/console_commands/assign-module-command.md)
- [User Models](../../laravel/Modules/User/docs/models/README.md)
- [Bug Fixing Guidelines](bug-fixing-guidelines.md)

*Ultimo aggiornamento: 2025-01-27* 