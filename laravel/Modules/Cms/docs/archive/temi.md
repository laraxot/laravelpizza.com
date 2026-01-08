# Struttura dei Temi in il progetto

## Panoramica

Nel progetto il progetto, i temi sono componenti di presentazione separati dai moduli funzionali. Questa separazione è fondamentale per mantenere una chiara distinzione tra logica di business e presentazione.

## Posizionamento Corretto

I temi devono essere posizionati nella directory `laravel/Themes/` e **NON** nella directory Modules.

### Struttura Corretta
```
laravel/
├── Modules/           # Componenti funzionali
│   ├── Xot/
│   ├── User/
│   └── ...
└── Themes/            # Componenti di presentazione
    └── One/           # Tema principale
```

## Tema Principale: ThemeOne

Il tema principale utilizzato in il progetto è ThemeOne, basato su Filament 3, che deve essere installato in:
```
laravel/Themes/One/
```

### Installazione Corretta
```bash
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

### Errore da Evitare
❌ **NON** utilizzare:
```bash
git subtree add --prefix laravel/Modules/ThemeOne git@github.com:laraxot/theme_one_fila3.git dev --squash
```

## Struttura del Tema

Il tema ThemeOne segue questa struttura:
```
Themes/One/
├── Resources/
│   ├── assets/        # File CSS, JS, immagini
│   ├── views/         # Template Blade
│   └── lang/          # File di traduzione
├── Http/
│   ├── Controllers/   # Controller specifici del tema
│   └── Livewire/      # Componenti Livewire
├── routes/            # Route specifiche del tema
└── Config/            # Configurazioni del tema
```

## Personalizzazione del Tema

Per personalizzare il tema:

1. **Stili**: Modificare i file SCSS in `Resources/assets/scss/`
2. **Layout**: Personalizzare i template in `Resources/views/layouts/`
3. **Componenti**: Creare o modificare componenti in `Resources/views/components/`

## Integrazione con Filament

ThemeOne è progettato per integrarsi con Filament Admin Panel:

```php
// Esempio di personalizzazione del tema Filament
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->theme(Themes\One\ThemeOne::class) // Integrazione con ThemeOne
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
            ]);
    }
}
```

## Vantaggi della Separazione Temi/Moduli

1. **Sviluppo parallelo**: Team diversi possono lavorare su funzionalità e UI separatamente
2. **Manutenibilità**: Modifiche all'UI non impattano la logica di business
3. **Riutilizzo**: Lo stesso tema può essere utilizzato in progetti diversi
4. **Coerenza**: Garantisce un'esperienza utente uniforme in tutta l'applicazione
5. **Aggiornamenti**: Facilita l'aggiornamento separato di UI e funzionalità

## Collegamenti tra versioni di temi.md
* [temi.md](docs/regole/temi.md)
* [temi.md](laravel/Modules/Cms/docs/temi.md)

