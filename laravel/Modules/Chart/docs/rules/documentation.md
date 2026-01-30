# Regole Documentazione

## 📂 Struttura

### Root `/docs`
- Contiene la documentazione specifica del progetto
- Gestisce i collegamenti tra i moduli
- Mantiene l'indice generale
- Contiene le regole del progetto

### Moduli `/Modules/[ModuleName]/docs`
- Contiene solo documentazione generica e riutilizzabile
- NON deve contenere collegamenti ad altri moduli
- Documenta solo le funzionalità del modulo
- Mantiene la propria struttura interna

## 🔗 Collegamenti

### Collegamenti tra Moduli
- Devono essere definiti SOLO in `/docs/module-links.md`
- Non devono apparire nella documentazione dei singoli moduli
- Devono specificare le dipendenze e le relazioni
- Devono essere mantenuti aggiornati

### Collegamenti Interni al Modulo
- Possono essere presenti nella documentazione del modulo
- Devono usare percorsi relativi
- Devono essere mantenuti all'interno della cartella del modulo
- Non devono fare riferimento a file esterni al modulo

## 📝 Contenuti

### Documentazione Moduli
- Deve essere generica e riutilizzabile
- Non deve contenere riferimenti al progetto specifico
- Deve documentare API e funzionalità
- Deve includere esempi generici

### Documentazione Progetto
- Deve essere nella root `/docs`
- Può contenere riferimenti specifici
- Deve documentare l'integrazione
- Deve mantenere i collegamenti

## ✅ Best Practices

1. **Separazione**
   - Mantenere separata la documentazione generica da quella specifica
   - Non duplicare informazioni
   - Usare riferimenti quando necessario

2. **Manutenibilità**
   - Aggiornare regolarmente i collegamenti
   - Verificare i link morti
   - Mantenere la struttura coerente

3. **Chiarezza**
   - Usare nomi descrittivi per i file
   - Mantenere una struttura coerente
   - Documentare le modifiche

4. **Versionamento**
   - Versionare la documentazione con il codice
   - Mantenere un changelog
   - Taggare le versioni importanti 
## Collegamenti tra versioni di documentation.md
* [documentation.md](docs/rules/documentation.md)
* [documentation.md](laravel/Modules/Xot/docs/documentation.md)
* [documentation.md](laravel/Modules/Xot/docs/guidelines/documentation.md)
* [documentation.md](laravel/Modules/Cms/docs/roadmap/features/documentation.md)

