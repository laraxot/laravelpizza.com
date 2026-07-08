# Pattern Validazione: Almeno 2 Criteri con Punteggio > 0

## Contesto

Nel modulo **IndennitaResponsabilita**, la compilazione della valutazione richiede che l'utente inserisca almeno **2 criteri** con un punteggio superiore a 0, come indicato nella legenda del form.

## Implementazione

### Costante di Configurazione

```php
/**
 * Minimum number of criteria that must have a score > 0.
 */
private const MIN_POSITIVE_RATINGS = 2;
```

### Metodo di Validazione

Il metodo `ensureMinimumPositiveRatings()` esegue la validazione prima del salvataggio:

```php
/**
 * Ensure that at least MIN_POSITIVE_RATINGS editable ratings have a value > 0.
 *
 * @param  array<string, mixed>  $state
 *
 * @throws ValidationException
 */
protected function ensureMinimumPositiveRatings(array $state): void
{
    /** @var Collection<int, Rating> $editableRatings */
    $editableRatings = $this->getRatingsForYear()->where('is_readonly', false);
    /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
    $ratingsData = (array) ($state['ratings'] ?? []);

    $positiveCount = 0;
    foreach ($editableRatings as $rating) {
        $value = $ratingsData[$rating->id]['pivot']['value'] ?? 0;
        if (is_numeric($value) && (float) $value > 0) {
            ++$positiveCount;
        }
    }

    if ($positiveCount < self::MIN_POSITIVE_RATINGS) {
        Notification::make()
            ->title('Errore di Validazione')
            ->body('Attenzione: come indicato nella legenda, è necessario compilare almeno '.self::MIN_POSITIVE_RATINGS.' criteri con punteggio superiore a 0.')
            ->danger()
            ->send();

        throw ValidationException::withMessages([
            'ratings' => 'Almeno '.self::MIN_POSITIVE_RATINGS.' criteri devono avere un punteggio superiore a 0.',
        ]);
    }
}
```

### Integrazione nel Salvataggio

Il metodo `save()` chiama la validazione prima di procedere:

```php
public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
{
    $this->form->validate();

    /** @var array<string, mixed> $state */
    $state = $this->form->getState();

    // Custom validation: At least 2 editable rating fields must have a value > 0
    $this->ensureMinimumPositiveRatings($state);

    // ... resto del salvataggio
}
```

## Logica di Validazione

1. **Recupera i ratings editabili**: Filtra i ratings dove `is_readonly = false`
2. **Conta i valori positivi**: Per ogni rating editabile, verifica se il valore è > 0
3. **Confronta con il minimo**: Se il conteggio è inferiore a `MIN_POSITIVE_RATINGS` (2), blocca il salvataggio
4. **Notifica l'utente**: Mostra un messaggio di errore in italiano conforme alla legenda
5. **Lancia eccezione**: `ValidationException` per evidenziare il campo in errore nel form

## Vantaggi del Pattern

- **DRY**: La costante `MIN_POSITIVE_RATINGS` centralizza la regola
- **KISS**: Logica semplice e lineare, facile da comprendere
- **Type Safety**: PHPDoc completo per PHPStan Level 10
- **UX**: Messaggio chiaro che fa riferimento alla legenda
- **Manutenibilità**: Cambiare il numero minimo richiede solo modificare la costante

## File di Riferimento

- `/laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

## Collegamenti

- [Best Practices](./best-practices.md)
- [Architecture Rules](./architecture-rules.md)
- [Filament v5 Infolist Pattern](../../docs/FILAMENT-V5-INFOLIST-PATTERN.md)
