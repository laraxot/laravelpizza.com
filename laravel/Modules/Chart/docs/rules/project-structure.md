# Regole Struttura Progetto

## Convenzioni Laravel
1. **Percorsi**:
   - Tutte le cartelle in minuscolo
   - Nomi plurali per le risorse
   - Struttura standardizzata
   - Case-sensitive

2. **Struttura Standard**:
   ```
   app/
   ├── Console/
   ├── Exceptions/
   ├── Http/
   ├── Models/
   └── Providers/

   resources/
   ├── css/
   ├── js/
   ├── lang/
   ├── views/
   └── ...

   Modules/
   └── ModuleName/
       ├── app/
       ├── resources/
       └── composer.json
   ```

3. **Best Practices**:
   - Verificare sempre la documentazione
   - Utilizzare percorsi relativi
   - Mantenere la coerenza
   - Seguire le convenzioni

## Gestione Moduli
1. **Struttura**:
   - Namespace base: `Modules\ModuleName`
   - Cartelle in minuscolo
   - Percorsi relativi

2. **Risorse**:
   - `resources/` invece di `Resources/`
   - `views/` invece di `Views/`
   - `lang/` invece di `Lang/`

3. **Verifica**:
   - Controllare la struttura
   - Verificare i percorsi
   - Testare la risoluzione

## Documentazione
1. **Regole**:
   - Mantenere aggiornate
   - Verificare la coerenza
   - Seguire le convenzioni

2. **Strumenti**:
   - Utilizzare IDE con supporto
   - Configurare i linter
   - Mantenere la tracciabilità

3. **Monitoraggio**:
   - Verifica dei percorsi
   - Analisi della struttura
   - Controllo della coerenza 