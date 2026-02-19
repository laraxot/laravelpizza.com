# Principi Architetturali Laraxot: DRY + KISS + SOLID + ROBUST + INTELLIGENT

## Regola Fondamentale
**SEMPRE** seguire i principi architetturali Laraxot: DRY + KISS + SOLID + ROBUST + INTELLIGENT.

## Principi Obbligatori

### 1. DRY (Don't Repeat Yourself)
- **NON** duplicare mai codice, configurazioni o logica
- **SEMPRE** creare componenti riutilizzabili
- **SEMPRE** centralizzare configurazioni comuni
- **SEMPRE** estendere classi base esistenti

### 2. KISS (Keep It Simple, Stupid)
- **NON** complicare mai le cose
- **SEMPRE** preferire soluzioni semplici e dirette
- **SEMPRE** evitare over-engineering
- **SEMPRE** mantenere la leggibilità del codice

### 3. SOLID
- **Single Responsibility**: Ogni classe ha una sola responsabilità
- **Open/Closed**: Aperto per estensione, chiuso per modifica
- **Liskov Substitution**: Le classi derivate sono sostituibili
- **Interface Segregation**: Interfacce piccole e specifiche
- **Dependency Inversion**: Dipendere da astrazioni, non da concrezioni

### 4. ROBUST
- **SEMPRE** gestire errori e casi edge
- **SEMPRE** validare input e output
- **SEMPRE** implementare fallback e recovery
- **SEMPRE** testare scenari critici

### 5. INTELLIGENT
- **SEMPRE** usare pattern appropriati
- **SEMPRE** implementare logica di business intelligente
- **SEMPRE** ottimizzare performance quando necessario
- **SEMPRE** seguire best practices del framework

### 6. LARAXOT
- **SEMPRE** estendere classi base XotBase
- **SEMPRE** seguire convenzioni Laraxot
- **SEMPRE** usare trait e macro appropriati
- **SEMPRE** rispettare l'architettura modulare

## Applicazione Pratica

### Struttura File
- **NON** creare mai file `.md` nella root di `.ai/`
- **SEMPRE** organizzare contenuti in sottocartelle appropriate
- **SEMPRE** seguire naming convention coerenti
- **SEMPRE** mantenere separazione delle responsabilità

### Organizzazione Guidelines
```
laravel/.ai/guidelines/
├── architecture/          # Principi architetturali
├── testing/              # Guidelines per i test
├── development/          # Best practices sviluppo
├── security/             # Sicurezza e validazione
└── performance/          # Ottimizzazioni e performance
```

## Penalità per Violazioni
- File `.md` nella root di `.ai/` verranno RIMOSSI
- Codice che viola i principi verrà RIFATTO
- Architettura non conforme verrà CORRETTA
- Focus sulla qualità e manutenibilità

## Regola Assoluta
**SEMPRE DRY + KISS + SOLID + ROBUST + INTELLIGENT + LARAXOT!**

## Collegamenti
- [Testing Priority Rule](testing-priority-rule.md)
- [Model Testing Philosophy](model-testing-philosophy.md)
- [No RefreshDatabase Rule](no-refresh-database-rule.md)
- [Laraxot Framework](../../laravel/modules/xot/docs/laraxot-framework.md)

---
**Ultimo aggiornamento**: Dicembre 2024
**Versione**: 1.0
**Compatibilità**: Laraxot <nome progetto>, Architecture Principles
**Compatibilità**: Laraxot <nome progetto>, Architecture Principles
