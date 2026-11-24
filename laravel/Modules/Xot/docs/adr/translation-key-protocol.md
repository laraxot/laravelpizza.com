---
title: "ADR — Protocollo delle chiavi di traduzione"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
decision-makers: [Xot, Lang]
issues: []
---

# ADR: protocollo delle chiavi di traduzione

## Contesto

Le chiavi di traduzione sono un contratto fra codice, cataloghi Laravel e
strumenti che generano o verificano i testi. Una forma abbreviata può sembrare
valida, ma può risolvere un array invece di una stringa, stampare la chiave
grezza o impedire al catalogo owner di essere trovato. Per esempio,
`trade::widgets.signal.none_value` non contiene il tipo della stringa foglia.

La decisione risponde alla domanda: quale struttura deve avere una nuova chiave
per essere deterministica, traducibile e verificabile?

## Driver della decisione

- Il namespace identifica il modulo o il tema proprietario.
- Il primo segmento dopo `::` identifica sempre il file lingua Laravel.
- La struttura deve distinguere collezione, chiave e tipo della stringa.
- Il catalogo deve restare coerente fra `it`, `en`, `de` ed `es`.
- Le chiavi devono essere compatibili con il flusso di generazione e controllo di Lang.

## Alternative scartate

- Chiavi brevi come `trade::widgets.signal.none_value`: manca il tipo finale e
  la forma non distingue in modo esplicito una foglia da un gruppo.
- Frasi italiane usate direttamente come chiavi: non hanno owner, struttura o
  garanzia di copertura linguistica.
- Un namespace tecnico diverso dal modulo/tema owner: nasconde la proprietà
  del testo e duplica i cataloghi.
- Correggere ogni chiave aggiungendo segmenti senza leggere il file lingua:
  il nome corretto dipende dalla struttura effettiva del catalogo.

## Decisione

Una chiave nuova deve seguire questa forma canonica:

```text
<namespace>::<file>.<collection>.<key>.<type>
```

Esempio:

```blade
{{ __('trade::widgets.signal.none_value.label') }}
```

Questo esempio è valido solo se esiste una struttura equivalente a:

```php
// Modules/Trade/lang/it/widgets.php
return [
    'signal' => [
        'none_value' => [
            'label' => '...',
        ],
    ],
];
```

La regola operativa è quindi:

1. individuare il namespace owner (`<modulo>` minuscolo o `pub_theme` per il
   tema attivo);
2. leggere il file lingua e usare il suo nome come `<file>`;
3. scegliere una collezione semantica coerente con i cataloghi fratelli;
4. scegliere la chiave dell'elemento;
5. terminare con un tipo esplicito (`label`, `title`, `description`,
   `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt` o
   quello già adottato dal catalogo);
6. aggiungere la stessa foglia a tutte le lingue supportate, conservando i
   placeholder.

Il protocollo vale per Blade, PHP, configurazione e componenti Filament. Le
viste di un tema usano `pub_theme::` quando il testo appartiene al tema attivo;
una vista di modulo non deve spostare nel tema una traduzione di dominio.

## Conseguenze

- Le chiavi sono più lunghe, ma il loro owner e il tipo restituito sono
  leggibili senza indovinare.
- Una chiave malformata viene corretta alla sorgente del catalogo, non aggirata
  con fallback o testo hardcoded.
- Le correzioni devono verificare sia il codice chiamante sia il file lingua;
  il solo conteggio dei segmenti non dimostra che la foglia esista.
- I cataloghi legacy possono contenere forme più brevi: non si rinominano in
  modo massivo senza una migrazione coordinata e una verifica dei riferimenti.

## Conferma

- Durante la review, ogni chiave nuova viene scomposta nei cinque elementi:
  namespace, file, collezione, chiave e tipo.
- Si verifica che la foglia risolva una stringa e non un array.
- Si controllano i cataloghi delle lingue supportate e le occorrenze con:

  ```bash
  rg "__\\(|trans\\(" Modules Themes
  ```

- Le modifiche al codice aggiungono un `@see` al documento owner; le modifiche
  a un'Action con effetti collaterali mantengono anche il relativo `@contract`.

## Verifica

Solo revisione: non è stato individuato un test automatico che controlli la forma delle chiavi di traduzione
(controllato il 2026-11-24: nessun file PHP di moduli o temi cita questo ADR). Il controllo ripetibile è la scomposizione in cinque elementi
descritta in Conferma e la ricerca delle occorrenze con `rg "__\\(|trans\\(" laravel/Modules laravel/Themes`; il
debito è dichiarato: una regola eseguibile sulla struttura delle chiavi va scritta da chi possiede i cataloghi (Lang).
