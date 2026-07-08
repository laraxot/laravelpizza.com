# Risoluzione dei Problemi Comuni con PTVX

## Errori Frequenti

### Estensione di Classi Filament Dirette
**Problema**: Uno strumento AI potrebbe suggerire di estendere direttamente classi Filament invece delle classi XotBase.
**Soluzione**: Assicurarsi sempre che le risorse estendano `XotBaseResource`, le pagine estendano le classi appropriate da `Xot\Filament\Resources\Pages\`, ecc.

### Traduzioni Hardcoded
**Problema**: Uno strumento AI potrebbe suggerire l'uso di metodi hardcoded come `->label('Etichetta')`.
**Soluzione**: Rimuovere sempre questi metodi e affidarsi al sistema di traduzioni automatico basato sulle chiavi.

### Uso di Services Invece di Actions
**Problema**: Uno strumento AI potrebbe suggerire l'uso di Services tradizionali invece di Spatie QueueableAction.
**Soluzione**: Sostituire i Services con le Actions appropriate.

## Pattern di Debug

### Verifica dell'Architettura
Quando si sospetta che uno strumento AI abbia prodotto codice che non rispetta i pattern Laraxot:

1. Controllare che tutte le classi estendano le corrispondenti XotBase
2. Verificare che non ci siano metodi hardcoded per le traduzioni
3. Assicurarsi che le Actions siano usate al posto dei Services

### Validazione del Codice Generato
Prima di utilizzare codice generato da uno strumento AI:

1. Controllare la presenza di estensioni dirette di classi Filament
2. Verificare che le relazioni tra modelli siano corrette
3. Assicurarsi che le regole di validazione siano appropriate
4. Controllare che i nomi delle variabili e funzioni seguano le convenzioni

## Esempi di Risoluzione

### Problema: Risorse che estendono direttamente Filament
```
// Errato
class MiaRisorsa extends Filament\Resources\Resource
{
    // ...
}

// Corretto
class MiaRisorsa extends Modules\Xot\Filament\Resources\XotBaseResource
{
    // ...
}
```

### Problema: Traduzioni hardcoded
```
// Errato
TextInput::make('nome')
    ->label('Nome')
    ->required()

// Corretto
TextInput::make('nome')
    ->required()
```

### Problema: Uso di Service invece di Action
```
// Errato
class MiaLogicaService
{
    public function elaboraDati($dati) {
        // logica qui
    }
}

// Corretto
class ElaboraDatiAction
{
    use QueueableAction;

    public function execute($dati) {
        // logica qui
    }
}
```

## Validazione Automatica

Per verificare che il codice generato dagli strumenti AI rispetti i requisiti:

1. Eseguire PHPStan per controllare problemi di tipo
2. Controllare che non ci siano errori di architettura
3. Verificare che tutte le dipendenze siano corrette
4. Assicurarsi che le traduzioni siano gestite automaticamente

## Comunicazione con gli Strumenti AI

Quando si richiede assistenza agli strumenti AI:

1. Specificare chiaramente che il progetto usa il framework Laraxot
2. Indicare che tutte le classi devono estendere le corrispondenti XotBase
3. Richiedere esplicitamente di non usare metodi hardcoded per le traduzioni
4. Specificare che si devono usare le Actions invece dei Services

### Prompt Esempmpio
```
"Genera una risorsa Filament per il modello MiaEntita rispettando le regole Laraxot:
- Estendi XotBaseResource invece di Filament Resource
- Non usare metodi hardcoded per le traduzioni
- Usa Actions per la logica di business invece di Services
- Segui le convenzioni di denominazione del progetto PTVX"
```