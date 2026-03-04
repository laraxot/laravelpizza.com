# Regola business: almeno 2 valutazioni > 0 nelle pagine Compila

## Obiettivo
Quando una pagina Filament di compilazione richiede esplicitamente in legenda un minimo di criteri valorizzati,
il `save()` deve bloccare il salvataggio se il numero minimo non e' rispettato.

## Pattern consigliato
1. Definire una costante di soglia nella pagina:
   - `private const MIN_POSITIVE_RATINGS = 2;`
2. Validare i dati del form prima di aggiornare le pivot:
   - considerare solo i rating editabili (`is_readonly = false`)
   - contare i valori numerici `> 0`
3. Se il conteggio e' inferiore alla soglia, lanciare `ValidationException`.

## Esempio sintetico
```php
$state = $this->form->getState();
$this->ensureMinimumPositiveRatings($state);
```

```php
if ($positiveCount < self::MIN_POSITIVE_RATINGS) {
    throw ValidationException::withMessages([
        'ratings' => 'Almeno 2 criteri devono avere un punteggio superiore a 0.',
    ]);
}
```

## Note architetturali
- La regola e' **di business**, non solo di UI.
- Va messa lato server (in `save()`), non solo in legenda o helper text.
- Coerente con DRY/KISS: una funzione dedicata riusabile e testabile.
- Compatibile con il pattern XotBasePage (`getFormSchema()` + `infolist(Schema $schema)`).

## Implementazione di riferimento
- `Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`
- `Modules/IndennitaResponsabilita/docs/compila_min_two_positive_ratings_rule.md`
