---
qmd: "adr presenza motori di ricerca indexnow bing sitemap robots sameAs verifica search console llms.txt motori ai"
title: "ADR — Presenza nei motori di ricerca: sitemap dichiarata, IndexNow, identità dell'entità, niente file per l'AI"
type: decision
module: Seo
status: accepted
created: 2026-11-19
updated: 2026-11-24
issues:
  - "progetto ospite #736"
  - "progetto ospite #738"
tags: [adr, seo, indexnow, schema-org, motori-ai]
---

# ADR: presenza nei motori di ricerca

## Contesto

Un sito può essere ben fatto e non esistere per i motori. Prima di salire in una pagina dei risultati bisogna esserci:
le pagine vanno **scoperte**, **indicizzate** e **riconosciute** come appartenenti a un'entità precisa (il sito, il suo
nome, i suoi profili ufficiali).

Fatti da cui parte la decisione:

- Google: le funzioni AI di Search (AI Overviews, AI Mode) usano lo stesso indice e gli stessi sistemi di ranking della
  ricerca classica. Una pagina deve essere indicizzata e idonea allo snippet; non servono file per l'AI, markup speciale
  o Markdown («Google Search itself doesn't use them»). I dati strutturati non sono necessari per l'AI ma restano utili
  per i risultati avanzati. Fonte: Google Search Central, *Optimizing your website for generative AI features on Google
  Search* e *AI features and your website*.
- IndexNow: un invio (`POST` JSON con `host`, `key`, `keyLocation`, `urlList`, al massimo 10.000 URL) viene condiviso
  da tutti i motori aderenti (Bing, Yandex, Seznam, Naver…). La chiave è pubblica: sta in `/{chiave}.txt` e serve a
  dimostrare che le URL sono del sito. Codici: 200 ricevute, 202 chiave in verifica, 403 chiave non valida, 422 URL di
  un altro host, 429 troppi invii. Fonte: indexnow.org/documentation. Google non aderisce.
- La ricerca di ChatGPT e Copilot si appoggia all'indice di Bing: essere in Bing in fretta conta anche per i motori AI.
- `robots.txt` senza riga `Sitemap:` costringe Bing e gli altri motori a scoprire la sitemap da soli; Google la riceve
  comunque da Search Console.
- Il JSON-LD della home pubblicava `Organization` con solo nome, URL e logo. `description` e `sameAs` (i profili
  ufficiali) sono i dati con cui un motore lega un nome a un'entità e la distingue da omonimi.

## Decisione

1. **Sitemap dichiarata** in `robots.txt` con URL assoluto. Il `robots.txt` dinamico del modulo
   (`BuildRobotsTxtAction`) la dichiara già con `url()`; un `robots.txt` statico del progetto la scrive col suo dominio.
2. **IndexNow** nel modulo Seo:
   - chiave nella configurazione Seo del tenant (`indexnow_key`, `SeoConfigData::indexNowKey()`); vuota = spento;
   - `GET /{chiave}.txt` → `ServeIndexNowKeyAction`, 404 per ogni chiave diversa;
   - `SubmitIndexNowAction` invia a `api.indexnow.org` solo URL dell'host del sito, a blocchi da 10.000
     ([contratto](../contracts/submit-index-now-action.md));
   - `php artisan seo:indexnow` invia le URL della sitemap **nuove o cambiate** (`<lastmod>` più recente dell'ultimo
     invio; stato URL => data in `storage/app/seo/indexnow-submitted.json`); `--all`, `--url=`, `--dry-run`. Gira a
     ogni deploy, a sito online.
   - `<lastmod>` in sitemap solo con date vere, da `SitemapLastModifiedContract` (#736).
3. **Identità dell'entità** (Xot `MetatagData`, Cms `BuildHeadSchemaAction`): in home `Organization` riceve
   `description` (la descrizione del sito) e `sameAs` (link social + `same_as` del tenant, solo URL https validi); un
   segnaposto non diventa un profilo dichiarato.
4. **Verifica dei motori**: `google_site_verification`, `bing_site_verification`, `yandex_verification` nel
   `metatag` del tenant diventano i meta di verifica in home, solo se valorizzati. La verifica via DNS resta preferibile
   (copre tutto il dominio e non dipende dal codice): i meta servono quando il DNS non è sotto controllo.
5. **Niente `llms.txt`** né altri file per l'AI: Google dichiara di non usarli e per gli altri motori non c'è uno
   standard. Si investe in pagine indicizzabili, veloci e con contenuto originale.

## Alternative scartate

- **Reinviare tutta la sitemap a ogni deploy**: IndexNow chiede URL nuove o cambiate; invii ripetuti delle stesse URL
  rischiano il 429 e non accelerano nulla. Si invia solo il nuovo; `--all` resta per i casi eccezionali (cambio di dominio).
- **Hook su ogni modello che cambia** (segnalazioni, articoli): più tempestivo, ma lega Seo ai moduli che lo usano o
  obbliga ciascuno a ricordarsene. La sitemap è già il punto in cui ogni modulo dichiara le sue pagine
  (`SitemapPathsContract`): l'invio la legge e resta agnostico. Un invio per evento si può aggiungere sopra.
- **Chiave IndexNow in `.env`**: la chiave è pubblica per protocollo; in configurazione del tenant è versionata con il
  dominio a cui appartiene e non va ricordata a ogni server.
- **`lastmod` inventato**: una data uguale per tutto (oggi) fa ignorare il campo ai motori. Da #736 le fonti che hanno
  una data vera la danno con `SitemapLastModifiedContract` (segnalazioni e articoli: `updated_at`); le pagine CMS restano
  senza `<lastmod>` perché la data del file JSON cambia a ogni checkout e non dice quando è cambiato il contenuto.
- **`llms.txt`**: costo basso ma valore non dimostrato; si rivaluta se un motore lo adotta pubblicamente.

## Conseguenze

- Una pagina nuova arriva a Bing (e quindi a ChatGPT/Copilot), Yandex, Seznam e Naver al deploy successivo, senza
  aspettare il crawler. Per Google contano la sitemap inviata da Search Console e i link interni.
- L'invio non dice che la pagina verrà indicizzata: conferma solo la ricezione. Si misura in Bing Webmaster Tools e
  Search Console (copertura dell'indice), non nel log del deploy.
- I profili ufficiali e i token di verifica sono dati del tenant: finché non ci sono, le proprietà non compaiono.
- Le pagine restano la leva principale: indicizzabili, veloci (Core Web Vitals) e con contenuto che risponde a una
  domanda reale. Questo ADR mette il sito in condizione di essere trovato, non di salire da solo.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Seo/tests/Feature/IndexNow/IndexNowTest.php`: file della chiave solo per la chiave
  configurata, invio solo di URL dell'host a `api.indexnow.org` a blocchi da 10.000, niente invio senza chiave, reinvio di
  una URL della sitemap solo se il suo `<lastmod>` è più recente. Le singole regole hanno un group: vedi i contratti
  [SubmitIndexNowAction](../contracts/submit-index-now-action.md) e [ServeIndexNowKeyAction](../contracts/serve-index-now-key-action.md).
- `vendor/bin/pest Modules/Seo/tests/Unit/Actions/Robots/BuildRobotsTxtActionTest.php`: `robots.txt` dichiara la sitemap
  con URL assoluto.
- Solo revisione: che nessuno aggiunga `llms.txt` o altri file "per l'AI", e che `sameAs` e i meta di verifica restino
  condizionati ai dati del tenant (codice in Xot e Cms, fuori da questo modulo).
