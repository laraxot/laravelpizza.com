# Regole Componenti Blade

## Struttura Componenti

### Organizzazione
1. **Layouts**:
   - Layout principali in `views/layouts/`
   - Componenti layout in `views/components/layouts/`
   - Namespace: `layouts`

2. **UI Components**:
   - Componenti UI in `views/components/ui/`
   - Namespace: `ui`

3. **Blocks**:
   - Blocchi riutilizzabili in `views/components/blocks/`
   - Namespace: `blocks`

## Convenzioni Naming

1. **File**:
   - Nome in kebab-case
   - Suffisso `.blade.php`
   - Esempio: `main.blade.php`

2. **Componenti**:
   - Nome in kebab-case
   - Namespace appropriato
   - Esempio: `<x-layouts.main>`

## Best Practices

1. **Struttura**:
   - Mantenere la coerenza dei namespace
   - Separare i componenti per tipo
   - Documentare le dipendenze

2. **Utilizzo**:
   - Usare i componenti appropriati
   - Seguire le convenzioni di naming
   - Mantenere la documentazione aggiornata

3. **Manutenzione**:
   - Verificare la struttura completa
   - Controllare le dipendenze
   - Aggiornare la documentazione

## Errori Comuni

1. **Struttura**:
   - Confusione tra layout e componenti
   - Namespace errati
   - Percorsi non standard

2. **Prevenzione**:
   - Verificare la struttura
   - Documentare le convenzioni
   - Seguire le best practices 