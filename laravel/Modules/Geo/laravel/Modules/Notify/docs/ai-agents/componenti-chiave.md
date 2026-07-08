# Componenti Chiave

## Modulo Xot
E' il modulo fondamentale che fornisce:
- Classi base (XotBaseModel, XotBaseUser, XotBaseResource, ecc.)
- Service provider base
- Architettura modulare
- Componenti Filament standardizzati
- PHPStan Level 10 compliance
- Approfondimento: [Qualità del Codice](./qualita-codice.md)

## Autenticazione Multi-Tipo
Il modulo User implementa un sistema avanzato di autenticazione multi-tipo usando Single Table Inheritance (STI):
- Tipi supportati: Doctor, Patient, Admin
- Sistema OAuth completo con Passport
- Gestione team e tenants
- Role-Based Access Control con Spatie Permission

## Filament Integration
- Tutte le risorse estendono XotBaseResource
- Traduzioni automatiche basate sulle chiavi (vedi [Regole Critiche Laraxot](./regole-critiche.md#traduzioni))
- Layout standardizzati
- Componenti riutilizzabili

## Chart Module - JpGraph 4.4.3
Il modulo Chart gestisce la generazione di grafici con doppia strategia:
- **Chart.js 4.4.3** (Frontend): Grafici interattivi nelle dashboard Filament
- **JpGraph 4.4.3** (Backend): Generazione server-side PNG per embedding in PDF
- Package Composer: `mitoteam/jpgraph` (PHP 8.5 support)
- Pattern: Actions + DTOs (ChartData, AnswersChartData)
- Tipi: bar1, bar2, bar3, horizbar1, pie1, pieAvg, lineSubQuestion
- Documentazione: `Modules/Chart/docs/jpgraph-4-4-3-reference.md`