# Analisi Incrementale con PHPStan

## Introduzione

L'analisi incrementale con PHPStan è un approccio che permette di migliorare gradualmente la qualità del codice, aumentando il livello di analisi in modo progressivo e correggendo gli errori man mano che vengono rilevati.

## Script di Automazione

È stato creato uno script bash (`scripts/phpstan-incremental.sh`) che automatizza il processo di analisi incrementale. Lo script:

1. Inizia con l'analisi a livello 1 (il più permissivo)
2. Aumenta gradualmente il livello fino a 9 (il più restrittivo)
3. Genera file di baseline per gli errori trovati ad ogni livello
4. Fornisce feedback dettagliato sul progresso

## Utilizzo

```bash
# Rendere lo script eseguibile
chmod +x scripts/phpstan-incremental.sh

# Eseguire lo script
./scripts/phpstan-incremental.sh
```

## Processo di Correzione

Per ogni livello di PHPStan, lo script:

1. **Esegue l'analisi** e salva i risultati in un file di log
2. **Verifica la presenza di errori**:
   - Se non ci sono errori, passa al livello successivo
   - Se ci sono errori, genera un file baseline e si ferma

3. **Risoluzione errori**: L'utente deve:
   - Consultare il file di log (`logs/phpstan/level_X.log`)
   - Correggere gli errori manualmente
   - Rimuovere il riferimento al file baseline dal `phpstan.neon`
   - Rieseguire lo script

## Livelli di PHPStan

Lo script progredisce attraverso i seguenti livelli:

- **Livello 1**: Controlli di base (variabili/classi non esistenti)
- **Livello 2**: Metodi statici/dinamici
- **Livello 3**: Tipi di ritorno
- **Livello 4**: Tipi di parametri
- **Livello 5**: Proprietà di classi
- **Livello 6**: Tipi più complessi
- **Livello 7**: Uso di docblock più rigoroso
- **Livello 8**: Tipi nell'inferenza e check di invarianza/covarianza
- **Livello 9**: Impostazioni avanzate (mixed esplicito, etc.)

## File di Configurazione

Lo script opera sul file `phpstan.neon` nella directory principale. La configurazione è ottimizzata per il progetto il progetto, tenendo conto delle sue peculiarità:

- Utilizzo di `XotBaseRouteServiceProvider` invece di `RouteServiceProvider`
- Utilizzo di `XotBaseResource` invece di `Resource`
- Struttura modulare del progetto

## Correzione Errori Comuni

### Come Correggere Errori Tipici

1. **Call to undefined method**:
   ```php
   // Prima
   $result = $object->nonExistentMethod();
   
   // Dopo
   $result = $object->existingMethod();
   ```

2. **Access to undefined property**:
   ```php
   // Prima
   $value = $object->nonExistentProperty;
   
   // Dopo
   $value = $object->existingProperty;
   ```

3. **Parametri con tipi mancanti**:
   ```php
   // Prima
   public function process($data) {
   
   // Dopo
   public function process(array $data): void {
   ```

4. **Tipi di ritorno mancanti**:
   ```php
   // Prima
   public function getData() {
   
   // Dopo
   public function getData(): array {
   ```

## Conclusione

L'analisi incrementale ti consente di migliorare gradualmente la qualità del codice, affrontando i problemi in ordine di importanza e complessità. Una volta raggiunto il livello 9, il codice sarà conforme agli standard più elevati di qualità e tipo-sicurezza. 