# Moduli PTVX

Il sistema PTVX è composto da **35 moduli indipendenti** organizzati per area funzionale.

## 📊 Panoramica Moduli

| Categoria | Numero Moduli | Stato |
|-----------|---------------|-------|
| Gestione Risorse Umane | 4 | ✅ Attivi |
| Compliance e Privacy | 2 | ✅ Attivi |
| Gestione Amministrativa | 4 | ✅ Attivi |
| Integrazioni Esterne | 4 | ✅ Attivi |
| UI e Framework | 3 | ✅ Attivi |
| Supporto e Utilità | 18 | ✅ Attivi |

## 🏗️ Modulo Core

### Xot - Framework Base

**Namespace**: `Modules\Xot`
**Descrizione**: Modulo fondamentale che fornisce il framework base per tutti gli altri moduli
**Dipendenze**: Nessuna (è la base di tutto)
**PHPStan Level**: 10

**Componenti Principali**:
- Classi XotBase (Model, Resource, Page, User, ecc.)
- Service Provider base
- Helper comuni
- Sistema traduzioni automatiche
- Componenti Filament standardizzati

**Documentazione**: [Modules/Xot/docs/README.md](../laravel/Modules/Xot/docs/README.md)

---

## 👥 Gestione Risorse Umane

### User - Sistema Autenticazione e Autorizzazione

**Namespace**: `Modules\User`
**Descrizione**: Sistema completo di autenticazione multi-tipo con OAuth, team e tenant
**Database**: `user` (connessione dedicata per GDPR)

**Caratteristiche**:
- **Single Table Inheritance (STI)**: Doctor, Patient, Admin
- **OAuth 2.0** con Laravel Passport
- **Multi-Tenancy**: Isolamento dati per tenant
- **Team Management**: Gestione team e inviti
- **Role-Based Access Control**: Spatie Permission
- **Social Login**: Socialite integration

**Modelli Principali**:
- `BaseUser` - Modello utente base
- `Doctor`, `Patient`, `Admin` - Tipi utente specifici
- `Team` - Team management
- `Tenant` - Multi-tenancy
- `Permission`, `Role` - Authorization

**Documentazione**: [Modules/User/docs/README.md](../laravel/Modules/User/docs/README.md)

### Performance - Valutazione Performance

**Namespace**: `Modules\Performance`
**Descrizione**: Sistema completo per valutazione performance individuali e organizzative
**Database**: `performance` (connessione dedicata)

**Caratteristiche**:
- Valutazioni periodiche (annuali, semestrali)
- Criteri di valutazione personalizzabili
- Report e statistiche
- Dashboard performance
- Export dati (PDF, Excel)

**Documentazione**: [Modules/Performance/docs/README.md](../laravel/Modules/Performance/docs/README.md)

### PresenzeAssenze - Gestione Presenze

**Namespace**: `Modules\PresenzeAssenze`
**Descrizione**: Sistema gestione presenze, assenze, permessi e ferie

**Caratteristiche**:
- Timbratura presenze
- Richiesta permessi/ferie
- Gestione giustificativi
- Calcolo ore lavorate
- Report mensili

**Documentazione**: [Modules/PresenzeAssenze/docs/README.md](../laravel/Modules/PresenzeAssenze/docs/README.md)

### Questionari - Sistema Questionari e Sondaggi

**Namespace**: `Modules\Questionari`
**Descrizione**: Sistema completo per creazione e gestione questionari

**Caratteristiche**:
- Creazione questionari dinamici
- Tipologie domande multiple
- Logica condizionale
- Analisi risultati
- Export dati

**Documentazione**: [Modules/Questionari/docs/README.md](../laravel/Modules/Questionari/docs/README.md)

---

## 🛡️ Compliance e Privacy

### Gdpr - GDPR Compliance

**Namespace**: `Modules\Gdpr`
**Descrizione**: Gestione completa compliance GDPR

**Caratteristiche**:
- Consensi e trattamenti dati
- Right to be forgotten
- Data portability
- Audit trail
- Cookie policy management

**Modelli Principali**:
- `Consent` - Consensi utente
- `Treatment` - Trattamenti dati
- `Profile` - Profili GDPR
- `Event` - Eventi GDPR

**Documentazione**: [Modules/Gdpr/docs/README.md](../laravel/Modules/Gdpr/docs/README.md)

### Activity - Audit Trail

**Namespace**: `Modules\Activity`
**Descrizione**: Tracciamento completo di tutte le modifiche e attività

**Caratteristiche**:
- Logging automatico modifiche
- Event sourcing
- Snapshots dei modelli
- Timeline attività
- Ricerca e filtri avanzati

**Documentazione**: [Modules/Activity/docs/README.md](../laravel/Modules/Activity/docs/README.md)

---

## 💼 Gestione Amministrativa

### IndennitaResponsabilita - Indennità di Responsabilità

**Namespace**: `Modules\IndennitaResponsabilita`
**Descrizione**: Gestione indennità di responsabilità per dirigenti

**Caratteristiche**:
- Calcolo automatico indennità
- Storico assegnazioni
- Report mensili/annuali
- Integrazione contabilità

**Documentazione**: [Modules/IndennitaResponsabilita/docs/README.md](../laravel/Modules/IndennitaResponsabilita/docs/README.md)

### IndennitaCondizioniLavoro - Indennità Condizioni Lavoro

**Namespace**: `Modules\IndennitaCondizioniLavoro`
**Descrizione**: Gestione indennità per condizioni di lavoro particolari

**Caratteristiche**:
- Gestione turni notturni
- Indennità festive
- Straordinari
- Calcoli automatici

**Documentazione**: [Modules/IndennitaCondizioniLavoro/docs/README.md](../laravel/Modules/IndennitaCondizioniLavoro/docs/README.md)

### Incentivi - Sistema Incentivi e Premi

**Namespace**: `Modules\Incentivi`
**Descrizione**: Sistema completo gestione incentivi e premi

**Caratteristiche**:
- Definizione criteri incentivi
- Calcolo automatico premi
- Approvazione workflow
- Report incentivi

**Documentazione**: [Modules/Incentivi/docs/README.md](../laravel/Modules/Incentivi/docs/README.md)

### Rating - Sistema Rating e Recensioni

**Namespace**: `Modules\Rating`
**Descrizione**: Sistema rating e recensioni per servizi/persone

**Caratteristiche**:
- Rating stelle (1-5)
- Recensioni testuali
- Moderazione contenuti
- Statistiche rating

**Documentazione**: [Modules/Rating/docs/README.md](../laravel/Modules/Rating/docs/README.md)

---

## 🔗 Integrazioni Esterne

### Pdnd - Piattaforma Digitale Nazionale Dati

**Namespace**: `Modules\Pdnd`
**Descrizione**: Integrazione con Piattaforma Digitale Nazionale Dati

**Caratteristiche**:
- Interoperabilità PA
- Scambio dati sicuro
- API Gateway
- Autenticazione SPID/CIE

**Documentazione**: [Modules/Pdnd/docs/README.md](../laravel/Modules/Pdnd/docs/README.md)

### Ptv - Integrazione Sistemi PTV

**Namespace**: `Modules\Ptv`
**Descrizione**: Integrazione con sistemi PTV esterni

**Documentazione**: [Modules/Ptv/docs/README.md](../laravel/Modules/Ptv/docs/README.md)

### Sigma - Integrazione Dati Strutturati

**Namespace**: `Modules\Sigma`
**Descrizione**: Integrazione e gestione dati strutturati

**Documentazione**: [Modules/Sigma/docs/README.md](../laravel/Modules/Sigma/docs/README.md)

### Europa - Integrazione Sistemi Europei

**Namespace**: `Modules\Europa`
**Descrizione**: Integrazione con sistemi e database europei

**Documentazione**: [Modules/Europa/docs/README.md](../laravel/Modules/Europa/docs/README.md)

---

## 🎨 UI e Framework

### UI - Componenti UI

**Namespace**: `Modules\UI`
**Descrizione**: Libreria completa componenti UI riutilizzabili

**Caratteristiche**:
- Componenti Filament custom
- Widgets dashboard
- Form components
- Table columns
- Actions personalizzate

**Documentazione**: [Modules/UI/docs/README.md](../laravel/Modules/UI/docs/README.md)

### Lang - Sistema Traduzioni

**Namespace**: `Modules\Lang`
**Descrizione**: Sistema completo gestione traduzioni multilingua

**Lingue Supportate**:
- 🇮🇹 Italiano (principale)
- 🇬🇧 Inglese
- 🇩🇪 Tedesco

**Caratteristiche**:
- Traduzioni automatiche chiavi
- Gestione file lingua
- Editor traduzioni in Filament
- Fallback multilingua

**Documentazione**: [Modules/Lang/docs/README.md](../laravel/Modules/Lang/docs/README.md)

---

## 🛠️ Moduli Supporto

### Altri Moduli Disponibili

| Modulo | Descrizione | Status |
|--------|-------------|--------|
| **Blog** | Sistema blog e articoli | ✅ Attivo |
| **Cms** | Content Management System | ✅ Attivo |
| **Cart** | Carrello e-commerce | ✅ Attivo |
| **Crypto** | Gestione criptovalute | ✅ Attivo |
| **DbForge** | Database schema management | ✅ Attivo |
| **Feed** | RSS/Atom feed generator | ✅ Attivo |
| **Food** | Gestione menu e ricette | ✅ Attivo |
| **FormX** | Form builder avanzato | ✅ Attivo |
| **Geo** | Gestione dati geografici | ✅ Attivo |
| **Import** | Import dati (CSV, Excel) | ✅ Attivo |
| **Job** | Job queue management | ✅ Attivo |
| **LU** | Location utilities | ✅ Attivo |
| **Media** | Media library manager | ✅ Attivo |
| **Notify** | Sistema notifiche | ✅ Attivo |
| **healthcare_app** | Sistema query builder | ✅ Attivo |
| **Seo** | SEO optimization | ✅ Attivo |
| **Shop** | E-commerce platform | ✅ Attivo |
| **Tenant** | Multi-tenancy core | ✅ Attivo |

---

## 📦 Dipendenze Moduli

### Grafico Dipendenze

```
Xot (Core) ← Tutti i moduli dipendono da Xot
├── User
│   ├── Gdpr (usa User per profili)
│   ├── Activity (traccia User actions)
│   ├── Performance (valuta Users)
│   └── Tenant (multi-tenancy User)
├── UI (componenti usati ovunque)
├── Lang (traduzioni usate ovunque)
├── Media (gestione file)
├── Notify (notifiche sistema)
└── Job (queue processing)
```

### Moduli Indipendenti

Alcuni moduli sono completamente indipendenti (oltre alla dipendenza da Xot):
- Blog
- Cms
- Crypto
- Feed
- Food
- Shop

### Moduli Fortemente Integrati

Moduli che lavorano strettamente insieme:
- **User + Gdpr + Activity**: Autenticazione, privacy, audit
- **Performance + User**: Valutazioni personale
- **IndennitaResponsabilita + IndennitaCondizioniLavoro + Incentivi**: Sistema compensi
- **Pdnd + Sigma + Europa**: Integrazioni esterne

---

## 🚀 Abilitazione Moduli

### Comando Artisan

```bash
# Abilita modulo singolo
php artisan module:enable User

# Abilita moduli multipli
php artisan module:enable User Performance Gdpr Activity

# Abilita tutti i moduli
php artisan module:enable-all

# Disabilita modulo
php artisan module:disable ModuleName

# Lista moduli
php artisan module:list
```

### Configurazione composer.json

```json
{
    "require": {
        "laraxot/module-xot": "^1.0",
        "laraxot/module-user": "^1.0",
        "laraxot/module-performance": "^1.0"
    }
}
```

---

## 📚 Documentazione Moduli

Ogni modulo ha documentazione completa nella propria cartella `docs/`:

```
laravel/Modules/{ModuleName}/docs/
├── README.md              # Panoramica modulo
├── architecture.md        # Architettura specifica
├── api.md                # API endpoints
├── models.md             # Documentazione models
├── actions.md            # Documentazione actions
├── filament.md           # Risorse Filament
└── examples.md           # Esempi utilizzo
```

---

## 🔍 Trovare Codice

### Namespace Pattern

```php
// Pattern namespace modulo
Modules\{ModuleName}\{Type}\{ClassName}

// Esempi
Modules\User\Models\BaseUser
Modules\Performance\Actions\CreateEvaluationAction
Modules\Gdpr\Filament\Resources\ConsentResource
```

### Autoloading

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\": "Modules/"
        }
    }
}
```

---

## 📊 Metriche Qualità

| Metrica | Target | Status |
|---------|--------|--------|
| PHPStan Level | 10 | ✅ Raggiunto |
| Test Coverage | 80%+ | ✅ Raggiunto |
| Documentazione | 100% | 🔄 In Progresso |
| Traduzioni | 3 Lingue | ✅ Completo |

---

## 🎯 Roadmap Moduli

### In Sviluppo

- [ ] Completamento documentazione moduli secondari
- [ ] Miglioramento test coverage moduli minori
- [ ] Standardizzazione API responses

### Pianificati

- [ ] Modulo Reporting avanzato
- [ ] Modulo Analytics
- [ ] Modulo Workflow automation

---

## 📖 Risorse Aggiuntive

- [Architettura](architecture.md)
- [Regole Laraxot](laraxot-rules.md)
- [Setup](setup.md)
- [Sviluppo](development.md)
- [Qualità Codice](code-quality.md)
