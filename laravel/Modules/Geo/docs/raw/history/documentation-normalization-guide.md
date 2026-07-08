# Guida alla Normalizzazione della Documentazione Laraxot PTVX

## Obiettivo

Normalizzare la documentazione di tutti i moduli e temi seguendo i principi:
- **DRY (Don't Repeat Yourself)**: Eliminare duplicazioni
- **KISS (Keep It Simple, Stupid)**: Mantenere semplicità e chiarezza
- **Business Logic First**: Focus su scopo e motivazioni, non solo implementazione

## Stato Attuale

### Statistiche
- **Totale file .md trovati**: ~5.208 file non conformi
- **Problemi principali**:
  - File con maiuscole nel nome
  - File con date nel nome (YYYY-MM-DD, YYYYMMDD)
  - Contenuti duplicati
  - Mancanza di focus su business logic

### Moduli Analizzati
- ✅ Xot (framework base)
- ✅ User (autenticazione)
- ✅ Performance (valutazioni)
- ✅ Lang (traduzioni)
- ⏳ Altri moduli in analisi

## Regole di Naming

### ✅ Corretto
```
README.md                    # Unica eccezione per maiuscole
architecture.md              # Tutto minuscolo
business-logic.md            # Trattini per separare parole
filament-resources.md        # Descrittivo e chiaro
```

### ❌ Errato
```
ARCHITECTURE.md              # Maiuscole
Architecture.md              # CamelCase
business_logic.md            # Underscore (preferire trattini)
filament-resources.md   # Date nel nome
phpstan-fixes.md  # Date specifiche
```

## Struttura Standard per Modulo

```
Modules/{ModuleName}/docs/
├── README.md                          # Panoramica, business logic, quick start
│
├── Core Documentation
│   ├── architecture.md                # Architettura e pattern
│   ├── business-logic.md              # Logica di business dettagliata
│   ├── configuration.md               # Configurazione e setup
│   └── installation.md                # Guida installazione
│
├── Development
│   ├── testing.md                     # Strategie di test
│   ├── phpstan-compliance.md          # Analisi statica
│   ├── development-guidelines.md      # Linee guida sviluppo
│   └── troubleshooting.md             # Risoluzione problemi
│
├── Features (se necessario)
│   ├── feature-name.md                # Documentazione feature specifica
│   └── ...
│
└── Integration (se necessario)
    ├── module-integration.md          # Integrazione con altri moduli
    └── ...
```

## Processo di Consolidamento

### Fase 1: Identificazione Duplicati
1. Trovare file con stesso "base name" (ignorando date e maiuscole)
2. Elencare tutti i file duplicati per modulo
3. Creare report di analisi

### Fase 2: Analisi Contenuti
Per ogni gruppo di duplicati:
1. Leggere tutti i file
2. Identificare contenuto unico in ciascuno
3. Determinare quale file è più completo/recente
4. Pianificare consolidamento

### Fase 3: Consolidamento
1. Creare nuovo file con nome normalizzato
2. Unire contenuti eliminando duplicazioni
3. Mantenere focus su business logic
4. Aggiungere sezioni mancanti se necessarie

### Fase 4: Aggiornamento Riferimenti
1. Cercare tutti i link ai file vecchi
2. Aggiornare riferimenti al nuovo file
3. Verificare link funzionanti

### Fase 5: Pulizia
1. Eliminare file duplicati/obsoleti
2. Verificare struttura finale
3. Aggiornare README.md del modulo

## Template README.md per Modulo

```markdown
# Modulo {Nome} - Documentazione

## Panoramica

Breve descrizione del modulo (2-3 frasi).

## Business Logic

### Scopo
Perché esiste questo modulo? Quale problema risolve?

### Casi d'Uso Principali
- Caso d'uso 1
- Caso d'uso 2
- Caso d'uso 3

### Flussi di Business
Descrizione dei flussi principali con focus su logica, non implementazione.

## Componenti Principali

### Modelli
- **NomeModello**: Scopo e responsabilità

### Resources Filament
- **NomeResource**: Funzionalità esposte

### Actions/Services
- **NomeAction**: Logica di business implementata

## Architettura

### Pattern Utilizzati
- Pattern 1: Motivazione
- Pattern 2: Motivazione

### Integrazioni
- Modulo X: Tipo di integrazione
- Modulo Y: Tipo di integrazione

## Configurazione

Riferimento a [configuration.md](configuration.md)

## Testing

Riferimento a [testing.md](testing.md)

## Collegamenti

### Documentazione Interna
- [Architecture](architecture.md)
- [Business Logic](business-logic.md)
- [Troubleshooting](troubleshooting.md)

### Documentazione Correlata
- [Modulo X](../ModuloX/docs/README.md)
- [Modulo Y](../ModuloY/docs/README.md)

*Ultimo aggiornamento: [Data]*
```

## Checklist per Ogni Modulo

- [ ] README.md aggiornato con focus su business logic
- [ ] File duplicati identificati e consolidati
- [ ] Tutti i file rinominati secondo convenzioni
- [ ] Struttura cartelle organizzata
- [ ] Link interni verificati e funzionanti
- [ ] Link a moduli correlati aggiornati
- [ ] Contenuto focalizzato su "perché" e "scopo"
- [ ] Dettagli implementativi ridotti al minimo

## Priorità Moduli

### Alta Priorità (Core Framework)
1. **Xot** - Framework base
2. **User** - Autenticazione
3. **Lang** - Traduzioni
4. **UI** - Componenti UI

### Media Priorità (Business Logic)
5. **Performance** - Valutazioni
6. **Ptv** - Dati anagrafici
7. **Gdpr** - Privacy
8. **Activity** - Audit trail

### Bassa Priorità (Specifici)
9. Altri moduli specifici del dominio

## Script di Supporto

### Normalizzazione Nomi
```bash
/var/www/_bases/base_ptvx_fila5_mono/bashscripts/normalize_docs_naming.sh
```

### Analisi Duplicati
```bash
/var/www/_bases/base_ptvx_fila5_mono/bashscripts/analyze_docs_duplicates.sh
```

## Note Importanti

1. **Non eliminare informazioni**: Durante il consolidamento, preservare tutte le informazioni utili
2. **Backup**: Considerare backup prima di eliminazioni massive
3. **Iterativo**: Procedere modulo per modulo, non tutto insieme
4. **Review**: Far verificare i cambiamenti da chi conosce il modulo
5. **Git**: Committare frequentemente con messaggi descrittivi

## Esempi di Consolidamento

### Esempio 1: File PHPStan
**Prima:**
- `phpstan-fixes.md`
- `phpstan-fixes-archive-1.md`
- `phpstan-fixes.md`
- `PHPSTAN_FIXES.md`

**Dopo:**
- `phpstan-compliance.md` (consolidato, focus su regole e pattern)

### Esempio 2: File Traduzioni
**Prima:**
- `translation-system.md`
- `translation_system.md`
- `translations-system.md`
- `TRANSLATION_SYSTEM.md`

**Dopo:**
- `translation-system.md` (unico file, normalizzato)

## Metriche di Successo

- ✅ Riduzione file duplicati > 70%
- ✅ 100% file con naming conforme
- ✅ README.md di ogni modulo con business logic chiara
- ✅ Struttura cartelle standardizzata
- ✅ Zero link rotti nella documentazione

---

*Documento creato: 2025-01-29*
*Ultima revisione: 2025-01-29*
