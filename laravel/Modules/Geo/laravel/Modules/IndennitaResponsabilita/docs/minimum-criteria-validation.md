# Validazione Criteri Minimi - Indennità Responsabilità

## Problema

La legenda del modulo specifica che **almeno 2 criteri di valutazione devono avere un punteggio superiore a 0** per poter salvare la scheda di indennità di responsabilità.

## Soluzione Implementata

### Costante di Configurazione

```php
/**
 * Minimum number of criteria that must have a score > 0.
 */
private const MIN_POSITIVE_RATINGS = 2;
```

### Metodo di Validazione

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

### Integrazione nel Save

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

## Regole Business

| Campo | Descrizione |
|-------|-------------|
| `MIN_POSITIVE_RATINGS` | Numero minimo di criteri con valore > 0 (default: 2) |
| Campi readonly | Esclusi dal conteggio (sono calcolati automaticamente) |
| Campo con valore 0 | Non conta come "positivo" |
| Campo con valore > 0 | Conta come "positivo" |

## Comportamento

1. **Validazione al salvataggio**: Quando l'utente clicca "Salva", il sistema:
   - Conta i criteri editabili con valore > 0
   - Se il conteggio è < 2, mostra notifica di errore
   - Blocca il salvataggio fino a quando la condizione non è soddisfatta

2. **Feedback utente**:
   - Notifica di errore con messaggio chiaro
   - Messaggio di errore nel form

## Vantaggi

- **Clear intent**: La costante `MIN_POSITIVE_RATINGS` rende esplicito il requisito
- **Easy to modify**: Cambiare il numero minimo richiede solo modificare la costante
- **Separation of concerns**: La logica di validazione è in un metodo dedicato
- **User-friendly**: Messaggi di errore chiari indicano il problema

## File Principale

`Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

---

**Data**: 2026-02-17
**Autore**: AI Agent
**Versione**: 1.0
