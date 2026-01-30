# Regole e Memorie Aggiornate per Tutti gli Agenti - Filament 5.x, Multi-tenancy e Laravel Modules

## Panoramica

## 4. Environment Configuration

### 4.1 Development vs Testing Environments

È importante comprendere la differenza tra le configurazioni di ambiente:

- **Sviluppo** (`.env.development`): 
  - Usa SQLite per setup immediato e sviluppo rapido
  - Configurazione: `DB_CONNECTION=sqlite`, `DB_DATABASE=$PROJECT_ROOT/database/database.sqlite`
  - Ideale per sviluppo locale senza necessità di setup aggiuntivi

- **Test** (`.env.testing`):
  - Usa MySQL con database suffissi "_test" 
  - Richiesto per garantire corretto isolamento multi-tenant nei test
  - **MAI** usare SQLite per i test, anche per convenienza
  
Questa differenziazione è fondamentale per mantenere l'integrità del sistema multi-tenant durante lo sviluppo e i test.

Questo documento contiene le regole e memorie aggiornate per tutti gli agenti che lavorano con il framework Laraxot, in particolare per quanto riguarda l'integrazione tra Filament 5.x (con nested resources e chart widgets), multi-tenancy e Laravel Modules.

## 1. Regole Fondamentali di Architettura

### 1.1 Pattern XotBase
- **OBBLIGATORIO**: Tutte le risorse Filament devono estendere `Modules\Xot\Filament\Resources\XotBaseResource`
- **OBBLIGATORIO**: Tutti i widget devono estendere `Modules\Xot\Filament\Widgets\XotBaseWidget`
- **OBBLIGATORIO**: Tutti i modelli devono estendere `Modules\Xot\Models\XotBaseModel`
- **OBBLIGATORIO**: Tutte le pagine devono estendere `Modules\Xot\Filament\Pages\XotBasePage`
- **OBBLIGATORIO**: Tutte le sezioni devono estendere `Modules\Xot\Filament\Schemas\Components\XotBaseSection`

### 1.2 Regole Laravel Modules
- **OBBLIGATORIO**: Ogni modulo deve avere la propria cartella `docs/` con documentazione specifica
- **OBBLIGATORIO**: I namespace devono seguire il pattern `Modules\{ModuleName}\{Category}`
- **OBBLIGATORIO**: I file .md devono essere solo nelle cartelle `docs/` esistenti, mai crearne di nuove
- **OBBLIGATORIO**: Rispettare le convenzioni di denominazione: nomi file .md minuscoli tranne README.md

### 1.3 Regole Multi-tenancy
- **OBBLIGATORIO**: Ogni risorsa che deve essere tenant-specifica deve includere il controllo del tenant
- **OBBLIGATORIO**: Implementare sempre `canAccessTenant()` nel modello utente
- **OBBLIGATORIO**: Applicare global scopes per la separazione dei dati
- **OBBLIGATORIO**: Non usare mai `property_exists()` su modelli Eloquent, usare `hasAttribute()` o `isset()`

## 2. Nested Resources in Filament 5.x

### 2.1 Implementazione Base
- **OBBLIGATORIO**: Usare `php artisan make:filament-resource NomeRisorsa --nested` per creare risorse annidate
- **OBBLIGATORIO**: La risorsa figlia deve avere `protected static ?string $parentResource = ParentResource::class`
- **OBBLIGATORIO**: La risorsa padre deve avere un relation manager o una pagina ManageRelatedRecords
- **OBBLIGATORIO**: Il relation manager deve avere `protected static ?string $relatedResource = ChildResource::class`

### 2.2 Configurazione Avanzata
- **OPZIONALE**: Usare `getParentResourceRegistration()` per personalizzare i nomi delle relazioni
- **OBBLIGATORIO**: Assicurarsi che i nomi delle relazioni siano coerenti tra modello e risorsa
- **OBBLIGATORIO**: Implementare controlli di autorizzazione a ogni livello di annidamento

### 2.3 Best Practices
- **RACCOMANDATO**: Non superare 3-4 livelli di annidamento
- **RACCOMANDATO**: Mantenere URL coerenti con il pattern `{parent}/{parent_id}/{child}`
- **RACCOMANDATO**: Implementare breadcrumb navigation per contesto chiaro

## 3. Multi-tenancy in Filament 5.x

### 3.1 Configurazione del Panel
```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->tenant(Team::class)  // Modello tenant
        ->tenantRegistration(RegisterTeam::class)  // Pagina registrazione
        ->tenantProfile(EditTeamProfile::class);   // Pagina profilo
}
```

### 3.2 Implementazione nel Modello Utente
- **OBBLIGATORIO**: Implementare `FilamentUser` e `HasTenants` interfaces
- **OBBLIGATORIO**: Implementare `getTenants()` e `canAccessTenant()`
- **OBBLIGATORIO**: Assicurarsi che la relazione con i tenant esista

### 3.3 Sicurezza e Best Practices
- **OBBLIGATORIO**: Usare `scopedUnique()` e `scopedExists()` per la validazione
- **OBBLIGATORIO**: Implementare global scopes per la separazione dati
- **OBBLIGATORIO**: Controllare l'accesso ai dati anche nelle relazioni
- **RACCOMANDATO**: Usare middleware specifici per tenant quando necessario

## 4. Chart Widgets in Filament 5.x

### 4.1 Implementazione Base
- **OBBLIGATORIO**: Estendere `Filament\Widgets\ChartWidget`
- **OBBLIGATORIO**: Implementare `getType()` per specificare il tipo di grafico
- **OBBLIGATORIO**: Implementare `getData()` per fornire i dati

### 4.2 Implementazione Multi-tenant
- **OBBLIGATORIO**: Filtrare sempre i dati per il tenant corrente
- **OBBLIGATORIO**: Implementare controlli di accesso ai dati
- **RACCOMANDATO**: Usare caching specifico per tenant

### 4.3 JpGraph Integration
- **OPZIONALE**: Usare JpGraph per grafici server-side, specialmente per PDF
- **OBBLIGATORIO**: Assicurarsi che i percorsi file siano specifici per tenant
- **RACCOMANDATO**: Implementare sistemi di pulizia automatica dei file

## 5. Integrazione con Laravel Modules

### 5.1 Struttura del Modulo
```
Modules/
└── ModuleName/
    ├── app/
    │   ├── Filament/
    │   │   ├── Resources/
    │   │   ├── Pages/
    │   │   ├── Widgets/
    │   │   └── Components/
    │   ├── Models/
    │   ├── Services/
    │   └── Http/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── tests/
    └── docs/
```

### 5.2 Best Practices per Moduli
- **OBBLIGATORIO**: Seguire sempre il pattern XotBase per estendere funzionalità
- **RACCOMANDATO**: Implementare documentazione specifica in `docs/`
- **RACCOMANDATO**: Usare service providers specifici del modulo
- **RACCOMANDATO**: Implementare test specifici per ogni modulo

## 6. Regole Specifiche per il Progetto Quaeris

### 6.1 Gestione Survey Multi-tenant
- **OBBLIGATORIO**: Ogni survey deve essere associata a un tenant
- **OBBLIGATORIO**: Le risposte alle survey devono essere filtrate per tenant
- **RACCOMANDATO**: Implementare caching per grafici complessi di survey

### 6.2 Integrazione Limesurvey
- **RACCOMANDATO**: Usare JpGraph per generare grafici server-side
- **RACCOMANDATO**: Implementare sistemi di conversione dati da Limesurvey
- **RACCOMANDATO**: Assicurare la sicurezza dei dati durante l'integrazione

## 7. Sicurezza e Validazione

### 7.1 Best Practices di Sicurezza
- **OBBLIGATORIO**: Implementare sempre controlli di autorizzazione
- **OBBLIGATORIO**: Validare tutti gli input utente
- **OBBLIGATORIO**: Usare prepared statements per query SQL
- **OBBLIGATORIO**: Implementare CSRF protection per form

### 7.2 Validazione dei Dati
- **OBBLIGATORIO**: Usare `scopedUnique()` e `scopedExists()` per validazione multi-tenant
- **OBBLIGATORIO**: Implementare validazione sui modelli e nei form
- **RACCOMANDATO**: Usare classi di form request per logica complessa

## 8. Performance e Ottimizzazione

### 8.1 Best Practices
- **RACCOMANDATO**: Implementare caching appropriato per dati e grafici
- **RACCOMANDATO**: Usare eager loading per relazioni complesse
- **RACCOMANDATO**: Ottimizzare le query con indici appropriati
- **RACCOMANDATO**: Usare paginazione per grandi dataset

### 8.2 Monitoraggio
- **RACCOMANDATO**: Implementare logging per attività critiche
- **RACCOMANDATO**: Monitorare l'uso delle risorse (memoria, CPU)
- **RACCOMANDATO**: Implementare sistemi di alert per problemi di performance

## 9. Testing e Qualità del Codice

### 9.1 Standard di Qualità
- **OBBLIGATORIO**: Tutti i moduli devono raggiungere PHPStan Level 10
- **OBBLIGATORIO**: Implementare test Pest per tutte le funzionalità
- **RACCOMANDATO**: Mantenere copertura test > 80%
- **RACCOMANDATO**: Usare strumenti di analisi codice (PHPMD, PHPInsights)

### 9.2 Best Practices di Testing
- **RACCOMANDATO**: Testare la separazione dati tra tenant
- **RACCOMANDATO**: Testare le funzionalità di annidamento
- **RACCOMANDATO**: Testare le integrazioni tra moduli
- **RACCOMANDATO**: Implementare test di integrazione specifici per multi-tenancy

## 10. Conformità con Principi DRY, KISS, SOLID

### 10.1 Principi Fondamentali
- **DRY**: Non duplicare mai logica, usare Actions e Service per logica condivisa
- **KISS**: Mantenere il codice semplice e leggibile
- **SOLID**: Seguire i principi SOLID per architettura mantenibile
- **Robust**: Gestire correttamente errori e casi limite

### 10.2 Pattern Consigliati
- **Actions Pattern**: Usare Spatie Queueable Actions per logica di business
- **Service Pattern**: Usare Services per logica complessa ma non adatta ad Actions
- **Repository Pattern**: Usare Repositories per astrazione accesso dati
- **Event/Listener Pattern**: Usare eventi per comunicazione tra componenti

## 11. Memorie Importanti

### 11.1 Regole Filament
- Non usare mai metodi come `label()`, `placeholder()`, `helperText()` direttamente nei componenti
- Usare sempre il sistema di traduzione automatico attraverso LangServiceProvider
- Le traduzioni si trovano in formato `{modulo}::risorsa.fields.{campo}.{tipo}`

### 11.2 Regole Database
- Mai usare RefreshDatabase trait nei test, usare DatabaseTransactions
- Usare sempre database MySQL con suffisso "_test" per testing
- Rispettare la struttura multi-database per tenant isolation

### 11.3 Regole Documentazione
- Aggiornare sempre le cartelle docs quando si implementa nuova funzionalità
- Usare link relativi, mai assoluti
- Mantenere la documentazione aggiornata con il codice
- Seguire le convenzioni di denominazione file

## 12. Environment Configuration

### 12.1 Development vs Testing Environments

È importante comprendere la differenza tra le configurazioni di ambiente:

- **Sviluppo** (`.env.development`): 
  - Usa SQLite per setup immediato e sviluppo rapido
  - Configurazione: `DB_CONNECTION=sqlite`, `DB_DATABASE=$PROJECT_ROOT/database/database.sqlite`
  - Ideale per sviluppo locale senza necessità di setup aggiuntivi

- **Test** (`.env.testing`):
  - Usa MySQL con database suffissi "_test" 
  - Richiesto per garantire corretto isolamento multi-tenant nei test
  - **MAI** usare SQLite per i test, anche per convenienza
  
Questa differenziazione è fondamentale per mantenere l'integrità del sistema multi-tenant durante lo sviluppo e i test.

## 13. Conclusione

Queste regole e memorie rappresentano la conoscenza collettiva accumulata durante lo sviluppo del framework Laraxot e del progetto Quaeris. Seguendo questi principi, tutti gli agenti possono lavorare in modo coerente e produrre codice di alta qualità che rispetta gli standard architetturali stabiliti.

Ogni agente deve conoscere queste regole e applicarle durante lo sviluppo, assicurando coerenza, sicurezza e qualità in tutto il codice prodotto.