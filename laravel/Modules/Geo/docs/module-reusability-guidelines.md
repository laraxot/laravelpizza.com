# Linee Guida per la Riusabilità dei Moduli Laraxot

## Principio Fondamentale

I moduli condivisi tra progetti (Notify, User, Xot, UI, ecc.) devono essere **completamente project-agnostic** per garantire riusabilità e portabilità.

## Regole Critiche

### 1. NO Hardcoding Nomi Progetti
❌ **VIETATO utilizzare nomi di progetti hardcoded:**
```php
// ERRORE: Riferimenti hardcoded
'content' => 'Benvenuto su <nome progetto>!',
'database' => '<nome progetto>_test',
use Modules\<nome progetto>\Models\User;
'Modules\\<nome progetto>\\Models\\Patient',
'content' => 'Benvenuto su <nome progetto>!',
'database' => '<nome progetto>_test',
use Modules\<nome progetto>\Models\User;
'Modules\\<nome progetto>\\Models\\Patient',
```

✅ **SEMPRE utilizzare pattern dinamici:**
```php
// CORRETTO: Pattern riutilizzabili
'content' => 'Benvenuto su ' . config('app.name') . '!',
$testDatabase = config('database.default') . '_test',
$userClass = XotData::make()->getUserClass();
$patientClass = XotData::make()->getPatientClass();
```

### 2. Utilizzo di XotData per Classi Dinamiche
Per ottenere dinamicamente le classi del progetto corrente:

```php
use Modules\Xot\Datas\XotData;

// Classe User del progetto
$userClass = XotData::make()->getUserClass();
$user = $userClass::factory()->create();

// Namespace del progetto principale
$projectNamespace = XotData::make()->getProjectNamespace();

// Nome del modulo principale
$mainModule = XotData::make()->main_module;
```

### 3. Configurazioni Database Dinamiche
```php
// Per i test
$testDatabase = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$testDatabase}", [
    'driver' => 'sqlite',
    'database' => ':memory:',
]);

// Per configurazioni generali
$appName = config('app.name');
$defaultConnection = config('database.default');
```

### 4. Pattern per Factory nei Test
```php
// SEMPRE utilizzare XotData nei test dei moduli riutilizzabili
protected function createTestUser(): mixed
{
    $userClass = XotData::make()->getUserClass();
    return $userClass::factory()->create([
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
}

// Per modelli specifici del progetto
protected function createTestPatient(): mixed
{
    $patientClass = XotData::make()->getPatientClass();
    return $patientClass::factory()->create();
}
```

## Moduli che DEVONO Seguire Queste Regole

### Moduli Completamente Riutilizzabili
- **Notify**: Sistema notifiche (email, SMS, push, telegram)
- **User**: Gestione utenti e autenticazione
- **Xot**: Framework base e utilità
- **UI**: Componenti interfaccia utente
- **Cms**: Gestione contenuti
- **Blog**: Sistema blog
- **Geo**: Gestione geografica

### Moduli Project-Specific (Possono Contenere Hardcoding)
- **<nome progetto>**: Specifico per progetti sanitari
- **DentalPro**: Specifico per studi dentistici
- **<nome modulo>**: Variante regionale
- **<nome progetto>**: Specifico per progetti sanitari
- **DentalPro**: Specifico per studi dentistici
- **<nome progetto>**: Variante regionale

## Checklist per Moduli Riutilizzabili

Prima di committare modifiche a un modulo riutilizzabile:

- [ ] Nessun riferimento hardcoded a nomi di progetti specifici
- [ ] Utilizzo di `XotData::make()->getUserClass()` per la classe User
- [ ] Utilizzo di `config('app.name')` invece di nomi hardcoded
- [ ] Configurazioni database dinamiche nei test
- [ ] Nessun import diretto di modelli da progetti specifici
- [ ] Traduzioni generiche senza riferimenti a progetti specifici
- [ ] Documentazione project-agnostic
- [ ] Test che funzionano indipendentemente dal progetto host

## Pattern di Implementazione

### Gestione Dinamica delle Classi
```php
// In un modulo riutilizzabile
class NotificationService
{
    protected function getUserClass(): string
    {
        return XotData::make()->getUserClass();
    }

    protected function createNotificationForUser(int $userId): void
    {
        $userClass = $this->getUserClass();
        $user = $userClass::find($userId);

        // Logica di notifica...
    }
}
```

### Factory Pattern Riutilizzabili
```php
// NotifyThemeableFactory.php
public function definition(): array
{
    $projectNamespace = XotData::make()->getProjectNamespace();

    return [
        'themeable_type' => $this->faker->randomElement([
            "{$projectNamespace}\\Models\\Patient",
            "{$projectNamespace}\\Models\\Doctor",
            "{$projectNamespace}\\Models\\Admin",
        ]),
        'themeable_id' => $this->faker->numberBetween(1, 100),
        // ...
    ];
}
```

### Test Pattern Riutilizzabili
```php
// In test dei moduli riutilizzabili
describe('Notification Management', function () {
    it('can create notification with user', function () {
        // Utilizzo dinamico della classe User
        $userClass = XotData::make()->getUserClass();
        $user = $userClass::factory()->create();

        $notification = Notification::factory()->create([
            'user_id' => $user->id,
        ]);

        expect($notification->user)->toBeInstanceOf($userClass);
    });
});
```

## Verifica della Riusabilità

### Script di Controllo
```bash
# Cerca hardcoding di nomi progetti nei moduli riutilizzabili
REUSABLE_MODULES=("Notify" "User" "Xot" "UI" "Cms" "Blog" "Geo")

for module in "${REUSABLE_MODULES[@]}"; do
    echo "Controllo modulo $module..."
    grep -r -i "<nome progetto>\|<nome modulo>\|dentalpro" "Modules/$module/" --exclude-dir=vendor || echo "✅ $module è pulito"
    grep -r -i "<nome progetto>\|<nome progetto>\|dentalpro" "Modules/$module/" --exclude-dir=vendor || echo "✅ $module è pulito"
done
```

### Controlli Specifici
```bash
# Cerca import diretti da progetti specifici
grep -r "use Modules\\\\[^N][^o][^t][^i][^f][^y]" Modules/Notify/ --include="*.php"

# Cerca configurazioni database hardcoded
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/ --include="*.php"
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/ --include="*.php"

# Cerca riferimenti User hardcoded
grep -r "User::" Modules/Notify/ --include="*.php" | grep -v "XotData"
```

## Benefici della Riusabilità

1. **Portabilità**: Moduli utilizzabili in qualsiasi progetto Laraxot
2. **Manutenibilità**: Un solo codebase per tutti i progetti
3. **Coerenza**: Comportamento uniforme tra progetti
4. **Efficienza**: Evita duplicazione di codice
5. **Scalabilità**: Facilita l'aggiunta di nuovi progetti
6. **Testing**: Test più robusti e generici
7. **Deployment**: Semplifica il deployment multi-progetto

## Eccezioni e Casi Particolari

### Quando è Accettabile l'Hardcoding
- **Moduli project-specific**: Moduli dedicati a un singolo progetto
- **Configurazioni di esempio**: Nei file di documentazione come esempi
- **Test di integrazione**: Quando si testa l'integrazione con un progetto specifico

### Gestione delle Eccezioni
```php
// Documentare chiaramente le eccezioni
/**
 * NOTA: Questo modulo è specifico per <nome progetto>
 * e può contenere riferimenti hardcoded al progetto.
 */
class <nome progetto>SpecificService
 * NOTA: Questo modulo è specifico per <nome progetto>
 * e può contenere riferimenti hardcoded al progetto.
 */
class <nome progetto>SpecificService
{
    // Implementazione project-specific...
}
```

## Collegamenti e Riferimenti

- [Modules/Notify/docs/reusability_guidelines.md](../laravel/modules/notify/docs/reusability_guidelines.md)
- [Modules/Xot/docs/xotdata_usage.md](../laravel/modules/xot/docs/xotdata_usage.md)
- [docs/laraxot_conventions.md](laraxot_conventions.md)
- [docs/module_architecture.md](module_architecture.md)

*Ultimo aggiornamento: gennaio 2025*
