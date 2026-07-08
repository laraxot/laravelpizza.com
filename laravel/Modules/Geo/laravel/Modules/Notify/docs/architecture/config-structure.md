# Struttura di Configurazione nei Moduli
# Struttura di Configurazione nei Moduli <nome progetto>

## Principi di Configurazione

1. **Separazione tra Specifico e Generico**
   - **Configurazione Specifica del Provider**: Credenziali e parametri di connessione specifici
   - **Configurazione Generica**: Comportamenti applicabili a tutti i provider

2. **Struttura di Configurazione in `config/sms.php`**
   ```php
   return [
       'default' => env('SMS_DRIVER', 'default_driver'),

       // Specifico per provider - Solo parametri di autenticazione e identificazione
       'drivers' => [
           'provider1' => [
               'api_key' => env('PROVIDER1_API_KEY'),
               'sender' => env('PROVIDER1_SENDER'),
               // Solo parametri specifici per la connessione!
           ],
           'provider2' => [
               'username' => env('PROVIDER2_USERNAME'),
               'password' => env('PROVIDER2_PASSWORD'),
               // Solo parametri specifici per la connessione!
           ],
       ],

       // Configurazione generica - Applicabile a tutti i provider
       'retry' => [
           'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
           'delay' => env('SMS_RETRY_DELAY', 60),
       ],

       'rate_limit' => [
           'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
           'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
           'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
       ],

       // Altre configurazioni generiche
   ];
   ```

## Errori Comuni da Evitare

1. **MAI duplicare configurazioni generiche nelle sezioni dei provider specifici**
   - ❌ ERRATO: Aggiungere `retry`, `rate_limit`, ecc. nella sezione del provider
   - ✅ CORRETTO: Usare le sezioni generiche per comportamenti comuni

2. **MAI aggiungere parametri non necessari nella configurazione del provider**
   - ❌ ERRATO: Aggiungere threshold, timeout, debug nella configurazione del provider
   - ✅ CORRETTO: Includere solo parametri essenziali (api_key, token, credenziali)

3. **SEMPRE distinguere tra configurazione e implementazione**
   - La configurazione definisce i parametri
   - L'implementazione (Action, Service) gestisce la logica di utilizzo

## Best Practices

1. **Usa Variabili d'Ambiente per Tutti i Valori Sensibili**
   ```php
   'api_key' => env('PROVIDER_API_KEY'),
   ```

2. **Fornisci Valori di Default Sensati**
   ```php
   'timeout' => env('SMS_TIMEOUT', 30), // Default a 30 secondi
   ```

3. **Usa Commenti per Spiegare Unità di Misura e Significato**
   ```php
   'delay' => env('SMS_RETRY_DELAY', 60), // Secondi
   ```

4. **Centralizza Logiche Comuni**
   - Rate limit, retry e circuit breaking dovrebbero essere configurati una volta sola
   - L'implementazione dovrebbe utilizzare queste configurazioni generiche
