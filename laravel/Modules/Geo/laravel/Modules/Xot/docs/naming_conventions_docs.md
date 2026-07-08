# Convenzioni di Naming nella Documentazione

## Regola: Nome del Progetto nei Moduli

### ⚠️ Regola Fondamentale
Il nome specifico del progetto (es: "il progetto") NON DEVE MAI apparire nella documentazione dei singoli moduli.

### Motivazione
1. **Riusabilità dei Moduli**
   - I moduli sono progettati per essere riutilizzabili in diversi progetti
   - Il riferimento a un progetto specifico limita questa riusabilità
   - La documentazione deve essere neutrale e generica

2. **Manutenibilità**
   - In caso di rebranding, non è necessario aggiornare la documentazione dei moduli
   - Evita confusione quando il modulo viene utilizzato in progetti diversi
   - Semplifica il processo di fork e riutilizzo

3. **Separazione delle Responsabilità**
   - I moduli descrivono funzionalità generiche
   - Il contesto specifico del progetto va documentato nella root
   - Mantiene pulita la separazione tra logica di business e implementazione

### Dove Usare il Nome del Progetto
✅ CORRETTO:
- `/project_docs/` (cartella root del progetto)
- `README.md` principale
- File di configurazione specifici del progetto
- Documentazione di deployment

❌ ERRATO:
- Documentazione dei moduli
- File di traduzione dei moduli
- Esempi di codice nei moduli
- Test dei moduli

### Esempi

#### ✅ CORRETTO (in un modulo)
```markdown
# Modulo di Gestione Pazienti
Questo modulo fornisce funzionalità per la gestione dei pazienti in una clinica odontoiatrica.
```

#### ❌ ERRATO (in un modulo)
```markdown
# Modulo Pazienti il progetto
Questo modulo gestisce i pazienti nella piattaforma il progetto.
```

### Terminologia da Usare nei Moduli
- "il sistema"
- "l'applicazione"
- "la piattaforma"
- "il progetto"
- "l'implementazione"

### Checklist di Verifica
Prima di committare modifiche alla documentazione di un modulo, verificare:
- [ ] Nessun riferimento al nome specifico del progetto
- [ ] Uso di terminologia generica
- [ ] Descrizioni funzionali indipendenti dal contesto
- [ ] Esempi neutrali

## Note Importanti
1. Questa regola si applica a TUTTI i file nella cartella `docs/` dei moduli
2. Include anche esempi di codice e configurazioni
3. Si applica a tutti i formati (MD, PHP, JSON, etc.)
4. Vale anche per i commenti nel codice

## Collegamenti
- [Struttura Moduli](module-structure.md)
- [Convenzioni Generali](conventions.md)
- [Best Practices Documentazione](documentation-guidelines.md) 