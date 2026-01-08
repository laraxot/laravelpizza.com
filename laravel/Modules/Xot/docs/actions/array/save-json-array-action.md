# SaveJsonArrayAction

L'azione `SaveJsonArrayAction` è responsabile del salvataggio di array in formato JSON su file.

## Caratteristiche Principali

- Salvataggio sicuro di array in formato JSON
- Gestione automatica della codifica
- Validazione dei dati in ingresso
- Gestione degli errori di scrittura

## Metodi

### execute(array $data, string $filename): bool

Salva un array in formato JSON in un file specificato.

#### Parametri
- `$data`: Array da salvare
- `$filename`: Percorso del file di destinazione

#### Return
- `bool`: True se il salvataggio è avvenuto con successo

## Best Practices

1. **Validazione Input**
   - Verificare che l'array sia valido
   - Controllare i permessi di scrittura
   - Validare il percorso del file

2. **Gestione Errori**
   - Utilizzare try/catch per gestire errori di scrittura
   - Fornire messaggi di errore dettagliati
   - Loggare gli errori critici

3. **Ottimizzazione**
   - Utilizzare JSON_PRETTY_PRINT per leggibilità
   - Impostare permessi appropriati
   - Gestire file di grandi dimensioni

## Dipendenze

- Spatie\QueueableAction\QueueableAction
- Safe\Exceptions\JsonException
- Webmozart\Assert\Assert

## Esempio di Utilizzo

```php
$action = app(SaveJsonArrayAction::class);
$data = ['key' => 'value'];
$filename = storage_path('app/data.json');

$result = $action->execute($data, $filename);
```

## Note di Sviluppo

- L'azione utilizza la libreria Safe per operazioni sicure
- Implementa QueueableAction per supporto code
- Supporta la validazione tramite Assert 