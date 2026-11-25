---
title: "Dati dell'ente (EnteData e GetEnteDataAction)"
type: reference
module: Tenant
updated: 2026-11-25
qmd: "ente data GetEnteDataAction config ente telefono email pec url social normalizzazione replaceMatches Safe preg_replace regressione sync"
---

# Dati dell'ente

Le informazioni di contatto dell'ente (nome, indirizzo, PEC, telefono, DPO, orari, social) stanno nel file
`config/<tenant>/ente.php`. Il modulo le restituisce **gia' ripulite** a chi deve stamparle (footer, pagina contatti,
privacy), cosi' i template non validano nulla.

```php
$ente = app(\Modules\Tenant\Actions\Ente\GetEnteDataAction::class)->execute('it'); // o senza lingua: usa quella corrente
$ente->name;                    // stringa, mai null
$ente->link('phone');           // ['label' => '+39 06 1234', 'href' => 'tel:+39061234'] oppure null
$ente->hasContacts();           // true se almeno un campo di contatto non e' vuoto
```

## Come legge

`GetEnteDataAction` legge `config('ente')` con la funzione di Laravel, non passa dall'Action di overlay: funziona perche'
`TenantServiceProvider::mergeConfigs()` ha gia' sovrapposto ogni file della cartella tenant all'avvio
([configuration](configuration.md)). Un tenant senza `ente.php` ottiene un `EnteData` tutto vuoto.

## Regole di normalizzazione

Contratto con gli invarianti `TENANT-ENTE-INV-1..6`: [get-ente-data-action](contracts/get-ente-data-action.md). In sintesi:

- **Un valore mancante o non valido e' la stringa vuota**, mai un segnaposto: il template decide cosa mostrare.
- **Testi per lingua**: un campo puo' essere una stringa o una mappa `lingua => stringa`; vale la lingua richiesta, poi
  `app.fallback_locale`, poi il primo valore stringa. Si tolgono i caratteri di controllo tranne a capo e tabulazione
  (indirizzo e orari possono andare su piu' righe).
- **Telefono** (`phone`, `toll_free`): valido se, tolti spazi, punti, trattini, parentesi e barre, resta `+?` e 3-15 cifre.
  Si restituisce il valore originale; il `href` `tel:` tiene solo cifre e `+` (`EnteData::link()`).
- **Email, PEC, email del DPO**: regex semplice piu' `FILTER_VALIDATE_EMAIL`. `href` `mailto:`.
- **URL** (`region_url` e social): solo `http`/`https` con host, senza spazi, virgolette, `<>` o backslash.
- **Social**: lista di `{network, label, url, icon}`; la rete deve stare in `GetEnteDataAction::SOCIAL_NETWORKS`
  (facebook, instagram, linkedin, mastodon, telegram, tiktok, twitter, whatsapp, youtube, rss), l'URL deve essere valido,
  l'icona e' `it-<rete>` (sprite Bootstrap Italia), l'etichetta di default e' il nome della rete.

Non verifica che URL o PEC siano raggiungibili e non porta il telefono in formato internazionale.

## Pulizia con `Str::of()->replaceMatches()`

Le pulizie con regex (`GetEnteDataAction::text()`, `::phone()`, `EnteData::link()`) usano
`Str::of($value)->replaceMatches($pattern, '')`, non `Safe\preg_replace`: il risultato resta sempre una stringa (niente
`string|array`) e non serve importare `Safe`. Trappola nota: lo script di sync dei moduli ha gia' riportato una volta la
versione con `Safe\preg_replace` nei due file; se la si trova, si ripristina `Str` (comportamento identico). Guardia:
`tests/Unit/Actions/Ente/GetEnteDataActionTest.php`.
