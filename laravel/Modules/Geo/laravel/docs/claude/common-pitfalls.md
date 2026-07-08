# 🚨 Common Pitfalls - Errori Critici da Evitare

> **⚠️ FONDAMENTALE**: Questi errori causano bug critici, instabilità e problemi di manutenzione in PTVX.

## 🔥 Errori Critici (MAI Fare)

### 1. **property_exists() con Proprietà Magiche**
```php
// ❌ CRITICO - Mai fare!
if (property_exists($user, 'posts')) {
    return $user->posts; // Non funzionerà MAI
}

// ❌ Anche questo è sbagliato
if (property_exists($user, 'full_name')) {
    return $user->full_name; // Gli accessor non sono proprietà reali
}

// ✅ SEMPRE usare isset()
if (isset($user->posts)) {
    return $user->posts;
}

// ✅ Per relazioni specifiche
if ($user->relationLoaded('posts')) {
    return $user->posts;
}
```

**Perché?** Laravel usa metodi magici `__get()` e `__set()` per gestire proprietà dinamiche. `property_exists()` funziona solo per proprietà reali della classe.

### 2. **Query Cross-Database - VIETATO**
```php
// ❌ MAI Fare - Database diversi!
User::join('sigma.employees', 'users.matr', '=', 'employees.matr')->get();

// ❌ Neanche subquery cross-database
User::whereExists(function ($query) {
    $query->select(DB::raw(1))
          ->from('sigma.employees')
          ->whereRaw('sigma.employees.matr = users.matr');
})->get();

// ✅ SEMPRE Fare - Prima raccogli, poi filtra
$matricoleSigma = DB::connection('sigma')
    ->table('employees')
    ->pluck('matr')
    ->unique()
    ->toArray();

User::whereNotIn('matr', $matricoleSigma)->get();
```

### 3. **Estendere Classi Filament Dirette**
```php
// ❌ MAI Fare
class MyResource extends Filament\Resources\Resource { }
class MyPage extends Filament\Resources\Pages\Page { }

// ✅ SEMPRE Fare
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource { }
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBasePage { }
```

### 4. **Labels Hardcoded - MAI**
```php
// ❌ MAI Fare
TextInput::make('name')->label('Nome Utente')
Select::make('status')->label('Stato')
Button::make('submit')->label('Invia')

// ✅ SEMPRE Fare
TextInput::make('name') // Traduzioni automatiche
Select::make('status')
Button::make('submit')
```

### 5. **BadgeColumn Deprecated**
```php
// ❌ MAI Fare - Deprecated in Filament 4
BadgeColumn::make('status')

// ✅ SEMPRE Fare
TextColumn::make('status')->badge()
```

---

## ⚠️ Errori Comuni (Evitare)

### 1. **getTableColumns() nella Resource Sbagliata**
```php
// ❌ SBAGLIATO - Nella Resource class
class MyResource extends XotBaseResource {
    public static function getTableColumns(): array { } // VIOLAZIONE!
}

// ✅ CORRETTO - Nella List Page
class ListMyRecords extends XotBaseListRecords {
    protected function getTableColumns(): array { } // OK!
}
```

### 2. **Proprietà XotBasePage - VIETATE**
```php
// ❌ MAI Fare in classi che estendono XotBasePage
class MyPage extends XotBasePage {
    protected static ?string $navigationIcon = 'heroicon-o-users'; // VIETATO!
    protected static ?string $title = 'My Page'; // VIETATO!
    protected static ?string $navigationLabel = 'My Page'; // VIETATO!
}

// ✅ SEMPRE Fare
class MyPage extends XotBasePage {
    public static function getNavigationIcon(): string { // METODO, non proprietà
        return 'heroicon-o-users';
    }
    
    protected function getTitle(): string { // METODO, non proprietà
        return 'My Page';
    }
}
```

### 3. **Usare Services Invece di Actions**
```php
// ❌ Evitare
class MyService {
    public function processData($data) { }
}

// ✅ Preferire
class ProcessDataAction {
    use QueueableAction;
    
    public function execute($data) { }
}
```

### 4. **unique() senza ignoreRecord in Filament 4**
```php
// ❌ Potrebbe causare problemi in Filament 4
TextInput::make('email')->unique()

// ✅ Sempre specificare
TextInput::make('email')->unique(ignoreRecord: true)
```

---

## 🚨 Anti-Pattern Architetturali

### 1. **Complessità Non Necessaria**
```php
// ❌ Anti-KISS - Complicazione eccessiva
class UserRepositoryFactoryProviderManager {
    public function getFactoryProviderManager(): FactoryProviderManager {
        // 100 linee di codice per qualcosa che serve in un posto solo
    }
}

// ✅ KISS - Semplice e diretto
class UserRepository {
    public function findById(int $id): ?User {
        return User::find($id);
    }
}
```

### 2. **Premature Optimization**
```php
// ❌ Non creare "perché potrebbe servire domani"
class FutureFeatureAction {
    // 200 linee per una funzionalità che non esiste ancora
}

// ✅ Crea solo quando effettivamente necessario
class CurrentFeatureAction {
    // Solo ciò che serve ORA
}
```

### 3. **Script nella Directory Sbagliata**
```php
// ❌ MAI mettere script in laravel/
// laravel/migrate_database.sh

// ✅ SEMPRE in bashscripts/
// ../bashscripts/migrate_database.sh
```

---

## 🔧 Debugging Common Issues

### 1. **"Base table or view not found"**
```php
// Problema: Query cross-database
User::join('sigma.users', 'users.id', '=', 'sigma.users.id')->get();
// Errore: Base table or view not found: sigma.users

// Soluzione: Separare le query
$ids = DB::connection('sigma')->table('users')->pluck('id');
User::whereIn('id', $ids)->get();
```

### 2. **"property_exists() returns false"**
```php
// Problema: property_exists non funziona con proprietà magiche
if (property_exists($user, 'posts')) { // sempre false
    return $user->posts;
}

// Soluzione: usare isset()
if (isset($user->posts)) { // funziona correttamente
    return $user->posts;
}
```

### 3. **Filament: "Call to undefined method"**
```php
// Problema: Stai usando classi base sbagliate
class MyResource extends Resource { // Manca XotBase

// Soluzione: Estendere XotBase classes
class MyResource extends XotBaseResource { // Corretto
```

---

## 📋 Checklist Anti-Pitfalls

Prima di commit, verifica MAI:

- [ ] `property_exists()` con proprietà Eloquent
- [ ] Query cross-database con join/subquery
- [ ] Classi Filament estese direttamente
- [ ] Labels hardcoded nei componenti
- [ ] `BadgeColumn` invece di `TextColumn::make()->badge()`
- [ ] `getTableColumns()` in Resource classes
- [ ] Proprietà statiche in XotBasePage
- [ ] Script in `laravel/` invece di `../bashscripts/`

---

## 📚 Riferimenti Correlati

- [Eloquent Properties](eloquent-properties.md) - Gestione proprietà magiche
- [Architecture Rules](architecture-rules.md) - Pattern corretti
- [Core Rules](core.md) - Regole fondamentali
- [Code Quality](code-quality.md) - Tools di verifica

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 🔥 URGENTE - Errori critici da evitare  
**Aggiornamento**: Dicembre 2025

> **💡 Ricorda**: È più facile prevenire questi errori che correggerli dopo!