# Headernav Auth CTA: Localization + UI/UX

## Obiettivo

Evitare label italiane fuori da locale `it` e migliorare la qualita' visuale/accessibile dei bottoni `login/register` in header.

## Requisiti funzionali

1. Le label devono provenire da traduzioni tema:
   - `pub_theme::navigation.auth.login`
   - `pub_theme::navigation.auth.register`
2. Gli URL devono essere localizzati.
3. Nessun fallback hardcoded italiano quando la lingua corrente non e' `it`.

## Requisiti UI/UX

1. Gerarchia chiara:
   - login = azione secondaria (outline/ghost)
   - register = azione primaria (filled)
2. Stati interattivi consistenti:
   - hover
   - focus-visible con ring ben visibile
3. Testo breve e chiaro.

## Riferimenti esterni

- WCAG Focus Visible (SC 2.4.7): https://www.w3.org/WAI/WCAG22/Understanding/focus-visible
- web.dev focus styles: https://web.dev/articles/style-focus
- guideline button hierarchy (primary vs secondary): https://designsystem.gov.scot/components/button

## Verifica

- Test Pest per evitare regressioni su chiavi traduzione e stringhe legacy.
- Controllo manuale in almeno due lingue (`it`, `en`).
