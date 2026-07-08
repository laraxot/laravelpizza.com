# Validazione Criteri Minimi - Indennità Responsabilità

## Problema

La legenda del modulo Indennità Responsabilità richiede che almeno **2 criteri di valutazione** abbiano un valore maggiore di 0 per poter salvare la scheda.

## Soluzione Implementata

### Costante di Configurazione

```php
// CompilaIndennitaResponsabilita.php:43
private const MIN_POSITIVE_RATINGS = 2;
```

### Metodo di Validazione

```php
// CompilaIndennitaResponsabilita.php:347-373
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

### Integrazione nel Save

```php
// CompilaIndennitaResponsabilita.php:308-338
public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
{
    $this->form->validate();

    /** @var array<string, mixed> $state */
    $state = $this->form->getState();

    // Custom validation: At least 2 editable rating fields must have a value > 0
    $this->ensureMinimumPositiveRatings($state);

    $record = $this->getSpecificRecord();

    // Update record standard fields
    /** @var array<string, mixed> $dataToUpdate */
    $dataToUpdate = collect($this->data)->only(['dal', 'al', 'note'])->toArray();
    $record->update($dataToUpdate);

    // Update pivot ratings
    /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
    $ratingsData = (array) ($state['ratings'] ?? []);
    foreach ($ratingsData as $id => $rating) {
        $value = $rating['pivot']['value'];
        $record->ratings()->updateExistingPivot($id, [
            'value' => is_numeric($value) ? $value : 0,
        ]);
    }

    if ($shouldSendSavedNotification) {
        Notification::make()->title('Saved successfully')->success()->send();
    }
}
```

## Regole di Validazione

| Regola | Descrizione |
|--------|-------------|
| Almeno 2 criteri | Devono avere valore > 0 |
| Campi readonly esclusi | Solo i criteri editabili contano |
| Valore numerico | Deve essere un numero maggiore di 0 |
| Messaggio chiaro | Indica il requisito della legenda |

## Comportamento

1. **Validazione al save**: Quando l'utente clicca "Salva", il sistema valida che almeno 2 criteri editabili abbiano un valore > 0
2. **Notifica errore**: Se la condizione non è soddisfatta, mostra una notifica di errore
3. **Eccezione validazione**: Viene lanciata un'eccezione per bloccare il salvataggio
4. **Nessun blocco iniziale**: L'utente può inserire i dati senza essere bloccato, ma non può salvare fino a quando non soddisfa il requisito

## Errori Comuni (Rispolverati)

### ❌ NON validare singoli campi come invalidi
Non bisogna marcare ogni singolo campo con valore 0 come errato, perché:
- L'utente potrebbe avere solo 2 campi da compilare
- La regola è "almeno 2", non "tutti devono essere > 0"

### ✅ CORRETTO: Validazione globale
La validazione corretta è:
- Contare quanti campi editabili hanno valore > 0
- Se count < 2, mostrare errore globale
- NON marcare campi individuali come invalidi

## Riferimenti

- File: `Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`
- Costante: `MIN_POSITIVE_RATINGS = 2`
- Metodo: `ensureMinimumPositiveRatings()`
- Legenda: Visualizzata nel blade `compila.blade.php` tramite `$this->record->msg('legenda')`
