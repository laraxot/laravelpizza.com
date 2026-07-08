# Errori Comuni e Soluzioni

## Introduzione

Questo documento raccoglie una serie di errori comuni che si verificano durante lo sviluppo con il framework Laravel, in particolare quando si lavora con moduli come Filament e con l'architettura modulare del progetto.

La documentazione di questi errori ha lo scopo di fornire una guida rapida per la diagnosi e la risoluzione, riducendo i tempi di debug e migliorando l'efficienza dello sviluppo.

## Indice degli Errori

1. [Errore: Colonna non trovata nella tabella](#errore-colonna-non-trovata-nella-tabella)
2. [Errore: Compatibilità della firma del metodo](#errore-compatibilità-della-firma-del-metodo)
3. [Errore: Classe Model non istanziabile](#errore-classe-model-non-istanziabile)
4. [Errore: Namespace non trovato](#errore-namespace-non-trovato)
5. [Errore: Modello non trovato](#errore-modello-non-trovato)

---

## Errore: Colonna non trovata nella tabella

### Descrizione
Si verifica quando si fa riferimento a una colonna che non esiste nella tabella del database.

**Esempio di errore:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'nazione.descrizione' in 'field list'
```

### Cause possibili
1. La colonna è stata rimossa o rinominata, ma il codice non è stato aggiornato.
2. La relazione tra tabelle fa riferimento a colonne errate.
3. Il campo è stato referenziato utilizzando un nome non corretto.

### Soluzione
1. Verificare lo schema della tabella per identificare i nomi corretti delle colonne.
2. Aggiornare le query o le definizioni dei modelli per fare riferimento ai campi corretti.
3. Se si sta utilizzando Filament, controllare i campi nei form e nelle tabelle.

**Esempio di correzione:**
```php
// Modifica da:
Forms\Components\TextInput::make('nazione_id')
    ->relationship('nazione', 'descrizione')

// A:
Forms\Components\TextInput::make('nazione_id')
    ->relationship('nazione', 'nome')
```

---

## Errore: Compatibilità della firma del metodo

### Descrizione
Si verifica quando la firma di un metodo in una classe figlio non è compatibile con la firma del metodo nella classe genitore.

**Esempio di errore:**
```
Declaration of Modules\Broker\app\Filament\Clusters\ClienteCluster\Resources\ClienteBrainResource\Pages\CreateClienteFromBrain::mount($record = null) must be compatible with Filament\Resources\Pages\CreateRecord::mount(): void
```

### Cause possibili
1. Override di un metodo con una firma diversa rispetto alla classe genitore.
2. Cambio della firma del metodo nella classe genitore dopo un aggiornamento del framework.
3. Aggiunta di parametri non presenti nel metodo originale.

### Soluzione
1. Verificare la firma del metodo nella classe genitore.
2. Adattare la firma del metodo nella classe figlio per renderla compatibile.
3. Se necessario, ricorrere a hook alternativi offerti dal framework.

**Esempio di correzione:**
```php
// Modifica da:
public function mount($record = null): void
{
    // Codice esistente
}

// A:
public function mount(): void
{
    $record = request()->query('record');
    // Codice esistente
}
```

---

## Errore: Classe Model non istanziabile

### Descrizione
Si verifica quando si tenta di istanziare direttamente una classe astratta come `Illuminate\Database\Eloquent\Model`.

**Esempio di errore:**
```
Target [Illuminate\Database\Eloquent\Model] is not instantiable.
```

### Cause possibili
1. Riferimento a una classe con namespace errato.
2. Utilizzo di metodi come `getModel()` che restituiscono una stringa invece di un'istanza.
3. Configurazione errata nei service provider o nelle definizioni di dependency injection.

### Soluzione
1. Verificare i namespace dei modelli e importare correttamente le classi.
2. Utilizzare `getRecord()` al posto di `getModel()` quando si lavora con Filament.
3. Assicurarsi che i metodi che dovrebbero restituire un'istanza non restituiscano una stringa.

**Esempio di correzione:**
```php
// Modifica da:
use Modules\Brain\app\Models\Socio as BrainSocio;

// A:
use Modules\Brain\Models\Socio as BrainSocio;

// E da:
$model = $this->getModel();

// A:
$record = $this->getRecord();
```

---

## Errore: Namespace non trovato

### Descrizione
Si verifica quando si fa riferimento a un namespace che non esiste o non è accessibile.

**Esempio di errore:**
```
Class "Modules\Brain\app\Models\Socio" not found
```

### Cause possibili
1. Struttura del namespace diversa da quella prevista.
2. Mancanza di un import corretto all'inizio del file.
3. Errore di digitazione nel namespace.

### Soluzione
1. Verificare la struttura effettiva dei namespace nel progetto.
2. Controllare il percorso fisico dei file per assicurarsi che corrisponda al namespace.
3. Utilizzare l'autocompletamento dell'IDE per ridurre gli errori di digitazione.

---

## Errore: Modello non trovato

### Descrizione
Si verifica quando si tenta di accedere a un modello che non esiste o non è nella posizione prevista.

**Esempio di errore:**
```
Class "App\Models\NomeModello" not found
```

### Cause possibili
1. Il modello è stato spostato in un altro namespace.
2. Il modello non è stato ancora creato.
3. Errore di digitazione nel nome della classe.

### Soluzione
1. Verificare la posizione corretta del modello e il suo namespace.
2. Utilizzare il comando `php artisan make:model` per creare il modello se non esiste.
3. Controllare il nome della classe per assicurarsi che sia corretto.

---

## Best Practices per Evitare Errori Comuni

1. **Verifica sempre i namespace**: Prima di utilizzare una classe, controlla che il namespace sia corretto e che la classe esista in quella posizione.

2. **Segui le convenzioni del framework**: Laravel e Filament hanno convenzioni specifiche per i nomi e la struttura. Seguirle riduce la probabilità di errori.

3. **Utilizza gli strumenti di debug**: Usa `dd()`, `dump()` o strumenti come Laravel Telescope per analizzare gli errori.

4. **Mantieni aggiornata la documentazione**: Ogni volta che risolvi un errore, documentalo per future reference.

5. **Usa il type-hinting**: Specifica i tipi dei parametri e dei valori restituiti per ridurre gli errori di tipo.

6. **Considera l'upgrade gracefully**: Quando aggiorni il framework o le librerie, leggi attentamente le note di rilascio per identificare potenziali breaking changes.

7. **Implementa test unitari**: I test possono rilevare errori prima che raggiungano l'ambiente di produzione. 