# Approfondimento tecnico – differenze grafica laravelpizza.com vs tema Meetup

Documentazione **tecnica** con mappatura file, riferimenti di codice e checklist di intervento. Per il riepilogo visivo e priorità vedi [differenze-grafica-e-miglioramenti](differenze-grafica-e-miglioramenti.md).

Riferimento HTML di produzione (tema): `resources/html/` (index.html, components/navigation.html, components/footer.html).

---

## 1. Mappatura file per area

| Area | Produzione (HTML ref) | Nostra implementazione | Note |
|------|------------------------|------------------------|------|
| **Layout pagina** | index.html | Layout: `components/layouts/app.blade.php` → `<x-section slug="header"/>` + slot + `<x-section slug="footer"/>` | Section risolve in Cms: `pub_theme::components.sections.{slug}` |
| **Header** | `resources/html/components/navigation.html` | `resources/views/components/sections/header.blade.php` | Logo, nav, lingua, theme, auth |
| **Logo (header)** | navigation.html: unica riga "Laravel Pizza Meetups" + SVG pizza (fill) | `sections/header.blade.php` + `components/ui/logo.blade.php` | Due righe "Laravel Pizza" + "Meetups"; logo UI = pizza slice illustrata |
| **Hero** | `resources/html/index.html` (hero section) | Blocco: `content_blocks` in `config/.../pages/home.json` → view `pub_theme::components.blocks.hero.main` = `resources/views/components/blocks/hero/main.blade.php` | Titolo/CTA da JSON; icona pizza nel Blade |
| **Features** | index.html "Why Join" | home.json blocco features → `components/blocks/features/grid.blade.php` | Stessa struttura; icone Heroicons |
| **CTA finale** | index.html "Ready to Join?" | home.json blocco cta → `components/blocks/cta/banner.blade.php` | Un solo bottone "Create Your Account" |
| **Footer** | `resources/html/components/footer.html` (e index footer) | `components/sections/footer.blade.php` | Community, Resources, Follow; copyright |

---

## 2. Header – logo e nav (dettaglio codice)

### 2.1 Logo: una riga vs due righe

**Produzione (navigation.html):**

```html
<span class="text-xl font-bold ...">Laravel Pizza Meetups</span>
```

Un solo `<span>`, una riga.

**Nostra (sections/header.blade.php, righe 27–37):**

```blade
<a href="..." class="flex items-center space-x-3 group">
    <x-ui.logo class="h-8 w-auto text-red-600 ..." />
    <div class="flex flex-col">
        <span class="... font-bold text-lg md:text-xl ...">Laravel Pizza</span>
        <span class="... text-xs md:text-sm ...">Meetups</span>
    </div>
</a>
```

Due righe: "Laravel Pizza" + "Meetups".

**Intervento (parity produzione):** in `sections/header.blade.php` sostituire il `flex flex-col` con un unico span:

```blade
<span class="text-slate-900 dark:text-white font-bold text-lg md:text-xl">Laravel Pizza Meetups</span>
```

### 2.2 Logo SVG header (nav)

- **Produzione (navigation.html):** SVG viewBox 0 0 512 512, `fill="white"` (icona pizza “piena” stile FontAwesome).
- **Nostra (ui/logo.blade.php):** SVG viewBox 0 0 100 100, pizza slice illustrata (crosta, pepperoni, fill #DC2626/#F59E0B). Non è la stessa icona della nav produzione.

Se si vuole parity visiva con la nav di produzione, usare lo stesso SVG di `navigation.html` (viewBox 512 512, path fill) nel componente `ui/logo.blade.php` oppure in una variante solo per header.

### 2.3 Nav: label e URL Community / Chat

| Dove | Produzione (HTML) | Nostra implementazione |
|------|--------------------|------------------------|
| **Nav link** | "Community Chat" → chat.html (/chat) | "Community" (i18n) → `/community` (`sections/header.blade.php` righe 48, 101) |
| **Footer link** | "Community Chat" → chat.html | "Community Chat" → `/chat` (`sections/footer.blade.php` riga 26) |

Inconsistenza: in **header** abbiamo label "Community" e URL `/community`; in **footer** label "Community Chat" e URL `/chat`. Produzione usa ovunque "Community Chat" e `/chat`.

**Interventi:**

1. **Opzione A (parity produzione):** in `sections/header.blade.php` cambiare href da `LaravelLocalization::localizeUrl('/community')` a `...('/chat')` e usare in nav la chiave di traduzione per "Community Chat" (es. `__('Community Chat')`).
2. **Opzione B:** mantenere `/community` e aggiornare il footer a `/community` e documentare la scelta (slug unico `/community`).

File da toccare: `sections/header.blade.php` (righe 48, 51, 101, 104), `sections/footer.blade.php` (riga 26), file lang per "Community Chat".

---

## 3. Hero – icona pizza (stroke vs fill)

### 3.1 Produzione (index.html, righe 57–62)

SVG **fill** (icona piena), viewBox 0 0 512 512:

```html
<svg xmlns="http://www.w3.org/2000/svg" 
     viewBox="0 0 512 512" 
     fill="currentColor" 
     class="h-28 w-28 text-red-600 ...">
    <path d="M169.7 .9c-22.8-1.6-41.9 14-47.5 34.7L110.4 80c.5 0 1.1 0 1.6 0c176.7 0 320 143.3 320 320c0 .5 0 1.1 0 1.6l44.4-11.8c20.8-5.5 36.3-24.7 34.7-47.5C498.5 159.5 352.5 13.5 169.7 .9zM399.8 410.2c.1-3.4 .2-6.8 .2-10.2c0-159.1-128.9-288-288-288c-3.4 0-6.8 .1-10.2 .2L.5 491.9c-1.5 5.5 .1 11.4 4.1 15.4s9.9 5.6 15.4 4.1L399.8 410.2zM176 208a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm64 128a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM96 384a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
</svg>
```

### 3.2 Nostra (blocks/hero/main.blade.php, righe 34–41)

SVG **stroke** (contorno), viewBox 0 0 24 24 (Lucide/Heroicons style):

```blade
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ...>
    <path d="M15 11h.01"/>
    <path d="M11 15h.01"/>
    ...
    <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"/>
    <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"/>
</svg>
```

**Intervento (parity visiva):** in `blocks/hero/main.blade.php` sostituire l’SVG stroke (righe 34–41) con l’SVG fill di `resources/html/index.html` (path sopra), adattando class (es. `h-24 w-24 text-red-500` o `h-28 w-28 text-red-600`).

---

## 4. Hero – CTA secondario (bordo)

Produzione (index.html): `border-2 border-gray-600 hover:border-gray-500`.  
Nostra (hero/main.blade.php, riga 97): `border-2 border-slate-700 dark:border-white`. In dark siamo allineati; in light il nostro è più scuro (slate-700). Per parity light: considerare `border-gray-600 hover:border-gray-500` in light mode.

---

## 5. Features grid (Why Join)

- **Contenuto:** allineato tramite `home.json` (titolo, descrizione, 4 feature con icone Heroicons).
- **Layout:** `blocks/features/grid.blade.php` – griglia 4 colonne, card slate-800/50, bordo slate-700, hover border-red-500.
- **Icone:** produzione usa SVG stroke inline (calendar, users, map-pin, chat); noi usiamo `<x-dynamic-component :component="$feature['icon']"/>` (heroicon-o-calendar, heroicon-o-users, ecc.). Verificare che il naming Heroicons corrisponda agli stessi simboli (calendar, users, map-pin, chat-bubble).

Eventuali micro-differenze: padding card (p-8), gap (gap-8), font-size titolo/descrizione – da confrontare su screenshot.

---

## 6. CTA finale (Ready to Join?)

- **Contenuto:** da home.json (titolo, descrizione, un solo CTA "Create Your Account").
- **Stile:** `blocks/cta/banner.blade.php` – `from-red-600 to-red-700`, bottone bianco. Nessun secondo bottone, allineato a produzione.
- Verificare su screenshot: padding del box (p-8 md:p-12), dimensione titolo (text-3xl md:text-4xl).

---

## 7. Footer

- **File:** `components/sections/footer.blade.php`.
- **Colonne:** Brand (logo + descrizione), Community (Events, Community Chat, Code of Conduct, Join Us), Resources (Laravel/Filament/Livewire docs, Blog), Follow Us (social).
- **Produzione (footer.html):** Quick Links con Events, Community Chat, Dashboard; Community con About Us, Code of Conduct, Contact. Noi abbiamo "Community" con Events, Community Chat, Code of Conduct, Join Us – e "Resources" separata.
- **"Made with …":** produzione ha spesso "Made with [icon] for the Laravel community" in fondo; nostro footer ha solo "© YYYY Laravel Pizza Meetups. All rights reserved." Aggiungere la frase "Made with …" se si vuole parity testuale.

**URL da allineare:** Community Chat → `/chat` (già presente nel footer); header come in §2.3.

---

## 8. Riepilogo interventi (checklist tecnica)

| # | Priorità | Area | File | Intervento |
|---|----------|------|------|-------------|
| 1 | Alta | Logo header una riga | `sections/header.blade.php` | Sostituire due span con un solo "Laravel Pizza Meetups" |
| 2 | Alta | Hero icona fill | `blocks/hero/main.blade.php` | Sostituire SVG stroke con SVG fill da index.html (path §3.1) |
| 3 | Media | Nav Community Chat | `sections/header.blade.php` + lang | URL `/chat` e label "Community Chat" |
| 4 | Media | Footer parity | `sections/footer.blade.php` | Verificare Quick Links / "Made with …" |
| 5 | Bassa | Logo nav SVG | `ui/logo.blade.php` (opz.) | Usare SVG 512×512 fill come in navigation.html |
| 6 | Bassa | Hero CTA secondario light | `blocks/hero/main.blade.php` | Bordo light: gray-600/gray-500 se serve parity |

---

## 9. Riferimenti incrociati

- Screenshot: [screenshots/grafica-confronto](screenshots/grafica-confronto/README.md), [screenshots/2026-02-02](screenshots/2026-02-02/).
- Riepilogo priorità e tabelle: [differenze-grafica-e-miglioramenti](differenze-grafica-e-miglioramenti.md).
- Evidenza rapida: [evidenzia-differenze](evidenzia-differenze.md).
- HTML di riferimento tema: `resources/html/index.html`, `resources/html/components/navigation.html`, `resources/html/components/footer.html`.
