# Traduzione di Testi Statici in Laravel

## Introduzione

La traduzione di testi statici in Laravel può essere gestita utilizzando due approcci principali: file PHP e file JSON. Questa documentazione, basata sul corso di Laravel Daily, analizza entrambi i metodi, evidenziando vantaggi e svantaggi, e propone un'implementazione per il progetto `<nome progetto>`.

## Opzioni di Archiviazione delle Traduzioni

### File PHP

I file PHP sono stati il metodo predefinito per lungo tempo. Le traduzioni sono organizzate in file separati per lingua e funzionalità.

**Esempio**:
In un file Blade come `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/resources/views/auth/register.blade.php`, potremmo avere:
```php
<!-- Nome -->
<div>
    <x-input-label for="name" :value="__('auth.register.name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
```

La traduzione corrispondente sarebbe in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it/auth.php`:
```php
return [
    'register' => [
        'name' => 'Nome',
        'email' => 'Email',
        // ...
    ],
    // ...
];
```

**Nota sulla Cartella `lang`**:
In Laravel 10 e versioni successive, la cartella `lang` non è inclusa di default. Per aggiungerla, eseguire:
```bash
php artisan lang:publish
```

**Vantaggi dei File PHP**:
- Chiavi nidificate a più livelli.
- Separazione delle traduzioni per funzionalità (es. `auth.php`, `validation.php`).
- Possibilità di avere chiavi identiche in file diversi con traduzioni diverse.
- Supporto per commenti nel codice.

**Svantaggi dei File PHP**:
- Necessità di definire tutte le stringhe immediatamente per evitare di mostrare chiavi non tradotte agli utenti.
- Difficoltà per traduttori non tecnici a causa della struttura dei file.
- Rischio di creare confusione con molti file e cartelle.

### File JSON

I file JSON contengono un elenco unico di traduzioni per ogni lingua, con chiavi leggibili dall'uomo.

**Esempio**:
In un file Blade come `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/resources/views/auth/register.blade.php`, potremmo avere:
```php
<!-- Nome -->
<div>
    <x-input-label for="name" :value="__('Nome')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
```

La traduzione corrispondente sarebbe in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it.json`:
```json
{
    "Nome": "Il Tuo Nome"
}
```

**Vantaggi dei File JSON**:
- Possibilità di scrivere frasi complete come chiavi, che vengono mostrate se non tradotte.
- Facilità di consegna a traduttori non tecnici.
- Coerenza delle traduzioni per chiavi identiche in diverse viste.

**Svantaggi dei File JSON**:
- Impossibilità di avere chiavi nidificate, tutto è in un unico file.
- Mancanza di contesto per traduzioni ambigue.
- File di traduzione molto grandi in progetti complessi.
- Impossibilità di aggiungere commenti nei file JSON.

## Problemi nel Mescolare File PHP e JSON

Mescolare i due approcci può causare problemi se una chiave JSON corrisponde al nome di un file PHP. Ad esempio, se esiste un file `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it/auth.php` e una chiave `"Auth": "Autenticazione"` in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it.json`, chiamare `__('Auth')` restituirà il contenuto di `auth.php` invece della traduzione attesa.

## `trans()` vs `__()`: Quale Usare?

- `__()` è una funzione helper che chiama internamente `trans()`.
- `__()` restituisce `null` se non viene passato alcun valore, mentre `trans()` restituisce l'istanza del traduttore, permettendo di concatenare metodi come `trans()->getLocale()`.
- **Raccomandazione**: Usare `__()` per stringhe di traduzione e `trans()` per operazioni più complesse come ottenere la lingua corrente.

## Analisi e Ragionamento per il Progetto `<nome progetto>`

Considerando la struttura del progetto `<nome progetto>` e le regole di localizzazione esistenti, propongo di adottare principalmente l'approccio con file PHP per le seguenti ragioni:
1. **Organizzazione**: I file PHP permettono di separare le traduzioni per modulo (es. `auth.php`, `patient.php`), coerente con la struttura modulare del progetto.
2. **Contesto**: Le chiavi nidificate offrono maggiore chiarezza e contesto, utili in un'applicazione complessa come `<nome progetto>`.
3. **Commenti**: La possibilità di commentare i file PHP è vantaggiosa per documentare traduzioni complesse o ambigue.

Tuttavia, per testi più lunghi o frasi complete che non richiedono contesto specifico, potremmo utilizzare file JSON per semplificare il lavoro dei traduttori non tecnici.

## Modifiche Proposte

Di seguito elenco i file che modificherei e le modifiche specifiche che apporterei per implementare il sistema di traduzione nel progetto `<nome progetto>`:

1. **Creazione della Cartella `lang` (se non presente)**:
   - Eseguire il comando:
     ```bash
     php artisan lang:publish
     ```
   - Questo creerà la cartella `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/` con le sottocartelle per le lingue supportate (es. `en`, `it`).

2. **Struttura dei File di Traduzione PHP**:
   - Creare file di traduzione per ogni modulo in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it/` e `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/en/`.
   - Esempio per il modulo di autenticazione in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it/auth.php`:
     ```php
     return [
         'register' => [
             'name' => 'Nome',
             'email' => 'Email',
             'password' => 'Password',
             'confirm_password' => 'Conferma Password',
             'already_registered' => 'Già registrato?',
             'register' => 'Registrati',
         ],
         'login' => [
             'email' => 'Email',
             'password' => 'Password',
             'remember_me' => 'Ricordami',
             'forgot_password' => 'Password dimenticata?',
             'login' => 'Accedi',
         ],
         // Commento: Traduzioni per messaggi di errore
         'failed' => 'Queste credenziali non corrispondono ai nostri record.',
         'password_incorrect' => 'La password fornita non è corretta.',
         'throttle' => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
     ];
     ```
   - Creare file simili per altri moduli come `patient.php`, `dental.php`, ecc.

3. **File JSON per Testi Lunghi**:
   - Creare file JSON per testi lunghi o frasi complete in `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it.json` e `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/en.json`.
   - Esempio per `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/lang/it.json`:
     ```json
     {
         "Benvenuto nel sistema di gestione sanitaria": "Benvenuto nel sistema di gestione sanitaria",
         "Hai dimenticato la password? Nessun problema. Inserisci il tuo indirizzo email e ti invieremo un link per reimpostare la password.": "Hai dimenticato la password? Nessun problema. Inserisci il tuo indirizzo email e ti invieremo un link per reimpostare la password."
     }
     ```

4. **Modifica dei File Blade per Utilizzare le Traduzioni**:
   - Modificare i file Blade per utilizzare la funzione `__()` con chiavi appropriate.
   - Esempio per `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/resources/views/auth/login.blade.php`:
     ```php
     <!-- Email -->
     <div>
         <x-input-label for="email" :value="__('auth.login.email')" />
         <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
         <x-input-error :messages="$errors->get('email')" class="mt-2" />
     </div>

     <!-- Password -->
     <div class="mt-4">
         <x-input-label for="password" :value="__('auth.login.password')" />
         <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
         <x-input-error :messages="$errors->get('password')" class="mt-2" />
     </div>

     <!-- Ricordami -->
     <div class="block mt-4">
         <label for="remember_me" class="flex items-center">
             <x-checkbox id="remember_me" name="remember" />
             <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('auth.login.remember_me') }}</span>
         </label>
     </div>

     <div class="flex items-center justify-end mt-4">
         @if (Route::has('password.request'))
             <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-600" href="{{ route('password.request') }}">
                 {{ __('auth.login.forgot_password') }}
             </a>
         @endif

         <x-primary-button class="ms-4">
             {{ __('auth.login.login') }}
         </x-primary-button>
     </div>
     ```
   - Applicare modifiche simili a tutti i file Blade rilevanti nel progetto.

5. **Integrazione con `mcamara/laravel-localization`**:
   - Assicurarsi che il pacchetto `mcamara/laravel-localization` sia installato e configurato come descritto nella documentazione `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Lang/project_docs/laravel-localization-complete.md`.
   - Modificare il file `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/routes/web.php` per aggiungere il prefisso della lingua:
     ```php
     Route::group([
         'prefix' => LaravelLocalization::setLocale(),
         'middleware' => ['localeSessionRedirect', 'localizationRedirect']
     ], function () {
         // Tutte le route web
         Route::get('/', function () {
             return view('welcome');
         });
         // altre route...
     });
     ```

6. **Creazione di un Selettore di Lingua**:
   - Modificare il file `/var/www/html/_bases/base_techplanner_fila3_mono/laravel/resources/views/layouts/navigation.blade.php` per aggiungere un selettore di lingua:
     ```php
     @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
         <x-nav-link rel="alternate" hreflang="{{ $localeCode }}"
                     :active="$localeCode === app()->getLocale()"
                     href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
             {{ ucfirst($properties['native']) }}
         </x-nav-link>
     @endforeach
     ```

## Gestione Plurale/Singolare nelle Traduzioni

### Uso di `trans_choice()` e `@choice`
- Per messaggi che variano in base al conteggio, usa `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```

### Sintassi delle Regole Plurali
- `{0}`: caso zero
- `{1}`: caso singolare
- `[2,*]`: da 2 in poi
- Usa `:count` per il numero

### Plurale in JSON
- Supportato ma meno leggibile:
  ```json
  {
    "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages": "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages"
  }
  ```
- In Blade:
  ```blade
  {{ trans_choice('{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages', $messagesCount) }}
  ```
- **Raccomandazione**: Preferire i file PHP per le stringhe plurali.

### Modifiche Proposte
- Inserire tutte le stringhe plurali in `/lang/{locale}/messages.php`.
- Nei Blade, sostituire blocchi condizionali con `trans_choice()` o `@choice()`.
- Evitare l'uso del JSON per le stringhe plurali.

## Processo Dev → Traduttore: Istruzioni e Modifiche Proposte

1. **Preparazione**: Prepara i file PHP/JSON di riferimento in `/lang/en/` e `/lang/en.json`.
2. **Istruzioni per i Traduttori**:
   - Nei file PHP: traduci solo il testo a destra di `=>`, non cambiare chiavi o struttura.
   - Nei file JSON: traduci solo il valore, non la chiave.
   - Non aggiungere, rimuovere o spostare chiavi.
   - Se serve un apostrofo (`'`), anteporre `\`.
3. **Reintegrazione**: Sostituisci i file tradotti nella lingua target e verifica la sintassi.
4. **Modifiche Proposte**:
   - Nei Blade, sostituire tutte le stringhe hardcoded con chiavi strutturate.
   - Nei file PHP, uniformare la struttura e aggiungere commenti per i traduttori.
   - Versionare i file di traduzione separatamente.

## Conclusione

Implementare un sistema di traduzione per testi statici nel progetto `<nome progetto>` migliorerà l'accessibilità e l'esperienza utente per utenti di diverse lingue. L'approccio con file PHP è raccomandato per la maggior parte delle traduzioni a causa della sua flessibilità e organizzazione, mentre i file JSON possono essere utilizzati per testi più lunghi o frasi complete. Le modifiche proposte ai file Blade, ai file di traduzione e alle route garantiranno che il sistema di localizzazione sia robusto e conforme alle regole del progetto, come l'uso del prefisso della lingua negli URL.

## Risorse

- Corso Laravel Daily: [Multi-Language Laravel 11: All You Need to Know](https://laraveldaily.com/course/multi-language-laravel)
