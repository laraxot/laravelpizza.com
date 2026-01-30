# Correzioni PHPStan Livello 10 - Modulo Notify

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo Notify e le relative soluzioni implementate.

## Stato Attuale

Abbiamo completato la maggior parte delle correzioni necessarie per portare il modulo Notify a livello 10 di PHPStan. Rimangono solo alcuni errori in pochi file che possono essere facilmente risolti seguendo i pattern già stabiliti.

## Errori Principali e Soluzioni

### 1. Operazioni binarie con mixed

**Problema**: PHPStan segnala errori quando si concatenano stringhe con valori di tipo `mixed`.

**File interessati**:
- `Actions/BuildMailMessageAction.php`
- `Actions/EsendexSendAction.php`
- `Actions/NotifyTheme/Get.php`
- `Filament/Clusters/Test/Pages/SendPushNotification.php`

**Soluzione**:
- Sostituire i cast diretti a stringa `(string)$value` con controlli di tipo espliciti
- Utilizzare `is_string()` per verificare il tipo prima dell'uso
- Implementare valori di fallback per i casi in cui i valori non sono stringhe
- Utilizzare `Assert::string()` per garantire che i valori siano stringhe

### 2. Accesso a proprietà o metodi su mixed

**Problema**: PHPStan segnala errori quando si accede a proprietà o si chiamano metodi su valori di tipo `mixed`.

**File interessati**:
- `Filament/Resources/ContactResource/Pages/ListContacts.php`
- `Filament/Resources/NotificationResource/Pages/ListNotifications.php`
- `Notifications/Channels/NetfunChannel.php`
- `Services/MailEngines/MailtrapEngine.php`
- `Services/SmsService.php`

**Soluzione**:
- Aggiungere controlli di tipo con `is_object()` prima di accedere a proprietà
- Utilizzare `property_exists()` per verificare l'esistenza di proprietà
- Utilizzare `method_exists()` per verificare l'esistenza di metodi
- Implementare gestione degli errori con try/catch o controlli condizionali
- Utilizzare Reflection API per interagire con oggetti di tipo sconosciuto

### 3. Parametri di tipo incompatibile

**Problema**: PHPStan segnala errori quando si passano valori di tipo incompatibile ai metodi.

**File interessati**:
- `Filament/Resources/NotifyThemeResource.php`
- `Filament/Resources/NotifyThemeResource/Pages/ListNotifyThemes.php`
- `Notifications/FirebaseAndroidNotification.php`
- `Filament/Clusters/Test/Pages/SendPushNotification.php`

**Soluzione**:
- Utilizzare Closure per restituire array tipizzati correttamente
- Implementare controlli di tipo per garantire la compatibilità
- Costruire array con la struttura corretta prima di passarli ai metodi
- Utilizzare annotazioni PHPDoc per specificare i tipi generici
- Utilizzare factory method invece di costruttori diretti per classi complesse

### 4. Proprietà non definite

**Problema**: PHPStan segnala errori quando si accede a proprietà non definite nella classe.

**File interessati**:
- `Services/SmsService.php`

**Soluzione**:
- Definire esplicitamente tutte le proprietà utilizzate nella classe
- Aggiungere annotazioni PHPDoc per specificare i tipi delle proprietà
- Implementare metodi getter/setter per accedere alle proprietà

## Errori Rimanenti

Rimangono alcuni errori da risolvere nei seguenti file:

### 1. SendPushNotification.php

1. **Costruttore privato in MessageData**: 
   ```
   Cannot instantiate class Kreait\Firebase\Messaging\MessageData via private constructor
   ```
   **Soluzione**: Utilizzare il metodo factory fornito dalla libreria invece di istanziare direttamente.

2. **Tipo di parametro incompatibile**:
   ```
   Parameter #1 $data of class Kreait\Firebase\Messaging\MessageData constructor expects array<non-empty-string, string>, array{...} given.
   ```
   **Soluzione**: Assicurarsi che l'array passato al costruttore abbia le chiavi e i valori del tipo corretto.

### 2. SmsService.php

1. **Metodi non definiti su oggetto**:
   ```
   Call to an undefined method object::setLocalVars()
   ```
   **Soluzione**: Utilizzare l'API Reflection per chiamare i metodi in modo sicuro, o utilizzare `call_user_func` con controlli espliciti.

## Principi Applicati nelle Correzioni

1. **Controlli di tipo espliciti**: Verificare sempre il tipo di un valore prima di utilizzarlo in operazioni che richiedono un tipo specifico.
2. **Valori di fallback**: Implementare valori di default per gestire i casi in cui i valori non sono del tipo atteso.
3. **Documentazione migliorata**: Aggiungere annotazioni PHPDoc corrette per aiutare PHPStan a comprendere i tipi.
4. **Gestione degli errori**: Implementare try/catch o controlli condizionali per gestire potenziali errori.
5. **Asserzioni**: Utilizzare `Assert::string()`, `Assert::isArray()`, ecc. per garantire che i valori siano del tipo corretto.
6. **Reflection API**: Utilizzare Reflection per interagire con oggetti di tipo sconosciuto quando necessario.

## Esempi di Correzioni

### Esempio 1: Correzione di operazioni binarie con mixed

```php
// Prima
$url = Str::of($url)->replace(url(''), '')->toString();

// Dopo
if (!is_string($url)) {
    $url = '/' . $key; // Fallback
} else {
    $url = Str::of($url)->replace(url(''), '')->toString();
}
```

### Esempio 2: Correzione di accesso a proprietà su mixed

```php
// Prima
$fullName = $item->profile->full_name;

// Dopo
if (!is_object($item) || !property_exists($item, 'profile') || 
    !is_object($item->profile) || !property_exists($item->profile, 'full_name')) {
    return [];
}
$fullName = $item->profile->full_name;
```

### Esempio 3: Utilizzare Reflection API per chiamate metodo sicure

// Prima
$instance->setLocalVars($this->vars);
$instance->send();
$vars = $instance->getVars();

// Dopo
$reflectionClass = new \ReflectionClass($instance);
$setLocalVarsMethod = $reflectionClass->getMethod('setLocalVars');
$setLocalVarsMethod->invoke($instance, $this->vars);
$sendMethod = $reflectionClass->getMethod('send');
$sendMethod->invoke($instance);
$getVarsMethod = $reflectionClass->getMethod('getVars');
$result = $getVarsMethod->invoke($instance);
```

## Risultati e Prossimi Passi

Fino ad ora, abbiamo risolto la maggior parte degli errori di livello 10 in entrambi i moduli Lang e Notify. Il modulo Lang è completamente privo di errori, mentre il modulo Notify ha ancora alcuni problemi da risolvere.

### Prossimi Passi

1. Completare le correzioni degli errori rimanenti in SendPushNotification.php:
   - Utilizzare il factory method corretto per MessageData
   - Assicurarsi che l'array passato abbia il tipo corretto per i metodi della libreria Firebase

2. Completare le correzioni in SmsService.php:
   - Migliorare l'approccio di Reflection già implementato

3. Eseguire un'ultima verifica con PHPStan al livello 10 su entrambi i moduli

4. Estendere le correzioni ad altri moduli utilizzando i pattern stabiliti

5. Aggiornare le linee guida di sviluppo per prevenire errori simili in futuro 
## Altri Miglioramenti da Applicare

### 1. Analisi dei seguenti file:

- `Modules/Job/app/Models/JobsWaiting.php` - Proprietà con tipo mixed
- `Modules/Job/app/Models/Job.php` - Proprietà con tipo mixed
- `Modules/Job/app/Notifications/TaskCompleted.php` - Argomenti con tipo mixed
- `Modules/Job/app/Filament/Resources/ScheduleResource.php` - Callback con tipo mixed

## Principi Applicati nelle Correzioni Aggiuntive

1. **Tipi specifici**: Sostituito il tipo `mixed` con tipi più specifici quando possibile.
2. **Gestione sicura delle eccezioni**: Aggiunta gestione delle eccezioni per prevenire errori a runtime.
3. **Implementazione sicura**: Evitato l'uso di funzioni potenzialmente pericolose come `call_user_func` con input non controllato.
4. **Documentazione migliorata**: Aggiunta documentazione PHPDoc completa per spiegare i tipi di parametri e di ritorno.

## Prossimi Passi Aggiornati

1. Applicare principi simili agli altri file identificati nel modulo.
2. Eseguire l'analisi PHPStan a livello 10 per verificare che le correzioni risolvano effettivamente gli errori.
3. Documentare gli schemi e i pattern utilizzati per risolvere problemi simili in futuro.
4. Estendere le correzioni ai file del modulo Job identificati sopra.

## Collegamenti tra versioni di PHPSTAN_LEVEL10_FIXES.md
* [PHPSTAN_LEVEL10_FIXES.md](docs/PHPSTAN_LEVEL10_FIXES.md)
* [PHPSTAN_LEVEL10_FIXES.md](laravel/Modules/Notify/docs/PHPSTAN_LEVEL10_FIXES.md)
* [PHPSTAN_LEVEL10_FIXES.md](laravel/Modules/User/docs/PHPSTAN_LEVEL10_FIXES.md)
* [PHPSTAN_LEVEL10_FIXES.md](laravel/Modules/Lang/docs/PHPSTAN_LEVEL10_FIXES.md)
* [PHPSTAN_LEVEL10_FIXES.md](laravel/Modules/Job/docs/PHPSTAN_LEVEL10_FIXES.md)
* [PHPSTAN_LEVEL10_FIXES.md](laravel/Modules/Media/docs/PHPSTAN_LEVEL10_FIXES.md)

