---
title: "RegisterWidget: cosa possiede il modulo e cosa il tema"
type: note
tags: [registrazione, traduzioni, test, project-agnostic]
created: 2026-11-19
updated: 2026-11-19
qmd: "register widget copy ownership"
related:
  - "register-widget.md"
  - "stories/register-copy-project-agnostic.story.md"
---

# RegisterWidget: cosa possiede il modulo e cosa il tema

Il modulo Gdpr e' condiviso tra progetti (repo `laraxot/module_gdpr_fila5`). Possiede il **modulo di registrazione**
(campi, consensi, validazione, salvataggio), non la **pagina** che lo ospita. Titoli, sottotitoli, vantaggi, numeri,
link al login e meta SEO sono del progetto ospite e stanno nel suo tema o nelle sue traduzioni.

## Quale vista viene resa

`Filament\Widgets\Widget::render()` usa `$this->view`. `XotBaseWidget::resolveView()` la riempie con il primo nome
esistente fra:

1. `pub_theme::filament.widgets.auth.register` — la vista del tema attivo (es. `Themes/Sixteen`);
2. `gdpr::filament.widgets.auth.register` — la vista di riserva del modulo.

`RegisterWidget` non ridefinisce `getView()`: lo faceva restituendo `filament.widgets.auth.register` senza
namespace, metodo che nessuno chiamava e che funzionava solo perche' la cartella del tema e' nel percorso viste di
default.

## Il contratto che ogni vista rispetta

Tema o modulo, la vista del widget deve rendere:

| Elemento | Valore |
|---|---|
| form | `wire:submit="submit"` |
| campi | `wire:model` su `first_name`, `last_name`, `email`, `password`, `password_confirmation` |
| etichette dei campi | `gdpr::register.fields.<campo>.label` — le stesse di `RegisterWidget::validationAttributes()` |
| consensi | `wire:model` su `privacy_accepted`, `terms_accepted`, `marketing_consent` |
| testi dei consensi | `gdpr::register.consents.privacy_policy_label` / `terms_label` / `marketing_label` |
| link ai documenti | `consents.privacy_policy_link`, `consents.terms_link`, con `consents.opens_new_tab` per i lettori di schermo |

Il pulsante di invio non fa parte del contratto: la vista del modulo usa `gdpr::register.form.submit`, il tema puo'
usare la propria chiave (Sixteen usa `user::registration.actions.register.label`).

## Testi neutri

`lang/<lingua>/register.php` ha le stesse chiavi in it, en, de, es (le voci `navigation`, `label`, `plural_label`
sono impalcatura e restano escluse dal confronto). Nessuna frase nomina un prodotto, una comunita', un prezzo o un
servizio di un progetto. Un progetto che vuole un testo diverso lo sovrascrive in
`laravel/lang/vendor/gdpr/<lingua>/register.php`, senza toccare il modulo.

Rimosse il 2026-11-19 perche' descrivevano un altro prodotto e nessun codice le leggeva: `stats.*`, `benefits.*`,
`social_proof`, `clickbait.*`, `seo.*`, `sections.trust_badges`, `sections.benefits`, e tutti i file
`lang/*/new-keys.php`. Un tema che le usava deve portarle nelle proprie traduzioni.

## Cosa provano i test

- Pagina `/<lingua>/auth/register`: risponde, ha `lang` giusto, contiene il widget e i testi del contratto sopra;
  non contiene chiavi grezze `gdpr::register.`. Non controlla titolo, sottotitolo o link al login della pagina.
- Vista di riserva del modulo resa da sola, in ogni lingua: stesso contratto.
- Traduzioni: stesse chiavi in it/en/de/es, ogni chiave letterale usata dal codice del modulo esiste in ogni lingua,
  nessuna parola di un progetto nei file di lingua.

Guardia: `Modules/Gdpr/tests/Feature/RegisterWidgetContractTest.php`.
