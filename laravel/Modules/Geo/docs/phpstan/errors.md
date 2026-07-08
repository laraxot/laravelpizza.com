# Errori PHPStan nel Modulo Performance

## Categorie di Errori

### 1. Errori di Tipo nelle Relazioni
- **Problema**: Le relazioni Eloquent non specificano correttamente i tipi generici
- **Soluzione**: Aggiungere i tipi generici corretti nelle relazioni
- **Esempio**:
```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\Performance\Models\Individuale>
 */
public function schede(): HasMany
{
    return $this->hasMany(Individuale::class);
}
```

### 2. Errori di Mixin
- **Problema**: `@mixin Eloquent` non è riconosciuto
- **Soluzione**: Aggiungere l'import corretto per Eloquent
- **Esempio**:
```php
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
class MyModel extends Model
```

### 3. Errori di Metodi Statici
- **Problema**: Chiamate a metodi statici non definiti
- **Soluzione**: Aggiungere i metodi statici mancanti o correggere le chiamate
- **Esempio**:
```php
public static function where($column, $operator, $value = null)
{
    return static::query()->where($column, $operator, $value);
}
```

### 4. Errori di Proprietà
- **Problema**: Accesso a proprietà non definite
- **Soluzione**: Aggiungere le proprietà al modello o correggere l'accesso
- **Esempio**:
```php
protected $fillable = [
    'codice',
    'tipo',
    'posizione'
];
```

### 5. Errori di Confronto
- **Problema**: Confronti stretti tra tipi incompatibili
- **Soluzione**: Utilizzare il confronto appropriato o aggiungere controlli di tipo
- **Esempio**:
```php
if ($value !== null && $value !== '') {
    // ...
}
```

## File da Correggere

1. `Models/Individuale.php`
2. `Models/IndividualeAdm.php`
3. `Models/IndividualeAssenze.php`
4. `Models/IndividualeCatCoeff.php`
5. `Models/IndividualeDecurtazioneAssenze.php`
6. `Models/IndividualeDip.php`
7. `Models/IndividualePesi.php`
8. `Models/IndividualePo.php`
9. `Models/IndividualePoPesi.php`
10. `Models/IndividualeRegionale.php`
11. `Models/IndividualeTotStabi.php`
12. `Models/MyLog.php`
13. `Models/Option.php`
14. `Models/Organizzativa.php`
15. `Models/Performance.php`
16. `Models/PerformanceComportamenti.php`
17. `Models/PerformanceFondo.php`
18. `Models/PerformanceObiettivi.php`
19. `Models/StabiDirigente.php`
20. `Models/Traits/FunctionTrait.php`
21. `Models/Traits/MutatorTrait.php`
22. `Services/CriteriEsclusioneService.php`
23. `Services/CriteriValutazioneService.php`

## Piano di Azione

1. Correggere gli errori di tipo nelle relazioni
2. Aggiungere gli import mancanti per Eloquent
3. Implementare i metodi statici mancanti
4. Definire correttamente le proprietà nei modelli
5. Correggere i confronti di tipo
6. Aggiornare la documentazione PHPDoc

## Note
- Utilizzare `@phpstan-ignore-line` solo quando necessario
- Mantenere la compatibilità con il livello 4 di PHPStan
- Seguire le best practice di Laravel per i modelli Eloquent 