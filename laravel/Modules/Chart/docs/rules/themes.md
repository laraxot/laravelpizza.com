# Gestione dei Temi

## Dipendenze Critiche
- **Tailwind CSS**: Per la compatibilità con Filament 4.x, è **obbligatorio** utilizzare `tailwindcss@3.x`. Non aggiornare a versioni superiori finché non sarà supportato ufficialmente da Filament.

## Struttura dei Temi
I temi sono organizzati nella cartella `laravel/Themes/` e ogni tema ha la sua struttura indipendente.

### Struttura Standard di un Tema
```
Themes/
  ├── ThemeName/
  │   ├── app/           # Classi PHP del tema
  │   ├── config/        # Configurazioni specifiche del tema
  │   ├── database/      # Migrations e seeders
  │   ├── docs/          # Documentazione del tema
  │   ├── lang/          # Traduzioni
  │   ├── public/        # Assets compilati
  │   ├── resources/     # Assets sorgente (JS, CSS, views)
  │   ├── routes/        # Routes specifiche del tema
  │   ├── vendor/        # Dipendenze PHP
  │   ├── node_modules/  # Dipendenze JS
  │   ├── package.json   # Configurazione npm
  │   ├── vite.config.js # Configurazione Vite
  │   └── theme.json     # Metadati del tema
```

## Compilazione e Pubblicazione
Ogni tema ha il suo processo di compilazione indipendente:

1. **Installazione Dipendenze**
   ```bash
   cd laravel/Themes/ThemeName
   npm install tailwindcss@3 @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
   ```

2. **Compilazione degli Assets**
   ```bash
   npm run build
   ```

3. **Pubblicazione degli Assets**
   ```bash
   npm run copy
   ```
   Questo comando copia gli assets compilati nella cartella pubblica del progetto.

## Best Practices
- Ogni tema deve essere completamente indipendente
- La compilazione deve avvenire sempre dalla cartella del tema specifico
- Gli assets compilati devono essere pubblicati nella cartella pubblica corretta
- Mantenere aggiornata la documentazione del tema
- Seguire le convenzioni di nomenclatura standard
- **NON aggiornare Tailwind oltre la versione 3.x** finché non sarà supportato da Filament 
## Collegamenti tra versioni di themes.md
* [themes.md](docs/rules/themes.md)
* [themes.md](laravel/Modules/Xot/docs/themes.md)
* [themes.md](laravel/Modules/Cms/docs/frontoffice/themes.md)

