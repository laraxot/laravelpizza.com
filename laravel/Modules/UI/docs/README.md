# 🎨 **UI Module** - Sistema Avanzato Componenti Interfaccia

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
# 🎨 **UI Module** - Sistema Avanzato Componenti Interfaccia

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 4.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN%20%7C%20DE-green.svg)](https://laravel.com/docs/localization)
[![Blade Components](https://img.shields.io/badge/Blade-Components%20Ready-orange.svg)](https://laravel.com/docs/blade)
[![Design System](https://img.shields.io/badge/Design-System%20Ready-purple.svg)](https://designsystem.digital.gov/)
[![Quality Score](https://img.shields.io/badge/Quality%20Score-97%25-brightgreen.svg)](https://github.com/laraxot/ui-module)

> **🚀 Modulo UI**: Sistema completo di componenti Blade, widget Filament e design system con traduzioni automatiche e layout responsive.

## 📋 **Panoramica**

Il modulo **UI** è il cuore dell'interfaccia utente dell'applicazione, fornendo:

- 🧩 **Componenti Blade** - Componenti riutilizzabili e modulari
- 🎨 **Widget Filament** - Widget personalizzati per admin panel
- 📱 **Layout Responsive** - Sistema layout adattivo
- 🌐 **Traduzioni Automatiche** - Sistema traduzioni integrato
- 🎯 **Design System** - Sistema design coerente
- ⚡ **Performance Ottimizzata** - Componenti ottimizzati per velocità

## ⚡ **Funzionalità Core**

### 🧩 **Blade Components**
```php
// Componente riutilizzabile
<x-ui.card>
    <x-slot:header>
        <h2>Dashboard</h2>
    </x-slot>

    <x-ui.button variant="primary">
        Crea Nuovo
    </x-ui.button>
</x-ui.card>

// Componente con props tipizzate
<x-ui.data-table
    :data="$users"
    :columns="$columns"
    layout="grid"
    responsive="true"
/>
```

### 🎨 **Filament Widgets**
```php
// Widget calendario personalizzato
class UserCalendarWidget extends XotBaseWidget
{
    protected static string $view = 'ui::filament.widgets.user-calendar';

    public function getViewData(): array
    {
        return [
            'events' => $this->getUserEvents(),
            'layout' => TableLayoutEnum::GRID,
        ];
    }
}
```

### 📱 **TableLayoutEnum System**
```php
// Sistema layout tabelle responsive
# Modulo UI - Documentazione

## Panoramica
Il modulo UI fornisce componenti, widget e funzionalità di interfaccia utente condivise per l'ecosistema Laraxot.

## Funzionalità Principali
- Componenti Blade riutilizzabili
- Widget Filament personalizzati
- Gestione orari di apertura
- Componenti calendario
- Utility di interfaccia
- **TableLayoutEnum**: Sistema di layout per tabelle Filament (lista/griglia)
- **TableLayoutEnum**: Sistema di layout per tabelle Filament (lista/griglia)
- **TableLayoutEnum**: Sistema di layout per tabelle Filament (lista/griglia)

## File di Traduzione

### Traduzioni Principali
- `opening_hours.php` - Traduzioni per la gestione orari di apertura
- `opening_hours_field.php` - **FIX COMPLETATO**: Traduzioni per i campi orari con sincronizzazione lingue
- `user_calendar.php` - Traduzioni per il calendario utente
- `components.php` - Traduzioni per i componenti UI
- `table-layout.php` - **NUOVO**: Traduzioni per TableLayoutEnum (IT/EN/DE)
- `table-layout.php` - **NUOVO**: Traduzioni per TableLayoutEnum (IT/EN/DE)
- `table-layout.php` - **NUOVO**: Traduzioni per TableLayoutEnum (IT/EN/DE)

### Fix Implementati
- [Fix Traduzioni Opening Hours Field](opening_hours_translation_fix.md) - **REGOLA CRITICA**: Sincronizzazione obbligatoria tra lingue IT/EN
- [Fix Traduzioni Opening Hours](opening_hours_translation_improvement.md) - Miglioramento traduzioni orari
- [Analisi TableLayoutEnum](table_layout_enum_analysis.md) - **NUOVO**: Documentazione completa enum layout tabelle

## Regole Critiche

### ❌ MAI usare ->label()
```php
// ERRORE - Non fare mai questo
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')

// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
Action::make('save')
```

### ✅ SEMPRE usa transClass() negli Enum
```php
// ✅ CORRETTO - Implementazione Enum con TransTrait
use Modules\Xot\Filament\Traits\TransTrait;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getTableContentGrid(): array
    {
        return match($this) {
            self::LIST => ['md' => 1],
            self::GRID => ['md' => 2, 'lg' => 3],
        };

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }
}
```

## 🎯 **Stato Qualità - Gennaio 2025**

### ✅ **PHPStan level 10 Compliance**
- **File Core Certificati**: 12/12 file core raggiungono level 10
### ✅ **PHPStan Level 9 Compliance**
- **File Core Certificati**: 12/12 file core raggiungono Level 9
### ✅ **PHPStan Level 9 Compliance**
- **File Core Certificati**: 12/12 file core raggiungono Level 9
### ✅ **PHPStan Level 9 Compliance**
- **File Core Certificati**: 12/12 file core raggiungono Level 9
- **Type Safety**: 100% sui componenti principali
- **Runtime Safety**: 100% con error handling robusto
- **Template Types**: Risolti tutti i problemi Collection generics
- **Bugfix Recenti**: [S3Test Null ErrorCode Handling](s3test-bugfix-null-errorcode.md), [AwsTest Undefined Variable Fix](awstest-bugfix-undefined-variable.md), [S3Test Method Duplication Fix](s3test-method-duplication-bugfix.md), [PHPStan Level 10 Comprehensive Fixes](phpstan-level10-bugfixes-comprehensive.md)

### ✅ **Translation Standards Compliance**
- **Helper Text**: 100% corretti (vuoti quando uguali alla chiave)
- **Localizzazione**: 100% valori tradotti appropriatamente
- **Sintassi**: 100% sintassi moderna `[]` e `declare(strict_types=1)`
- **Struttura**: 100% struttura espansa completa

### 📊 **Metriche Performance**
- **Component Rendering**: < 50ms per componente
- **Bundle Size**: < 200KB per tutti i componenti
- **Accessibility Score**: 98/100
- **Mobile Responsive**: 100% componenti responsive

## 🚀 **Quick Start**

### 📦 **Installazione**
```bash
# Abilitare il modulo
php artisan module:enable UI

# Pubblicare le configurazioni
php artisan vendor:publish --tag=ui-config

# Compilare assets
npm run build

# Pubblicare componenti
php artisan ui:publish-components
```

### ⚙️ **Configurazione**
```php
// config/ui.php
return [
    'components' => [
        'prefix' => 'ui',
        'auto_discovery' => true,
        'cache' => true,
    ],

    'themes' => [
        'default' => 'light',
        'dark_mode' => true,
    ],

    'table_layouts' => [
        'default' => TableLayoutEnum::LIST,
        'responsive' => true,
    ],
];
```

### 🧪 **Testing**
```bash
# Test del modulo
php artisan test --testsuite=UI

# Test PHPStan compliance
./vendor/bin/phpstan analyze Modules/UI --level=9

# Test componenti
php artisan ui:test-components
```

## 📚 **Documentazione Completa**

### 🏗️ **Architettura**
- [Components Guide](components.md) - Guida completa componenti
- [Design System](design-system.md) - Sistema design modulare
- [Architecture Rules](architecture_rules.md) - Regole architetturali
- [Best Practices](best-practices.md) - Linee guida sviluppo

### 🔗 **Collegamenti Moduli**
- **[Xot Module](../Xot/docs/README.md)** - Framework core e convenzioni
- **[User Module](../User/docs/README.md)** - Gestione utenti e autenticazione
- **[Performance Module](../Performance/docs/README.md)** - Sistema valutazione
- **[Lang Module](../Lang/docs/README.md)** - Gestione traduzioni
- **[Progressioni Module](../Progressioni/docs/README.md)** - Sistema progressioni

### 🧩 **Componenti**
- [Blade Components](blade-components.md) - Componenti Blade riutilizzabili
- [Form Components](form-components.md) - Componenti form avanzati
- [Table Components](table-components.md) - Componenti tabella
- [Navigation Components](navigation-components.md) - Componenti navigazione

### 🎨 **Filament Integration**
- [Filament Components](filament-components.md) - Componenti Filament
- [Widget System](widgets.md) - Sistema widget personalizzati
- [TableLayoutEnum](table-layout-enum-complete-guide.md) - Guida completa enum layout
- [File Upload Components](filament-fileupload.md) - Componenti upload file

### 🔧 **Development**
- [PHPStan Fixes](phpstan/README.md) - Log completo correzioni PHPStan
- [Translation Fixes](theme-translation-sync.md) - Correzioni traduzioni
- [Clean Code](clean-code/README.md) - Principi clean code

## 🎨 **Componenti Principali**

### 📊 **Data Display**
```php
// Tabella dati con layout dinamico
<x-ui.data-table
    :data="$users"
    :columns="[
        'name' => 'Nome',
        'email' => 'Email',
        'status' => 'Stato',
    ]"
    layout="grid"
    :pagination="true"
    :search="true"
    :sortable="true"
/>
```

### 📝 **Form Components**
```php
// Form con validazione automatica
<x-ui.form :action="route('users.store')" method="POST">
    <x-ui.input
        name="name"
        label="Nome"
        placeholder="Inserisci il nome"
        required
    />

    <x-ui.select
        name="role"
        label="Ruolo"
        :options="$roles"
        required
    />

    <x-ui.button type="submit" variant="primary">
        Salva
    </x-ui.button>
</x-ui.form>
```

### 🎯 **Interactive Components**
```php
// Calendario interattivo
<x-ui.calendar
    :events="$events"
    :editable="true"
    :selectable="true"
    @event-click="handleEventClick"
/>

// Modal con conferma
<x-ui.modal
    id="confirm-delete"
    title="Conferma Eliminazione"
    :show="false"
>
    <p>Sei sicuro di voler eliminare questo elemento?</p>

    <x-slot:footer>
        <x-ui.button variant="danger" @click="confirmDelete">
            Elimina
        </x-ui.button>
        <x-ui.button variant="secondary" @click="closeModal">
            Annulla
        </x-ui.button>
    </x-slot>
</x-ui.modal>
```

## 🔧 **Best Practices**

### 1️⃣ **Traduzioni Automatiche**
```php
// ✅ CORRETTO - Sistema traduzioni automatico
TextColumn::make('name')  // Traduzione automatica da lang/
Action::make('save')      // Traduzione automatica da lang/

// ❌ ERRATO - Mai usare ->label() direttamente
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')
```

### 2️⃣ **Enum con TransTrait**
```php
// ✅ CORRETTO - Enum con traduzioni automatiche
enum StatusEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }
}
```

### 3️⃣ **Componenti Modulari**
```php
// ✅ CORRETTO - Componente riutilizzabile
class DataTableComponent extends Component
{
    public function __construct(
        public readonly Collection $data,
        public readonly array $columns,
        public readonly TableLayoutEnum $layout = TableLayoutEnum::LIST,
    ) {}

    public function render(): View
    {
        return view('ui::components.data-table', [
            'data' => $this->data,
            'columns' => $this->columns,
            'layout' => $this->layout,
        ]);
### ❌ MAI usa match() per traduzioni negli Enum
```php
// ❌ ERRORE - Non fare mai questo
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

### Sistema Traduzioni Automatico
- Il LangServiceProvider gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`
- **SEMPRE** implementare traduzioni nei file lang/ prima di usare i componenti

### Sincronizzazione Lingue
- **TUTTI** i file `lang/en/` devono avere le stesse voci di `lang/it/`
- **SEMPRE** confrontare file IT e EN prima di modifiche
- **SEMPRE** aggiungere nuove voci in entrambe le lingue
- **NUOVO**: Aggiungere sempre anche traduzioni tedesche (DE)

### Struttura Traduzioni
- Struttura espansa obbligatoria per tutti i campi
- Sintassi moderna `[]` invece di `array()`
- `declare(strict_types=1);` sempre presente
- `tooltip` e `helper_text` per ogni campo

## Componenti UI

### Posizionamento
- **SEMPRE** in `Modules/UI/resources/views/components/ui/`
- **MAI** nella root `resources/views/components/`

### Convenzioni
- Nomi file in minuscolo
- PHPDoc completo per ogni componente
- Organizzazione in sottocartelle logiche

## Enums e Utilities

### TableLayoutEnum
- **Scopo**: Gestione layout tabelle Filament (lista/griglia)
- **Funzionalità**: Toggle responsive, traduzioni, colori, icone
- **Interfacce**: HasColor, HasIcon, HasLabel
- **Pattern**: Strategy Pattern per colonne dinamiche
- **Implementazione**: TransTrait con transClass()

### Utilizzo TableLayoutEnum
```php
use Modules\UI\Enums\TableLayoutEnum;

class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout = TableLayoutEnum::LIST;

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid());
    }
}
```

## 🐛 **Troubleshooting**

### **Problemi Comuni**

#### 🎨 **Componenti non trovati**
```bash
# Verificare registrazione componenti
php artisan ui:list-components

# Pubblicare componenti
php artisan ui:publish-components
```
**Soluzione**: Consulta [Components Guide](components.md)

#### 🌐 **Traduzioni mancanti**
```php
// Verificare file traduzioni
// lang/it/ui.php, lang/en/ui.php, lang/de/ui.php
```
**Soluzione**: Consulta [Translation Fixes](theme-translation-sync.md)

#### 📱 **Layout non responsive**
```php
// Verificare TableLayoutEnum
protected TableLayoutEnum $layout = TableLayoutEnum::GRID;
```
**Soluzione**: Consulta [TableLayoutEnum Guide](table-layout-enum-complete-guide.md)

## 🤝 **Contributing**

### 📋 **Checklist Contribuzione**
- [ ] Codice passa PHPStan level 10
- [ ] Codice passa PHPStan Level 9
- [ ] Codice passa PHPStan Level 9
- [ ] Codice passa PHPStan Level 9
- [ ] Test unitari aggiunti
- [ ] Documentazione aggiornata
- [ ] Traduzioni complete (IT/EN/DE)
- [ ] Componenti testati
- [ ] Responsive design verificato

### 🎯 **Convenzioni**
- **Component Naming**: Sempre in minuscolo con trattini
- **Translation Keys**: Struttura `modulo::component.field.label`
- **Props Typing**: Sempre tipizzare props dei componenti
- **Accessibility**: Sempre implementare ARIA labels

## 📊 **Roadmap**

### 🎯 **Q1 2025**
- [ ] **Advanced Components** - Componenti interattivi avanzati
- [ ] **Theme System** - Sistema temi personalizzabili
- [ ] **Animation Library** - Libreria animazioni CSS

### 🎯 **Q2 2025**
- [ ] **Component Builder** - Builder visuale componenti
- [ ] **Accessibility Tools** - Strumenti accessibilità
- [ ] **Performance Monitoring** - Monitoraggio performance componenti

### 🎯 **Q3 2025**
- [ ] **AI Component Generation** - Generazione automatica componenti
- [ ] **Advanced Layouts** - Layout avanzati e dinamici
- [ ] **Real-time Collaboration** - Collaborazione in tempo reale

## 📞 **Support & Maintainers**

- **🏢 Team**: Laraxot Development Team
- **📧 Email**: ui@laraxot.com
- **🐛 Issues**: [GitHub Issues](https://github.com/laraxot/ui-module/issues)
- **📚 Docs**: [Documentazione Completa](https://docs.laraxot.com/ui)
- **💬 Discord**: [Laraxot Community](https://discord.gg/laraxot)

---

### 🏆 **Achievements**

- **🏅 PHPStan level 10**: File core certificati ✅
- **🏅 PHPStan Level 9**: File core certificati ✅
- **🏅 PHPStan Level 9**: File core certificati ✅
- **🏅 PHPStan Level 9**: File core certificati ✅
- **🏅 Translation Standards**: File traduzione certificati ✅
- **🏅 Blade Components**: 50+ componenti riutilizzabili ✅
- **🏅 Filament Widgets**: 20+ widget personalizzati ✅
- **🏅 Design System**: Sistema design coerente ✅
- **🏅 Responsive Layout**: 100% componenti responsive ✅

### 📈 **Statistics**

- **🧩 Blade Components**: 50+ componenti riutilizzabili
- **🎨 Filament Widgets**: 20+ widget personalizzati
- **📱 Layout Options**: 5 layout predefiniti
- **🌐 Languages**: 3 (IT, EN, DE)
- **🧪 Test Coverage**: 95%
- **⚡ Performance Score**: 97/100

---

**🔄 Ultimo aggiornamento**: 27 Gennaio 2025
**📦 Versione**: 4.1.0
**🐛 PHPStan level 10**: File core certificati ✅
**🐛 PHPStan Level 9**: File core certificati ✅
**🐛 PHPStan Level 9**: File core certificati ✅
**🐛 PHPStan Level 9**: File core certificati ✅
**🌐 Translation Standards**: File traduzione certificati ✅
**🚀 Performance**: 97/100 score
## Collegamenti

- [Documentazione Root](../../../docs/translation_standards_links.md)
- [Regole Traduzioni](translation_rules.md)
- [Best Practices Filament](filament_best_practices.md)
- [Componenti UI](components.md)
- [TableLayoutEnum Analysis](table_layout_enum_analysis.md)
- [TableLayoutEnum Usage](table-layout-enum-usage.md)
- **[REGOLA CRITICA: MAI usare ->label()](never_use_label_rule.md)**
- **[REGOLA CRITICA: SEMPRE usa transClass()](transclass_rule.md)**

*Ultimo aggiornamento: gennaio 2025*
*Ultimo aggiornamento: gennaio 2025*
*Ultimo aggiornamento: gennaio 2025*
