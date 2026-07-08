# Linee Guida per PHPStan Livello 10 - Regole Comuni

Questo documento contiene le linee guida generali e le regole comuni per risolvere gli errori PHPStan di livello 10 in tutti i moduli del progetto.

## Principi Fondamentali

### 1. Eliminazione del tipo `mixed`

Il tipo `mixed` è spesso la causa principale degli errori PHPStan a livello 10. **Dovrebbe essere utilizzato SOLO come ultima spiaggia**, quando non è possibile determinare un tipo più specifico.

### 2. Tipizzazione Corretta degli Array

Gli array dovrebbero essere sempre tipizzati correttamente utilizzando le notazioni generiche nelle annotazioni PHPDoc.

### 3. Conversione Sicura da `mixed` a Tipi Scalari

Quando si lavora con valori `mixed` da convertire in tipi scalari, utilizzare controlli di tipo prima della conversione.

## Casi Specifici per Filament

### 1. Documentazione del metodo `getInfolistSchema`

Il metodo `getInfolistSchema` è utilizzato nelle classi che estendono `XotBaseViewRecord` per definire lo schema di visualizzazione dei dettagli di un record. Questo metodo deve **sempre** restituire un array con chiavi di tipo stringa che rappresentano i componenti Filament da visualizzare.

La corretta documentazione di questo metodo deve essere:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'id' => TextEntry::make('id'),
        'nome' => TextEntry::make('nome'),
        // Altri componenti...
    ];
}
```

È fondamentale utilizzare sempre chiavi di tipo stringa per identificare chiaramente i componenti nell'array. Non utilizzare mai array sequenziali con indici numerici impliciti.

#### Esempi di implementazioni corrette:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'informazioni_personali' => Section::make('Informazioni Personali')
            ->schema([
                // Altri componenti...
            ]),
        'dettagli_contatto' => Section::make('Dettagli Contatto')
            ->schema([
                // Altri componenti...
            ]),
    ];
}
```

Per linee guida più dettagliate sul metodo `getInfolistSchema`, consultare il documento [INFOLIST_SCHEMA_GUIDELINES.md](../filament/INFOLIST_SCHEMA_GUIDELINES.md).

## Gestione degli Errori Comuni

### 1. `Cannot cast mixed to string/int/float/bool`

Questo errore si verifica quando si tenta di convertire un valore mixed direttamente a un tipo scalare.

### 2. `Parameter #X $Y of method Z expects array<string, T>, array<V, T> given`

Errore comune quando si passano array con chiavi miste a metodi che richiedono array con chiavi stringa.

### 3. `Method X returns mixed, but return statement returns Y`

Errore che si verifica quando una funzione restituisce un tipo specifico ma è dichiarata per restituire mixed.

## Processo di Lavoro Consigliato

1. Eseguire PHPStan a livello 10 per identificare gli errori
2. Raggruppare gli errori per tipo e modulo
3. Risolvere prima gli errori più comuni e semplici
4. Documentare ogni soluzione nella cartella `docs` del modulo corrispondente
5. Verificare che le soluzioni non introducano nuovi errori 