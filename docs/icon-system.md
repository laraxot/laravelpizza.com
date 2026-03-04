# 🎨 Sistema Icone UI

## Panoramica

Il modulo UI fornisce un sistema completo di icone SVG personalizzate integrate con Blade Icons e Filament. Tutte le icone sono registrate automaticamente e disponibili in tutta l'applicazione.

## 🚀 Caratteristiche

- **Registrazione Automatica**: Le icone SVG vengono registrate automaticamente
- **Prefisso Unificato**: Tutte le icone usano il prefisso `ui-`
- **Integrazione Filament**: Compatibile con tutti i componenti Filament
- **Blade Icons**: Utilizza il sistema Blade Icons di Laravel
- **Type Safety**: Supporto completo per PHPStan

## 📁 Struttura File

```
Modules/UI/resources/svg/
├── login.svg          # Icona login
├── archive-box.svg    # Icona archivio
├── article.svg        # Icona articolo
├── bathroom.svg       # Icona bagno
├── brain.svg          # Icona cervello
├── building-office.svg # Icona ufficio
├── categories.svg     # Icona categorie
├── chatgpt.svg        # Icona ChatGPT
├── clean.svg          # Icona pulizia
├── document-report.svg # Icona report
├── globe-alt.svg      # Icona globo
├── google.svg         # Icona Google
├── hello.svg          # Icona saluto
├── history.svg        # Icona cronologia
├── hourglass.svg      # Icona clessidra
├── light-bulb.svg     # Icona lampadina
├── loading.svg        # Icona caricamento
├── logo.svg           # Logo applicazione
├── marker-add.svg     # Icona aggiungi marker
├── marker-plus.svg    # Icona plus marker
├── pages.svg          # Icona pagine
├── pause.svg          # Icona pausa
├── play.svg           # Icona play
├── repair.svg         # Icona riparazione
├── shield-check.svg   # Icona scudo
├── sparkles.svg       # Icona scintille
├── status.svg         # Icona stato
├── superman.svg       # Icona superman
├── tags.svg           # Icona tag
├── telegram.svg       # Icona Telegram
├── trash.svg          # Icona cestino
├── ui-icon.svg        # Icona UI
├── widgets.svg        # Icona widget
├── wrench.svg         # Icona chiave inglese
├── cancel.svg         # Icona annulla
├── save.svg           # Icona salva
├── logout.svg         # Icona logout
├── showPassword.svg   # Icona mostra password
├── user-main.svg      # Icona utenti principali
├── user-team.svg      # Icona team utenti
└── user-user-tenant.svg # Icona tenant utenti
```

## 🔧 Configurazione

### Registrazione Automatica

Le icone vengono registrate automaticamente nel `UIServiceProvider`:

```php
public function registerBladeIcons(): void
{
    $this->callAfterResolving(BladeIconsFactory::class, function (BladeIconsFactory $factory) {
        $assetsPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'assets');
        $svgPath = $assetsPath.'/../svg';
        $factory->add($this->nameLower, ['path' => $svgPath, 'prefix' => $this->nameLower]);
    });
}
```

### Prefisso Icone

- **Prefisso**: `ui`
- **Formato**: `ui-{nome-icona}`
- **Esempio**: `login.svg` → `ui-login`

## 📖 Utilizzo

### In Blade Templates

```blade
{{-- Utilizzo base --}}
@svg('ui-login')
@svg('ui-authenticate')

{{-- Con classi CSS --}}
@svg('ui-login', 'w-6 h-6 text-blue-500')
@svg('ui-authenticate', 'w-6 h-6 text-green-500')

{{-- Con attributi personalizzati --}}
@svg('ui-login', ['class' => 'w-6 h-6', 'id' => 'login-icon', 'data-tooltip' => 'Login'])
@svg('ui-authenticate', ['class' => 'w-6 h-6', 'id' => 'auth-icon', 'data-tooltip' => 'Authenticate'])
```

### Nei Componenti Filament

#### Form Components
```php
Forms\Components\TextInput::make('email')
    ->prefixIcon('ui-login')
    ->suffixIcon('ui-google')

Forms\Components\TextInput::make('verification_code')
    ->prefixIcon('ui-authenticate')
    ->label('Verification Code')

Forms\Components\Select::make('category')
    ->options($categories)
    ->prefixIcon('ui-categories')
```

#### Table Columns
```php
Tables\Columns\TextColumn::make('name')
    ->icon('ui-user')
    ->sortable()

Tables\Columns\IconColumn::make('status')
    ->icon('ui-status')
    ->boolean()
```

#### Actions
```php
Actions\Action::make('login')
    ->icon('ui-login')
    ->url('/login')

Actions\Action::make('authenticate')
    ->icon('ui-authenticate')
    ->url('/authenticate')

Actions\Action::make('delete')
    ->icon('ui-trash')
    ->color('danger')
    ->requiresConfirmation()
```

#### Menu Items
```php
MenuItem::make()
    ->label('Dashboard')
    ->icon('ui-dashboard')
    ->url('/dashboard')

MenuItem::make()
    ->label('Settings')
    ->icon('ui-settings')
    ->url('/settings')
```

### Nei Widget Filament

```php
class StatsWidget extends Widget
{
    protected static string $view = 'ui::widgets.stats';

    public function getViewData(): array
    {
        return [
            'icon' => 'ui-chart',
            'title' => 'Statistics',
            'value' => $this->getStats(),
        ];
    }
}
```

## 🎨 Personalizzazione

### Aggiungere Nuove Icone

1. **Crea il file SVG** in `Modules/UI/resources/svg/`
2. **Usa un nome descrittivo** (es. `user-profile.svg`)
3. **L'icona sarà disponibile** come `ui-user-profile`

### Sottocartelle (es. brands)

- `brands/github.svg` → `ui-brands.github` (punto = separatore path)
- **Vietato** SVG inline nelle Blade: vedi [no-svg-hardcoded-in-blade.md](no-svg-hardcoded-in-blade.md)

### Esempio di Icona SVG

```svg
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
</svg>
```

### Best Practices per le Icone

1. **Dimensioni**: Usa `viewBox="0 0 24 24"` per consistenza
2. **Stile**: Usa `stroke="currentColor"` per ereditare il colore
3. **Classi**: Aggiungi `class="w-6 h-6"` per dimensioni base
4. **Nomi**: Usa nomi descrittivi e kebab-case
5. **Ottimizzazione**: Rimuovi attributi non necessari

## 🔍 Debugging

### Verificare Icone Registrate

```bash
# Lista tutte le icone registrate
php artisan tinker
>>> app('blade-icons')->getRegisteredSets()
```

### Testare Icone

```blade
{{-- Test icona in Blade --}}
@svg('ui-login')

{{-- Test con fallback --}}
@svg('ui-login', 'w-6 h-6', 'fallback-icon')
```

### Icone Disponibili

#### Icone Base
- `ui-create` - Icona per creare nuovi elementi
- `ui-edit` - Icona per modificare elementi
- `ui-delete` - Icona per eliminare elementi
- `ui-save` - Icona per salvare modifiche
- `ui-cancel` - Icona per annullare operazioni
- `ui-login` - Icona per il login
- `ui-authenticate` - Icona per l'autenticazione

#### Icone di Navigazione
- `ui-profile` - Icona per il profilo utente
- `ui-logout` - Icona per il logout
- `ui-register` - Icona per la registrazione

#### Icone di Tabella
- `ui-reorder` - Icona per riordinare elementi
- `ui-reorderRecords` - Icona per riordinare record
- `ui-openColumnManager` - Icona per aprire il gestore colonne
- `ui-applyTableColumnManager` - Icona per applicare modifiche colonne
- `ui-resetFilters` - Icona per resettare i filtri
- `ui-applyFilters` - Icona per applicare i filtri
- `ui-openFilters` - Icona per aprire i filtri

#### Icone di Esportazione
- `ui-exportPdf` - Icona per esportare PDF
- `ui-alert` - Icona per avvisi
- `ui-email` - Icona per email

#### Icone Geo
- `ui-geo-location` - Icona per posizioni geografiche
- `ui-geo-map` - Icona per mappe
- `ui-geo-place` - Icona per luoghi
- `ui-geo-menu` - Icona per menu geografici

#### Icone Sistema
- `ui-dashboard` - Icona per la dashboard
- `ui-settings` - Icona per le impostazioni
- `ui-associate` - Icona per associare elementi
- `ui-moveUp` - Icona per spostare in alto

## 📚 Esempi Avanzati

### Icone Condizionali

```blade
@svg($user->isActive ? 'ui-check' : 'ui-x', 'w-4 h-4')
```

### Icone Dinamiche

```php
$iconMap = [
    'admin' => 'ui-shield',
    'user' => 'ui-user',
    'guest' => 'ui-login',
];

$icon = $iconMap[$user->role] ?? 'ui-question';
```

### Icone con Stati

```blade
@svg('ui-status', [
    'class' => 'w-6 h-6',
    'data-status' => $status,
    'data-tooltip' => $statusText
])
```

## 🚀 Performance

### Caching

Le icone vengono cachate automaticamente da Blade Icons. Per forzare il refresh:

```bash
php artisan view:clear
php artisan config:clear
```

### Ottimizzazione

- Le icone SVG sono ottimizzate per il web
- Utilizzano il sistema di cache di Laravel
- Caricamento lazy quando possibile

## 🔗 Integrazione

### Con Altri Moduli

```php
// In altri moduli, usa le icone UI
@svg('ui-login')

// O in PHP
$icon = 'ui-login';
```

### Con Filament

Tutte le icone sono compatibili con Filament 4.x e versioni successive.

## 📝 Changelog

### v1.1.0 - [DATE]
- **🔧 Icone Aggiuntive**: Aggiunte icone mancanti (cancel, save, logout, showPassword, user-main, user-team, user-user-tenant)
- **🐛 Bug Fix**: Risolto errore "SvgNotFound" per icona "cancel"
- **📝 Traduzioni**: Aggiornati file di traduzione per utilizzare prefisso "ui-" corretto

### v1.0.0 - [DATE]
- **🎨 Sistema Icone**: Implementato sistema completo di icone SVG
- **🔧 Registrazione Automatica**: Icone registrate automaticamente
- **📚 Documentazione**: Documentazione completa del sistema
- **🎯 Integrazione Filament**: Compatibilità completa con Filament 4.x

## ♻️ Manutenzione 2025-11

- Refactor `Modules\UI\app\Actions\Icon\GetAllIconsAction` per garantire array `array<string, array<string, mixed>>` in tutta la catena.
- Validazione sicura dei percorsi: uso di `Symfony\Component\Finder\SplFileInfo` prima di costruire i nomi delle icone.
- Prefisso garantito stringa: cast esplicito e fallback `''` per i set personalizzati.
- Verifiche qualità: PHPStan L10 ✅, PHPMD ✅, PHPInsights ✅ (nota: soglia complessità legacy ancora 20).
- Documentare nuove icone o prefissi aggiuntivi in questa sezione prima del rilascio.
