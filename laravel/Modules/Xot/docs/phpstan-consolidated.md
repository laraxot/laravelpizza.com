# PHPStan - Guida Completa Consolidata

**Ultimo aggiornamento**: [DATE]
**Principi**: DRY + KISS
**Status**: ✅ CONSOLIDATO

## 🎯 Panoramica

Questa guida consolidata raccoglie tutte le informazioni PHPStan frammentate in un unico documento completo, seguendo i principi **DRY** e **KISS** per eliminare duplicazioni e semplificare la manutenzione.

## 📊 Livelli di Analisi

### Livelli Supportati
- **Livello 1-3**: Controlli base di sintassi
- **Livello 4-6**: Controlli di tipo più rigorosi
- **Livello 7-8**: Controlli dettagliati su tipi e DocBlocks
- **Livello 9**: Standard minimo per nuovo codice
- **Livello 10**: Obiettivo per codice critico

### Target Progetto
- **Nuovo codice**: Livello 9+
- **Codice critico**: Livello 10
- **Refactoring**: Migliorare gradualmente livelli esistenti

## ⚙️ Configurazione

### File di Configurazione
```php
// phpstan.neon
parameters:
    level: 9
    paths:
        - laravel/Modules
    excludePaths:
        - laravel/Modules/*/tests
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
    ignoreErrors:
        - '#Call to an undefined method#'
```

### Esecuzione Corretta
```bash
# ✅ CORRETTO - Eseguire da directory Laravel
cd laravel
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G

# ❌ ERRATO - Mai usare artisan per phpstan
php artisan test:phpstan
```

## 🏗️ Tipizzazione nei Modelli

### Proprietà del Modello
```php
/**
 * @property int $id
 * @property string|null $nome
 * @property int|null $stabi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, RelatedModel> $relatedModels
 */
class MioModello extends BaseModel
{
    /** @var list<string> */
    protected $fillable = ['nome', 'stabi'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

### Tipi per le Relazioni
```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, MioModello>
 */
public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(User::class);
}

/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<RelatedModel>
 */
public function relatedModels(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(RelatedModel::class);
}
```

## 🔧 Errori Comuni e Soluzioni

### Undefined Property
```php
// Errore: Access to an undefined property
// Soluzione: Aggiungere annotazione @property
/**
 * @property int $anno
 * @property Carbon|null $dal
 * @property Carbon|null $al
 */
```

### Missing Return Type
```php
// Errore: Method X does not have a return type specified
// Soluzione: Aggiungere tipo di ritorno esplicito
public function getFullNameAttribute(): string
{
    return $this->nome . ' ' . $this->cognome;
}
```

### Method Not Found
```php
// Errore: Call to an undefined method X
// Soluzione: Verificare namespace e importazioni
use Modules\User\Models\User; // Namespace corretto
```

### Array Shape
```php
// Errore: Parameter #1 $data of method X expects array{id: int, name: string}, array given
// Soluzione: Utilizzare docblock completo
/**
 * @param array{id: int, name: string} $data
 */
public function process(array $data): void
{
    // ...
}
```

### Parametri Nullable
```php
// Errore: Parameter #1 $value of method X expects string, string|null given
// Soluzione: Gestire caso null
public function process(?string $value): string
{
    return $value ?? '';
}
```

## 📦 Generics e Collection

```php
/**
 * @return Collection<int, User>
 */
public function getActiveUsers(): Collection
{
    return User::where('active', true)->get();
}

/**
 * @param array<int, string> $names
 * @return array<int, User>
 */
public function findUsersByNames(array $names): array
{
    // ...
}
```

## 🏭 Factory e Test

```php
// Factory method PHPDoc
/**
 * @return array<string, mixed>
 */
public function definition(): array
{
    return [
        'nome' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
    ];
}
```

## 🔄 Risoluzione di Errori Specifici

### Errore: Class X not found
```php
// Soluzione 1: Importare la classe correttamente
use Modules\ModuleA\Models\ClassX;

// Soluzione 2: Usare FQCN
\Modules\ModuleA\Models\ClassX::method();
```

### Errore: Return type mismatch
```php
// Errore: Return type (mixed) of method X not compatible with return type (string) of parent method
// Soluzione: Allineare i tipi di ritorno
/**
 * @return string
 */
public function getLabel(): string
{
    return $this->label;
}
```

### Errore: PHPDoc tag @param for parameter $x has no value type specified
```php
// Soluzione: Aggiungere tipo al parametro PHPDoc
/**
 * @param array<string, mixed> $data
 */
```

## 📋 Configurazione e Ignori

### Utilizzo di Baseline
```bash
# Generare baseline
./vendor/bin/phpstan analyze --generate-baseline

# Analizzare con baseline
./vendor/bin/phpstan analyze --baseline=phpstan-baseline.neon
```

### Ignori Condizionali
```php
/** @phpstan-ignore-next-line */
$variabile = $oggetto->proprietaNonStandard;
```

## 🚀 Progressione dei Livelli

1. **Livello 1-3**: Controlli base di sintassi e funzioni
2. **Livello 4-6**: Controlli di tipo più rigorosi
3. **Livello 7-8**: Controlli dettagliati su tipi e DocBlocks
4. **Livello 9-10**: Controlli avanzati e massima rigidità

## 📝 Note Importanti

- Eseguire PHPStan frequentemente durante lo sviluppo
- Documentare pattern comuni di errori/soluzioni
- Non ignorare errori senza documentare il motivo
- Mantenere la consistenza nei docblock e nei tipi
- Utilizzare le funzioni sicure di `thecodingmachine/safe`
- Aggiornare il baseline solo quando necessario
- Includere PHPStan nei controlli pre-commit

## 🔗 Risorse

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Modules/Xot/docs/PHPSTAN_LIVELLO10_LINEE_GUIDA.md](phpstan_livello10_linee_guida.md)
- [docs/PHPSTAN_LEVEL10_FIXES.md](../../../../docs/phpstan_level10_fixes.md)

---

*Guida consolidata che elimina duplicazioni e semplifica la manutenzione della documentazione PHPStan.*
