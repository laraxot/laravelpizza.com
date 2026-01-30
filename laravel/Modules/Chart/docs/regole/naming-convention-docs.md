# Regola: Naming Convention Documentazione

## Descrizione
Tutti i file e le cartelle all'interno della directory `docs/` devono utilizzare caratteri minuscoli, con l'unica eccezione di `README.md`.

## Contesto
Questa regola garantisce:
- Consistenza nella struttura della documentazione
- Facilità di navigazione
- Compatibilità cross-platform
- Manutenibilità

## Regole Specifiche
1. **File**:
   - Utilizzare solo caratteri minuscoli
   - Separare le parole con trattini (`-`)
   - Estensione sempre in minuscolo (`.md`)
   - Esempio: `form-architecture.md`

2. **Cartelle**:
   - Utilizzare solo caratteri minuscoli
   - Separare le parole con trattini (`-`)
   - Esempio: `errori-gravi/`

3. **Eccezioni**:
   - `README.md` può essere in maiuscolo
   - File di configurazione specifici (es. `.gitignore`)

## Esempi
```plaintext

# ❌ Errore
docs/ErroriGravi/
docs/Implementazione/
docs/STANDARDS.md
docs/FormArchitecture.md

# ✅ Corretto
docs/errori-gravi/
docs/implementazione/
docs/standards.md
docs/form-architecture.md
```

## Best Practices
1. Verificare sempre il naming prima di creare nuovi file/cartelle
2. Utilizzare script di validazione
3. Documentare le eccezioni
4. Mantenere la consistenza

## Collegamenti Correlati
- [Struttura Documentazione](../struttura-documentazione.md)
- [Best Practices](../best-practices.md)
