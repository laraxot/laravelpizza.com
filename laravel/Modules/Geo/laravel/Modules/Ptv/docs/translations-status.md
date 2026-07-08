# Traduzioni Modulo Ptv - Stato Aggiornamento

**Data**: 2026-02-24

## Stato Traduzioni

| Lingua | File Presenti | Stato |
|--------|---------------|-------|
| Italiano (it) | 41 file | ✅ Completo |
| Inglese (en) | 2 file → 8 file | 🚧 In aggiornamento |
| Tedesco (de) | 1 file → 4 file | 🚧 In aggiornamento |

## File Creati/Aggiornati

### Inglese (en)
- ✅ `actions.php` - Azioni (compila, import, export)
- ✅ `stabi_dirigente.php` - Dirigenti di stabilimento
- ✅ `worker.php` - Lavoratori
- ✅ `valutatore.php` - Valutatori
- ✅ `lavoratore.php` - Lavoratori
- ✅ `rep.php` - Reparti
- ✅ `rating.php` - Rating
- ✅ `import_valutatori.php` - Importazione valutatori
- ✅ `criteri_esclusione_enum.php` - Enum criteri esclusione
- ✅ `comparison_operator_enum.php` - Operatori di confronto (riusabile)
- ✅ `rule_value_type_enum.php` - Tipo valore in regola (riusabile)

### Tedesco (de)
- ✅ `actions.php` - Azioni
- ✅ `stabi_dirigente.php` - Dirigenti di stabilimento
- ✅ `worker.php` - Lavoratori
- ✅ `criteri_esclusione_enum.php` - Enum criteri esclusione
- ✅ `comparison_operator_enum.php` - Operatori di confronto (riusabile)
- ✅ `rule_value_type_enum.php` - Tipo valore in regola (riusabile)

## Struttura Traduzioni

```
Modules/Ptv/lang/
├── de/          # Tedesco
│   ├── actions.php
│   ├── stabi_dirigente.php
│   ├── worker.php
│   └── criteri_esclusione_enum.php
├── en/          # Inglese
│   ├── actions.php
│   ├── stabi_dirigente.php
│   ├── worker.php
│   ├── valutatore.php
│   ├── lavoratore.php
│   ├── rep.php
│   ├── rating.php
│   ├── import_valutatori.php
│   └── criteri_esclusione_enum.php
└── it/          # Italiano (completo)
    └── ... (41 file)
```

## Chiavi Traduzione Verificate

✅ `ptv::actions.compila.label` → "Compila" (it), "Fill out" (en), "Ausfüllen" (de)
✅ `ptv::stabi_dirigente.fields.matr.label` → "Matricola" (it), "Employee ID" (en), "Mitarbeiternummer" (de)
✅ `ptv::worker.fields.cognome.label` → "Cognome" (it), "Last Name" (en), "Nachname" (de)

## Note

- Le traduzioni in italiano sono complete (41 file)
- Le traduzioni in inglese e tedesco coprono i file principali
- I file rimanenti verranno aggiunti progressivamente
- Ogni file contiene la struttura espansa (label, description, helper_text, placeholder)

## Collegamenti

- [Regola Traduzioni](../../../docs/translation-rules.md)
- [AGENTS.md](../../../AGENTS.md)
