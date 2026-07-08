# Naming Convention per Relazioni Eloquent

## Regola Fondamentale

I nomi dei metodi relazione devono riflettere la **cardinalità**:

| Tipo Relazione | Cardinalità | Nome Metodo | Esempio |
|----------------|-------------|-------------|---------|
| `hasOne()` | 1:1 | **Singolare** | `scheda()` |
| `hasMany()` | 1:N | **Plurale** | `schedas()` |
| `belongsTo()` | N:1 | **Singolare** | `user()` |
| `belongsToMany()` | N:N | **Plurale** | `roles()` |

## Perché Questa Regola?

### Semantica Corretta
```php
// ❌ ERRATO - hasMany con nome singolare
public function scheda(): HasMany  // Confusione: sembra 1:1

// ✅ CORRETTO - hasMany con nome plurale  
public function schedas(): HasMany  // Chiaro: sono molteplici
```

### Accesso alle Proprietà
Laravel usa il nome del metodo per la property magica:
```php
$dirigente->schedas        // Collection (molteplici)
$dirigente->schedas()->first()  // Primo elemento

$dirigente->scheda         // Singolo modello (hasOne)
```

## Convenzione Lingua

### Standard PTVX
Usare **inglese** per i nomi dei metodi relazione:

| Italiano | Inglese (PTVX) |
|----------|----------------|
| `schede()` | `schedas()` |
| `assenze()` | `absences()` |
| `utenti()` | `users()` |
| `valutazioni()` | `valuations()` |

### Esempi in Codice

```php
// ✅ CORRETTO
class StabiDirigente extends BaseModel
{
    // hasOne → singolare
    public function boss(): HasOne
    {
        return $this->hasOne(User::class);
    }
    
    // hasMany → plurale (inglese)
    public function schedas(): HasMany
    {
        return $this->hasMany(Scheda::class);
    }
    
    // belongsTo → singolare
    public function repart(): BelongsTo
    {
        return $this->belongsTo(Repart::class);
    }
}
```

## PHPDoc Corrispondente

```php
/**
 * @property-read Scheda|null $scheda           // hasOne
 * @property-read Collection<int, Scheda> $schedas  // hasMany
 * @property-read Repart|null $repart           // belongsTo
 */
```

## Anti-pattern da Evitare

### ❌ Mix di Lingue
```php
public function schede(): HasMany     // Italiano plurale - NON usare
public function schedas(): HasMany    // Inglese plurale - USA QUESTO
```

### ❌ Nomi Non Coerenti con Cardinalità
```php
// hasMany con nome singolare
public function scheda(): HasMany     // ERRATO: sembra hasOne

// hasOne con nome plurale  
public function schedas(): HasOne     // ERRATO: sembra hasMany
```

## Checklist

Prima di committare una relazione:

- [ ] Tipo relazione corretto (hasOne/hasMany/belongsTo/belongsToMany)
- [ ] Nome metodo riflette cardinalità (singolare/plurale)
- [ ] Uso lingua inglese
- [ ] PHPDoc aggiornato con `@property-read`
- [ ] Nome property magica coerente

## Collegamenti

- [Eloquent Relationships - Laravel Docs](https://laravel.com/docs/eloquent-relationships)
- [Model Naming Convention](../../../docs/MODEL_NAMING_CONVENTION.md)
- [Dynamic Class Resolution Pattern](dynamic-class-resolution-pattern.md)
