# Cms - Product Requirements Document (PRD)

> Documento vivente. Modulo Content Management System.

## 1. Purpose & Vision

Il modulo **Cms** gestisce pagine e contenuti dinamici tramite Laravel Folio, Livewire Volt e blocchi JSON. È il cuore del front-office: nessuna pagina pubblica esiste senza passare dal Cms.

**Visione**: Pagine 100% CMS-driven — contenuti in JSON, rendering via blocchi, zero controller tradizionali.

## 2. Problem Statement

Senza Cms:
- Ogni pagina richiederebbe Blade hardcoded e route manuali
- Nessuna separazione tra contenuto e presentazione
- Impossibile gestire pagine da admin senza deploy

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Content editor** | Gestisce contenuti | Modificare pagine da Filament |
| **Sviluppatore** | Crea blocchi | Componenti blocchi riutilizzabili |
| **Admin** | Configurazione | PageResource, sezioni, header/footer |

## 4. Scope

### In Scope
- PageResource Filament per gestione pagine
- JSON content blocks (config/local/{tenant}/database/content/)
- Folio catch-all per route pubbliche
- Block components per hero, sezioni, footer
- Integrazione con modulo Lang per localizzazione

### Out of Scope
- E-commerce o carrello
- Blog con commenti
- Versioning avanzato contenuti (audit)

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Pagine pubbliche via JSON + Folio
- **FR-002**: Admin Filament per gestione pagine e contenuti
- **FR-003**: Blocchi contenuto modulari (hero, block, section)
- **FR-004**: Localizzazione contenuti (locale in JSON)

### P1: Enhancement
- **FR-005**: Sezioni globali (header, footer)
- **FR-006**: Metatag e SEO per pagina

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan Level 10
- **NFR-002**: Nessun controller tradizionale per front-office
- **NFR-003**: Contenuti JSON in config/local/{tenant}/

## 7. Technical Architecture

- **Dipendenze**: Xot, Lang, UI, Folio, Volt
- **Storage**: JSON in `config/local/{tenant}/database/content/pages/`
- **Rendering**: Folio + Volt, blocchi in `Themes/{Theme}/resources/views/components/blocks/`

## 8. Risks & Assumptions

- Assunzione: tutti i contenuti pubblici passano da JSON
- Rischio: JSON troppo grandi — valutare migrazione DB per contenuti

## 9. References

- [PRD Progetto](../../../../docs/prd.md)
- [Content Blocks System](./content-blocks-system.md)
- [Folio Routing](./folio-routing-locale.md)

## Testing & Coverage

Il modulo $(basename $(dirname $(dirname "$prd"))) segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

