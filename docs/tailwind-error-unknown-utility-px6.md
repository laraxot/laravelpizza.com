# Tailwind Error: `Cannot apply unknown utility class `px-6``

## Contesto

- Modulo: **Meetup**
- Tema: **Themes/Meetup** (HTML statici con Vite 7 + Tailwind 4 via `@tailwindcss/vite`)
- Ambiente: dev server Vite avviato in `laravel/Themes/Meetup/resources/html`
- File coinvolti:
  - `laravel/Themes/Meetup/resources/html/events.html`
  - `laravel/Themes/Meetup/resources/html/css/app.css`

## Sintomo

In console Vite, durante `npm run dev`:

```text
[plugin:@tailwindcss/vite:generate:serve] Cannot apply unknown utility class `px-6`. Are you using CSS modules or similar and missing `@reference`?
/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/html/events.html
```

## Come dovrebbe funzionare

- Le utility standard di Tailwind (`px-6`, `py-3`, ecc.) devono essere sempre disponibili:
  - nei template HTML come classi (`class="px-6 py-3 ..."`),
  - nei file CSS che importano Tailwind con `@import "tailwindcss";`.
- L’uso di `@apply px-6 ...` è valido **solo** in file CSS gestiti da Tailwind (es. `app.css`), o in altri CSS che dichiarano esplicitamente la sorgente tramite `@reference`.

## Causa dell’errore

Nel caso specifico:

- In una versione precedente di `events.html` era presente un blocco inline:

```html
<style>
  .category-filter {
      @apply px-4 py-2 rounded-full border-2 border-gray-300 text-gray-700 font-medium transition-all;
      @apply hover:border-gray-200 hover:text-green-600;
  }
  ...
</style>
```

- Questo `<style>` **non**:
  - importava Tailwind (`@import "tailwindcss";`),
  - né dichiarava la sorgente con `@reference` verso il CSS principale (`app.css`).

Il plugin `@tailwindcss/vite` quindi vedeva un `@apply px-6` in un contesto dove le utility non erano state caricate, e lo segnalava come “unknown utility class”.

## Soluzione adottata

### 1. Rimozione di `@apply` dagli HTML

- Tutta la logica con `@apply` è stata spostata/normalizzata in `css/app.css` o sostituita con classi Tailwind inline.
- `events.html` ora usa direttamente le classi utility nelle `class="..."` (es. `px-6 py-2 rounded-lg ...`) senza blocchi `<style>` con `@apply`.

### 2. Regola: niente `@apply` nei `<style>` degli HTML

Per il tema Meetup:

- **NON** usare `@apply` dentro `<style>` inline negli HTML.
- Usare invece uno di questi pattern:
  - **Pattern A** – Solo classi utility inline:
    ```html
    <button class="px-6 py-2 rounded-lg font-medium bg-red-600 text-white ...">
    ```
  - **Pattern B** – Classi custom definite in `app.css`:
    ```css
    /* css/app.css */
    @import "tailwindcss";

    @layer components {
      .btn-primary {
        @apply bg-red-600 text-white px-6 py-3 rounded-lg font-semibold;
      }
    }
    ```
    ```html
    <button class="btn-primary">Join</button>
    ```

### 3. Opzione alternativa (non usata ma documentata): `@reference`

Se in futuro servisse usare `@apply` in un CSS separato (non `app.css`), è necessario:

```css
@reference "./css/app.css";

.my-class {
  @apply px-6 py-3 bg-red-600 text-white;
}
```

> **Nota:** questo non va usato nei `<style>` inline degli HTML per il tema Meetup; teniamo tutta la logica Tailwind in `app.css`.

## Verifica

- Dopo aver rimosso `@apply` dagli HTML e normalizzato il CSS:
  - `npm run dev` non mostra più l’errore `Cannot apply unknown utility class 'px-6'`.
  - `http://localhost:5173/events.html` si carica correttamente con lo stile previsto.

## Riferimenti

- Modulo: `laravel/Modules/Meetup`
- Tema statico: `laravel/Themes/Meetup/resources/html`
- Docs correlati:
  - `laravel/Modules/Meetup/docs/tailwind-best-practices.md`
  - `laravel/Themes/Meetup/docs/laravelpizza-com-design-analysis.md`
