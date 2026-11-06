---
title: "[STORY] AI: PHPStan swarm wave AIService"
type: story
module: AI
status: done
priority: high
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, phpstan, swarm, aiservice, missingType.iterableValue, method.unused]
qmd: "ai phpstan swarm wave AIService parseResponse array string mixed namespace App Services"
related:
  - ./services-to-actions-ai.story.md
  - ./phpstan-cleanup-ai.story.md
  - ../wiki/concepts/ai-services-support-to-actions.md
  - ../00-INDEX.md
---

# [STORY] AI: PHPStan swarm wave AIService

## Claim

- Task: `phpstan-ai` / agent `swarm-ai` (questa lane)
- Peer parallelo: `phpstan-wave-ai` / `lane-ai` (ha scritto i due file PHP prima del gate lock+mtime)
- Ground truth: `.cursor-scratch/phpstan-wave/AI.tsv` (33 errori, 2 file)
- Verify: `.cursor-scratch/phpstan-wave/AI.verify.txt` (exit 0)

## Scopo

`AIService` e' il facade legacy FixCity (ticket cittadini): prompt → chiamata OpenAI → risposta JSON → array tipizzato per classificazione, soluzioni, sentiment, priorita', routing, pattern, miglioramenti. Le Actions vive (`ClassifyTicketAction`, `SuggestSolutionsAction`, `AiJsonResponseDecoderAction`) coprono gia' i flussi usati; il Service e' rimasto nel tree dopo un merge (vedi [services-to-actions-ai](./services-to-actions-ai.story.md)) e deve comunque rispettare PHPStan se presente.

## Causa radice

1. **`missingType.iterableValue`**: parametri/return `array` senza value type (PHPDoc `array<string, mixed>` / `list<array<string, mixed>>` assenti).
2. **`method.unused` su `parse*Response`**: i metodi pubblici mettevano in cache la **stringa** di `makeAIRequest` e la restituivano come `array` (Assert/is_array errati). I parser esistevano ma non erano collegati → bug di contratto + dead code statico.
3. **`class.notFound` nel test**: `use Modules\AI\App\Services\AIService` (namespace `App\` illegale nel modulo; classe reale `Modules\AI\Services\AIService`).

## Fix (applicato dalla peer lane sui file PHP)

- Collegati i `parse*Response` dopo la cache: la cache resta sulla stringa JSON (allineata alle Actions), poi decode → `array<string, mixed>`.
- Helper privato `decodeOrDefault` via `AiJsonResponseDecoderAction` (decode difensivo: JSON invalido → default del flusso, non eccezione `Safe\json_decode`).
- PHPDoc su tutti i confini `array`.
- Test Pest: namespace corretto, Http/Cache fake, asserzioni `Assert::` piatte (niente `@phpstan-ignore`).

Questa lane **non ha editato** i due PHP: al primo tocco erano `LOCKED` da `lane-ai` e caldi (mtime &lt; 120s) → SKIP per protocollo swarm. Ha eseguito solo verify + docs.

## Verifica

```bash
cd laravel && nice -n 10 ./vendor/bin/phpstan analyse \
  Modules/AI/app/Services/AIService.php \
  Modules/AI/tests/Unit/Services/AIServiceTest.php \
  --memory-limit=2G --no-progress --error-format=raw \
  > ../../.cursor-scratch/phpstan-wave/AI.verify.txt 2>&1
```

| Metrica | Valore |
|---|---|
| Errori iniziali (TSV) | 33 |
| Errori finali (verify) | 0 |
| Exit code verify | 0 |
| File PHP saltati (lock peer) | `AIService.php`, `AIServiceTest.php` |
| File docs aggiornati | questa story, [00-INDEX.md](../00-INDEX.md) |

## Note

Non eliminare `AIService` in questa wave: decisione di product/dead-code gia' in [ai-services-support-to-actions](../wiki/concepts/ai-services-support-to-actions.md). Qui solo ripristino del contratto tipizzato e wiring dei parser.

Spike fleet ~12:21 (`phpstan.parse`, marker merge cross-modulo): **`parse` ≠ tipo** — hub [Lang phpstan-lang-zero](../../Lang/docs/stories/phpstan-lang-zero.story.md).
