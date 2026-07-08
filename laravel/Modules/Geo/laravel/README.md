# PTVX - Sistema di Gestione Integrato

<p align="center">
<img src="https://via.placeholder.com/400x100/4F46E5/FFFFFF?text=PTVX+SYSTEM" alt="PTVX Logo" width="400">
</p>

<p align="center">
<a href="https://github.com/laraxot/ptvx"><img src="https://img.shields.io/badge/PHP-8.3+-blue.svg" alt="PHP Version"></a>
<a href="https://github.com/laraxot/ptvx"><img src="https://img.shields.io/badge/Laravel-11.x-orange.svg" alt="Laravel Version"></a>
<a href="https://github.com/laraxot/ptvx"><img src="https://img.shields.io/badge/Filament-4.x-purple.svg" alt="Filament Version"></a>
<a href="https://github.com/laraxot/ptvx"><img src="https://img.shields.io/badge/Laraxot-Modular-green.svg" alt="Laraxot Framework"></a>
</p>

## 🏗️ Architettura Modulare Laraxot

PTVX è un sistema di gestione integrato basato su Laravel con architettura modulare Laraxot. Il sistema è composto da **35 moduli indipendenti** che gestiscono diverse aree funzionali dell'organizzazione.

### 📋 Moduli Principali

#### 👥 **Gestione Risorse Umane**
- **[User](Modules/User/docs/README.md)** - Sistema autenticazione e autorizzazione multi-tipo
- **[Performance](Modules/Performance/docs/README.md)** - Sistema valutazione performance individuali e organizzative
- **[PresenzeAssenze](Modules/PresenzeAssenze/docs/README.md)** - Gestione presenze e assenze personale
- **[Questionari](Modules/Questionari/docs/README.md)** - Sistema questionari e sondaggi

#### 🛡️ **Compliance e Privacy**
- **[Gdpr](Modules/Gdpr/docs/README.md)** - Gestione compliance GDPR completa
- **[Activity](Modules/Activity/docs/README.md)** - Tracciamento completo modifiche e audit trail

#### 💼 **Gestione Amministrativa**
- **[IndennitaResponsabilita](Modules/IndennitaResponsabilita/docs/README.md)** - Indennità di responsabilità
- **[IndennitaCondizioniLavoro](Modules/IndennitaCondizioniLavoro/docs/README.md)** - Indennità condizioni di lavoro
- **[Incentivi](Modules/Incentivi/docs/README.md)** - Sistema incentivi e premi
- **[Rating](Modules/Rating/docs/README.md)** - Sistema rating e recensioni

#### 🔗 **Integrazioni Esterne**
- **[Pdnd](Modules/Pdnd/docs/README.md)** - Integrazione Piattaforma Digitale Nazionale Dati
- **[Ptv](Modules/Ptv/docs/README.md)** - Integrazione sistemi PTV
- **[Sigma](Modules/Sigma/docs/README.md)** - Integrazione dati strutturati
- **[Europa](Modules/Europa/docs/README.md)** - Integrazione sistemi europei

#### 🎨 **UI e Framework**
- **[UI](Modules/UI/docs/README.md)** - Componenti UI e interfaccia
- **[Lang](Modules/Lang/docs/README.md)** - Sistema traduzioni multilingua
- **[Xot](Modules/Xot/docs/README.md)** - Framework base e componenti core

## ⚠️ **REGOLE CRITICHE LARAXOT - DA SEGUIRE SEMPRE**

### 🚫 **Estensioni Classi Filament**
**MAI estendere classi Filament direttamente:**
- ❌ `extends Filament\Resources\Pages\CreateRecord`
- ❌ `extends Filament\Resources\Pages\EditRecord`
- ❌ `extends Filament\Resources\Pages\ListRecords`
- ❌ `extends Filament\Resources\Pages\Page`

**✅ SEMPRE estendere le classi XotBase corrispondenti:**
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord`
- ✅ `extends Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
- ✅ `extends Modules\Xot\Filament\Pages\XotBasePage`

### 🚫 **Proprietà Vietate in XotBasePage**
**Chi estende `XotBasePage` NON DEVE avere:**
```php
// ❌ VIETATO
protected static ?string $navigationIcon = 'heroicon-o-home';
protected static ?string $title = 'Titolo';
protected static ?string $navigationLabel = 'Etichetta';
```

### 🚫 **Label e Traduzioni Hardcoded**
**MAI usare metodi hardcoded:**
```php
// ❌ VIETATO
TextInput::make('name')->label('Nome')
TextColumn::make('status')->placeholder('Stato')
Action::make('edit')->tooltip('Modifica')
```

**✅ Traduzioni gestite automaticamente:**
```php
// ✅ CORRETTO
TextInput::make('name')
TextColumn::make('status')
Action::make('edit')
```

### 🚫 **BadgeColumn Deprecato**
**NON usare più BadgeColumn:**
```php
// ❌ DEPRECATO
BadgeColumn::make('status')

// ✅ CORRETTO
TextColumn::make('status')->badge()
```

### 🚫 **Servizi Tradizionali**
**NON usare Services, ma Spatie QueueableAction:**
```php
// ❌ VIETATO
class UserService
{
    public function process(array $data) { /* ... */ }
}

// ✅ CORRETTO
class ProcessUserAction
{
    use QueueableAction;

    public function execute(UserData $data): UserData
    {
        // Logica business
    }
}
```

### 🚫 **getTableColumns() in XotBaseResource**
**Chi estende `XotBaseResource` NON DEVE implementare `getTableColumns()`:**
- ❌ `getTableColumns()` → VIETATO
- ✅ Usare solo `getTableColumns()` se necessario (ereditato da base)

### 📦 **Spatie Translatable**
**Per modelli translatable, utilizzare sempre Spatie Laravel Translatable:**
```php
// ✅ CORRETTO
use Spatie\Translatable\HasTranslations;

class MyModel extends BaseModel
{
    use HasTranslations;

    public $translatable = ['name', 'description'];
}
```

**MAI usare implementazioni custom per la translatable.**

### 📚 **Documentazione Completa**
- **[Spatie Translatable Guide](docs/spatie-translatable.md)** - Guida completa per l'uso di Spatie Laravel Translatable
- **[Plugin Filament](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)** - Plugin per integrazione con Filament
- **[Repository GitHub](https://github.com/spatie/laravel-translatable)** - Repository ufficiale

## 🚀 Caratteristiche Principali

### 🏛️ **Architettura Modulare**
- **35 moduli indipendenti** con dipendenze minime
- **Namespace isolati** per evitare conflitti
- **Auto-discovery** automatico dei componenti
- **Service Provider centralizzati** per configurazione

### 🔒 **Sicurezza Avanzata**
- **Autenticazione multi-tipo** (Doctor, Patient, Admin)
- **Role-Based Access Control** con Spatie Permission
- **GDPR Compliance** completa
- **Audit Trail** per tutte le operazioni
- **Multi-Tenancy** per isolamento studi

### 🎯 **Performance Ottimizzate**
- **Database connections dedicate** per moduli specifici
- **Caching intelligente** per dati frequenti
- **Queue system** per operazioni pesanti
- **PHPStan livello 9+** per qualità codice

### 🌐 **Multilingua Completo**
- **Italiano** (principale)
- **Inglese** (internazionalizzazione)
- **Tedesco** (supporto multilingua)
- **Struttura traduzioni espansa** per tutti i componenti

## 📚 Documentazione

### 🎯 **Documentazione per Modulo**
Ogni modulo ha documentazione completa nella cartella `docs/`:

| Modulo | Descrizione | Documentazione |
|--------|-------------|----------------|
| **User** | Autenticazione e gestione utenti | [📖 Docs](Modules/User/docs/README.md) |
| **Performance** | Sistema valutazione performance | [📖 Docs](Modules/Performance/docs/README.md) |
| **Gdpr** | Compliance GDPR completa | [📖 Docs](Modules/Gdpr/docs/README.md) |
| **Xot** | Framework base e componenti | [📖 Docs](Modules/Xot/docs/README.md) |
| **UI** | Componenti interfaccia | [📖 Docs](Modules/UI/docs/README.md) |

### 🛠️ **Guide Tecniche**
- [Best Practices Filament](Modules/Xot/docs/filament-best-practices.md)
- [Service Provider Architecture](Modules/Xot/docs/service-provider-architecture.md)
- [Translation Guidelines](Modules/Lang/docs/README.md)
- [PHPStan Implementation](bashscripts/docs/phpstan-usage.md)

## 🏃‍♂️ Installazione Rapida

```bash
# 1. Clona il repository
git clone https://github.com/laraxot/ptvx.git
cd ptvx/laravel

# 2. Installa dipendenze
composer install

# 3. Configura ambiente
cp .env.example .env
php artisan key:generate

# 4. Configura database
php artisan migrate

# 5. Installa moduli
php artisan module:enable User Performance Gdpr Activity

# 6. Avvia server
php artisan serve
```

## 🔧 Configurazione

### Database
Il sistema supporta **connessioni multiple** per ottimizzazione performance:
- `mysql` - Database principale
- `performance` - Database valutazioni performance
- `user` - Database dati sensibili (GDPR)

### Ambiente
```env
APP_NAME="PTVX Sistema Integrato"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ptvx
DB_USERNAME=ptvx_user
DB_PASSWORD=secure_password

# Connessioni aggiuntive
PERFORMANCE_DB_CONNECTION=performance
USER_DB_CONNECTION=user
```

## 🧪 Testing

```bash
# Test completi
php artisan test

# Test per modulo specifico
php artisan test --filter=Performance
php artisan test --filter=User

# Analisi qualità codice
./vendor/bin/phpstan analyze --level=9
./vendor/bin/pint
```

## 🤝 Contribuire

### Linee Guida
1. **Segui convenzioni PSR-12** per stile codice
2. **Aggiungi test** per nuove funzionalità
3. **Aggiorna documentazione** in `Modules/*/docs/`
4. **Verifica PHPStan** livello 9+ prima di commit
5. **Usa link relativi** nella documentazione

### Flusso Sviluppo
```bash
# 1. Crea branch feature
git checkout -b feature/amazing-feature

# 2. Implementa funzionalità
# (codice, test, documentazione)

# 3. Verifica qualità
php artisan test
./vendor/bin/phpstan analyze

# 4. Commit e push
git add .
git commit -m "Add amazing feature"
git push origin feature/amazing-feature

# 5. Crea Pull Request
```

## 📊 Metriche Progetto

| Metrica | Valore | Status |
|---------|--------|--------|
| **Moduli Totali** | 35 | ✅ Completo |
| **Documentazione Moduli** | 12/35 | 🔄 In Corso |
| **PHPStan Level** | 9 | ✅ Raggiunto |
| **Test Coverage** | 80%+ | ✅ Eccellente |
| **Traduzioni** | 3 Lingue | ✅ Completo |
| **Filament Resources** | 100+ | ✅ Ricco |

## 🏆 Riconoscimenti

### Framework e Librerie
- **Laravel 11** - Framework web enterprise
- **Filament 4** - Admin panel moderno
- **Livewire 3** - Componenti reattivi
- **Spatie Packages** - Tool di qualità
- **Laraxot** - Framework modulare

### Qualità Codice
- **PHPStan level 10+** - Analisi statica avanzata
- **PSR-12 Compliant** - Standard coding
- **100% Type Hints** - Sicurezza tipi
- **PHPDoc Complete** - Documentazione API

## 📄 Licenza

Questo progetto è distribuito sotto licenza MIT.

## 👨‍💻 Autore

**Marco Sottana** - Sistema Laraxot PTVX
- Framework modulare per sviluppo enterprise
- Architettura scalabile e mantenibile
- Best practices per team development

---

<div align="center">
  <strong>🚀 PTVX - Sistema di Gestione Integrato</strong>
  <br>
  <em>Costruito con Laravel, Filament e ❤️ per l'organizzazione</em>
</div>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
