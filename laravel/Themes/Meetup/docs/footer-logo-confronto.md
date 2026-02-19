# Confronto logo footer – laravelpizza.com vs tema Meetup

Analisi delle **differenze del logo nel footer** tra [laravelpizza.com](https://laravelpizza.com/) e la nostra implementazione (es. [127.0.0.1:8000/it](http://127.0.0.1:8000/it)), con roadmap per l’allineamento.

Gli screenshot della sezione footer sono in:

- `screenshots/footer/footer-local-it.png`
- `screenshots/footer/footer-laravelpizza.png`

---

## 1. Situazione attuale

### 1.1 Nostro footer (sections/footer.blade.php)

- **Logo**: usa il componente `<x-ui.logo>` (pizza slice), **coerente con l’header**.
- **Verifica**: confermare che `<x-ui.logo>` sia presente e che i colori siano leggibili in dark.

### 1.2 Nostro header (sections/header.blade.php)

- **Logo**: componente `<x-ui.logo>` = **pizza slice** (triangolo, crosta, pepperoni) da `components/ui/logo.blade.php`.
- Stesso brand “Laravel Pizza” + “Meetups”.

Nota: questa riga era vera in una versione precedente del tema. Attualmente footer e header sono già allineati sullo stesso componente.

### 1.3 Produzione (laravelpizza.com)

- Il dominio [laravelpizza.com](https://laravelpizza.com/) **in questo momento non sembra servire l’app LaravelPizza** (risulta una landing esterna). Di conseguenza:
  - lo screenshot `screenshots/footer/footer-laravelpizza.png` va trattato come **evidenza dello stato attuale del dominio**, non come source-of-truth del tema.
  - per una vera parity di produzione serve un URL (staging/production) che serva davvero il front LaravelPizza.

### 1.4 Riferimento HTML tema (resources/html/components/footer.html)

- In una versione precedente del tema, il footer aveva un SVG “layers”.
- Attualmente, il Blade del tema Meetup usa già `<x-ui.logo>`.

---

## 2. Differenze da evidenziare

| Aspetto | Dominio pubblico (laravelpizza.com) | Nostra implementazione (locale) | Evidenza |
| --- | --- | --- | --- |
| **Icona footer** | Non affidabile come source-of-truth (dominio non serve l’app) | `<x-ui.logo>` (pizza slice) | `docs/screenshots/footer/` |
| **Coerenza header–footer** | Non valutabile finché il dominio non serve l’app | Header e footer usano `<x-ui.logo>` → **coerenti** | `resources/views/components/sections/header.blade.php` + `.../footer.blade.php` |
| **Chiusura footer** | Non affidabile come parity testuale | Include “Made with ❤️ for the Laravel community” | `resources/views/components/sections/footer.blade.php` |
| **Testo brand** | “Laravel Pizza Meetups” (nel nostro tema) | “Laravel Pizza Meetups” | Visivo |

Conclusione (stato attuale): nel tema Meetup locale **header e footer sono già allineati** sul componente `<x-ui.logo>`.

---

## 3. Roadmap per sistemare le differenze

### Fase 1 – Verifica visiva (footer)

1. Generare screenshot footer locale e dominio.
2. Salvare gli output sotto `docs/screenshots/footer/`.
3. Aggiornare questo doc con l’esito del confronto.

### Fase 2 – Allineamento logo footer (priorità alta) ✅ Fatto

**Obiettivo**: stesso logo (pizza) in header e footer.

**Stato**: già fatto nel tema Meetup (`<x-ui.logo>` nel footer).

- **Fatto**: in `sections/footer.blade.php` l’SVG “layers” è stato sostituito con `<x-ui.logo class="h-8 w-8 [&_svg]:h-8 [&_svg]:w-8 text-red-500 shrink-0" />`. Il testo “Laravel Pizza Meetups” è invariato.

### Fase 3 – Coerenza “Made with…” (priorità media) ✅ Fatto

- Nel nostro footer è presente anche la riga “Made with ❤️ for the Laravel community”.

### Fase 4 – Documentazione e regressioni

- Aggiornare [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md) nella sezione Footer con: “Logo footer = x-ui.logo (stesso dell’header)”.
- Aggiungere in [evidenzia-differenze](evidenzia-differenze.md) la voce “Logo footer” come allineato dopo intervento.
- Usare gli screenshot in `footer-logo-confronto/` per regressioni future (rifare screenshot dopo modifiche e confrontare).

---

## 4. Riepilogo interventi

| # | Priorità | Azione | File |
| --- | --- | --- | --- |
| 1 | Alta | Ottenere URL produzione/staging reale (non landing) per verificare parity | N/A |
| 2 | Media | Rifare screenshot footer su URL reale e aggiornare questo doc | `docs/screenshots/footer/` |
| 3 | Bassa | Allineare eventuali altri dettagli footer (link, colonne) | Come da [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md) |

---

## 5. Riferimenti

- Screenshot footer: [docs/screenshots/footer/](docs/screenshots/footer/).
- Screenshot footer: [screenshots/footer-logo-confronto](screenshots/footer-logo-confronto/readme.md).
- Approfondimento grafica (footer e logo): [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md).
- Differenze generali: [differenze-grafica-e-miglioramenti](differenze-grafica-e-miglioramenti.md).
- Componente logo condiviso: `resources/views/components/ui/logo.blade.php`.
