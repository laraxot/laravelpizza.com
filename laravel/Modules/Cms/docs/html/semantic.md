# Elementi Semantici HTML5

## Introduzione
Gli elementi semantici HTML5 forniscono significato e struttura al contenuto web. Secondo il W3C: "Un web semantico permette la condivisione e il riutilizzo dei dati tra applicazioni, aziende e comunità".

## Elementi Principali

### `<header>`
Contenitore per contenuti introduttivi o navigazione. Include tipicamente:
- Elementi heading (`<h1>` - `<h6>`)
- Logo o icona
- Informazioni sull'autore
- Menu di navigazione principale

```html
<header>
    <h1>Titolo Principale</h1>
    <nav>
        <!-- Menu di navigazione -->
    </nav>
</header>
```

### `<nav>`
Definisce una sezione di navigazione principale. Caratteristiche:
- Contiene link di navigazione primari
- Non tutti i link devono essere in `<nav>`
- Utile per l'accessibilità (screen reader)
- Può essere usato più volte nella pagina

```html
<nav>
    <a href="/home">Home</a>
    <a href="/about">Chi Siamo</a>
    <a href="/contact">Contatti</a>
</nav>
```

### `<main>`
Contenuto principale della pagina:
- Unico per pagina
- Contenuto centrale
- Esclude header, footer, nav e aside
- Importante per l'accessibilità

### `<article>`
Contenuto indipendente e autonomo:
- Post di blog
- Articoli di news
- Commenti
- Widget indipendenti

### `<section>`
Raggruppamento tematico di contenuti:
- Capitoli
- Schede
- Contenuti correlati
- Deve avere un heading

### `<aside>`
Contenuto correlato ma separato:
- Sidebar
- Note a margine
- Pubblicità
- Contenuti secondari
- Informazioni correlate

```html
<aside>
    <h3>Contenuti Correlati</h3>
    <ul>
        <li>Link correlato 1</li>
        <li>Link correlato 2</li>
    </ul>
</aside>
```

### `<footer>`
Piè di pagina del documento o sezione:
- Informazioni sull'autore
- Copyright
- Contatti
- Sitemap
- Link "torna su"
- Documenti correlati

```html
<footer>
    <p>Copyright © 2024</p>
    <nav>
        <a href="/privacy">Privacy</a>
        <a href="/terms">Termini</a>
    </nav>
</footer>
```

### `<figure>` e `<figcaption>`
Contenuto autonomo con didascalia:
- Illustrazioni
- Diagrammi
- Foto
- Listati di codice

```html
<figure>
    <img src="immagine.jpg" alt="Descrizione">
    <figcaption>Didascalia dell'immagine</figcaption>
</figure>
```

## Best Practices

### 1. Struttura Semantica
- Utilizzare tag appropriati per il contenuto
- Mantenere una gerarchia logica
- Favorire l'accessibilità
- Supportare SEO

### 2. Accessibilità
- Utilizzare landmark ARIA quando necessario
- Mantenere una struttura navigabile
- Supportare screen reader
- Fornire alternative testuali

### 3. Compatibilità
- Testare su browser diversi
- Verificare il supporto
- Utilizzare fallback quando necessario
- Mantenere la retrocompatibilità

## Tabella Elementi Semantici

| Elemento | Descrizione |
|----------|-------------|
| `<article>` | Contenuto indipendente e autonomo |
| `<aside>` | Contenuto correlato ma separato |
| `<details>` | Dettagli aggiuntivi espandibili |
| `<figcaption>` | Didascalia per elemento `<figure>` |
| `<figure>` | Contenuto autonomo con didascalia |
| `<footer>` | Piè di pagina del documento o sezione |
| `<header>` | Intestazione del documento o sezione |
| `<main>` | Contenuto principale del documento |
| `<mark>` | Testo evidenziato |
| `<nav>` | Link di navigazione |
| `<section>` | Sezione tematica del documento |
| `<summary>` | Intestazione visibile per `<details>` |
| `<time>` | Data/ora |

## Collegamenti
- [Struttura Layout](../structure/layout.md)
- [Componenti HTML](../components/html.md)
- [Accessibilità](../accessibility/README.md)

[Fonte: W3Schools](https://www.w3schools.com/html/html5_semantic_elements.asp) 
