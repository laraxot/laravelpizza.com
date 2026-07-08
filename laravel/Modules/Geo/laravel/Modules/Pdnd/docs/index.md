# Modulo Pdnd - Indice Documentazione

## 📚 Documentazione Disponibile (76KB totali)

### 🎯 Documentazione Principale

#### [README](./readme.md) `6.2KB`
Panoramica completa del modulo PDND:
- Componenti principali (C003, C030, client PDND)
- Struttura dati (DTO, enumerazioni)
- Flusso di lavoro
- Configurazione e sicurezza
- Troubleshooting

**Inizia da qui se è la prima volta che lavori sul modulo.**

---

### 🔧 Best Practices e Standard

#### [Filament Best Practices](./filament-best-practices.md) `4.4KB`
Regole vincolanti Filament 4 per il modulo:
- ✅ Estensioni classi (sempre XotBase*, mai Filament diretto)
- ✅ Traduzioni automatiche (mai ->label(), ->placeholder(), ->tooltip())
- ✅ BadgeColumn deprecato (usare TextColumn::badge())
- ✅ Proprietà vietate in XotBasePage
- ✅ Pattern migrazione Services → Actions

**Consulta prima di creare nuove pagine o risorse Filament.**

#### [Safe Functions Best Practices](./safe-functions-best-practices.md) `6.1KB`
Uso corretto delle Safe functions:
- Pattern `\Safe\preg_replace()` (prefix diretto, no import)
- Type casting preventivo da array mixed
- Gestione eccezioni Safe
- Checklist funzioni unsafe vs safe

**Consulta prima di usare preg_replace, json_decode/encode, file_get_contents.**

#### [Translations Structure](./translations-structure.md) `7.3KB`
Sistema traduzioni automatiche del modulo:
- Struttura espansa obbligatoria (label, placeholder, help)
- Pattern per campi, azioni, widget
- Convenzioni naming file e chiavi
- LangServiceProvider automatico

**Consulta prima di creare form o aggiungere campi.**

---

### 🔍 Fix e Troubleshooting

#### [PHPStan Complete Fixes](./phpstan-complete-fixes.md) `12KB`
Fix dettagliati di tutti i 48 errori PHPStan livello 9:
- Proprietà senza tipo → Type hints espliciti
- Proprietà non definita → PHPDoc @property
- Funzioni unsafe → Safe functions con `\Safe\` prefix
- Return type mancanti → `: void` espliciti
- Operazioni binarie mixed → Type casting preventivo
- Form dinamici → Istanziazione Schema corretta
- Array mixed → is_string() guards

**Consulta per capire come risolvere errori PHPStan specifici.**

#### [PHPStan Fixes](./phpstan-fixes.md) `2.3KB`
Fix storici (precedenti):
- Rimozione proprietà `$navigationIcon` vietate
- Problemi cache PHPStan

**Riferimento storico, le correzioni attuali sono in phpstan-complete-fixes.md.**

#### [Import Cleanup](./import-cleanup.md) `4.3KB`
Guida pulizia import inutilizzati:
- Pattern import standard
- Template per pagine ANPR
- Benefici performance e manutenibilità
- Checklist pre-commit

**Consulta prima di fare refactoring import.**

---

### 🏗️ Architettura

#### [Services Architecture](./services-architecture.md) `7.4KB`
Architettura servizi ANPR completa:
- Gerarchia classi (PdndClientService, C003, C030)
- Data Transfer Objects (DTO)
- Pattern di utilizzo
- Gestione errori ANPR
- Performance e monitoring

**Consulta prima di modificare o estendere servizi ANPR.**

---

### 📝 Changelog

#### [Changelog](./changelog.md) `4.6KB`
Registro completo delle modifiche:
- Refactoring Filament 4 (1 Ottobre 2025)
- Statistiche intervento (62 file, 48 errori, 54 fix stile)
- Prossimi step (migrazione Services → Actions)
- Note di versione e compatibilità

**Consulta per vedere cronologia modifiche e pianificazione futura.**

---

## 🚀 Quick Start

### Per Nuovi Sviluppatori

1. **Leggi**: [README](./readme.md) - Panoramica generale
2. **Studia**: [Filament Best Practices](./filament-best-practices.md) - Regole inviolabili
3. **Implementa**: Seguendo i pattern documentati
4. **Verifica**: Con PHPStan e Pint prima del commit

### Per Bug Fixing

1. **Identifica**: Tipo di errore (PHPStan, stile, logico)
2. **Consulta**: 
   - Errori PHPStan → [phpstan-complete-fixes.md](./phpstan-complete-fixes.md)
   - Problemi Safe → [safe-functions-best-practices.md](./safe-functions-best-practices.md)
   - Import → [import-cleanup.md](./import-cleanup.md)
3. **Applica**: Pattern documentato
4. **Documenta**: Aggiungi note in changelog se necessario

### Per Nuove Feature

1. **Progetta**: Seguendo [services-architecture.md](./services-architecture.md)
2. **Traduzioni**: Struttura espansa in [translations-structure.md](./translations-structure.md)
3. **UI Filament**: Regole in [filament-best-practices.md](./filament-best-practices.md)
4. **Test**: PHPStan livello 9, Pint, test funzionali
5. **Documenta**: Aggiorna README e crea doc specifica se necessario

## 📊 Metriche Documentazione

```
Totale file:        8
Dimensione totale:  76KB
Copertura:          100% componenti modulo
Formato:            Markdown
Collegamenti:       Bidirezionali tra docs
Ultimo update:      1 Ottobre 2025
```

## ✅ Checklist Documentazione

Per ogni nuova feature o modifica significativa:
- [ ] README aggiornato
- [ ] Best practices verificate
- [ ] Pattern documentato se nuovo
- [ ] Changelog aggiornato
- [ ] Collegamenti bidirezionali creati
- [ ] Esempi codice funzionanti
- [ ] Motivazioni tecniche spiegate

## 🔗 Collegamenti Esterni

### Risorse Ufficiali
- [PDND Interoperabilità](https://docs.pagopa.it/interoperabilita-1/)
- [ANPR Servizi](https://www.anpr.interno.it/portale/documentazione-tecnica)
- [Filament 4](https://filamentphp.com/docs/4.x)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
- [thecodingmachine/safe](https://github.com/thecodingmachine/safe)

### Documentazione Moduli Correlati
- [Modulo Xot - XotBasePage](../../Xot/docs/filament/xot-base-page.md)
- [Modulo Xot - Convenzioni](../../Xot/docs/xot-base-conventions.md)
- [Modulo Lang - LangServiceProvider](../../Lang/docs/readme.md)

*Ultimo aggiornamento: 1 Ottobre 2025*

