# Trait HasAuthenticationLogTrait

## Descrizione
Il trait `HasAuthenticationLogTrait` fornisce funzionalità per il logging degli eventi di autenticazione. Permette di tracciare i tentativi di login, gli IP, i timestamp e altre informazioni relative all'autenticazione.

## Proprietà
- `$authentications`: Collection di log di autenticazione
- `$login_at`: Timestamp dell'ultimo login
- `$ip_address`: Indirizzo IP dell'ultimo login

## Metodi Principali

### Relazioni
- `authentications()`: Restituisce la relazione one-to-many con i log di autenticazione

### Log di Autenticazione
- `latestAuthentication()`: Restituisce l'ultimo tentativo di autenticazione
- `notifyAuthenticationLogVia()`: Specifica i canali di notifica per i log di autenticazione

### Informazioni di Login
- `lastLoginAt()`: Restituisce il timestamp dell'ultimo login
- `lastSuccessfulLoginAt()`: Restituisce il timestamp dell'ultimo login riuscito
- `lastLoginIp()`: Restituisce l'IP dell'ultimo login
- `lastSuccessfulLoginIp()`: Restituisce l'IP dell'ultimo login riuscito
- `previousLoginAt()`: Restituisce il timestamp del penultimo login
- `previousLoginIp()`: Restituisce l'IP del penultimo login

### Statistiche
- `consecutiveDaysLogin()`: Calcola il numero di giorni consecutivi di login
- `getAuthenticationLogsAttribute()`: Restituisce le statistiche dei log di autenticazione

## Utilizzo
```php
use Modules\User\Models\Traits\HasAuthenticationLogTrait;

class User extends Authenticatable
{
    use HasAuthenticationLogTrait;
    
    // ... resto del codice
}
```

## Note
- Il trait richiede una tabella `authentication_logs` con le colonne:
  - `id`
  - `authenticatable_type`
  - `authenticatable_id`
  - `ip_address`
  - `user_agent`
  - `login_at`
  - `login_successful`
  - `created_at`
  - `updated_at`
- I log vengono automaticamente creati quando un utente tenta di autenticarsi
- Le notifiche vengono inviate tramite email per default
- Il trait supporta il tracciamento di tentativi di login falliti e riusciti 