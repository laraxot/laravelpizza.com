# Roadmap Modulo Cms - [DATE]

**Modulo**: Cms (Content Management System)
**Scopo**: Gestione contenuti dinamici con sistema blocks, pagine multi-lingua, menu gerarchici e integrazione Folio/Volt.
**Stato Generale**: 75%
**PHPStan Level 10**: 0 errori (10 suppressioni inline in app/)
**File PHP**: 111 in app/
**Test Files**: 91
**Documentazione**: 315 docs

---

## Stato Attuale

Il modulo Cms fornisce:
- **Pagine dinamiche** con slug-based routing e content blocks JSON
- **Sistema Blocks** modulare (Paragraph, Navigation, Newsletter, Logo, Social, Links)
- **Menu gerarchici** con `HasRecursiveRelationships`
- **Modelli Sushi** per configurazione e moduli (no database)
- **FolioVoltServiceProvider** per routing file-based multi-lingua
- **DTOs** Wireable per Livewire (BlockData, FooterData, HeadernavData)
- **Integrazione Filament** per admin content management

---

## Tasks

| # | Task | File | Priorita' | % |
|---|------|------|-----------|---|
| 1 | Ridurre suppressioni PHPStan (10) | [task-ridurre-phpstan-suppressioni.md](task-ridurre-phpstan-suppressioni.md) | Alta | 0% |
| 2 | Completare sistema blocks | [task-completare-sistema-blocks.md](task-completare-sistema-blocks.md) | Alta | 60% |
| 3 | Migliorare test Folio/Volt routing | [task-test-folio-volt-routing.md](task-test-folio-volt-routing.md) | Media | 40% |
| 4 | Consolidare documentazione (315 file) | [task-consolidare-documentazione.md](task-consolidare-documentazione.md) | Media | 20% |
| 5 | Implementare versioning pagine | [task-versioning-pagine.md](task-versioning-pagine.md) | Bassa | 0% |

---

## Note

- Buona copertura test (91 file)
- 10 suppressioni PHPStan da risolvere
- Sistema blocks funzionante ma estensibile
