# Da Proprietà a Metodi in Laravel 12

## Evoluzione del Pattern nei Modelli Eloquent

Laravel 12 ha introdotto un cambiamento fondamentale nell'architettura dei modelli Eloquent, passando da proprietà protette statiche a **metodi protetti**. Questo rappresenta un significativo miglioramento nel design e nella tipizzazione.

## Sintassi deprecata vs. Nuova sintassi

### ❌ Sintassi Deprecata (Laravel ≤ 11)

```php
class User extends Model
{
    protected $fillable = ['name', 'email']; 
    protected $casts = [
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];
    protected $hidden = ['password'];
}
```

### ✅ Sintassi Raccomandata (Laravel 12+)

```php
class User extends Model
{
    /**
     * Get the fillable attributes.
     *
     * @return array<int, string>
     */
    protected function fillable(): array
    {
        return ['name', 'email'];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Get the hidden attributes.
     *
     * @return array<int, string>
     */
    protected function hidden(): array
    {
        return ['password'];
    }
}
```

## Vantaggi dei Metodi Rispetto alle Proprietà

1. **Flessibilità**: I metodi possono contenere logica condizionale e non solo valori statici
2. **Tipizzazione forte**: Tipizzazione esplicita con return type e PHPDoc
3. **Lazy loading**: I valori vengono calcolati solo quando necessario
4. **Ereditarietà chiara**: Più facile estendere e sovrascrivere nelle classi figlie
5. **Meno "magic"**: Comportamento più prevedibile e verificabile
6. **Migliore supporto IDE**: Autocompletamento e navigazione del codice migliorati

## Compatibilità

Laravel 12 mantiene la retrocompatibilità con la sintassi precedente, quindi i modelli che utilizzano ancora `protected $property` continueranno a funzionare, ma questa sintassi è considerata deprecata e potrebbe essere rimossa in versioni future.
