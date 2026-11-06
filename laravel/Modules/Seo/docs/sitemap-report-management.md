---
title: "Sitemap - Gestione tramite report Google Search Console"
type: note
tags: [sitemap, seo, google-search-console, documentation]
qmd: "sitemap google search console report gestione invio errori"
status: active
source_of_truth: true
related:
  - sitemap.md
  - ../../Modules/Themes/docs/shared-components/sitemap.md
updated: 2026-10-26
---

# Scopo

Documentare come gestire le Sitemap della proprieta' tramite il **report Sitemap** di Google Search Console. Lo scopo non e' correggere un errore puntuale, ma capire a cosa serve il report (monitoraggio invio, lettura, errori), come interpretare gli stati e come agire in base al risultato.

## Cosa serve il report

- **Informare Google di nuove Sitemap** dopo la generazione o l'aggiornamento.
- **Consultare la cronologia di invio** (data invio, ultima lettura, stato).
- **Visualizzare errori riscontrati da Google** durante l'analisi delle Sitemap inviate, per correggerli e rinviare.

Nota: il report mostra solo le Sitemap inviate tramite il report stesso o l'API Search Console, non quelle rilevate solo tramite `robots.txt` o altri metodi. Se una Sitemap non compare, verificare che non sia confusa tra proprieta' `http` / `https` o `www` / non-`www`.

## Quando serve

- Dopo aver generato una nuova Sitemap XML o indice Sitemap.
- Quando si riceve una notifica di errore di scansione o indicizzazione.
- Periodicamente per verificare lo stato di tutte le Sitemap inviate.

## Stati dello stato ultimo scansione

| Stato | Significato | Azione |
|---|---|---|
| **Riuscita** | Recuperata e letta senza errori. Gli URL saranno messi in coda per la scansione. | Nessuna. Monitorare periodicamente. |
| **Presenta errori** | Recuperata parzialmente ma con errori. Gli URL validi verranno comunque in coda. | Cliccare la Sitemap nel report per espandere gli errori, correggere, rinviare. |
| **Impossibile recuperare** | Google non riesce a recuperare il file Sitemap. | Verificare `robots.txt` (non bloccare la Sitemap), URL esatto, disponibilita' server, azioni manuali non risolte; correggere e rinviare. |

## Informazioni visualizzate per ogni Sitemap

- **URL Sitemap**: URL esatto specificato al momento dell'invio. I reindirizzamenti non vengono seguiti.
- **Tipo**: Sitemap (XML/testo), Indice Sitemap, RSS, Atom, Sconosciuto.
- **Inviata**: data di invio tramite report/API.
- **Ultima lettura**: ultima volta che Google ha recuperato la Sitemap (solo se recuperata).
- **Stato**: Riuscita / Presenta errori / Impossibile recuperare.
- **Pagine rilevate**: numero di URL pagine analizzati dalla Sitemap (duplicati conteggiati una sola volta). Per un indice Sitemap: totale in tutte le secondarie.
- **Video rilevati**: numero URL video analizzati (non garantisce indicizzazione).
- **Visualizza copertura dell'indice**: apre il report di copertura per tutti gli URL della Sitemap.

## Errori di recupero (impossibile recuperare)

- Sitemap bloccata da `robots.txt`: rimuovere la regola che blocca il recupero.
- Azione manuale attiva: risolvere l'azione manuale, poi rinviare.
- URL errato (404): verificare l'URL nel browser; correggere il percorso.
- Altri errori generali: disponibilita' temporanea del server; attendere e verificare se il problema persiste.
- Domanda di scansione bassa: migliorare la qualita' dei contenuti per aumentare la scansione.

## Errori di analisi (Sitemap leggibile ma con errori)

- **URL non accessibili**: l'URL nella Sitemap ha un errore di scansione. Verificare con lo strumento Controllo URL.
- **URL non seguiti**: troppi reindirizzamenti (sostituire con URL finali); URL relativi invece di assoluti (usare `https://www.example.com/page.html` non `mypage.html`); reindirizzamenti di aggiornamento dei metadati o JavaScript.
- **URL non consentito**: URL a un livello superiore o su dominio diverso rispetto alla Sitemap. Verificare coerenza `www` / protocollo.
- **Errore di compressione**: il file compresso (gzip) non si decomprime correttamente. Ricomprimere e caricare di nuovo.
- **Sitemap vuota**: nessun URL presente.
- **Dimensioni file**: non compressa > 50 MB. Dividere in Sitemap piu' piccole e usare un indice Sitemap.
- **Valore attributo / tag non valido**: controllare attributi e tag XML secondo la specifica; correggere errori ortografici.
- **Data non valida**: usare il formato W3C Datetime (`2005-02-21` o `2005-02-21T18:00:15+00:00`).
- **XML non valido**: tag duplicati o mancanti; caratteri non escapati negli URL; dichiarazione XML iniziale mancante.
- **Spazio vuoto iniziale**: l'XML deve iniziare con la dichiarazione XML, non con spazi.
- **Spazio dei nomi non corretto**: `xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"` per Sitemap standard.
- **Formato indice nidificato**: un indice Sitemap non puo' contenere altri indici, solo Sitemap.
- **Numero eccessivo di URL / Sitemap**: max 50.000 URL per Sitemap, max 50.000 Sitemap per indice.
- **Errori video**: URL miniatura mancante o dimensioni errate (160x120 px); titolo video mancante; URL video e player coincidenti; URL contenuto che punta alla pagina di riproduzione.
- **Google News**: max 1000 URL; tag `<publication>` obbligatorio per ogni URL.

## Come inviare / rinviare / eliminare

- **Inviare**: tramite il report Sitemap o l'API Sitemaps di Search Console.
- **Inviare di nuovo**: dopo aver corretto errori, per aggiornare lo stato.
- **Eliminare**: dal report per interrompere il monitoraggio di una Sitemap non piu' valida.

## Note operative per l'architettura del progetto

- Il modulo `Seo` gestisce la generazione programmatica della Sitemap (`BuildSitemapAction`).
- Il tema `Sixteen` (e altri) espone la vista `sitemap.blade.php` e i componenti `blocks/sitemap/`.
- La configurazione `config/sitemap.php` governa le opzioni Guzzle per la scansione (timeout, redirect, cookie).
- Le Sitemap generate devono essere inviate manualmente tramite Search Console (o automatizzate via API) dopo la pubblicazione.
- Non duplicare la documentazione: il riferimento canonico per la componente visiva e' nel tema; questa pagina documenta la gestione via Search Console.

## Controlli periodici

1. Verificare che la Sitemap sia raggiungibile dall'URL dichiarato (senza redirect non seguito).
2. Controllare che `robots.txt` non blocchi il percorso della Sitemap.
3. Controllare che gli URL interni siano assoluti, validi, con encoding corretto.
4. Verificare che il formato XML rispetti lo schema corretto e inizi con `<?xml version="1.0" encoding="UTF-8"?>`.
5. Invare o rinviare tramite il report Search Console dopo ogni aggiornamento significativo.
6. Monitorare se lo stato passa a **Riuscita** e se il conteggio pagine rilevate e' coerente con le pagine pubblicate.
