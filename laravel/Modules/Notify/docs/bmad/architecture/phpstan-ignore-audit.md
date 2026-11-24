---
title: "Audit @phpstan-ignore in Notify"
type: report
created_at: '2026-09-01'
qmd: "audit phpstan ignore soppressioni notify trait unused rate limiting"
---

# Audit `@phpstan-ignore`: Notify

1 solo `@phpstan-ignore` nel modulo: `app/Traits/HasNotificationRateLimiting.php:13`,
`trait.unused`.

**Verdetto: legittimo, non è debito nascosto.** Il trait implementa `shouldSendNotification()`,
`getNotificationRateLimitRetryAfter()`, `getNotificationRateLimitRemainingAttempts()`,
`resetNotificationRateLimit()`: quattro metodi protetti pensati per essere consumati
da classi che estendono il trait, non da chiamanti esterni. `trait.unused` di PHPStan
misura solo l'uso *diretto* (`use HasNotificationRateLimiting;` in un'altra classe di
questo repo): grep conferma zero `use` nel codice applicativo. È coerente col pattern
già documentato altrove nel progetto ("trait pubblico della piattaforma senza consumer
in questo repo, non un errore da correggere"): la logica (rate limiting via
`Illuminate\Cache\RateLimiter`, con `Webmozart\Assert\Assert` per restringere i valori
di config) è corretta e testabile isolatamente; la soppressione resta finché non ha un
consumer reale o viene rimossa come API non usata.

**Non modificato**: né il trait né la soppressione.
