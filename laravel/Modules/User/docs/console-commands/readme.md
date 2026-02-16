# Comandi Console - Modulo User

## Panoramica
I comandi console del modulo User forniscono interfacce interattive moderne per la gestione di utenti, ruoli, moduli e password. Tutti i comandi seguono gli standard Laraxot con tipizzazione rigorosa e gestione errori robusta.

## Comandi Disponibili

### ChangePasswordCommand
**Comando**: `user:change-password`
**Descrizione**: Cambia la password di un utente esistente
**Funzionalità**:
- ✅ Interfaccia interattiva con Laravel Prompts
- ✅ Validazione email e password
- ✅ Controllo esistenza utente
- ✅ Aggiornamento automatico scadenza password
- ✅ Reset flag OTP
- ✅ Evento NewPasswordSet
- ✅ Gestione errori completa

**Utilizzo**:
```bash
# Interattivo
php artisan user:change-password

# Con email specificata
php artisan user:change-password --email=user@example.com
```

**Esempio Output**:
```
Inserisci l'email dell'utente: admin@example.com
Enter the new password: ********
Confirm the new password: ********
Password changed successfully!
```

### AssignModuleCommand
**Comando**: `user:assign-module`
**Descrizione**: Assegnazione/revoca moduli con multiselect pre-checked
**Funzionalità**:
- ✅ Multiselect interattivo con Laravel Prompts
- ✅ Moduli già assegnati pre-checked
- ✅ Assegnazione nuovi moduli
- ✅ Revoca moduli dechecked
- ✅ Feedback visivo completo
- ✅ Gestione errori robusta

**Utilizzo**:
```bash
php artisan user:assign-module
```

**Esempio Output**:
```
email ? admin@example.com
Current modules for admin@example.com: User, Xot, UI

Select modules (checked = assigned, unchecked = will be revoked):
 ◉ User
 ◉ Xot  
 ◉ UI
 ◯ Performance
 ◯ Patient

✓ Assigned module: Performance
✗ Revoked module: UI
Module assignment updated for admin@example.com
```

### AssignRoleCommand
**Comando**: `user:assign-role`
**Descrizione**: Assegnazione ruoli specifici
**Documentazione**: [Dettagli](assign-role-command.md)

### RemoveRoleCommand
**Comando**: `user:remove-role`
**Descrizione**: Rimozione ruoli specifici
**Documentazione**: [Dettagli](remove-role-command.md)

### SuperAdminCommand
**Comando**: `user:super-admin`
**Descrizione**: Gestione super admin
**Documentazione**: [Dettagli](super-admin-command.md)

## Architettura

### Filosofia Laraxot
- **Strict Types**: `declare(strict_types=1);` obbligatorio
- **Laravel Prompts**: Solo API moderne (`text()`, `multiselect()`, `password()`)
- **XotData**: Accesso centralizzato ai dati
- **Contracts**: Type safety con interfacce
- **Error Handling**: Controlli preventivi e gestione eccezioni

### Pattern Comuni
```php
// Recupero utente con controllo
$user = XotData::make()->getUserByEmail($email);
if (!$user) {
    $this->error("User with email '{$email}' not found.");
    return Command::FAILURE;
}

// Prompts interattivi
$email = text('email ?');
$selectedModules = multiselect(
    label: 'Select modules',
    options: $modules_opts,
    default: $currentModules,
    required: false,
    scroll: 10,
);

// Gestione password
$password = password('Enter new password:');
$confirmPassword = password('Confirm password:');
```

## Gestione Password

### Configurazione Password
- **Scadenza**: Configurata tramite `PasswordData::make()->expires_in` (default: 60 giorni)
- **Validazione**: Minimo 8 caratteri, regole configurabili
- **Hash**: Utilizzo di `Hash::make()` per sicurezza
- **OTP Reset**: Flag `is_otp` resettato automaticamente

### Campi Aggiornati
```php
$user->update([
    'password_expires_at' => now()->addDays($passwordData->expires_in),
    'is_otp' => false,
    'password' => Hash::make($password),
    'updated_by' => 'console-command',
]);
```

### Eventi
- **NewPasswordSet**: Dispatched dopo aggiornamento password
- **Audit Trail**: Campo `updated_by` tracciato
- **Notifiche**: Possibilità di notificare utente

## Gestione Ruoli

### Pattern dei Ruoli
- **Formato**: `{module}::admin` (es. `user::admin`, `performance::admin`)
- **Creazione**: `Role::firstOrCreate()` automatica
- **Guard**: Default web guard
- **Relazioni**: `model_has_roles` pivot table

### Operazioni Supportate
- **Assegnazione**: `$user->assignRole($role)`
- **Revoca**: `$user->removeRole($role_name)`
- **Verifica**: `$user->hasRole($role)`
- **Lista**: `$user->roles` (relazione)

## Best Practices

### Codice
- Utilizzare sempre `declare(strict_types=1);`
- Implementare controlli preventivi per utenti non trovati
- Fornire feedback visivo chiaro per ogni operazione
- Gestire errori con messaggi appropriati
- Utilizzare contracts per type safety
- Restituire `Command::SUCCESS` o `Command::FAILURE`

### UX
- Mostrare stato corrente prima delle modifiche
- Utilizzare simboli visivi (✓, ✗) per feedback
- Permettere operazioni di revoca
- Fornire messaggi di riepilogo
- Gestire casi edge (utente non trovato, nessuna modifica)

### Testing
- Verificare sintassi con `php -l`
- Testare con utenti esistenti e non esistenti
- Verificare assegnazione e revoca
- Controllare feedback visivo
- Testare gestione errori
- Verificare eventi e notifiche

## Struttura File

```
Modules/User/
├── app/
│   └── Console/
│       └── Commands/
│           ├── ChangePasswordCommand.php
│           ├── AssignModuleCommand.php
│           ├── AssignRoleCommand.php
│           ├── RemoveRoleCommand.php
│           └── SuperAdminCommand.php
├── docs/
│   └── console_commands/
│       ├── README.md (questo file)
│       ├── change-password-command.md
│       ├── assign-module-command.md
│       ├── assign-role-command.md
│       └── super-admin-command.md
└── tests/
    └── Unit/
        └── Commands/
            ├── ChangePasswordCommandTest.php
            ├── AssignModuleCommandTest.php
            └── ...
```

## Collegamenti
- [Console Commands Philosophy](console_commands_philosophy.md)
- [User Models](../models/README.md)
- [Role Management](../models/role-management.md)
- [Password Management](../password.md)
- [README.md](../README.md)

## Aggiornamenti Recenti

### 2025-01-27 - ChangePasswordCommand
- ✅ **Interfaccia Moderna**: Utilizzo di Laravel Prompts per input
- ✅ **Validazione Email**: Controllo formato email prima del processing
- ✅ **Gestione Errori**: Try-catch completo con messaggi informativi
- ✅ **Informazioni Utente**: Display completo delle informazioni utente
- ✅ **Audit Trail**: Campo `updated_by` tracciato
- ✅ **Eventi**: Dispatched evento NewPasswordSet
- ✅ **Return Codes**: Utilizzo di Command::SUCCESS/FAILURE

### 2025-01-27 - AssignModuleCommand
- ✅ **Multiselect con Pre-checked**: I moduli già assegnati sono pre-checked
- ✅ **Revoca Moduli**: Possibilità di revocare moduli dechecking
- ✅ **Feedback Migliorato**: Messaggi chiari per assegnazioni e revoche
- ✅ **Gestione Errori**: Controlli preventivi per utenti non trovati
- ✅ **Documentazione**: Documentazione completa con esempi

## Prossimi Sviluppi

### Comandi Pianificati
- [ ] `user:reset-password` - Reset password con invio email
- [ ] `user:bulk-assign-role` - Assegnazione ruoli in massa
- [ ] `user:audit-log` - Visualizzazione log audit utente
- [ ] `user:sync-permissions` - Sincronizzazione permessi

### Miglioramenti Tecnici
- [ ] Test di integrazione completi
- [ ] Validazione input avanzata
- [ ] Logging strutturato
- [ ] Metriche di utilizzo

*Ultimo aggiornamento: 2025-01-27* 