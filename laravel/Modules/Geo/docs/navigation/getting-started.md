---
title: "getting started"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "getting started"
issues: []
discussions: []
status: draft
---

# 🚀 Guida Rapida - Entry Point PTVX

> **BENVENUTO in PTVX!** Questa è la tua guida di partenza per iniziare rapidamente.

## 🎯 3 Passi per Iniziare

### 1. Leggi le Regole Fondamentali
Prima di tutto, **leggi [Regole Fondamentali](./core.md)** - sono essenziali per evitare errori comuni.

### 2. Scegli il Tuo Percorso
| Vuoi... | Vai a... |
|---------|----------|
| **Sviluppare nuove funzionalità** | [Architettura](./architecture-rules.md) |
| **Capire la struttura moduli** | [Struttura Moduli](./module-structure.md) |
| **Risolvere problemi** | [Errori Comuni](../claude/common-pitfalls.md) |
| **Migliorare qualità codice** | [Qualità Codice](./code-quality.md) |

### 3. Usa il Quick Reference
Quando sei bloccato, consulta [Quick Reference](./../quick-reference/errors.md) per soluzioni rapide.

---
## 📂 Navigazione Principale

### 🏗️ Architettura e Struttura
- **[Architettura PTVX](./architecture-rules.md)** - Come è organizzato il progetto
- **[Struttura Moduli](./module-structure.md)** - Come creare e gestire moduli
- **[Proprietà Eloquent](../claude/eloquent-properties.md)** - Gestione modelli (CRITICO)

### 🛠️ Sviluppo e Qualità
- **[Qualità Codice](./code-quality.md)** - PHPStan, testing, PSR-12
- **[Framework Specifici](../claude/framework-specifics.md)** - Filament, Livewire, Tailwind
- **[Task di Sviluppo](../claude/development-tasks.md)** - Workflow e automazioni

### 📚 Policy e Convenzioni
- **[Policy Documentazione](../claude/documentation-policy.md)** - Come scrivere documentazione
- **[Convenzioni](../development/conventions.md)** - Stile codice e naming
- **[Laravel Boost MCP](../claude/laravel-boost.md)** - Strumenti AI

### 🔧 Risoluzione Problemi
- **[Errori Comuni](../claude/common-pitfalls.md)** - Cosa NON fare
- **[Pattern DRY/KISS](./dry-kiss-patterns.md)** - Best practices
- **[Principi SOLID](../claude/solid-principles.md)** - Design principles

---

## 🚨 Checklist Pre-Commit

**Prima di ogni commit, verifica:**

- [ ] Leggi [Regole Fondamentali](./core.md)
- [ ] Esegui PHPStan livello 9
- [ ] Test passano
- [ ] Documentazione aggiornata
- [ ] Nessun errore critico in [Quick Reference](./../quick-reference/errors.md)

---

## 📞 Supporto

### Documentazione Collegata
- **[Documentazione Moduli](../modules.md)** - Tutti i 42 moduli
- **[Troubleshooting](../troubleshooting/)** - Risoluzione problemi avanzata
- **[Best Practices](../best-practices/)** - Guide approfondite

### Strumenti di Sviluppo
- **PHPStan**: `phpstan analyse --level=9`
- **Testing**: `./vendor/bin/pest`
- **Code Style**: `./vendor/bin/php-cs-fixer fix`

---

**🚀 Pronto? Inizia da [Regole Fondamentali](./core.md)!**

*Ultimo aggiornamento: Dicembre 2025*
