# Routing nel Progetto il progetto

## Indice
1. [Architettura del Routing](#architettura-del-routing)
2. [Struttura delle Directory](#struttura-delle-directory)
3. [Convenzioni di Routing](#convenzioni-di-routing)
4. [Localizzazione degli URL](#localizzazione-degli-url)
5. [Integrazione con Filament](#integrazione-con-filament)
6. [Best Practices](#best-practices)
7. [Esempi](#esempi)
8. [Troubleshooting](#troubleshooting)
9. [Collegamenti Bidirezionali](#collegamenti-bidirezionali)

## Architettura del Routing

### Frontend (Folio + Volt + Filament)
- **NON** utilizzare mai `/routes/web.php` per il frontend
- Folio gestisce automaticamente il routing basato sui file nella directory `Themes/{ThemeName}/resources/views/pages`
- Ogni file `.blade.php` diventa automaticamente una rotta
- Volt gestisce lo stato e la logica dei componenti
- Filament Widgets gestiscono i form complessi

### Perché NON usare web.php per il Frontend
1. **Architettura File-Based Routing**
   - Folio implementa il file-based routing
   - Le rotte sono determinate dalla struttura delle cartelle in `resources/views/pages`
   - Più organizzato e manutenibile
   - Segue il pattern moderno di Next.js e altri framework moderni

2. **Separazione delle Responsabilità**
   - Frontend: Folio + Volt + Filament Widgets
   - Backend: API + Filament Resources
   - Mantiene il codice organizzato e modulare

3. **Vantaggi di Folio**
   - Routing automatico
   - Nessuna configurazione manuale delle rotte
   - Meno codice da mantenere
   - Più facile da debuggare

4. **Integrazione con Volt e Filament**
   - Volt gestisce lo stato e la logica dei componenti
   - Filament Widgets gestiscono i form complessi
   - Perfetta integrazione con il routing di Folio
   - Non necessita di configurazioni di routing aggiuntive

## Struttura delle Directory

```
Themes/{ThemeName}/
└── resources/
    └── views/
        ├── pages/                # Folio - routing automatico
        │   ├── index.blade.php   # Homepage -> /
        │   ├── about.blade.php   # Chi siamo -> /about
        │   └── auth/
        │       ├── login.blade.php     # -> /auth/login
        │       └── register.blade.php  # -> /auth/register
        ├── components/           # Componenti riutilizzabili
        │   ├── forms/
        │   └── cards/
        └── filament/             # Widget Filament per form complessi
            └── widgets/
```

## Convenzioni di Routing

### Regole Principali

1. **Routing Folio**:
   - Tutte le pagine in `Themes/{ThemeName}/resources/views/pages/`
   - Nomi file e cartelle in lowercase
   - Routing automatico basato sulla struttura cartelle
   - No route manuali in `routes/web.php`

2. **Componenti Volt**:
   - Tutti i componenti in `resources/views/components/`
   - Nomi file e cartelle in lowercase
   - Namespace basato sulla struttura cartelle

3. **Widget Filament**:
   - Tutti i widget in `Modules/{Module}/app/Filament/Widgets/`
   - Utilizzati per form complessi
   - Integrati nelle pagine Folio tramite `@livewire`

4. **API Routes**:
   - Tutte le route API in `routes/api.php`
   - Prefisso automatico basato sul nome modulo
   - Versionamento API opzionale

### Nomenclatura dei File

Folio segue convenzioni specifiche per la nomenclatura dei file:

1. **File statici**: `nome-pagina.blade.php` → `/nome-pagina`
2. **Parametri dinamici**: `[parametro].blade.php` → `/{valore-parametro}`
3. **Parametri opzionali**: `[[parametro]].blade.php` → `/` o `/{valore-parametro}`
4. **Index files**: `index.blade.php` → `/` (nella directory corrente)

## Localizzazione degli URL

### Regola Fondamentale

Tutti gli URL in il progetto devono includere il prefisso della lingua come primo segmento del percorso:

```
/{locale}/{sezione}/{risorsa}
```

### Implementazione

#### 1. Recuperare la Locale Corrente

Usare sempre la funzione `app()->getLocale()` per ottenere la lingua corrente:

```php
$locale = app()->getLocale();
```

Non utilizzare valori hardcoded come 'it' o 'en'.

#### 2. Generare Link Localizzati

Quando si generano link, includere sempre la locale:

```php
// CORRETTO
<a href="{{ url('/' . app()->getLocale() . '/pages/' . $page->slug) }}">{{ $page->title }}</a>

// ERRATO
<a href="{{ url('/pages/' . $page->slug) }}">{{ $page->title }}</a>
```

#### 3. Nelle Pagine Folio

Nelle pagine Folio, recuperare e passare sempre la locale alla vista:

```php
render(function (View $view) {
    $locale = app()->getLocale();
    // altre operazioni...
    return $view->with([
        'data' => $data,
        'locale' => $locale,
    ]);
});
```

## Integrazione con Filament

### Pattern per Form Complessi

Per i form complessi in il progetto (come registrazione, wizard multi-step, ecc.), utilizzare **sempre** i widget Filament tramite Livewire, invece di implementare la logica direttamente nelle viste Blade con Volt.

```php
// In una vista Blade (es. register.blade.php)
@livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class, ['type' => 'patient'])
```

#### Vantaggi dell'approccio Livewire + Widget Filament
- **Separazione delle responsabilità**: logica del form nei widget, presentazione nelle viste
- **Riutilizzo del codice**: widget utilizzabili in più punti dell'applicazione
- **Manutenibilità superiore**: modifiche alla logica in un unico punto
- **Funzionalità avanzate**: validazione, gestione errori, componenti interattivi
- **Coerenza architettonica**: segue il pattern utilizzato in tutta l'applicazione

#### Quando usare Volt vs Widget Filament
- **Widget Filament**: per form complessi, wizard multi-step, validazione avanzata
- **Volt**: per componenti più semplici, logica specifica della pagina, interazioni UI

## Best Practices

### Organizzazione
1. **Struttura Coerente**
   - Usa la struttura delle cartelle per organizzare le rotte
   - Mantieni una gerarchia logica
   - Segui le convenzioni di naming

2. **Componenti Riutilizzabili**
   - Crea componenti Volt per la logica di business
   - Usa i componenti all'interno delle pagine Folio
   - Mantieni la logica separata dalla presentazione

3. **Form Complessi**
   - Utilizza Widget Filament per form complessi
   - Integra i widget nelle pagine Folio tramite Livewire
   - Mantieni la logica di validazione nei widget

4. **Middleware e Protezione**
   - Usa i middleware attraverso le convenzioni di Folio
   - Proteggi le rotte usando i file di configurazione appropriati
   - Implementa l'autenticazione a livello di componente

### Localizzazione
1. **URL Localizzati**
   - Includi sempre il prefisso della lingua negli URL
   - Usa `app()->getLocale()` per ottenere la lingua corrente
   - Genera link localizzati con la lingua corrente

2. **Contenuto Localizzato**
   - Usa i file di traduzione per le etichette
   - Implementa il contenuto localizzato nel database
   - Segui le convenzioni di naming per le chiavi di traduzione

## Esempi

### ❌ NON FARE (in web.php)
```php
Route::get('/auth/register', [RegisterController::class, 'show']);
Route::post('/auth/register', [RegisterController::class, 'register']);
```

### ✅ FARE (con Folio + Volt + Filament)
```php
// Themes/One/resources/views/pages/auth/register.blade.php
<?php
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

name('register');
middleware(['guest']);

new class extends Component {
    // Logica minima del componente
};
?>

<x-layouts.app>
    <div class="container mx-auto">
        <!-- Integrazione del widget Filament -->
        @livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class, ['type' => 'patient'])
    </div>
</x-layouts.app>
```

## Troubleshooting

### Errori Comuni

1. **Problemi di Routing**
   - Verificare la struttura delle directory
   - Controllare la nomenclatura dei file
   - Assicurarsi che i file siano nella directory corretta

2. **Problemi di Localizzazione**
   - Verificare che gli URL includano il prefisso della lingua
   - Controllare che la locale sia recuperata correttamente
   - Assicurarsi che i link siano generati con la locale corretta

3. **Problemi di Integrazione**
   - Verificare che i widget Filament siano integrati correttamente
   - Controllare che i namespace siano corretti
   - Assicurarsi che le dipendenze siano installate

### Domande da Porsi

Se ti trovi a voler aggiungere una rotta in web.php, chiediti:
1. Può essere gestita con la struttura file di Folio?
2. È davvero necessaria una rotta personalizzata?
3. Potrebbe essere gestita meglio come API endpoint?
4. Potrebbe essere implementata come widget Filament?

### Migrazione da Route a Folio

Per migrare le rotte esistenti:
1. Identifica la struttura URL desiderata
2. Crea la corrispondente struttura di cartelle in pages
3. Sposta la logica nei componenti Volt o nei widget Filament
4. Rimuovi le vecchie definizioni di rotte

## Collegamenti Bidirezionali

- [Architettura Folio + Volt + Filament](./FOLIO_VOLT_ARCHITECTURE.md)
- [Struttura dei Moduli](./MODULE_STRUCTURE.md)
- [Documentazione Generale](./documentation.md)
- [Regole del Progetto](./rules.md)
- [Collegamenti al Modulo Cms](../../Cms/project_docs/frontoffice/routing.md)
- [Collegamenti al Modulo Lang](../../Lang/project_docs/packages/localization.md)
- [Collegamenti alla Root](../../../project_docs/routing.md)
## Collegamenti tra versioni di routing.md
* [routing.md](../../../../project_docs/routing.md)
* [routing.md](../../Cms/project_docs/frontoffice/routing.md)

