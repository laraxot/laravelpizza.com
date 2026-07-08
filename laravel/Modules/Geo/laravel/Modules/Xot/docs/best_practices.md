# Best Practices per Laraxot

## Riferimenti al modello User

Una pratica fondamentale in Laraxot è **non fare mai riferimento diretto** alla classe specifica di implementazione dell'utente (`\Modules\User\Models\User`), poiché il modello utente effettivamente utilizzato viene configurato nei file di configurazione del sistema.

### ❌ Pratica scorretta

```php
/**
 * @var \Modules\User\Models\User $user
 */
public function handle($user) {
    // Codice che usa $user
}
```

### ✓ Pratica corretta

```php
use Modules\Xot\Contracts\UserContract;

/**
 * @var UserContract $user
 */
public function handle($user) {
    // Codice che usa $user
}
```

### Motivi per utilizzare UserContract

1. **Configurabilità**: Il modello User effettivo può cambiare in base alla configurazione.
2. **Disaccoppiamento**: Riduce le dipendenze verso implementazioni specifiche.
3. **Testabilità**: Facilita il testing con implementazioni mock dell'interfaccia.
4. **Flessibilità**: Consente di estendere o cambiare l'implementazione senza impattare il codice esistente.

### Come ottenere la classe User corretta

Se è necessario ottenere programmaticamente la classe User configurata:

```php
use Modules\Xot\Datas\XotData;

// Ottenere la classe User configurata
$userClass = XotData::make()->getUserClass();

// Creare un'istanza
$user = new $userClass();
```

### Tipizzazione nei parametri di metodo

Quando si tipizzano i parametri di un metodo:

```php
use Modules\Xot\Contracts\UserContract;

// Corretto
public function process(UserContract $user) {
    // Codice
}

// Errato
public function process(\Modules\User\Models\User $user) {
    // Codice
}
``` 