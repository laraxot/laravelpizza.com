---
title: "Niente testi fissi nelle Blade del modulo Notify (multilingua it/en/de/es)"
type: story
status: implemented
module: Notify
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Notify

## GitHub (tracciamento)

| Tipo | Repo | # | URL |
|------|------|---|-----|
| Issue (coordinamento) | laraxot/base_techplanner_fila5 | 18 | https://github.com/laraxot/base_techplanner_fila5/issues/18 |
| **Discussion** (canon) | laraxot/base_techplanner_fila5 | 54 | https://github.com/laraxot/base_techplanner_fila5/discussions/54 |

Nulla e' stato pubblicato da questa story: i riferimenti servono al tracciamento.

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('notify::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave.
- La stringa va in `Modules/Notify/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori del modello, frammenti di direttive Blade, stub e pagine di sviluppo non instradati.

## Cosa e' stato fatto

- Prima di questa story il modulo non aveva un documento di tracciamento per la campagna. La misura di partenza e' quella della passata 2026-10-30 qui sotto (32 occorrenze in 16 file).

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md).

## Dev Agent Record

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: Notify)

Scanner `Modules/Notify`: prima 32 occorrenze in 16 file (21 text, 6 attr, 5 url-literal), dopo 32 in 16 file (invariato). Escluse le 5 `url-literal`, le occorrenze utili sono 27 prima e 27 dopo. Lo scanner non vedeva il difetto vero: 6 Blade usavano 31 chiavi `notify::...` che non esistono in nessun file lingua (in pagina uscivano le chiavi grezze).

- Blade toccate (6): `filament/resources/mail-template-resource/pages/preview-mail-template`, `filament/resources/notification-template-resource/pages/preview-notification-template`, `mail/welcome`, `mail/newsletter`, `mail/promotion`, `mail/transactional/order-confirmation`. Le chiavi sono state riscritte a cinque elementi (`notify::mail_welcome.sections.header.title` ecc.).
- Chiavi nuove in `it`, `en`, `de`, `es` (31 per lingua): `preview_mail_template` (4: oggetto, versione HTML, versione testo, variabili), `preview_notification_template` (2), `mail_welcome` (5), `mail_newsletter` (4), `mail_promotion` (4), `mail_order_confirmation` (12). I file sono nuovi tranne `it/preview_mail_template.php` e `it/preview_notification_template.php`, che esistevano con altre chiavi e sono stati estesi senza toccarle.
- Attenzione: per queste chiavi non esisteva alcun testo originale. I testi `it` sono scritti ex novo (nessun «identico al byte» possibile), `en`/`de`/`es` ne sono la traduzione (`de` con «Sie», `es` e `it` con il «tu» come nel resto del progetto). Da far rivedere a chi conosce il tono delle mail.
- Controlli: `check-blade-keys` su `Modules/Notify` da 31 chiavi mancanti (tutte e quattro le lingue) a 0; compilazione Blade 85 file, 1 non compila (`admin/index/acts/manage_template`, gia' rotta prima, la sistema un altro agente); `php -l` pulito sui file lingua toccati; `check-key-shape`: nessuna delle chiavi nuove e' tra le storte.
- Residui (27 + 5 `url-literal`): mail e template di esempio (`emails/samples/*`, `emails/welcome`: «Hello World», «This is a test», «Welcome Steve»... sono contenuto dimostrativo, 17), `components/mail/message` («Hello», componente non usato), stub `index` e `layouts/master` (3), `alt="Twitter"`/`alt="Facebook"` nei template mail `ark` e `sunny` e in `layouts/ark` (6, marchi). `url('/appointments/...')` nelle mail degli appuntamenti: ignorati come da brief.
- Non verificato: le sei Blade estendono `notify::mail-layouts.base.default` e nessuna classe PHP le richiama (`grep` senza esito): non ho verificato che il layout si risolva ne' che le viste siano raggiungibili; nessuna pagina o mail guardata; i testi PHP non cercati.
