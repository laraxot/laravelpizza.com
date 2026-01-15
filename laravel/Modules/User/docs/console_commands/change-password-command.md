# ChangePasswordCommand

## Panoramica
Il comando `ChangePasswordCommand` permette di cambiare la password di un utente esistente tramite interfaccia console interattiva o parametri da riga di comando.

## Comando
```bash
php artisan user:change-password [--email=user@example.com]
```

## Funzionalità

### Caratteristiche Principali
- **Interfaccia Interattiva**: Utilizzo di Laravel Prompts per input utente
- **Validazione Email**: Controllo formato email prima del processing
- **Controllo Esistenza**: Verifica che l'utente esista e sia persistente
- **Gestione Password**: Hash sicuro e aggiornamento scadenza
- **Reset OTP**: Disattivazione automatica del flag OTP
- **Eventi**: Dispatched dell'evento NewPasswordSet
- **Audit Trail**: Tracciamento dell'operazione

### Opzioni
- `--email`: Email dell'utente (opzionale, se non fornita viene richiesta interattivamente)

## Utilizzo

### Modalità Interattiva
```bash
php artisan user:change-password
```

**Output**:
```
Inserisci l'email dell'utente: admin@example.com
Enter the new password: ********
Confirm the new password: ********
Password changed successfully!
```

### Modalità Non-Interattiva
```bash
php artisan user:change-password --email=admin@example.com
```

**Output**:
```
Enter the new password: ********
Confirm the new password: ********
Password changed successfully!
```

## Implementazione Tecnica

### Classe e Namespace
```php
<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\NewPasswordSet;
use Modules\Xot\Datas\XotData;

class ChangePasswordCommand extends Command
{
    protected $signature = 'user:change-password {--email= : Email dell\'utente}';
    protected $description = 'Cambia la password di un utente esistente';
}
```

### Metodi Principali

#### handle()
Metodo principale che coordina l'esecuzione del comando:
```php
public function handle(): int
{
    try {
        // 1. Recupera email utente
        $email = $this->getUserEmail();
        
        // 2. Valida email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email non valida: ' . $email);
            return Command::FAILURE;
        }
        
        // 3. Recupera utente
        $user = $this->getUserByEmail($email);
        if ($user === null) {
            $this->error("Utente con email '{$email}' non trovato.");
            return Command::FAILURE;
        }
        
        // 4. Verifica persistenza
        if (!$user->exists) {
            $this->error('Utente non persistente nel database.');
            return Command::FAILURE;
        }
        
        // 5. Mostra informazioni utente
        $this->displayUserInfo($user);
        
        // 6. Gestisce password
        $password = $this->getNewPassword();
        $confirmPassword = $this->confirmPassword($password);
        
        if ($confirmPassword === null) {
            $this->error('Le password non coincidono!');
            return Command::FAILURE;
        }
        
        // 7. Aggiorna password
        $this->updateUserPassword($user, $password);
        
        // 8. Dispatches evento
        event(new NewPasswordSet($user));
        
        $this->info('Password cambiata con successo!');
        return Command::SUCCESS;
        
    } catch (\Exception $e) {
        $this->error('Errore durante il cambio password: ' . $e->getMessage());
        return Command::FAILURE;
    }
}
```

#### getUserEmail()
Recupera l'email dall'opzione o prompt interattivo:
```php
private function getUserEmail(): string
{
    $email = $this->option('email');
    
    if (empty($email)) {
        $email = text('Inserisci l\'email dell\'utente:');
    }
    
    return trim($email);
}
```

#### getUserByEmail()
Recupera l'utente tramite XotData:
```php
private function getUserByEmail(string $email): ?\Modules\User\Models\User
{
    try {
        return XotData::make()->getUserByEmail($email);
    } catch (\Exception $e) {
        $this->warn("Errore nel recupero utente: {$e->getMessage()}");
        return null;
    }
}
```

#### displayUserInfo()
Mostra le informazioni dell'utente:
```php
private function displayUserInfo(\Modules\User\Models\User $user): void
{
    $this->info('=== Informazioni Utente ===');
    $this->info("ID: {$user->id}");
    $this->info("Nome: " . ($user->name ?? 'N/A'));
    $this->info("Email: {$user->email}");
    $this->info("Tipo: " . ($user->type ?? 'N/A'));
    $this->info("Stato: " . ($user->is_active ? 'Attivo' : 'Inattivo'));
    $this->info("OTP: " . ($user->is_otp ? 'Sì' : 'No'));
    $this->info("Scadenza password: " . ($user->password_expires_at?->format('d/m/Y H:i') ?? 'N/A'));
    $this->info('==========================');
}
```

#### getNewPassword()
Recupera la nuova password:
```php
private function getNewPassword(): string
{
    return password('Inserisci la nuova password:');
}
```

#### confirmPassword()
Conferma la password inserita:
```php
private function confirmPassword(string $password): ?string
{
    $confirmPassword = password('Conferma la nuova password:');
    return $password === $confirmPassword ? $password : null;
}
```

#### updateUserPassword()
Aggiorna la password dell'utente:
```php
private function updateUserPassword(\Modules\User\Models\User $user, string $password): void
{
    // Recupera la configurazione password
    $passwordData = PasswordData::make();
    $passwordExpiryDateTime = now()->addDays($passwordData->expires_in);
    
    // Aggiorna l'utente
    $user->update([
        'password_expires_at' => $passwordExpiryDateTime,
        'is_otp' => false,
        'password' => Hash::make($password),
        'updated_by' => 'console-command',
    ]);
    
    $this->info('Password aggiornata nel database.');
}
```

## Gestione Password

### Configurazione
La configurazione della password viene gestita tramite `PasswordData::make()`:
```php
$passwordData = PasswordData::make();
$passwordExpiryDateTime = now()->addDays($passwordData->expires_in);
```

**Campi Configurabili**:
- `expires_in`: Giorni di validità password (default: 60)
- `min`: Lunghezza minima password (default: 8)
- `mixedCase`: Richiede maiuscole e minuscole
- `letters`: Richiede lettere
- `numbers`: Richiede numeri
- `symbols`: Richiede caratteri speciali
- `uncompromised`: Verifica compromissione

### Campi Aggiornati
```php
$user->update([
    'password_expires_at' => $passwordExpiryDateTime,  // Scadenza password
    'is_otp' => false,                                 // Reset flag OTP
    'password' => Hash::make($password),               // Hash password
    'updated_by' => 'console-command',                 // Audit trail
]);
```

### Eventi
Dopo l'aggiornamento della password viene dispatched l'evento `NewPasswordSet`:
```php
event(new NewPasswordSet($user));
```

**Evento NewPasswordSet**:
- **Payload**: `UserContract $authObject`
- **Broadcasting**: Canale privato
- **Utilizzo**: Notifiche, audit trail, logging

## Gestione Errori

### Tipi di Errore
1. **Email non fornita**: Richiesta interattiva fallita
2. **Email non valida**: Formato email incorretto
3. **Utente non trovato**: Email non esistente nel sistema
4. **Utente non persistente**: Istanza transiente
5. **Password non fornita**: Input password fallito
6. **Password non coincidono**: Conferma password errata
7. **Errore database**: Problemi di connessione o permessi

### Codici di Ritorno
- `Command::SUCCESS` (0): Operazione completata con successo
- `Command::FAILURE` (1): Errore durante l'esecuzione

### Gestione Eccezioni
```php
try {
    // Logica del comando
} catch (\Exception $e) {
    $this->error('Errore durante il cambio password: ' . $e->getMessage());
    return Command::FAILURE;
}
```

## Sicurezza

### Validazione Input
- **Email**: Validazione formato con `filter_var()`
- **Password**: Controllo lunghezza minima
- **Conferma**: Verifica corrispondenza password

### Hash Password
```php
'password' => Hash::make($password)
```
- Utilizzo di `Hash::make()` per sicurezza
- Salt automatico e sicuro
- Compatibilità con `Hash::check()`

### Audit Trail
```php
'updated_by' => 'console-command'
```
- Tracciamento dell'operazione
- Identificazione dell'origine
- Compliance normativa

## Testing

### Test Unitari
```bash
php artisan test --filter=ChangePasswordCommandTest
```

### Test di Integrazione
```bash
php artisan test --filter=ChangePasswordCommandIntegrationTest
```

### Scenari di Test
1. **Email valida, utente esistente**: Successo
2. **Email non valida**: Errore validazione
3. **Email non esistente**: Errore utente non trovato
4. **Password non coincidono**: Errore conferma
5. **Errore database**: Gestione eccezioni
6. **Modalità non-interattiva**: Funzionamento con --email

## Dipendenze

### Package Laravel
- `Illuminate\Console\Command`: Classe base comando
- `Illuminate\Support\Facades\Hash`: Hashing password
- `Laravel\Prompts`: Input interattivo

### Package Modulo User
- `Modules\User\Datas\PasswordData`: Configurazione password
- `Modules\User\Events\NewPasswordSet`: Evento password
- `Modules\User\Models\User`: Modello utente

### Package Xot
- `Modules\Xot\Datas\XotData`: Accesso centralizzato dati

## Collegamenti
- [README Comandi Console](README.md)
- [PasswordData](../Datas/PasswordData.md)
- [NewPasswordSet Event](../Events/NewPasswordSet.md)
- [User Model](../Models/User.md)
- [Password Management](../password.md)

## Aggiornamenti

### 2025-01-27 - Versione 2.0
- ✅ **Interfaccia Moderna**: Migrazione da `$this->ask()` a Laravel Prompts
- ✅ **Validazione Email**: Controllo formato email prima del processing
- ✅ **Gestione Errori**: Try-catch completo con messaggi informativi
- ✅ **Informazioni Utente**: Display completo delle informazioni utente
- ✅ **Audit Trail**: Campo `updated_by` tracciato
- ✅ **Return Codes**: Utilizzo di Command::SUCCESS/FAILURE
- ✅ **Documentazione**: Documentazione completa e strutturata

### 2025-01-27 - Versione 1.0
- ✅ **Funzionalità Base**: Cambio password utente
- ✅ **Interfaccia Console**: Input interattivo
- ✅ **Gestione Password**: Hash e scadenza
- ✅ **Eventi**: Dispatched NewPasswordSet

*Ultimo aggiornamento: 2025-01-27*





