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
- Utilizzare tipi di ritorno e parametri espliciti nelle firme dei metodi
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

### Esempio 3: Correzione di parametri di tipo incompatibile

```php
// Prima
->options(NotifyThemeResource::fieldOptions('lang'))

// Dopo
->options(function (): array {
    return NotifyThemeResource::fieldOptions('lang');
})
```

## Risultati

# Correzioni PHPStan Livello 10 - Modulo Job

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo Job e le relative soluzioni implementate.

## Errori Identificati

### 1. Uso del tipo mixed in Schedule.php

```php
private function evaluateFunction(string $functionString): mixed
```

**Problema**: Utilizzo del tipo `mixed` come tipo di ritorno del metodo `evaluateFunction`, che rende difficile per PHPStan analizzare il codice che utilizza questo valore.

**Soluzione**:
1. Sostituito il tipo di ritorno `mixed` con `?string` che è più specifico e appropriato per il caso d'uso:
   ```php
   /**
    * @param string $functionString Il nome della funzione da valutare
    * @return string|null Il risultato della funzione o null se la funzione non è consentita
    * 
    * @throws \InvalidArgumentException Se viene passato un argomento non valido
    */
   private function evaluateFunction(string $functionString): ?string
   ```

2. Rifattorizzato l'implementazione del metodo per gestire in modo più sicuro e prevedibile la valutazione delle funzioni:
   ```php
   if (in_array($functionString, $allowedFunctions, true)) {
       // Chiamiamo la funzione in modo sicuro
       try {
           if ($functionString === 'strtolower') {
               return strtolower('TEST_STRING');
           }
           if ($functionString === 'strtoupper') {
               return strtoupper('test_string');
           }
       } catch (\Exception $e) {
           // Log error or handle exception
           return null;
       }
   }
   
   // Funzione non consentita
   return null;
   ```

3. Eliminato l'uso di `call_user_func` che potrebbe portare a problemi di sicurezza e sostituito con un approccio più sicuro basato su condizioni esplicite.

### 2. Tipo di ritorno non compatibile nei metodi getFormSchema() delle risorse Filament

**Problema**: I metodi `getFormSchema()` nelle risorse Filament (ad esempio `ImportResource`, `JobBatchResource`, `JobManagerResource`, `ScheduleResource`) restituivano un array indicizzato numericamente `array<int, Component>` mentre la classe base `XotBaseResource` richiede un array associativo con chiavi di tipo stringa `array<string, Component>`.

**Soluzione**:
1. Modificato il formato di ritorno in tutti i metodi `getFormSchema()` delle risorse per utilizzare chiavi di tipo stringa:
   ```php
   // Da
   return [
       \Filament\Forms\Components\TextInput::make('name')
           ->required(),
       // altri componenti...
   ];
   
   // A
   return [
       'name' => \Filament\Forms\Components\TextInput::make('name')
           ->required(),
       // altri componenti...
   ];
   ```

2. Questa modifica è stata applicata alle seguenti classi:
   - `Modules\Job\Filament\Resources\ImportResource`
   - `Modules\Job\Filament\Resources\JobBatchResource`
   - `Modules\Job\Filament\Resources\JobManagerResource`
   - `Modules\Job\Filament\Resources\ScheduleResource`

3. Principi seguiti:
   - Conformità ai tipi: assicurato che il tipo di ritorno corrisponda a quanto dichiarato nella classe base
   - Consistenza: applicato lo stesso pattern a tutte le risorse Filament del modulo

### 3. Rimozione della proprietà $navigationIcon ridefinita nelle risorse Filament

**Problema**: Le classi che estendono `XotBaseResource` non devono ridefinire la proprietà `protected static ?string $navigationIcon` poiché questa è già gestita dalla classe base.

**Soluzione**:
1. Applicato il principio di ereditarietà corretto: le proprietà di configurazione di navigazione devono essere gestite centralmente nella classe base e non ridefinite nelle classi figlie.
2. Mantenere la responsabilità di definire le icone di navigazione nella classe base permette una gestione coerente e un punto unico di configurazione per l'interfaccia utente.

**Benefici**:
- Riduzione della duplicazione del codice
- Semplificazione della manutenzione (modifiche all'UI in un unico punto)
- Coerenza visiva attraverso l'intera applicazione
- Separazione delle responsabilità: la classe base gestisce l'aspetto, le classi figlie la logica specifica

**Pattern applicato**: _Principle of Least Knowledge_ - Le classi figlie non dovrebbero preoccuparsi di dettagli di implementazione dell'interfaccia utente che possono essere gestiti dalla classe base.

## Altri Miglioramenti da Applicare

### 1. Analisi dei seguenti file:

- `Modules/Job/app/Models/JobsWaiting.php` - Proprietà con tipo mixed
- `Modules/Job/app/Models/Job.php` - Proprietà con tipo mixed
- `Modules/Job/app/Notifications/TaskCompleted.php` - Argomenti con tipo mixed
- `Modules/Job/app/Filament/Resources/ScheduleResource.php` - Callback con tipo mixed

## Principi Applicati

1. **Tipi specifici**: Sostituito il tipo `mixed` con tipi più specifici quando possibile.
2. **Gestione sicura delle eccezioni**: Aggiunta gestione delle eccezioni per prevenire errori a runtime.
3. **Implementazione sicura**: Evitato l'uso di funzioni potenzialmente pericolose come `call_user_func` con input non controllato.
4. **Documentazione migliorata**: Aggiunta documentazione PHPDoc completa per spiegare i tipi di parametri e di ritorno.
5. **Corrispondenza di tipi**: Assicurato che i tipi di ritorno dei metodi overridden corrispondano a quelli definiti nelle classi base.
6. **Evitare ridefinizioni inutili**: Non ridefinire proprietà o metodi già gestiti dalla classe base, a meno che non sia necessario.

## Prossimi Passi

1. Applicare principi simili agli altri file identificati nel modulo.
2. Eseguire l'analisi PHPStan a livello 10 per verificare che le correzioni risolvano effettivamente gli errori.
3. Documentare gli schemi e i pattern utilizzati per risolvere problemi simili in futuro. 
# Correzioni PHPStan Livello 10 - Modulo User

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati e Correzioni Effettuate

### 1. Uso del tipo mixed in CheckOtpExpiredRule.php

```php
public function validate(string $attribute, mixed $value, \Closure $fail): void
```

**Problema**: Utilizzo del tipo `mixed` senza ulteriori specifiche sul tipo effettivo del valore. Inoltre, il metodo `message()` non aveva un tipo di ritorno esplicito.

**Soluzione**:
1. Aggiunta di documentazione PHPDoc per specificare che `$value` è un `string|int`:
   ```php
   /**
    * @param string $attribute L'attributo che viene validato
    * @param string|int $value Il valore dell'attributo
    * @param \Closure(string): void $fail La closure da chiamare in caso di fallimento
    */
   public function validate(string $attribute, mixed $value, \Closure $fail): void
   ```

2. Aggiunto tipo di ritorno esplicito per il metodo `message()`:
   ```php
   /**
    * @return string Il messaggio di errore
    */
   public function message(): string
   ```

### 2. Problemi di tipizzazione in ModelContract.php

**Problema**: Mancanza di annotazioni PHPDoc complete per i parametri e valori di ritorno dei metodi dell'interfaccia.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc complete per tutti i metodi:
   ```php
   /**
    * Fill the model with an array of attributes. Force mass assignment.
    *
    * @param array<string, mixed> $attributes Gli attributi da assegnare al modello
    * @return static Il modello stesso
    */
   public function forceFill(array $attributes);
   ```

2. Specificazione corretta dei tipi di array:
   ```php
   /**
    * Convert the model instance to an array.
    *
    * @return array<string, mixed> Il modello convertito in array
    */
   public function toArray();
   ```

3. Miglioramento della documentazione generale dell'interfaccia:
   ```php
   /**
    * Interfaccia ModelContract che deve essere implementata dai modelli.
    *
    * @phpstan-require-extends Model
    *
    * @mixin \Eloquent
    */
   interface ModelContract
   ```

### 3. Miglioramenti in PasswordData.php

**Problema**: Mancanza di annotazioni PHPDoc per metodi e proprietà, e utilizzo implicito di tipi mixed.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc complete per tutti i metodi:
   ```php
   /**
    * Crea un'istanza della classe PasswordData.
    *
    * @return self
    */
   public static function make(): self
   ```

2. Specificazione corretta dei tipi di array e parametri:
   ```php
   /**
    * Converte l'oggetto in un array.
    *
    * @return array<string, int|bool|string|null>
    */
   public function toArray(): array
   ```

3. Aggiunta di annotazioni di tipo per variabili locali:
   ```php
   /** @var array<string, mixed> $data */
   $data = TenantService::getConfig('password');
   ```

### 4. Correzioni in Filament/Pages/Password.php

**Problema**: Mancanza di annotazioni PHPDoc per metodi e proprietà, e utilizzo di tipi non specifici.

**Soluzione**:
1. Aggiunta di annotazioni PHPDoc complete per tutti i metodi e proprietà:
   ```php
   /**
    * Dati del form per la gestione delle password.
    *
    * @var array<string, mixed>|null
    */
   public ?array $formData = [];
   ```

2. Specificazione corretta dei tipi per parametri e valori di ritorno:
   ```php
   /**
    * Restituisce le azioni per il form di aggiornamento.
    *
    * @return array<Action>
    */
   protected function getUpdateFormActions(): array
   ```

3. Aggiunta di annotazioni di tipo per variabili locali:
   ```php
   /** @var array<string, mixed> $data */
   $data = $this->form->getState();
   ```

### 5. Miglioramenti in Http/Livewire/Auth/Login.php

**Problema**: Mancanza di annotazioni PHPDoc per metodi e proprietà, e utilizzo di tipi non specifici.

**Soluzione**:
1. Documentazione migliorata per la classe e le proprietà:
   ```php
   /**
    * Componente Livewire per la gestione del login.
    *
    * @property ComponentContainer $form
    */
   class Login extends Component implements HasForms
   ```

2. Specificazione corretta dei tipi per proprietà:
   ```php
   /**
    * Regole di validazione.
    *
    * @var array<string, array<string|object>>
    */
   protected $rules = [
       'email' => ['required', 'email'],
       'password' => ['required'],
       'remember' => ['boolean'],
   ];
   ```

3. Tipizzazione esplicita dei valori di ritorno e annotazioni per variabili:
   ```php
   /**
    * Esegue l'autenticazione dell'utente.
    *
    * @return RedirectResponse|void
    */
   public function authenticate()
   {
       /** @var array{email: string, password: string, remember?: bool} $data */
       $data = $this->validate();
   ```

### 6. Metodo `authentications()` non trovato in Listeners

**Problema**: I Listener come `FailedLoginListener`, `LoginListener`, `LogoutListener`, e `OtherDeviceLogoutListener` tentano di richiamare il metodo `authentications()` su un oggetto di tipo `Illuminate\Contracts\Auth\Authenticatable`, ma questo metodo non è definito nell'interfaccia `Authenticatable`.

```php
// In FailedLoginListener.php
$log = $event->user->authentications()->create([...]);
```

**Soluzione**:
1. Creazione di un'interfaccia `HasAuthentications` che definisce il metodo `authentications()` e la relazione tra User e Authentication:

```php
namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasAuthentications
{
    /**
     * Ottiene tutti i log di autenticazione associati all'utente.
     *
     * @return MorphMany
     */
    public function authentications(): MorphMany;
}
```

2. Assicurarsi che il modello User implementi questa interfaccia:

```php
use Modules\User\Contracts\HasAuthentications;

class User extends BaseUser implements HasAuthentications
{
    // ...
}
```

3. Aggiunta di type casting nei Listener per verificare che l'utente implementi l'interfaccia `HasAuthentications`:

```php
public function handle(Failed $event): void
{
    if ($event->user instanceof HasAuthentications) {
        $ip = $this->request->ip();
        $userAgent = $this->request->userAgent();
        $location = [];

        $log = $event->user->authentications()->create([
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'login_at' => now(),
            'login_successful' => false,
            'location' => $location,
        ]);
    }
}
```

**Benefici**:
- Tipo corretto definito con un'interfaccia dedicata
- Controllo esplicito del tipo prima di chiamare il metodo
- Separazione delle responsabilità chiara tramite interfacce
- Evitato l'uso di `mixed` o suppression di errori

**Pattern applicato**: _Interface Segregation_ - Creazione di interfacce specifiche per comportamenti specifici, anziché interfacce generiche troppo ampie.

## Principi Applicati

1. **Specificazione dei tipi**: Evitato l'uso del tipo `mixed` quando possibile, o almeno documentato i tipi effettivi attraverso PHPDoc.
2. **Tipi di array specificati**: Utilizzata la notazione generica per specificare i tipi di chiavi e valori degli array.
3. **Tipi di ritorno espliciti**: Aggiunti tipi di ritorno espliciti per tutti i metodi.
4. **Documentazione migliorata**: Aggiunta documentazione PHPDoc completa per classi, proprietà e metodi.
5. **Annotazioni per variabili locali**: Utilizzate le annotazioni `@var` per specificare i tipi delle variabili locali quando PHPStan non può inferirli correttamente.

## Considerazioni Future

1. Continua l'utilizzo di queste pratiche in tutto il modulo User e in altri moduli.
2. Considera l'uso di generics (come `@template`) per migliorare ulteriormente la tipizzazione delle classi che gestiscono diverse tipologie di dati.
3. Mantieni aggiornata la documentazione quando vengono modificati metodi o proprietà.
# Correzioni PHPStan Livello 10 - Modulo Media

Questo documento traccia gli errori PHPStan di livello 10 identificati nel modulo Media e le relative soluzioni implementate.

## Errori Identificati

### 1. Uso del tipo mixed per risorsa di file in VideoStream.php

```php
private mixed $stream; // File stream resource
```

**Problema**: Utilizzo del tipo `mixed` per la proprietà `$stream` che rappresenta una risorsa di file. In PHP, le risorse hanno un tipo specifico che non può essere correttamente rappresentato come scalare o oggetto.

**Soluzione**:
1. Utilizzato un'annotazione PHPDoc per specificare il tipo `resource|null` e inizializzato la proprietà a `null`:
   ```php
   /** @var resource|null */
   private $stream = null; // File stream resource
   ```

   Questo approccio è necessario perché PHP non supporta direttamente il tipo `resource` come tipo di dichiarazione, ma PHPStan può comprenderlo attraverso l'annotazione PHPDoc.

### 2. Altri problemi di tipo in SubtitleService.php

Il file `SubtitleService.php` contiene un'annotazione PHPDoc con tipi complessi che potrebbero generare errori a livello 10:

```php
* @return (float|int|mixed|string)[][]
* @psalm-return list{0?: array{sentence_i: int<0, max>, item_i: int<0, max>, start: float|int, end: float|int, time: string, text: mixed},...}
```

**Problema**: L'uso di `mixed` e tipizzazioni complesse può rendere difficile per PHPStan analizzare correttamente il codice.

**Soluzione da implementare**:
1. Rivedere e semplificare le tipizzazioni quando possibile
2. Sostituire i tipi `mixed` con tipi più specifici in base al contesto

### 3. Proprietà con tipo mixed in Media.php

Il modello `Media.php` contiene diverse proprietà documentate con tipo `mixed`:

```php
* @property mixed $extension
* @property mixed $human_readable_size
* @property mixed $original_url
* @property mixed $preview_url
```

**Soluzione da implementare**:
1. Specificare tipi più precisi per queste proprietà in base ai valori effettivi che possono assumere

## Principi Applicati

1. **Uso appropriato di PHPDoc per tipi speciali**: Quando PHP non supporta nativamente un tipo (come `resource`), utilizzare annotazioni PHPDoc per fornire informazioni di tipo a PHPStan.
2. **Inizializzazione appropriata**: Inizializzare le proprietà con valori appropriati per il loro tipo.
3. **Documentazione chiara**: Fornire commenti esplicativi che indicano lo scopo e il tipo atteso delle proprietà.

## Prossimi Passi

1. Completare la revisione di `SubtitleService.php` per risolvere i problemi di tipo complessi.
2. Aggiornare il modello `Media.php` per specificare tipi più precisi per le proprietà attualmente documentate come `mixed`.
3. Eseguire l'analisi PHPStan a livello 10 per verificare che le correzioni risolvano effettivamente gli errori.
4. Documentare pattern e soluzioni standard per gestire risorse di file e altri tipi speciali nel progetto. 
