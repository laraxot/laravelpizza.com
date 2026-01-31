# Task: Aumentare Copertura Test - Xot

**Modulo**: Xot
**Priorita'**: Alta
**Completamento**: 10%
**Data**: 2026-01-30

---

## Descrizione

Il modulo Xot ha solo 6 file di test per 496 file PHP in app/. La copertura test e' criticamente bassa per un modulo fondazionale da cui dipendono tutti gli altri.

## Aree Prioritarie per Test

### 1. Actions (80+ classi, 0 test dedicati)
- `Actions/File/*` - Operazioni su file
- `Actions/Cast/*` - Cast sicuri (SafeStringCast, SafeIntCast, SafeBooleanCast)
- `Actions/Model/*` - Operazioni su modelli
- `Actions/Export/*` - Export PDF/XLS

### 2. Services (20+ classi)
- `Services/ArtisanService` - Esecuzione comandi Artisan
- `Services/ConfigService` - Gestione configurazione
- `Services/ModuleService` - Gestione moduli

### 3. Base Classes
- `Models/XotBaseModel` - Verifica traits e comportamento base
- `Filament/Resources/XotBaseResource` - Verifica pattern estensione

### 4. DTOs (30+ classi)
- `Datas/XotData` - Configurazione core
- `Datas/MetatagData` - Metatag SEO
- `Datas/RouteData` - Dati routing

## Target

- Da 6 a 30+ file di test
- Copertura minima 60% per Actions e Services
- Test unitari per tutti i Cast actions
- Test di integrazione per XotBaseModel

## Criteri di Completamento

- [ ] Almeno 10 test per Actions principali
- [ ] Almeno 5 test per Services
- [ ] Almeno 5 test per DTOs
- [ ] Tutti i test passano
- [ ] PHPStan level 10 mantiene 0 errori
