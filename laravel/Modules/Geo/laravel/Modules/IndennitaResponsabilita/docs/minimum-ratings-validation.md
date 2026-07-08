# Validazione Criteri Minimi - Compila Indennità Responsabilità

## Panoramica

La pagina di compilazione delle indennità di responsabilità implementa una validazione che richiede l'inserimento di almeno **2 criteri** con punteggio superiore a 0.

## Requisito

Come indicato nella **leggenda** visualizzata nella pagina, è necessario compilare almeno 2 criteri con valore maggiore di 0 per poter salvare la scheda di valutazione.

## Implementazione

### Costante di Configurazione

```php
private const MIN_POSITIVE_RATINGS = 2;
```

### Metodo di Validazione

Il metodo `ensureMinimumPositiveRatings()` in `CompilaIndennitaResponsabilita.php` (linea 347-373):

1. **Raccoglie i ratings editabili**: Recupera solo i campi valutazione che non sono in sola lettura (`is_readonly = false`)

2. **Conta i valori positivi**: Itera su tutti i ratings editabili e conta quelli con valore > 0

3. **Valida il minimo**: Se il conteggio è inferiore a `MIN_POSITIVE_RATINGS`:
   - Mostra una notifica di errore con il messaggio appropriato
   - Lancia una `ValidationException` per bloccare il salvataggio

### Codice Sorgente

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
            $positiveCount++;
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

### Utilizzo nel Metodo Save

Il metodo `save()` chiama `ensureMinimumPositiveRatings()` prima di procedere con il salvataggio:

```php
public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
{
    $this->form->validate();

    /** @var array<string, mixed> $state */
    $state = $this->form->getState();

    // Custom validation: At least 2 editable rating fields must have a value > 0
    $this->ensureMinimumPositiveRatings($state);

    // ... proceed with save
}
```

## Messaggi di Errore

1. **Notifica visualizzata**:
   > "Attenzione: come indicato nella legenda, è necessario compilare almeno 2 criteri con punteggio superiore a 0."

2. **Errore sul form**:
   > "Almeno 2 criteri devono avere un punteggio superiore a 0."

## Note

- La validazione considera solo i **campi editabili** (non quelli in sola lettura)
- I campi con valore `0`, `null` o vuoto non vengono conteggiati come positivi
- La costante `MIN_POSITIVE_RATINGS` può essere modificata per cambiare il requisito minimo

## Voci di Leggenda

La legenda visualizzata nella pagina (caricata dal database, tabella `messages`) indica esplicitamente questo requisito. La validazione nel codice implementa quanto richiesto nella legenda.

## Cronologia Modifiche

- **2026-02-17**: Implementazione iniziale della validazione con messaggi in italiano
- **Requisito**: Dalla legenda del modulo Indennità Responsabilità
