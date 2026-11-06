---
issues: []
discussions: []
title: "MailTemplate slug: preventOverwrite obbligatorio"
type: concept
status: canonical
module: Notify
created: 2026-09-10
updated: 2026-09-10
tags: [mail-template, slug, sluggable, spatie-email, gotcha]
qmd: "mail template slug preventOverwrite hasSlug regenerate subject spatieemail counter update missingmailtemplate"
related:
  - ./one-migration-consolidamento-wave2.md
  - ../../../../Quaeris/docs/stories/quaeris-send-invite-migrate-to-record-notification.md
---

# `MailTemplate::getSlugOptions()` deve avere `->preventOverwrite()`

## Regola

```php
public function getSlugOptions(): SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('subject')
        ->saveSlugsTo('slug')
        ->preventOverwrite();   // ← non opzionale
}
```

Senza `preventOverwrite()`, `Spatie\Sluggable\HasSlug` rigenera lo `slug` da
`subject` ad **ogni** `save()`/`update()` con eventi attivi: non solo alla
creazione.

## Perché è un problema concreto

`Modules\Notify\Emails\SpatieEmail::__construct()`, ad **ogni istanziazione**,
fa `firstOrCreate(...)` seguito da `$tpl->update(['counter' => $tpl->counter + 1])`.
Quell'`update()` fa scattare `HasSlug`: uno slug impostato a mano: dalla scheda
"Inviti" (`ManageMailTemplates`, convenzione `survey-pdf-<id>-<nome>`) o dallo
script `notify:migrate-themes-to-mail-templates`: viene riscritto col
subject-slug. Il lookup successivo `getMailTemplate()` → `findForMailable()`
cerca lo slug originale, non lo trova, e lancia
`Spatie\MailTemplates\Exceptions\MissingMailTemplate`.

Con `preventOverwrite()` lo slug si genera solo quando il campo è vuoto; un
valore già presente sopravvive a qualunque save.

## Storia

- Il comando di migrazione (story `quaeris-send-invite-migrate-to-record-notification.md`,
  Task 4) avvolgeva le scritture in `MailTemplate::withoutEvents(...)` proprio per
  aggirare questo (Difetto 6). Sintomo curato lì, causa non rimossa.
- Difetto 10 (2026-09-10): l'impatto sul flusso di invio reale è emerso solo
  testando il passo 3 del Difetto 9 (`RecordNotification::toSms()` che legge
  `sms_from`). Fix applicato alla causa: `->preventOverwrite()` in
  `getSlugOptions()`. Il `withoutEvents(...)` nello script resta come difesa in
  profondità, ridondante ma innocuo.

## Se lo slug è già corrotto in DB

Ripristino via query grezza, **mai** Eloquent (che ri-triggererebbe HasSlug):

```php
DB::connection('notify')->table('mail_templates')
    ->where('id', $id)->update(['slug' => 'survey-pdf-44-invito']);
```
