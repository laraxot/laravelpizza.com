# Workflow Analisi PHPStan

> **Nota**: Per una panoramica completa sulla gestione della documentazione e delle regole, consultare [DOCUMENTATION_MANAGEMENT.md](DOCUMENTATION_MANAGEMENT.md)

## REGOLE FONDAMENTALI
- ⚠️ **NON INTERROMPERE MAI L'ANALISI** finché non si raggiunge il livello 7
- ⚠️ **CORREGGERE PIÙ ERRORI POSSIBILI CONTEMPORANEAMENTE** per ottimizzare il processo
- ⚠️ **CONTINUARE SENZA SOSTA** fino al completamento del livello 7

## Processo di Analisi

### 1. Preparazione
- Posizionarsi nella cartella `laravel`
- Verificare la presenza del file `phpstan.neon`
- Assicurarsi che tutte le dipendenze siano installate
- **IMPORTANTE**: L'analisi DEVE continuare fino al raggiungimento del livello 7 di PHPStan
- **FONDAMENTALE**: Correggere il maggior numero possibile di errori in ogni sessione
- **MAI INTERROMPERE** l'analisi prima di aver raggiunto il livello 7

### 2. Analisi Incrementale
1. **Livello 1-7 - Analisi Globale**
   ```bash
   ./vendor/bin/phpstan analyse Modules --level=N  # dove N va da 1 a 7
   ```
   - Correggere TUTTI gli errori dello stesso tipo contemporaneamente
   - Quando possibile, correggere errori simili in batch
   - Continuare l'analisi senza interruzioni
   - Se gli errori sono > 200, procedere modulo per modulo
   - Se gli errori sono < 100, passare al livello successivo
   - Ripetere fino al raggiungimento del livello 7

2. **Livello 1-7 - Analisi per Modulo**
   ```bash
   ./vendor/bin/phpstan analyse Modules/NomeModulo --level=N  # dove N va da 1 a 7
   ```
   - Analizzare un modulo alla volta
   - Correggere gruppi di errori simili in una singola sessione
   - Ottimizzare il processo correggendo più errori contemporaneamente
   - Per ogni modulo, raggiungere il livello 7 prima di passare al modulo successivo
   - **NON FERMARSI MAI** finché il modulo non raggiunge il livello 7

3. **Incremento Livello**
   - Quando gli errori totali sono < 100, aumentare il livello
   - Ripetere il processo per ogni livello fino al livello 7
   - **ASSOLUTAMENTE VIETATO INTERROMPERE** finché non si raggiunge il livello 7
   - Ogni modulo deve raggiungere il livello 7 di analisi
   - Lavorare su più errori contemporaneamente per velocizzare il processo

### 3. Processo di Correzione
1. **Prima della Correzione**
   - IMPORTANTE: Aggiornare e studiare la documentazione nella cartella `docs` del modulo specifico
     ```
     Modules/
     ├── Cms/
     │   ├── docs/         # Se correggo file in Cms, aggiorno questi docs
     │   └── [file da correggere]
     ├── Blog/
     │   ├── docs/         # Se correggo file in Blog, aggiorno questi docs
     │   └── [file da correggere]
     ```
   - IMPORTANTE: Per regole significative, aggiornare anche:
     ```
     base_predict_fila3_mono/
     ├── .cursor/
     │   └── rules/        # Regole per Cursor AI
     └── .windsurfrules    # Regole per Windsurf
     ```
   - Aggiornare le rules e le memories
   - Studiare l'errore e il suo contesto

2. **Durante la Correzione**
   - Mantenere la funzionalità del sito
   - Creare/aggiornare i test necessari
   - Seguire le convenzioni di codice

3. **Dopo la Correzione**
   - Verificare che non siano stati introdotti nuovi errori
   - Eseguire i test
   - Aggiornare la documentazione del modulo se necessario

## Tipologie di Errori Comuni

### 1. Errori di Visibilità
```php
// Errore: Access level to method must be public (as in parent class)
protected function getTableHeaderActions(): array  // ❌ ERRATO
public function getTableHeaderActions(): array     // ✅ CORRETTO
```

### 2. Errori di Tipo
```php
// Errore: Method return type missing
function getData()                    // ❌ ERRATO
public function getData(): array      // ✅ CORRETTO
```

### 3. Errori di Proprietà
```php
// Errore: Property does not exist
/** @property string $title */        // ✅ CORRETTO
class MyModel extends BaseModel
```

## Checklist per Ogni Correzione

1. **Documentazione**
   - [ ] Aggiornare docs nel modulo specifico (es: Modules/Cms/docs se lavoro su file in Cms)
   - [ ] Aggiornare rules
   - [ ] Aggiornare memories
   - [ ] Se la regola è importante:
     - [ ] Aggiornare .cursor/rules
     - [ ] Aggiornare .windsurfrules

2. **Analisi**
   - [ ] Studiare l'errore
   - [ ] Identificare la causa root
   - [ ] Pianificare la correzione

3. **Implementazione**
   - [ ] Correggere il codice
   - [ ] Aggiungere/aggiornare test
   - [ ] Verificare funzionalità

4. **Verifica**
   - [ ] Rilanciare PHPStan
   - [ ] Eseguire i test
   - [ ] Verificare il sito

## Best Practices

1. **Gestione Errori**
   - ✅ Correggere GRUPPI di errori simili contemporaneamente
   - ✅ Ottimizzare il processo con correzioni multiple
   - ✅ Mantenere commit atomici per gruppi di correzioni simili
   - ✅ Documentare le correzioni di massa
   - ❌ MAI interrompere l'analisi prima del livello 7
   - ❌ MAI correggere un solo errore alla volta se esistono errori simili
   - ❌ MAI rimandare le correzioni a sessioni successive

2. **Approccio Efficiente**
   - Identificare pattern comuni di errori
   - Correggere tutti gli errori dello stesso tipo in una volta
   - Utilizzare ricerche globali per trovare errori simili
   - Automatizzare le correzioni quando possibile
   - Non perdere tempo con pause o interruzioni

3. **Testing**
   - Aggiungere test per nuove funzionalità
   - Aggiornare test esistenti
   - Verificare copertura
   - Assicurarsi che i test passino a livello 7 di PHPStan

4. **Documentazione**
   - Aggiornare in tempo reale
   - Mantenere esempi aggiornati
   - Documentare decisioni importanti
   - Per regole significative:
     - Aggiornare la documentazione del modulo
     - Aggiornare .cursor/rules
     - Aggiornare .windsurfrules

5. **Gestione Regole**
   - Identificare regole importanti durante l'analisi
   - Documentare le regole in più luoghi:
     - Docs del modulo specifico
     - .cursor/rules per Cursor AI
     - .windsurfrules per Windsurf
   - Mantenere coerenza tra le diverse documentazioni 