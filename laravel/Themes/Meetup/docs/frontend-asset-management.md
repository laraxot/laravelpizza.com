# Frontend Asset Management in Themes

## Data
2025-11-29 (Aggiornato)

## Objective

To clearly document the process and rationale behind executing Node.js-related commands (`npm install`, `npm run build`, `npm run copy`) within specific theme directories. This serves as a fundamental rule for managing frontend assets in this modular Laravel application.

## ⚠️ REGOLA CRITICA

Frontend asset compilation and dependency management commands (such as `npm install`, `npm run dev`, `npm run build`, or custom scripts like `npm run copy`) **must be executed within the root directory of the respective theme or module's frontend project.**

### Per Tema Meetup

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install
npm run dev
npm run build
npm run copy   # Crea la directory di destinazione se non esiste, poi copia gli asset compilati da ./dist/* alla root web dell'applicazione principale in ../../../public_html/themes/Meetup
```

**NON eseguire dalla root Laravel!**

## Reasoning

This practice is essential due to the project's modular and theme-based architecture:

1. **Self-Contained Frontend Projects:** Each theme (and potentially some modules) is designed as a self-contained frontend project. This means it has its own `package.json` file, specifying its unique Node.js dependencies (e.g., Tailwind CSS, Alpine.js, Vite configuration).

2. **Asset Pipeline Isolation:** Running `npm install` within the theme directory ensures that only the dependencies required by *that specific theme* are installed in its `node_modules` directory. Similarly, `npm run build` (which typically invokes Vite for compilation) processes assets defined *within that theme's context*.

3. **Vite Configuration Path Resolution:** The `vite.config.js` file uses `resolve(__dirname, ...)` to resolve paths. When executed from the theme directory:
   - `__dirname` = `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`
   - Paths are correctly resolved relative to the theme directory

   If executed from Laravel root:
   - `__dirname` = `/var/www/_bases/base_laravelpizza/laravel`
   - Paths would be incorrectly resolved ❌

4. **package.json Resolution:** NPM looks for `package.json` in the current working directory. Running commands from the theme directory ensures the correct `package.json` is found.

5. **Separation of Concerns:** This approach promotes a clean separation between the main Laravel application's backend dependencies and the frontend dependencies of individual themes/modules. It prevents conflicts and simplifies dependency management.

6. **Maintainability:** When working on a theme, developers only need to manage the frontend dependencies relevant to that theme, improving clarity and reducing cognitive load.

## Consequences of Incorrect Execution

Executing these commands from the main Laravel project root (`/var/www/_bases/base_laravelpizza/laravel/`) would:

* Install theme-specific dependencies in the wrong `node_modules` folder
* Cause missing dependencies for the theme
* Result in incorrect asset compilation (e.g., Vite not finding the correct theme `resources/` directory)
* Lead to build errors or visual regressions on the frontend
* Break path resolution in `vite.config.js` (wrong `__dirname`)

## Examples

### ✅ CORRETTO

```bash
# Tema Meetup
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install
npm run build

# Tema One (User Module)
cd /var/www/_bases/base_laravelpizza/laravel/Modules/User/resources/views
npm install
npm run build
npm run copy
```

### ❌ ERRATO

```bash
# NON fare questo!
cd /var/www/_bases/base_laravelpizza/laravel
npm install  # Cerca package.json nella root Laravel
npm run build  # Path risolti incorrettamente
```

## Verification

### Check Correct Directory

```bash
# Verify package.json exists in current directory
ls -la package.json

# Verify vite.config.js exists in current directory
ls -la vite.config.js

# Verify node_modules is in current directory after npm install
ls -la node_modules
```

## Related Documentation

- [Regola Esecuzione Comandi NPM](./npm-commands-execution-rule.md) - Regola generale dettagliata
- [Vite Asset Loading Best Practices](./vite-asset-loading-best-practices.md) - Best practices per Vite
- [README Theme](./../README.md) - Documentazione generale tema

## Checklist

- [x] Documentata regola critica
- [x] Spiegato reasoning (path resolution, package.json, isolamento)
- [x] Forniti esempi corretti/errati
- [x] Documentate conseguenze esecuzione errata
- [x] Aggiunti riferimenti a documentazione correlata
