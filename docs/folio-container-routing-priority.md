# Folio Container Routing Priority: index.blade.php vs [slug].blade.php

## Problema

Per la URL `/it/events/laravel-beginners-pizza-night`, Folio usa `[container0]/[container1]/index.blade.php` invece di `[container0]/[slug].blade.php`.

## Causa Tecnica: La Pipeline di Folio

Il file `vendor/laravel/folio/src/Router.php` (linee 55-81) esegue un ciclo `for` su ogni segmento URL. Per ogni segmento, passa lo stato attraverso una **Pipeline** con quest'ordine **fisso e non modificabile**:

```
Step 1: MatchRootIndex                               → /
Step 2: MatchDirectoryIndexViews                      → dir/index.blade.php (dir letterale)
Step 3: MatchWildcardViewsThatCaptureMultipleSegments → [...param].blade.php
Step 4: MatchLiteralDirectories                       → events/ (cartella statica, ContinueIterating)
Step 5: MatchWildcardDirectories                      → [param]/ (cartella parametrica)
Step 6: MatchLiteralViews                             → about.blade.php (file letterale)
Step 7: MatchWildcardViews                            → [slug].blade.php (file parametrico)
```

**Il primo step che trova un match restituisce `MatchedView` e la pipeline si ferma.**

### Il Codice Sorgente Chiave

**MatchWildcardDirectories.php** — Il colpevole:
```php
public function __invoke(State $state, Closure $next): mixed
{
    if ($directory = $this->findWildcardDirectory($state->currentDirectory())) {
        $currentState = $state->withData(/* ... */)->replaceCurrentUriSegmentWith(/* ... */);

        if (! $currentState->onLastUriSegment()) {
            return new ContinueIterating($currentState);  // Non ultimo segmento → avanti
        }

        // Ultimo segmento + index.blade.php esiste → MATCH IMMEDIATO
        if (file_exists($path = $currentState->currentUriSegmentDirectory().'/index.blade.php')) {
            return new MatchedView($path, $currentState->data);
        }
    }
    return $next($state);  // Solo se nessun match → passa a Step 6, 7
}
```

`MatchWildcardDirectories` (Step 5) trova `[container1]/index.blade.php` e restituisce il match **prima** che `MatchWildcardViews` (Step 7) possa trovare `[slug].blade.php`.

## Trace per `/events/laravel-beginners-pizza-night`

### Iterazione 0 — Segmento `events`
- Step 5 (`MatchWildcardDirectories`): trova `[container0]/` → non ultimo segmento → **ContinueIterating**

### Iterazione 1 — Segmento `laravel-beginners-pizza-night`
- Step 2 (`MatchDirectoryIndexViews`): `is_dir('pages/[container0]/laravel-beginners-pizza-night')`? NO → `$next()`
- Step 5 (`MatchWildcardDirectories`): `findWildcardDirectory()` → trova `[container1]/`! Ultimo segmento + `index.blade.php` esiste → **MatchedView**
- Step 7 (`MatchWildcardViews`): **MAI RAGGIUNTO** (troverebbe `[slug].blade.php`)

## Regola Fondamentale

Per l'ultimo segmento URL, la priorita' e':

| Priorita' | Tipo | Pipeline Step |
|-----------|------|--------------|
| 1 (alta) | cartella letterale + `index.blade.php` | MatchDirectoryIndexViews (Step 2) |
| 2 | cartella parametrica `[x]/` + `index.blade.php` | MatchWildcardDirectories (Step 5) |
| 3 | file letterale `nome.blade.php` | MatchLiteralViews (Step 6) |
| 4 (bassa) | file parametrico `[param].blade.php` | MatchWildcardViews (Step 7) |

**`[container1]/index.blade.php` (tipo 2) vince SEMPRE su `[slug].blade.php` (tipo 4).**

### Ordine di Precedenza Cartella Letterale vs Parametrica

Quando esistono entrambe:
- `pages/events/[slug].blade.php` → usa Step 4 (`MatchLiteralDirectories`) poi Step 7 → **vince**
- `pages/[container0]/[slug].blade.php` → usa Step 5 (`MatchWildcardDirectories`) poi Step 7

La cartella letterale `events/` (Step 4) ha priorita' su `[container0]/` (Step 5).

## Soluzioni per Dare Priorita' a `[slug].blade.php`

### Soluzione 1: Rimuovere `[container1]/index.blade.php` (Piu' semplice)

```bash
rm "pages/[container0]/[container1]/index.blade.php"
rmdir "pages/[container0]/[container1]/"
php artisan view:clear && php artisan route:clear
```

### Soluzione 2: Usare Cartelle Letterali (Consigliata per LaravelPizza)

```
pages/
├── [slug].blade.php               → /{slug} (CMS catch-all)
└── events/
    └── [slug].blade.php           → /events/{slug}
```

### Soluzione 3: Folio Model Binding con FQCN (Attualmente usata)

```
pages/
├── [slug].blade.php                                    → /{slug}
└── events/
    └── [.Modules.Meetup.Models.Event].blade.php        → /events/{slug}
```

## Pattern Consigliato per LaravelPizza

```
pages/
├── index.blade.php                                    → / (home)
├── [slug].blade.php                                   → /{slug} (CMS catch-all)
├── auth/...
└── events/
    └── [.Modules.Meetup.Models.Event].blade.php       → /events/{slug} (model binding)
```

**✅ USARE `[container0]/` per contenuti CMS-driven nested** — Pattern generico DRY + scalabile. Vedi [Container0 Pattern Philosophy](container0-pattern-philosophy.md) per la filosofia completa.

## Riferimenti

- Documentazione completa con trace dettagliato: `Modules/Meetup/docs/folio-container-routing-priority.md`
- Codice sorgente: `vendor/laravel/folio/src/Router.php`
- [Folio Routing](folio-routing.md)
