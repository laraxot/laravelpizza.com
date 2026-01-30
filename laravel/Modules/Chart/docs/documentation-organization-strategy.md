# Strategia di Organizzazione Documentazione <nome progetto>

## Obiettivi

1. **Eliminare duplicazioni**: Rimuovere file duplicati e ridondanti
2. **Standardizzare naming**: Applicare convenzioni di naming coerenti (hyphen-separated)
3. **Creare gerarchia logica**: Organizzare contenuti in struttura logica e navigabile
4. **Aggiornare collegamenti**: Correggere tutti i link interni
5. **Migliorare accessibilità**: Rendere la documentazione facilmente navigabile

## Regole di Naming Canoniche

### Convenzione Scelta: Hyphen-Separated
- ✅ `filament-best-practices.md`
- ✅ `phpstan-fixes.md`
- ✅ `translation-system.md`
- ❌ `filament_best_practices.md`
- ❌ `phpstan_fixes.md`
- ❌ `translation_system.md`

### Motivazione
- Maggiore leggibilità
- Compatibilità con URL
- Coerenza con standard web
- Facilità di ricerca

## Struttura Gerarchica Target

### Root Docs (`/docs/`)
```
docs/
├── README.md                    # Indice principale
├── core/                        # Documentazione core del sistema
│   ├── architecture.md
│   ├── configuration.md
│   └── installation.md
├── development/                 # Guide per sviluppatori
│   ├── best-practices.md
│   ├── coding-standards.md
│   └── testing.md
├── modules/                     # Documentazione moduli
│   ├── overview.md
│   └── integration.md
├── standards/                   # Standard e convenzioni
│   ├── naming-conventions.md
│   ├── documentation-standards.md
│   └── translation-standards.md
├── troubleshooting/            # Risoluzione problemi
│   ├── common-errors.md
│   └── phpstan-fixes.md
├── guides/                     # Guide specifiche
│   ├── quick-start.md
│   └── migration-guide.md
└── reference/                  # Materiale di riferimento
    ├── api.md
    └── changelog.md
```

### Module Docs (`/Modules/{ModuleName}/docs/`)
```
Modules/ModuleName/docs/
├── README.md                   # Overview del modulo
├── architecture/               # Architettura del modulo
├── features/                   # Funzionalità specifiche
├── api/                       # API del modulo
├── configuration/             # Configurazione
├── troubleshooting/           # Problemi specifici del modulo
└── examples/                  # Esempi di utilizzo
```

## Conflitti Identificati da Risolvere

### Conflitti con Contenuto Diverso
1. `navigation_components.md` vs `navigation-components.md` (UI module)
2. `phpstan_fixes.md` vs `phpstan-fixes.md` (UI module)

### Azione Richiesta
- Analizzare contenuto di entrambi i file
- Selezionare versione più completa/aggiornata
- Consolidare informazioni se necessario
- Mantenere versione hyphen-separated

## Processo di Consolidamento

### Fase 1: Risoluzione Conflitti
1. Analizzare file in conflitto
2. Selezionare versione canonica
3. Consolidare contenuti se necessario
4. Rimuovere versioni duplicate

### Fase 2: Riorganizzazione Strutturale
1. Spostare file nelle cartelle appropriate
2. Aggiornare tutti i link interni
3. Creare indici per ogni sezione
4. Validare struttura finale

### Fase 3: Validazione e Test
1. Verificare tutti i link
2. Testare navigazione
3. Validare completezza
4. Documentare modifiche

## Criteri per Selezione File Canonici

### Priorità (in ordine):
1. **Completezza**: File con più informazioni
2. **Aggiornamento**: File modificato più recentemente
3. **Qualità**: Migliore organizzazione e chiarezza
4. **Naming**: Preferenza per hyphen-separated
5. **Posizione**: Preferenza per posizione logica

## Prossimi Passi

1. ✅ Eseguito script di deduplicazione automatica
2. 🔄 Risoluzione manuale conflitti identificati
3. ⏳ Riorganizzazione strutturale
4. ⏳ Aggiornamento link interni
5. ⏳ Validazione finale

## Log delle Decisioni

### Conflitti Risolti
- (Da aggiornare durante il processo)

### File Canonici Selezionati
- (Da aggiornare durante il processo)

### Link Aggiornati
- (Da aggiornare durante il processo)

---

*Documento creato: 2025-08-01*
*Ultimo aggiornamento: 2025-08-01*
