---
title: "Seo: condivisione social"
type: concept
status: active
module: Seo
tags: [seo, social, share, widget, blade, i18n]
qmd: "seo social share condivisione link facebook twitter linkedin whatsapp telegram copy SocialShareData GenerateSocialShareLinksAction widget blade component"
related:
  - ./architecture.md
  - ./metatag.md
---

# Condivisione social

Link di condivisione per pagine e dettagli (articolo, evento, scheda), senza pacchetti Composer: le URL si costruiscono
in PHP, le icone sono componenti Blade del modulo e il "copia link" usa Alpine.js.

## Dati e Action

- `Modules\Seo\Datas\SocialShareData` (Spatie Laravel Data): `url` (obbligatoria), `title`, `text`, `image`, `hashtags`
  (separati da virgola), `via` (handle della fonte) e `platforms` (default `facebook, twitter, linkedin, whatsapp,
  telegram, copy`).
- `Modules\Seo\Actions\GenerateSocialShareLinksAction::execute(SocialShareData): array<string, string>` restituisce una
  mappa piattaforma => URL, con i valori passati a `urlencode`. Il testo e' `text`, altrimenti `title`, altrimenti vuoto.

| Piattaforma | URL costruito |
|-------------|---------------|
| `facebook` | `https://www.facebook.com/sharer/sharer.php?u={url}` |
| `twitter` | `https://twitter.com/intent/tweet?url={url}&text={testo}` + `&via=` e `&hashtags=` se valorizzati |
| `linkedin` | `https://www.linkedin.com/sharing/share-offsite/?url={url}` |
| `whatsapp` | `https://api.whatsapp.com/send?text={testo} {url}` |
| `telegram` | `https://t.me/share/url?url={url}&text={testo}` |
| `copy` | l'URL stesso (non codificato): la copia negli appunti e' lato client |

## Vista e widget

- Componente Blade `seo::social-share` (`resources/views/components/social-share.blade.php`): prop `data`
  (`SocialShareData`) e `variant` (`horizontal` default, `vertical`, `grid`). Chiama l'Action, disegna un link per ogni
  piattaforma richiesta; per `copy` usa Alpine.js con `navigator.clipboard` e ripiego su `document.execCommand('copy')`.
- Icone: `resources/views/components/icons/{facebook,twitter,linkedin,whatsapp,telegram,link,check}.blade.php`, usate
  come `<x-seo::icons.facebook class="h-6 w-6" />`.
- `Modules\Seo\Filament\Widgets\SocialShareWidget` (estende `XotBaseSchemaWidget`, vista
  `seo::filament.widgets.social-share`): per default condivide `url()->current()` con titolo `config('app.name')`.

## Traduzioni

I testi dell'interfaccia non sono scritti a mano nel componente (e' riusato da piu' temi): chiavi `seo::social_share.*`
(`widget_title`, `actions.share.title`, `actions.copy_link.title`, `messages.link_copied.message`), presenti in
`lang/it`, `lang/en`, `lang/de`, `lang/es`.

## Note di progetto

- Nessun pacchetto terzo dedicato alla condivisione: per link semplici l'Action e' piu' leggera e senza dipendenze.
- Test: `tests/Unit/Actions/GenerateSocialShareLinksActionTest.php`, `tests/Unit/Datas/SocialShareDataTest.php`,
  `tests/Unit/Filament/Widgets/SocialShareWidgetTest.php` (con `tests/Fixtures/ExposedSocialShareWidget.php`).
