# Titolo e descrizione delle pagine (`<title>`, meta description, Open Graph)

Ogni pagina pubblica ha un `<title>` e una meta description propri. Prima del 12/11/2026 tutte le pagine
avevano lo stesso titolo ("Laravel Pizza Meetups") e la descrizione predefinita del modulo
("Gestione meta tag e SEO del sito web"): male per i motori di ricerca, per le anteprime condivise e per chi
usa un lettore di schermo (il titolo è la prima cosa che legge).

## Da dove arrivano

In ordine di priorità:

| Fonte | Chi la usa | Come |
|---|---|---|
| Attributi `title` / `description` del layout | login, registrazione, pagine password, pagine di errore | `<x-layouts.app :title="..." :description="...">` (anche come slot `<x-slot name="title">`) |
| Modello mostrato dalla pagina | dettaglio evento, profilo | `title`/`description` del modello in `$data['item']` di `<x-page>`; il profilo imposta il nome in `[id].blade.php` |
| JSON della pagina CMS | home, eventi, chi siamo, contatti, privacy… | `title` tradotto del JSON; descrizione dal primo blocco con `description` o `subtitle` |
| Default del tenant | tutte le altre | `config/local/<tenant>/metatag.php` (`title`) e `config/local/<tenant>/lang/<lingua>/metatag.php` (`description`) |

Il titolo finale è `Pagina - Sito`; se il titolo della pagina contiene già il nome del sito (i JSON del CMS
lo fanno) resta com'è. La descrizione è tagliata a 160 caratteri.

## Come funziona

- `Modules\Cms\View\Components\Page` (`<x-page>`) chiama `ResolvePageMetaAction::remember()` mentre rende il
  contenuto: calcola titolo e descrizione e li mette negli **attributi della richiesta**
  (`cms.meta.title`, `cms.meta.description`).
- Blade rende lo slot di un componente **prima** del componente: quando il layout arriva a `<x-metatags>`, il
  contenuto è già stato reso e gli attributi ci sono.
- `Modules\Cms\View\Components\Metatags` legge, in ordine, gli attributi espliciti del layout, quelli della
  richiesta e il default del tenant, e passa `$title` e `$description` alla vista `cms::components.metatags`
  (che li usa per `<title>`, `description`, Open Graph e Twitter Card) e al JSON-LD.

Perché gli attributi della richiesta e non `MetatagData::concatTitle()`: `MetatagData` è un singleton
statico. Nei test (molte richieste nello stesso processo) e con worker di lunga durata il titolo di una
pagina resterebbe attaccato alla successiva. Per lo stesso motivo la descrizione predefinita è tradotta al
momento del rendering: il singleton viene spesso creato prima che il middleware imposti la lingua.

## Aggiungere una pagina

- Pagina CMS: basta il `title` tradotto nel JSON; per la descrizione, un `description` o `subtitle` nel primo
  blocco (di solito l'hero).
- Pagina Folio con layout proprio: `<x-layouts.app :title="__('...')">`.
- Pagina che mostra un modello senza `<x-page>`: nel `mount()` del componente Volt,
  `request()->attributes->set(ResolvePageMetaAction::TITLE, $nome)`.

## Privacy nel JSON-LD

`BuildPageSchemaAction` non mette più l'email nella `Person` del profilo pubblico: il JSON-LD è letto dai
crawler come il resto della pagina.

Test: `Modules/Meetup/tests/Feature/FrontOfficePrivacyAndSeoTest.php`.
