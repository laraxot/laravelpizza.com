# Standard di Accessibilità

## 🎯 WCAG 2.1

### Livello A
- [ ] 1.1.1 Contenuti non testuali
- [ ] 1.2.1 Solo audio e solo video preregistrati
- [ ] 1.2.2 Sottotitoli per video preregistrati
- [ ] 1.3.1 Informazioni e relazioni
- [ ] 1.3.2 Sequenza significativa
- [ ] 1.3.3 Caratteristiche sensoriali
- [ ] 1.4.1 Uso del colore
- [ ] 1.4.2 Controllo audio
- [ ] 2.1.1 Tastiera
- [ ] 2.1.2 Nessuna trappola per la tastiera
- [ ] 2.2.1 Timing regolabile
- [ ] 2.2.2 Pausa, ferma, nascondi
- [ ] 2.3.1 Tre lampeggi o soglia inferiore
- [ ] 2.4.1 Evitare blocchi
- [ ] 2.4.2 Titoli di pagina
- [ ] 2.4.3 Ordine focus
- [ ] 2.4.4 Scopo del link
- [ ] 3.1.1 Lingua della pagina
- [ ] 3.2.1 Al focus
- [ ] 3.2.2 All'input
- [ ] 3.3.1 Identificazione errore
- [ ] 3.3.2 Etichette o istruzioni
- [ ] 4.1.1 Parsing
- [ ] 4.1.2 Nome, ruolo, valore

### Livello AA
- [ ] 1.2.4 Sottotitoli per video live
- [ ] 1.2.5 Descrizione audio per video preregistrati
- [ ] 1.4.3 Contrasto minimo
- [ ] 1.4.4 Ridimensionamento testo
- [ ] 1.4.5 Immagini di testo
- [ ] 2.4.5 Percorsi multipli
- [ ] 2.4.6 Intestazioni ed etichette
- [ ] 2.4.7 Focus visibile
- [ ] 3.1.2 Lingua parti
- [ ] 3.2.3 Navigazione coerente
- [ ] 3.2.4 Identificazione coerente
- [ ] 3.3.3 Suggerimenti per errori
- [ ] 3.3.4 Prevenzione errori

## 🛠️ Strumenti

### Validatori
- [WAVE](https://wave.webaim.org/)
- [aXe](https://www.deque.com/axe/)
- [Lighthouse](https://developers.google.com/web/tools/lighthouse)

### Screen Reader
- [NVDA](https://www.nvaccess.org/)
- [JAWS](https://www.freedomscientific.com/products/software/jaws/)
- [VoiceOver](https://www.apple.com/accessibility/mac/vision/)

## 📝 Checklist

### HTML
```html
<!-- Struttura semantica -->
<header>
  <nav aria-label="Navigazione principale">
    <ul>
      <li><a href="/">Home</a></li>
    </ul>
  </nav>
</header>

<main>
  <h1>Titolo principale</h1>

  <section aria-labelledby="section-title">
    <h2 id="section-title">Titolo sezione</h2>
    <p>Contenuto</p>
  </section>
</main>

<footer>
  <p>Copyright © 2024</p>
</footer>
```

### Form
```html
<form>
  <div class="form-group">
    <label for="email">Email</label>
    <input
      type="email"
      id="email"
      name="email"
      required
      aria-required="true"
      aria-describedby="email-help"
    >
    <small id="email-help">Inserisci la tua email</small>
  </div>

  <button type="submit">Invia</button>
</form>
```

### Immagini
```html
<img
  src="logo.png"
  alt="Logo dell'azienda"
  width="200"
  height="100"
>
```

## Tecniche W3C di riferimento

Per implementazioni dettagliate (label, focus, link, contrasto, autocomplete, aria-label, reflow):

- [H44](https://www.w3.org/WAI/WCAG21/Techniques/html/H44) – Label associati ai form controls
- [F78](https://www.w3.org/WAI/WCAG21/Techniques/failures/F78) / [G195](https://www.w3.org/WAI/WCAG21/Techniques/general/G195) – Focus visibile
- [H30](https://www.w3.org/WAI/WCAG21/Techniques/html/H30) – Scopo del link
- [C8](https://www.w3.org/WAI/WCAG21/Techniques/css/C8) – Letter-spacing
- [C38](https://www.w3.org/WAI/WCAG21/Techniques/css/C38) – Reflow (label/input)
- [G18](https://www.w3.org/WAI/WCAG21/Techniques/general/G18) – Contrasto 4.5:1
- [H98](https://www.w3.org/WAI/WCAG21/Techniques/html/H98) – Autocomplete
- [ARIA6](https://www.w3.org/WAI/WCAG21/Techniques/aria/ARIA6) – aria-label

Piano di risoluzione per il tema Two: `laravel/Themes/Two/docs/wcag-techniques-resolution.md`.

## 🔗 Collegamenti
- [Performance](./performance.md)
- [UI Standards](./ui-standards.md)
- [Componenti Base](../base-components.md)
