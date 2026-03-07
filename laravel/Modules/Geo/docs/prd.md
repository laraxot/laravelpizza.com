# Geo - Product Requirements Document (PRD)

> Documento vivente. Modulo servizi geografici.

## 1. Purpose & Vision

Il modulo **Geo** fornisce geocoding, mappe e gestione posizioni. Integra provider esterni per coordinate, indirizzi e visualizzazione mappe.

**Visione**: Funzionalità geografiche riutilizzabili per eventi, contatti, sedi.

## 2. Problem Statement

Senza Geo:
- Nessun geocoding per indirizzi
- Mappe hardcoded o duplicate
- Dati geografici (comuni, province) non centralizzati

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Utente finale** | Visualizza mappe | Vedere sedi eventi, contatti |
| **Admin** | Configurazione | Gestire comuni, province |
| **Sviluppatore** | Integrazione | API geocoding, componenti mappa |

## 4. Scope

### In Scope
- Modello Comune (Sushi) con dati comuni italiani
- Geocoding e reverse geocoding
- Componenti mappa (solo free tier: OpenStreetMap, Leaflet)
- Integrazione con pagine contatti e eventi

### Out of Scope
- Google Maps a pagamento
- Routing e navigazione
- Dati geografici fuori Italia (estensione futura)

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Dati comuni italiani (JSON/Sushi)
- **FR-002**: Geocoding indirizzo → coordinate
- **FR-003**: Componente mappa per pagine contatti/eventi

### P1: Enhancement
- **FR-004**: Admin Filament per province/regioni
- **FR-005**: Cache per richieste geocoding

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan Level 10
- **NFR-002**: Solo mappe free (OpenStreetMap, Leaflet)
- **NFR-003**: Nessuna API key obbligatoria per funzionamento base

## 7. Technical Architecture

- **Dipendenze**: Xot
- **Dati**: comuni.json, modelli Comune, Provincia
- **Provider**: OpenStreetMap Nominatim (o simile)

## 8. Risks & Assumptions

- Assunzione: uso free tier sufficiente per progetto
- Rischio: rate limit Nominatim → cache aggressiva

## 9. Testing & Coverage

Il modulo Geo segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

## 10. References

- [PRD Progetto](../../../../docs/prd.md)
- [Free Maps Only](../../../../.cursor/memories/free-maps-only.md)

## Testing & Coverage

Il modulo $(basename $(dirname $(dirname "$prd"))) segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

