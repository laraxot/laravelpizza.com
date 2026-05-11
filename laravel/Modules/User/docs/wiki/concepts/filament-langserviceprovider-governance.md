---
type: concept
module: User
confidence: high
updated: 2026-04-20
sources:
  - ../../../app/Filament/Pages/SocialiteProviderSettingsPage.php
  - ../../../app/Filament/Resources/SocialProviderResource.php
  - ../../../lang/it/auth.php
---

# filament langserviceprovider governance

## regola non negoziabile

Nei componenti Filament del modulo `User` non si devono usare `->label()` e `->tooltip()` hardcoded o con traduzioni inline.

La label deve essere risolta dal `LangServiceProvider` e dai file lingua del modulo.

## motivo tecnico

- evita drift tra UI e traduzioni
- riduce duplicazione e regressioni
- mantiene i temi sottili e i moduli come fonte di verita della copy

## anti-regressione operativa

Prima di chiudere una modifica su Filament:

1. cercare `->label(` e `->tooltip(` nei file toccati
2. rimuovere override non indispensabili
3. aggiungere/aggiornare chiavi in `lang/*` con struttura coerente
4. aggiornare wiki log modulo + root

## note pratiche

- per componenti come `Placeholder`, usare `->hiddenLabel()` quando serve nascondere titolo e non forzare testi
- evitare stringhe italiane letterali nelle view tema; usare sempre chiavi `user::...`

## riferimenti

- [socialite-provider-governance](./socialite-provider-governance.md)
- [socialite-admin-tutorial](./socialite-admin-tutorial.md)
- [login-page-design-comuni](./login-page-design-comuni.md)
