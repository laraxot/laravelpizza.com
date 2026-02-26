# Temi in il progetto

il progetto utilizza un sistema di temi basato su Filament 3.3. Ogni tema è un pacchetto Laravel indipendente che può essere installato e configurato separatamente.

## Struttura dei Temi

Un tema deve seguire questa struttura:

```
Themes/{ThemeName}/
├── app/
│   └── Providers/
│       └── ThemeServiceProvider.php
├── config/
│   └── theme.php
├── resources/
│   └── views/
│       ├── components/
│       │   └── blocks/
│       ├── layouts/
│       └── pages/
└── assets/
    ├── css/
    └── js/
```

## Componenti Richiesti

### Service Provider
Il service provider del tema deve:
1. Registrare il tema con Filament
2. Caricare gli assets
3. Registrare le viste

### Configurazione
Il file di configurazione deve contenere:
1. Nome e descrizione del tema
2. Percorsi delle viste e degli assets
3. Provider da registrare

### Views
Le viste devono essere organizzate in:
1. `components/blocks/` - Componenti riutilizzabili
2. `layouts/` - Layout del tema
3. `pages/` - Pagine specifiche del tema

## Tema One

Il tema One è il tema predefinito di il progetto. È basato su Filament 3.3 e include:

### Blocchi Disponibili
- Hero
- Feature Sections
- Stats
- CTA

### Layout
- Layout principale con navigazione
- Layout per le pagine
- Layout per i componenti

### Assets
- CSS personalizzato
- JavaScript personalizzato
- Font e immagini

## Personalizzazione

Per personalizzare un tema:

1. Modifica i file nella directory `resources/views`
2. Aggiorna gli assets nella directory `assets`
3. Modifica la configurazione in `config/theme.php`

## Best Practices

1. **Namespace**: Usa il namespace corretto per il tema
2. **Assets**: Organizza gli assets in modo pulito
3. **Views**: Segui le convenzioni di naming
4. **Config**: Mantieni la configurazione pulita e documentata
5. **Provider**: Registra solo ciò che è necessario
6. **Blocchi**: Crea blocchi riutilizzabili
7. **Layout**: Mantieni i layout flessibili
8. **Documentazione**: Documenta tutto accuratamente 
## Collegamenti tra versioni di themes.md
* [themes.md](docs/rules/themes.md)
* [themes.md](../../../Xot/project_docs/themes.md)
* [themes.md](../../../Cms/project_docs/frontoffice/themes.md)

* [README.md Tema One](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Themes/One/project_docs/README.md)
* [Convenzioni Namespace Tema One](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Themes/One/project_docs/namespace-conventions.md)b6f667c (.)


