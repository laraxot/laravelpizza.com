# Indice Regole Critiche - Modulo Meetup

## Data
2025-11-30

## 📚 Documentazione Regole Critiche

### Regole Consolidate

1. **[Regole Critiche Consolidate](./critical-rules-consolidated.md)**
   - Frontend Asset Management
   - Componenti Blade Anonimi
   - Architettura Frontoffice

### Regole Specifiche

2. **[Frontend Asset Management](./development-workflow-css-js-changes.md)**
   - Workflow build e copy
   - Dev mode vs Production
   - Troubleshooting

3. **[Componenti Blade Anonimi](./pub-theme-component-namespace-error-analysis.md)**
   - Sintassi corretta
   - Analisi errore namespace
   - Soluzione implementata

4. **[Architettura Frontoffice](./architecture-reference.md)**
   - Folio + Volt pattern
   - Repository analizzati
   - Best practices

### Riferimenti Cross-Module

5. **[Regole Xot](../../Xot/docs/critical-rules-consolidated.md)** e **belongsToManyX** (regola progetto: `.cursor/rules/belongstomanyx-critical.md`)
   - Regole generali Laraxot
   - Filosofia Migrazioni
   - Estensioni Filament
   - Relazioni many-to-many: usare sempre `belongsToManyX()`, mai `belongsToMany()` (RelationX)

6. **[Regole Tema Meetup](../../../Themes/Meetup/docs/critical-rules-consolidated.md)**
   - Frontend Asset Management
   - Vite Configuration
   - Metatags Component

7. **[SVG: file .svg, no inline nelle Blade](./svg-icons-no-hardcoded-blade.md)** (regola: `.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc`)
   - Icone in `Modules/Meetup/resources/svg/`, uso `<x-filament::icon icon="meetup-{nome}" />`

### Schema.org e task implementazione

8. **[Schema.org Enhancement Recommendations](./schema-org-enhancement-recommendations.md)** – Riferimento tipi Schema.org studiati (Event, EventSeries, Offer, Place, Person, ecc.) e roadmap
9. **[Task Schema.org Event/Series/Azioni](./tasks-schema-org-event-series-actions.md)** – Event, EventSeries, EventSchedule, JoinAction, LeaveAction, EventReservation, EducationEvent, attendee
10. **[Task Schema.org Offer/Prezzo](./tasks-schema-org-offer-price.md)** – Offer, PriceSpecification, FoodEstablishment

## 🔄 Aggiornamenti Recenti

- **2025-11-30**: Aggiunta regola Frontend Asset Management
- **2025-11-30**: Aggiunta regola Componenti Blade Anonimi
- **2025-11-30**: Consolidata Architettura Frontoffice
