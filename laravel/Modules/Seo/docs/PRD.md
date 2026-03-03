# Seo - Product Requirements Document (PRD)

> Documento vivente. Modulo ottimizzazione SEO.

## 1. Purpose & Vision

Il modulo **Seo** gestisce metatag, structured data e ottimizzazioni per ricerca. Migliora visibilità e ranking delle pagine pubbliche.

**Visione**: SEO by default per ogni pagina, senza duplicazione di logica.

## 2. Problem Statement

Senza Seo:
- Metatag hardcoded o inconsistenti
- Nessuno schema markup (JSON-LD)
- Ogni modulo duplicherebbe logica SEO

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Content editor** | Gestisce contenuti | Modificare title, description |
| **Sviluppatore** | Integrazione | Componenti metatag, schema |
| **Admin** | Configurazione | Impostazioni globali SEO |

## 4. Scope

### In Scope
- Metatag per pagina (title, description, og:image)
- Schema markup (Organization, Event, WebPage)
- Sitemap e robots.txt
- Integrazione con Cms e Filament

### Out of Scope
- SEO audit automatico
- Keyword research
- Backlink monitoring

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Metatag dinamici per pagina
- **FR-002**: Schema.org JSON-LD per eventi e pagine
- **FR-003**: Sitemap XML generata

### P1: Enhancement
- **FR-004**: Admin per configurazione SEO globale
- **FR-005**: Open Graph e Twitter Cards

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan Level 10
- **NFR-002**: Nessun impatto su performance (lazy load metatag)
- **NFR-003**: Validazione schema.org

## 7. Technical Architecture

- **Dipendenze**: Xot, Cms
- **Output**: Metatag in layout, JSON-LD in head
- **Storage**: Config per default, override per pagina

## 8. Risks & Assumptions

- Assunzione: schema.org validi per Google
- Rischio: metatag duplicati → componente centralizzato

## 9. References

- [PRD Progetto](../../../../docs/prd.md)
