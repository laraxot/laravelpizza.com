# Filosofia, Religione e Politica di Laraxot: Regole di Migrazione

## Regola Fondamentale: Una Tabella = Una Migration per Modulo

La filosofia Laraxot stabilisce con chiarezza che **non devono mai esistere più migration files per la stessa tabella all'interno dello stesso modulo**. Questo principio è fondamentale per mantenere:

- **Ordine architettonico**: Ogni tabella ha una sola fonte di verità per la sua struttura
- **Chiarezza evolutiva**: La storia della tabella è raccontata in un unico file
- **Facilità di manutenzione**: Nessun rischio di conflitti o duplicazioni
- **Coerenza del sistema**: Nessun dubbio su quale sia la "vera" migration della tabella

## Problema Identificato

Il modulo User violava questa filosofia fondamentale con tre migration files diversi per la stessa tabella `roles`:
1. `2023_01_01_000011_create_roles_table.php`
2. `2023_01_01_000012_create_roles_table.php`
3. `2025_09_18_000000_create_roles_table.php`

Questo rappresenta una **violazione grave della religione e politica di Laraxot** perché:
- **Duplicazione inaccettabile**: Creare più migration per la stessa tabella
- **Mancata coerenza**: La tabella viene creata più volte
- **Rischio di conflitti**: Operazioni potenzialmente in conflitto tra loro
- **Mancata chiarezza**: Non è chiaro quale migration sia quella "ufficiale"

## Soluzione Implementata

### Per la migration problematica `2025_09_18_000000_create_roles_table.php`:

La migration è stata modificata per **estendere** la tabella `roles` esistente anziché crearla, rispettando la realtà che la tabella già esiste grazie ad altre migration o al pacchetto Spatie Laravel Permission.

### Approccio corretto da seguire:

1. **Verifica esistenza**: Controllare se la tabella già esiste
2. **Estensione sicura**: Usare `tableUpdate()` anziché `tableCreate()` quando la tabella già esiste
3. **Controllo colonne**: Verificare l'esistenza delle colonne prima di aggiungerle con `hasColumn()`
4. **Controllo indici**: Verificare l'esistenza degli indici prima di crearli
5. **Rollback sicuro**: Rimuovere solo le colonne aggiunte, non quelle originali

## Principi Laraxot Rispettati

- **DRY (Don't Repeat Yourself)**: Non creare duplicati per la stessa entità
- **KISS (Keep It Simple, Stupid)**: Approccio semplice e diretto
- **Architettura modulare**: Rispetto per la struttura esistente
- **Unicità della fonte**: Una tabella = una sola migration di creazione
- **Pattern Laraxot**: Uso corretto di `XotBaseMigration` e suoi metodi sicuri

## Regole da Rispettare Sempre

1. **Una tabella, una sola migration di creazione per modulo**
2. **Le migration successive devono estendere, non ricreare**
3. **Usare sempre `hasColumn()`, `hasTable()`, `hasIndex()` per controlli sicuri**
4. **Nessuna duplicazione intenzionale di logica di creazione**
5. **Chiarezza evolutiva: la storia della tabella deve essere lineare**

## Documentazione della Regola

Questa regola diventa parte fondamentale della **filosofia, religione e politica di Laraxot**:
> "In un modulo, per ogni tabella deve esistere una sola migration responsabile della sua creazione. Le migration successive possono estendere la struttura esistente, ma non ricreare la tabella."

## Conclusione

Il rispetto di questa regola fondamentale garantisce l'armonia architettonica del sistema Laraxot, mantenendo la chiarezza, la coerenza e la facilità di manutenzione del codice.
