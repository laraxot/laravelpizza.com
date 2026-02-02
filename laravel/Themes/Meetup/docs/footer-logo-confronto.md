# Confronto logo footer – laravelpizza.com vs tema Meetup

Analisi delle **differenze del logo nel footer** tra https://laravelpizza.com/ e la nostra implementazione (es. http://127.0.0.1:8000/it), con roadmap per l’allineamento.

Gli screenshot della sezione footer sono in [screenshots/footer-logo-confronto](screenshots/footer-logo-confronto/README.md).

---

## 1. Situazione attuale

### 1.1 Nostro footer (sections/footer.blade.php)

- **Logo**: SVG inline **diverso** dal logo dell’header.
- **Codice** (righe 7–14): viewBox `0 0 24 24`, path a “strati” + cerchi (`path` con `M12 2L2 7l10 5...` e `circle`). Icona che ricorda **layers/stack**, non la pizza slice.
- **Testo**: “Laravel Pizza Meetups” accanto all’icona.

### 1.2 Nostro header (sections/header.blade.php)

- **Logo**: componente `<x-ui.logo>` = **pizza slice** (triangolo, crosta, pepperoni) da `components/ui/logo.blade.php`.
- Stesso brand “Laravel Pizza” + “Meetups” ma **icona diversa** da quella del footer.

### 1.3 Produzione (laravelpizza.com)

- Il sito in produzione usa in **header** un’icona pizza (fill, viewBox 512×512, stile FontAwesome-like).
- Il **footer** su laravelpizza.com (verificato con screenshot `footer-laravelpizza-com.png`) usa la **stessa icona pizza slice** dell’header: fetta di pizza rossa stilizzata con crosta e “pepperoni”, testo “Laravel Pizza Meetups” su due righe, e in chiusura “Made with ❤️ for the Laravel community”.

### 1.4 Riferimento HTML tema (resources/html/components/footer.html)

- Stesso SVG del nostro Blade: path + cerchi (layers), **non** pizza slice.
- Quindi: il nostro footer è allineato al riferimento HTML del tema, ma se **produzione live** usa la pizza anche nel footer, dobbiamo allinearci a produzione.

---

## 2. Differenze da evidenziare

| Aspetto | Produzione (laravelpizza.com) | Nostra implementazione | Evidenza |
|--------|--------------------------------|------------------------|----------|
| **Icona footer** | **Pizza slice** (stessa dell’header): fetta rossa con crosta e pepperoni | Icona **“layers”** (tre strati impilati, path + cerchi), **non** pizza slice | Screenshot `footer-laravelpizza-com.png` vs `footer-locale-it.png` |
| **Coerenza header–footer** | Stesso logo (pizza) in header e footer | Header = pizza slice, footer = layers → **inconsistente** | Visivo |
| **Chiusura footer** | “Made with ❤️ for the Laravel community” | Solo “© YYYY … All rights reserved.” | Testo |
| **Testo brand** | “Laravel Pizza Meetups” | “Laravel Pizza Meetups” | Allineato |

Conclusione: **il logo nel footer non è lo stesso** di laravelpizza.com: in produzione è la **pizza slice** (come in header); da noi nel footer è l’icona **layers** (tre strati). Va sostituita con `<x-ui.logo>` per parity.

---

## 3. Roadmap per sistemare le differenze

### Fase 1 – Verifica visiva (fatto con screenshot)

1. Generare screenshot footer: `npm run screenshots:footer` dalla cartella del tema (vedi [screenshots/footer-logo-confronto](screenshots/footer-logo-confronto/README.md)).
2. Confrontare `footer-laravelpizza-com.png` e `footer-locale-it.png`: confermare se produzione usa pizza anche nel footer.
3. Aggiornare questo doc con l’esito del confronto (stesso logo sì/no).

### Fase 2 – Allineamento logo footer (priorità alta)

**Obiettivo**: stesso logo (pizza) in header e footer, in linea con laravelpizza.com.

1. **File**: `resources/views/components/sections/footer.blade.php`.
2. **Intervento**: sostituire l’SVG inline “layers” (righe 7–14) con il componente condiviso `<x-ui.logo>`, con classi adatte al footer (es. dimensione minore, colore rosso/bianco).
   - Esempio: `<x-ui.logo class="h-8 w-8 text-red-500" />` al posto del blocco `<svg>...</svg>` attuale.
3. Mantenere il testo “Laravel Pizza Meetups” accanto al logo.
4. Verificare in light/dark che il logo sia leggibile (es. `text-red-500` / `dark:text-red-400`).

### Fase 3 – Coerenza “Made with…” (priorità media)

- Produzione spesso ha in fondo al footer la frase tipo “Made with [icon] for the Laravel community”.
- Nel nostro footer c’è solo “© YYYY Laravel Pizza Meetups. All rights reserved.” Se si vuole parity testuale, aggiungere la riga “Made with …” (vedi [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md) §7).

### Fase 4 – Documentazione e regressioni

- Aggiornare [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md) nella sezione Footer con: “Logo footer = x-ui.logo (stesso dell’header)”.
- Aggiungere in [evidenzia-differenze](evidenzia-differenze.md) la voce “Logo footer” come allineato dopo intervento.
- Usare gli screenshot in `footer-logo-confronto/` per regressioni future (rifare screenshot dopo modifiche e confrontare).

---

## 4. Riepilogo interventi

| # | Priorità | Azione | File |
|---|----------|--------|------|
| 1 | Alta | Sostituire SVG “layers” con `<x-ui.logo>` nel footer | `sections/footer.blade.php` |
| 2 | Media | Aggiungere “Made with …” se richiesta parity con produzione | `sections/footer.blade.php` |
| 3 | Bassa | Allineare eventuali altri dettagli footer (link, colonne) | Come da [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md) |

---

## 5. Riferimenti

- Screenshot footer: [screenshots/footer-logo-confronto](screenshots/footer-logo-confronto/README.md).
- Approfondimento grafica (footer e logo): [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md).
- Differenze generali: [differenze-grafica-e-miglioramenti](differenze-grafica-e-miglioramenti.md).
- Componente logo condiviso: `resources/views/components/ui/logo.blade.php`.
