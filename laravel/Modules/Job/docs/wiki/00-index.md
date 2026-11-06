---
title: "📚 **Indice Documentazione Modulo Job**"
module: "Job"
type: concept
tags: [00, INDEX]
created: 2026-07-14
updated: 2026-07-14
qmd: "00 index"
related:
  - "./phpstan-fixes-archive-2.md"
status: stale
---

> Nota 2026-10-14 (docs-audit): Copia parziale e piu' vecchia di ../00-index.md (stesse voci, descrizioni non verificate, link relativi misti); l'indice operativo e' ../00-index.md. Link verso ./phpstan-fixes-archive-2.md: bersaglio inesistente. Contenuto non riscritto, verificare prima di usarlo.

# 📚 **Indice Documentazione Modulo Job**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](README.md) - Panoramica completa, Multi-Queue e Scheduling.
2. [roadmap.md](../roadmap.md) - Visione evolutiva e obiettivi 2026.
3. [philosophy.md](../philosophy.md) - La gestione "Zen" dei flussi asincroni.

## 🏗️ **Core Logic & Services**
- ⚡ **[Queue Management](../queueable-action.md)** - Guida alla gestione delle code e dei worker.
- 🕒 **[Scheduling System](../schedule.md)** - Configurazione di cron job e task pianificati.
- 🧬 **[Batch Processing](./analysis.md)** - Elaborazione massiva di job concatenati.

## 📊 **Monitoring & Reports**
- 📈 **[Job Monitor UI](../filament.md)** - Dashboard di monitoraggio in Filament.
- 📄 **[PDF Reports](../job-reports.md)** - Generazione di log e statistiche in PDF (HTML2PDF).
- 🔗 **[Soketi & Socket.io](../soketi.md)** - Real-time monitoring tramite websocket.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Level 10](../phpstan-level-10-compliance.md)** - Conformità e fix specifici.
- 🔬 **[Testing Strategy](../testing.md)** - Approccio Pest per i flussi di coda.
- 🧹 **[PHPMD & Complexity](../cyclomatic-complexity-report.md)** - Analisi della pulizia del codice.

## 📦 **Pacchetti Composer**
- [Riferimento composer packages](../../../../../bashscripts/ai/wiki/memories/composer-packages-reference.md) - Nessuna dipendenza diretta; usa Xot, spipu/html2pdf (via Xot)

## 🔗 **Moduli Correlati**
- [Xot](../../../Xot/docs/README.md) - Base framework e Page classes.
- [Activity](../../../Activity/docs/README.md) - Tracciamento log esecuzione.
- [Notify](../../../Notify/docs/README.md) - Notifiche fallimento job.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](../dependency-intelligence.md)
