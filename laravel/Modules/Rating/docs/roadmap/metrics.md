# Metriche e obiettivi di qualità

Indicatori misurabili per lo stato del modulo e il successo delle fasi.

---

## Qualità codice

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| PHPStan | 0 errori Level 10 | `./vendor/bin/phpstan analyse Modules/Rating --memory-limit=-1` da `laravel/` |
| Strict types | 100% file PHP | `declare(strict_types=1);` in ogni file |
| Return types | 100% metodi pubblici/protetti | Analisi manuale o PHPStan |
| Estensione base | Tutti i modelli | Ogni modello estende `BaseModel` del modulo |

---

## Test

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| Test esistenti | Almeno 1 test feature/unit per flusso rating | `php artisan test --filter=Rating` |
| Test passano | 100% | Nessun test skipped/failed in CI o locale |
| Test in PHPStan | Inclusi | Nessuna esclusione di `Modules/Rating/tests` in phpstan.neon |

---

## Documentazione

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| roadmap.md | Indice con link a roadmap/ | Presenza e link relativi a vision, phases, quality |
| architecture.md | Allineato a codice | Riferimenti a trait, modelli, relazioni corretti |
| roadmap/ | vision, phases, quality (+ opzionali) | File presenti e link relativi funzionanti |
| Naming .md | Solo minuscolo, no date nei nomi | Convenzioni progetto |

---

## Traduzioni

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| Chiavi navigation/fields/actions | Piene, non placeholder | Nessun valore tipo `resource.navigation` |
| Lingue | it (obbligatorio), en (opzionale) | File in `lang/it/` e eventuale `lang/en/` |

---

## Integrazione (Fase 3)

| Metrica | Obiettivo | Come verificare |
|--------|-----------|-----------------|
| Doc integrazione | Un documento o sezione dedicata | Spiega uso trait + Action da modulo consumer |
| Dipendenze circolari | Zero | Nessun use di moduli consumer in Rating |
