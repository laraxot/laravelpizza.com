## phpstan_themes_zero.json - Regole di Posizionamento

- **File interessato**: `phpstan_themes_zero.json`
- **Contenuto**: output grezzo/aggregato dell'analisi PHPStan specifica per il tema Zero.

### Regola di posizionamento

- I file JSON di analisi PHPStan **per modulo/tema** non devono stare nella root `laravel/`, ma:
  - o dentro `laravel/docs/` se sono report cross‑modulo (es. `phpstan_theme_zero_analysis.json`, `phpstan_theme_one_analysis.json`, `phpstan_user_analysis.json`, `phpstan_xot_analysis.json`, `phpstan_lang_analysis.json`)
  - o dentro la cartella del tema/modulo se servono solo a quel contesto (nel caso di Zero, sotto `laravel/Themes/Zero/` o sue sottocartelle tecniche).

Per il file `phpstan_themes_zero_filtered.json`:

- **NON è ammesso** il path: `laravel/phpstan_themes_zero_filtered.json`
- Il file viene spostato in una posizione interna al tema Zero:
  - `laravel/Themes/Zero/phpstan_themes_zero_filtered.json`

### Collegamenti utili

- [PHPStan Theme Zero Analysis](./phpstan_theme_zero_analysis.json)
- [Theme Zero PHPStan Docs](../Themes/Zero/docs/phpstan-level10-analysis.md)
- [Theme Zero Documentation Index](../Themes/Zero/docs/index.md)

