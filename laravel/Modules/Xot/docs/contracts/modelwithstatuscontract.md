# ModelWithStatusContract

## Descrizione
Questo contratto definisce l'interfaccia per i modelli che supportano la gestione degli stati utilizzando il pacchetto Spatie Model Status.

## Utilizzo
```php
class YourModel extends Model implements ModelWithStatusContract
{
    use \Spatie\ModelStatus\HasStatuses;
    
    // Implementazione dei metodi richiesti dal contratto
}
```

## Metodi richiesti

### statuses()
```php
public function statuses(): MorphMany
```
Restituisce la relazione morfica con gli stati del modello.

### status()
```php
public function status(): ?Status
```
Restituisce lo stato corrente del modello, se presente.

### setStatus()
```php
public function setStatus(string $name, ?string $reason = null): self
```
Imposta un nuovo stato per il modello con un motivo opzionale.

## Proprietà
- `id`: Identificatore univoco del modello
- `user_id`: ID dell'utente associato
- `post_type`: Tipo di post
- `created_at`: Data di creazione
- `updated_at`: Data di aggiornamento
- `created_by`: Utente che ha creato il record
- `updated_by`: Utente che ha aggiornato il record
- `title`: Titolo del record
- `pivot`: Relazione pivot
- `tennant_name`: Nome del tenant
- `user`: Relazione con l'utente
- `status`: Stato corrente
- `statuses`: Collection degli stati
- `statuses_count`: Conteggio degli stati

## Best Practices
- Utilizzare il trait `HasStatuses` di Spatie
- Implementare tutti i metodi richiesti dal contratto
- Gestire correttamente le relazioni morfiche
- Documentare gli stati disponibili
- Implementare la validazione degli stati

## Note sulla sicurezza
- Verificare i permessi prima di modificare gli stati
- Validare i nomi degli stati
- Sanitizzare i motivi degli stati
- Implementare il logging delle modifiche di stato

## Collegamenti correlati
- [Documentazione Spatie Model Status](https://github.com/spatie/laravel-model-status)
- [Documentazione Laravel Eloquent](https://laravel.com/docs/eloquent)
- [Documentazione PHPStan](https://phpstan.org/) 