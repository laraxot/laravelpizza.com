---
title: "Topic cookie-consent"
type: digest
status: active
qmd: "digest ceiling 100 cookie-consent"
---

# Topic cookie-consent

Sintesi automatica di 5 documenti (chiave `cookie-consent`).

## cookie-consent

_Fonte: `_integration/cookie-consent.md`_



## Cookie Consent

_Fonte: `cookie-consent-3.md`_

# Cookie Consent

---
title: "cookie consent"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "cookie consent"
issues: []
discussions: []
module: theme
topic: cookie_consent
canonical: ../../../Themes/docs/shared-components/cookie-consent.md
---

See canonical documentation: ../../../Themes/docs/shared-components/cookie-consent.md

## cookie-consent

_Fonte: `cookie-consent.md`_

https://github.com/whitecube/laravel-cookie-consent

https://devpeel.com/how-to-add-gdpr-cookie-consent-in-laravel/#google_vignette

https://codebrisk.com/blog/make-your-laravel-app-compliant-with-the-eu-gdpr-cookie-law

https://github.com/statikbe/laravel-cookie-consent

https://github.com/scify/laravel-cookies-consent

## cookie-consent

_Fonte: `packages/cookie-consent.md`_

See canonical documentation: ../../../../Themes/docs/shared-components/.gitkeep

## Implementazione Cookie Consent

_Fonte: `roadmap/cookie-consent.md`_

# Implementazione Cookie Consent

## Stato
- **Completamento**: 90%
- **Priorità**: Alta
- **Difficoltà**: Media

## Descrizione
Implementazione del sistema di gestione del consenso ai cookie conforme al GDPR, con supporto per:
- Categorizzazione cookie
- Gestione preferenze
- Log consensi
- Banner personalizzabile

## Architettura
```php
class CookieConsentController extends Controller
{
    public function show()
    {
        return view('gdpr::cookie-consent', [
            'categories' => CookieCategory::all(),
            'preferences' => auth()->user()?->cookiePreferences
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
