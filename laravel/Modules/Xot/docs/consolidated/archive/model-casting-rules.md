# Regole per Model Casting in Laraxot - CRITICO

## ERRORE ARCHITETTURALE GRAVE: Proprietà $casts Deprecata

### ❌ VIETATO ASSOLUTO - Uso della Proprietà $casts

```php
// ❌ ERRORE GRAVE - MAI USARE QUESTA SINTASSI
class User extends BaseModel
{
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'options' => 'array',
    ];
}
```

### ✅ OBBLIGATORIO - Metodo casts()

```php
// ✅ SINTASSI CORRETTA E MODERNA
class User extends BaseModel
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'options' => 'array',
        ];
    }
}
```

## Gravità del Problema

### Perché è un Errore Architetturale Grave

1. **Deprecazione Laravel 11**: La proprietà `$casts` è deprecata in favore del metodo `casts()`
2. **Limitazioni Funzionali**: Non permette l'uso di metodi statici sui caster
3. **Manutenibilità**: Codice legacy che non sfrutta le nuove funzionalità
4. **Conformità**: Non rispetta gli standard moderni di Laravel
5. **Performance**: Il metodo `casts()` è più efficiente e flessibile

### Vantaggi del Metodo casts()

1. **Metodi Statici**: Possibilità di usare metodi statici sui caster built-in
2. **Flessibilità**: Logica dinamica per determinare i cast
3. **Type Safety**: Migliore tipizzazione e supporto PHPStan
4. **Futuro-Proof**: Preparato per le future versioni di Laravel
5. **Funzionalità Avanzate**: Accesso a nuovi caster come `AsEnumCollection::of()`

## Esempi di Migrazione

### Cast Base

```php
// ❌ VECCHIO MODO
protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'is_active' => 'boolean',
];

// ✅ NUOVO MODO
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
```

### Cast Avanzati con Enum

```php
// ❌ VECCHIO MODO (limitato)
protected $casts = [
    'status' => UserStatus::class,
    'options' => 'array',
];

// ✅ NUOVO MODO (potente)
protected function casts(): array
{
    return [
        'status' => UserStatus::class,
        'options' => AsEnumCollection::of(UserOption::class),
        'settings' => AsCollection::using(SettingsCollection::class),
    ];
}
```

### Cast con Logica Dinamica

```php
// ✅ POSSIBILE SOLO CON IL METODO casts()
protected function casts(): array
{
    $baseCasts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    if ($this->hasJsonColumn('metadata')) {
        $baseCasts['metadata'] = 'array';
    }

    return $baseCasts;
}
```

## Audit Risultati (2025-08-01)

### File con Errori Trovati: 20

1. `/Themes/Two/Main_files/filament-peek-demo/app/Models/Post.php`
2. `/Themes/Two/Main_files/filament-peek-demo/app/Models/User.php`
3. `/Themes/Two/Main_files/filament-peek-demo/app/Models/Menu.php`
4. `/Modules/Notify/app/Models/NotificationTemplate.php`
5. `/Modules/Notify/app/Models/MailTemplateVersion.php`
6. `/Modules/Notify/app/Models/MailTemplateLog.php`
7. `/Modules/Lang/app/Models/TranslationFile.php`
8. `/Modules/Xot/app/Models/InformationSchemaTable.php`
9. `/Modules/Geo/app/Models/BasePivot.php`
10. `/Modules/Geo/app/Models/BaseMorphPivot.php`
11. `/Modules/Geo/app/Models/BaseModel.php`
12. `/Modules/FormBuilder/app/Models/FormSubmission.php`
13. `/Modules/FormBuilder/app/Models/FormTemplate.php`
14. `/Modules/FormBuilder/app/Models/FormField.php`
15. `/Modules/Geo/app/Models/Location.php`
16. `/Modules/Geo/app/Models/Address.php`
17. `/Modules/Geo/app/Models/Place.php`
18. `/Modules/Chart/project_docs/Chart.php`
19. `/Modules/Chart/project_docs/Chart_conflict.php`
20. `/Modules/Chart/app/Models/Chart.php`

### Priorità di Refactoring

1. **CRITICO**: `BaseModel` e `BasePivot` (influenzano tutti i modelli figli)
2. **ALTO**: Modelli core come `User`, `NotificationTemplate`
3. **MEDIO**: Modelli specifici di modulo
4. **BASSO**: File di documentazione e conflitti

## Piano di Refactoring

### Fase 1: Modelli Base (CRITICO)
- [ ] `Modules/Geo/app/Models/BaseModel.php`
- [ ] `Modules/Geo/app/Models/BasePivot.php`
- [ ] `Modules/Geo/app/Models/BaseMorphPivot.php`

### Fase 2: Modelli Core (ALTO)
- [ ] `Themes/Two/Main_files/filament-peek-demo/app/Models/User.php`
- [ ] `Modules/Notify/app/Models/NotificationTemplate.php`
- [ ] `Modules/Xot/app/Models/InformationSchemaTable.php`

### Fase 3: Modelli Modulo (MEDIO)
- [ ] Tutti gli altri modelli dei moduli

### Fase 4: Cleanup (BASSO)
- [ ] File di documentazione
- [ ] File di conflitto

## Regole di Implementazione

### 1. Tipizzazione Obbligatoria

```php
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        // ...
    ];
}
```

### 2. Merge con Parent

```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'custom_field' => 'datetime',
    ]);
}
```

### 3. Documentazione PHPDoc

```php
/**
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_active
 */
class User extends BaseModel
{
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
```

## Validazione e Testing

### PHPStan
- Eseguire PHPStan livello 9+ dopo ogni refactoring
- Verificare che tutti i cast siano tipizzati correttamente

### Test
- Testare che i cast funzionino correttamente
- Verificare compatibilità con codice esistente

## Backlink e Riferimenti

- [model_base_rules.md](model_base_rules.md)
- [../../project_docs/phpstan-cast-fixes-guide.md](../../project_docs/phpstan-cast-fixes-guide.md)
- [Laravel 11 Model Casts Documentation](https://laravel.com/project_docs/11.x/eloquent-mutators#attribute-casting)

*Ultimo aggiornamento: agosto 2025*
