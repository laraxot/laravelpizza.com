# Header nav: logo, dropdown lingua, toggle light/dark

**Componente**: `resources/views/components/sections/header.blade.php`

## Logo

Il logo in header è lo **stesso di laravelpizza.com**: SVG spicchio di pizza con path `M12 2L22 20H2L12 2z` e cerchi (pepperoni) alle coordinate 8,14 / 12,12 / 14,16 / 10,17, fill `#fef2f2`. Riferimento: `resources/html/components/navigation.html`. Il link punta a home localizzata (`LaravelLocalization::localizeUrl('/')`).

## Dropdown lingua

Dropdown in linea con la grafica del sito:
- Stile: `bg-slate-200/80 dark:bg-slate-800`, bordo `border-slate-300 dark:border-slate-600`, hover `border-red-500/50`
- Menu a tendina: `bg-slate-100 dark:bg-slate-800`, bordo `border-slate-200 dark:border-slate-700`
- Lingue da `config('laravellocalization.supportedLocales')`; link con `LaravelLocalization::getLocalizedURL($code, null, [], true)`
- Interattività: Alpine.js (`x-data`, `x-show`, `@click.outside`)

## Auth CTA localizzate

- Le CTA guest dell'header non possono usare stringhe hardcoded come `Accedi` o `Registrati`.
- Devono usare chiavi di traduzione del tema (`pub_theme::navigation.auth.*`) cosi' il prefisso lingua controlla anche le label finali.
- Gerarchia UI/UX:
- login come azione secondaria con bordo/ghost button;
- register come primary CTA piena, piu' evidente e con hit area generosa;
- stessa semantica su desktop e mobile.
- Verifica minima: su `/de` il guest header deve mostrare `Anmelden` e `Registrieren`, e non deve mostrare label italiane.

## Toggle light/dark

Toggle versione chiara / scura con **icone standard** (sole = light, luna = dark):
- Persistenza: `$persist(true).as('theme_dark')` (Alpine Persist)
- Classe su `document.documentElement`: `dark` per tema scuro
- Icone: sole (Heroicons outline) quando il tema è scuro (click per passare a light), luna quando è light (click per passare a dark)
- Layout: script in `main.blade.php` applica subito il valore da `localStorage.theme_dark` per evitare flash

Tailwind: `darkMode: 'class'` in `tailwind.config.js`. Body e header usano varianti `dark:` per colori in tema scuro.

## Riferimenti

- [logo-implementation-error](logo-implementation-error.md)
- [mcp-configuration](mcp-configuration.md) (confronto grafica con laravelpizza.com)
