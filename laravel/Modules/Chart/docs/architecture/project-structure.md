# Struttura del Progetto Base

## Directory Principali

### 1. Laravel (`/laravel`)
La directory `laravel/` è il contenitore principale per tutti i componenti dell'applicazione:

```
laravel/
├── Modules/           # Moduli dell'applicazione
├── Themes/           # Temi dell'applicazione
├── app/              # Core application
├── config/           # Configurazioni
├── database/         # Migrazioni e seeds
├── resources/        # Asset e viste base
└── routes/           # Route dell'applicazione
```

#### Moduli (`/laravel/Modules`)
Ogni modulo è una componente indipendente con:
- Propria cartella `docs/`
- Proprio `composer.json`
- Proprio namespace
- Propria cartella `app/`

#### Temi (`/laravel/Themes`)
❗ IMPORTANTE: I temi DEVONO essere in questa cartella, non in `/Themes`
```
laravel/Themes/
└── {ThemeName}/
    ├── resources/
    │   ├── views/
    │   ├── css/
    │   └── js/
    └── config/
```

### 2. Documentazione (`/docs`)
La documentazione principale del progetto:
```
docs/
├── architecture/    # Documentazione architetturale
├── modules/        # Documentazione generale moduli
├── standards/      # Standard e convenzioni
└── themes/         # Documentazione generale temi
```

### 3. Scripts (`/bashscripts`)
Script di utilità e automazione:
```
bashscripts/
├── docs/           # Documentazione script
├── lib/            # Librerie comuni
└── utils/          # Utility script
```

## Regole Fondamentali

### 1. Posizionamento Componenti
- Tutti i componenti Laravel devono essere nella cartella `laravel/`
- Mai posizionare componenti Laravel fuori da `laravel/`
- Mantenere la struttura standard dei moduli e temi

### 2. Documentazione
- Ogni modulo ha la propria cartella `docs/`
- La documentazione principale sta in `/docs`
- Collegamenti bidirezionali tra docs locali e principale

### 3. Namespace
- Moduli: `Modules\{ModuleName}`
- Temi: `Themes\{ThemeName}`
- No `App\` nei moduli

## Collegamenti Bidirezionali
- [Struttura Temi](../laravel/Modules/Theme/docs/theme-structure.md)
- [Struttura Moduli](architecture/modules-structure.md)
- [Standard Directory](standards/directory-standards.md)

## Vedi Anche
- [Convenzioni di Naming](naming-conventions.md)
- [Best Practices](standards/best-practices.md)
- [Guida Sviluppo](development-guide.md) 