# Checklist Fillable - Model Organizzativa

## Errore Comune: Campo Mancante nei Fillable

### Problema

Quando si aggiunge un nuovo campo calcolato al modello `Organizzativa` che viene
materializzato tramite mutator (es: `perc_parttimepond_dalal`, `gg_presenza_dalal`),
e' facile dimenticare di aggiungere il campo alla proprieta' `$fillable`.

### Conseguenze

Se il campo non e' nei fillable:

```php
$this->update(['perc_parttimepond_dalal' => $value]);
```

L'update **non persiste il valore** nel database. Eloquent lo ignora silenziosamente.

Il mutator sembra funzionare, il valore viene restituito correttamente, ma al reload
del modello il campo e' ancora `NULL`.

### Sintomi

- Action eseguita senza errori
- Log mostra accesso al mutator
- Valore restituito corretto
- **Ma nel DB il campo rimane NULL**

### Soluzione

Aggiungere sempre il campo a `$fillable`:

```php
// In Modules/Performance/Models/Organizzativa.php

protected $fillable = [
    // ... altri campi ...
    'gg_assenza_dalal',
    'hh_assenza_dalal',
    'gg_presenza_dalal',
    'perc_parttimepond_dalal',
    'gg_anno', // ← NON DIMENTICARE!
];
```

## Checklist per Nuovi Campi Calcolati

Quando si aggiunge un campo calcolato materializzato:

- [ ] Aggiungere la colonna alla tabella via migration
- [ ] Aggiungere il campo ai `$fillable` del modello
- [ ] Aggiungere il cast in `casts()` se necessario (integer, float, ecc.)
- [ ] Aggiungere il mutator che calcola e persiste il valore
- [ ] Creare l'action di materializzazione batch
- [ ] Verificare che l'update funzioni con `refresh()` del modello

## Pattern Corretto

### Mutator con Persistenza

```php
public function getPercParttimepondDalalAttribute(?float $value): ?float
{
    // Se gia' valorizzato, usa il valore dal DB
    if (is_float($value)) {
        return $value;
    }

    // Se record non salvato, non possiamo persistere
    if ($this->getKey() == null) {
        return null;
    }

    // Calcola il valore (delegato a metodo separato)
    $calculatedValue = $this->calculatePercParttimepondDalal();

    // Persisti automaticamente
    static::withoutEvents(function () use ($calculatedValue): void {
        $this->update(['perc_parttimepond_dalal' => $calculatedValue]);
    });

    return $calculatedValue;
}
```

### Verifica Fillable

```php
// Test rapido in tinker
$scheda = Organizzativa::first();
$scheda->update(['perc_parttimepond_dalal' => 0.75]);
$scheda->refresh();
echo $scheda->perc_parttimepond_dalal; // Deve mostrare 0.75
```

## Collegamenti

- [Action Update Perc Part-time](./action-update-perc-parttimepond-dalal.md)
- [Action Update Gg Presenza](./action-update-gg-presenza-dalal.md)
- [Model Organizzativa](../app/Models/Organizzativa.php)
