# ModelWithPosContract

Il `ModelWithPosContract` è un'interfaccia che definisce il contratto per i modelli che necessitano di gestire una posizione ordinale.

## Caratteristiche Principali

- Gestione automatica della posizione
- Riordinamento dinamico degli elementi
- Supporto per gruppi di ordinamento
- Validazione delle posizioni

## Metodi Richiesti

### Accessors e Mutators

```php
public function getPosAttribute(): int;
public function setPosAttribute(int $value): void;

public function getGroupPosAttribute(): ?string;
public function setGroupPosAttribute(?string $value): void;
```

### Metodi di Ordinamento

```php
public function moveUp(): bool;
public function moveDown(): bool;
public function moveToPosition(int $position): bool;
public function resetPosition(): void;
```

## Eventi Gestiti

- `creating`: Assegna automaticamente la prossima posizione disponibile
- `updating`: Aggiorna le posizioni degli altri elementi se necessario
- `deleting`: Riordina gli elementi rimanenti

## Schema Database

```php
Schema::create('table_name', function (Blueprint $table) {
    $table->integer('pos')->default(0);
    $table->string('group_pos')->nullable();
    $table->index(['pos', 'group_pos']);
});
```

## Best Practices

1. **Gestione Posizioni**
   - Mantenere le posizioni consecutive
   - Gestire correttamente i buchi nella sequenza
   - Validare i limiti delle posizioni

2. **Performance**
   - Utilizzare indici appropriati
   - Ottimizzare le query di riordinamento
   - Gestire batch di aggiornamenti

3. **Validazione**
   - Verificare la validità delle posizioni
   - Gestire i conflitti di posizione
   - Validare i gruppi di ordinamento

## Dipendenze

- Illuminate\Database\Eloquent\Model
- Illuminate\Support\Collection
- Webmozart\Assert\Assert

## Esempio di Utilizzo

```php
class MenuItem extends Model implements ModelWithPosContract
{
    use HasPosTrait;

    protected $fillable = [
        'name',
        'pos',
        'group_pos'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (null === $model->pos) {
                $model->pos = $model->getNextPosition();
            }
        });
    }
}
```

## Note di Sviluppo

- Implementare la logica di riordinamento in modo efficiente
- Gestire correttamente le transazioni per gli aggiornamenti multipli
- Mantenere la consistenza delle posizioni
- Documentare eventuali comportamenti specifici del gruppo 