# HTML Structure Comparison Configuration

This file provides project-specific paths for the agnostic bashscripts/html/ tools.

## Reference Files

- **Reference HTML**: `laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/reference_segnalazioni.html`
- **Local HTML**: `laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/local_segnalazioni.html` (generated)
- **Output Directory**: `laravel/Themes/Sixteen/docs/body-structure-comparison/`

## Usage

```bash
# From project root
bash bashscripts/html/html-structure-compare.sh segnalazioni-elenco \
  laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/reference_segnalazioni.html \
  laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/local_segnalazioni.html
```

## Pages to Compare

| Page | Reference URL | Local URL | Reference File |
|------|--------------|-----------|----------------|
| Segnalazioni Elenco | https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html | http://127.0.0.1:8000/it/tests/segnalazioni-elenco | `prompts/segnalazione_disservizio/reference_segnalazioni.html` |

## Theme

- **Theme**: Sixteen
- **Theme Path**: `laravel/Themes/Sixteen/`
- **Build Command**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`
