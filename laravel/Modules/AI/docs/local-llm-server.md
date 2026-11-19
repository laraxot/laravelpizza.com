---
title: "Server AI locale (colibri, Ollama, llama.cpp): fornitore `local`"
type: guide
status: active
module: AI
created: 2026-11-18
updated: 2026-11-18
related:
  - ./vision-openrouter.md
qmd: "ai locale colibri ollama llama.cpp lm studio openai compatibile vision menu foto gratis privacy fornitore local moe"
---

# Server AI locale: il fornitore `local`

## In una riga

Oltre a Groq e OpenRouter il modulo AI parla con **qualunque server sul proprio computer o in sede**
che esponga l'API OpenAI (`/v1/chat/completions`): [colibri](https://github.com/JustVugg/colibri),
Ollama, llama.cpp, LM Studio. È gratis, non ha limiti di richieste e le foto non escono dal locale.
In cambio è più lento, soprattutto senza GPU.

## colibri in breve

| Aspetto | Dettaglio |
|---|---|
| Cos'è | motore di inferenza in C per modelli MoE molto grandi: esperti "caldi" in GPU, "tiepidi" in RAM, "freddi" letti dall'NVMe |
| Licenza | Apache-2.0 (ogni modello ha la sua: LFM3-VL ha la LFM Open License, Qwen-Image-2.1 è non commerciale) |
| API | OpenAI `/v1/chat/completions` e Anthropic `/v1/messages`, porta 8000, chiave solo se si avvia con `COLI_API_KEY` |
| GPU | facoltativa: CUDA, Vulkan (anche integrate AMD/Intel), Metal |
| Vista | immagini in ingresso (`image_url` anche data URI) su Qwen3.8-27B, Qwen3.8-Flash-Next, LFM3-VL, MiMo-V2.6, GLM-5.3-Flash, DeepSeek V4.1 Flash, Mistral-Large-4 |
| Limite per noi | **non accetta `response_format`** sul motore qwen36 (risponde 400): per questo il fornitore `local` di default non lo manda e mette lo schema nel prompt |
| Extra | API "System One" (`/v1/systemone`): sceglie tra etichette date e ne restituisce le probabilità (utile per classificazioni) |

### Modelli adatti alla lettura dei menu

| Modello | Download | RAM | Nota |
|---|---|---|---|
| **Qwen3.8-27B** (int4) | 56 GB → 51 GB | 20 GB (int4) / 30 GB (int8) | lo stesso modello che usiamo su Groq (`qwen/qwen3.8-27b`): stessa qualità, in locale |
| LFM3-VL-2B (GGUF Q4_K_M + mmproj) | 1,1 GB + 0,4 GB | 2,1 GB | piccolo: per prove o macchine modeste |

## Prova reale (18/11/2026)

colibri compilato dal sorgente (`make qwen36`, 34 s), LFM3-VL-2B Q4_K_M, container cloud con **2 vCPU e
7 GB di RAM, senza GPU**. Lettura della foto di prova del menu (1029×1400) con la stessa azione del modulo
Restaurant (`ReadMenuPhotoAction` → `ExtractStructuredDataFromImagesAction`, fornitore `local`):

- funziona end-to-end, due prove: **10 piatti su 10** con categorie e prezzi giusti, legenda allergeni
  completa (14 voci), JSON valido senza `response_format`;
- **470 e 482 secondi** (Groq: 2,4–4,4 s). Su 2 vCPU senza GPU è il caso peggiore;
- il modello da 2B lascia i numeri degli allergeni e "vegano" nel nome ("Tiramisù della casa (1, 3, 7)")
  invece di metterli in `allergen_codes`/`diets`. Il modulo Restaurant ora li recupera dal nome
  (`BuildMenuImportResultAction::codesFromName()` / `dietsFromName()`), per qualunque modello. Per la
  qualità migliore resta consigliato Qwen3.8-27B.

Su una workstation con 12+ core, 64+ GB di RAM e GPU integrata Vulkan i tempi scendono di molto (il README
di colibri riporta per LFM3-VL-2B 34,5 token/s su CPU desktop e 214 con Vulkan su GPU dedicata).

## Configurazione

`config/services.php`:

```php
'local_ai' => [
    'url' => env('LOCAL_AI_URL', 'http://127.0.0.1:8000/v1'),   // Ollama: http://127.0.0.1:11434/v1
    'key' => env('LOCAL_AI_KEY'),                                // solo se il server la chiede
    'timeout' => env('LOCAL_AI_TIMEOUT', 600),
    'response_format' => env('LOCAL_AI_RESPONSE_FORMAT', 'none'), // none | json_object | json_schema
],
```

Impostazioni AI (pannello): aggiungere `local` ai fornitori immagini (per esempio dopo `groq`, come
riserva gratuita quando Groq dà 429) e scrivere in `vision_models.local` **l'id del modello come lo
conosce il server** (colibri: quello di `--model-id`; Ollama: per esempio `qwen2.5vl:7b`). colibri
rifiuta con 404 un id diverso.

| `response_format` | Quando |
|---|---|
| `none` (default) | colibri, o qualunque server: lo schema va nel prompt, il JSON si legge anche dentro ```json |
| `json_object` | Ollama, llama.cpp, LM Studio: forzano JSON valido |
| `json_schema` | server che applicano lo schema (llama.cpp con grammatiche, Ollama recenti) |

## Avvio rapido con colibri

```bash
git clone --depth 1 https://github.com/JustVugg/colibri && cd colibri
./start-here.sh                       # sceglie il modello per la macchina e lo scarica
# oppure a mano, modello piccolo:
cd c && make qwen36
coli import LFM3-VL-2B-Q4_K_M.gguf    # con mmproj-LFM3-VL-2B-BF16.gguf nella stessa cartella
coli serve --model LFM3-VL-2B-Q4_K_M.colibri --port 8090 --model-id lfm3-vl-2b
```

Se l'app Laravel gira sulla porta 8000 (php artisan serve), usare un'altra porta per colibri.
Prima di esporlo in rete: `COLI_API_KEY=...` e la stessa chiave in `LOCAL_AI_KEY`.

## Codice

- `Enums/AiProviderEnum::Local`: `baseUrl()` da config, `requiresKey()` false, `jsonMode()`, `timeout()`.
- `OpenAiCompatibleRequestAction`: senza chiave manda `Bearer local` (alcuni server vogliono un valore).
- `ExtractStructuredDataFromImagesAction`: `response_format` secondo `jsonMode()`; schema nel prompt se
  il server non lo applica.
- Test: `tests/Unit/Vision/VisionActionsTest.php` (fornitore locale senza chiave, URL, JSON mode, timeout).
