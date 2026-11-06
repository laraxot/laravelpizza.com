---
title: "roadmap miglioramenti"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap miglioramenti"
issues: []
discussions: []
status: draft
---

# Roadmap: Notify, il modulo che parla con sei canali e con sé stesso 4533 volte

> Numeri misurati: [`docs/cosa-migliorare.md`](cosa-migliorare.md) (80,
> 2026-09-01): PHPStan 0, PHPMD app/ 191, Code 91.8, Arch 85.7, **823 casi
> test, coverage 6,3% ⚠**. Questo è il dato che conta più di ogni altro in
> questo documento: 823 test e quasi nessuna riga toccata. Non è "manca
> copertura", è che 800 e passa test probabilmente ripetono lo stesso
> percorso o non arrivano mai al codice vero: capire perché viene prima di
> scriverne un ottocentoquattresimo.

Prima il numero, perché va detto una volta sola e forte: **4533 file
markdown in `docs/`**, contro 233 file PHP in `app/`. Un rapporto di quasi 20
documenti per ogni file di codice. Questo non è un modulo ben documentato, è
un modulo che ha smesso di distinguere fra scrivere e ricordare. Prova
diretta, senza bisogno di aprirli: nella sola root di `docs/` convivono
`00-index.md`, `00-index.md`, `00-index-2.md` e `00-INDEX.md`: quattro
`00-index.md`, `00-index-documentation.md`, `00-index-2.md` e `00-INDEX.md`: quattro
indici per un unico modulo, nessuno dei quattro probabilmente aggiornato
dopo la nascita degli altri tre. E poi `absolute-completion.md` insieme ad
`ABSOLUTE_COMPLETION_100.md`: un modulo che si certifica "completo al 100%"
due volte, con due grafie diverse, è un modulo che non si fida di sé stesso
abbastanza da cancellare il primo certificato quando scrive il secondo.

## Sei integrazioni reali, zero rete che le protegge

`require` di questo modulo è l'unico dei cinque qui analizzati che sembra
scritto da chi lo usa davvero: `aws/aws-sdk-php`, `irazasyed/telegram-bot-sdk`,
`kreait/laravel-firebase`, `laravel-notification-channels/fcm`,
`laravel-notification-channels/telegram`,
`spatie/laravel-database-mail-templates`, `symfony/postmark-mailer`. Email,
SMS, WhatsApp, Telegram, FCM push: sei canali di comunicazione con il mondo
esterno, ciascuno con la propria superficie di errore (rate limit, token
scaduti, webhook malformati). E poi, come tutti gli altri: `require-dev: []`.
Il modulo con più integrazioni esterne del lotto è anche quello con zero
modo automatico di sapere se una di queste integrazioni si è rotta prima che
se ne accorga un utente che non ha ricevuto la notifica.

## Le pipeline che esistono già e non sono mai partite

`.github/workflows/` non è vuoto: contiene `module-release.yml_test`,
`sync-remote-repo.yml_test`, `sync-subtrees.yml_test`: tre file da 4-10 KB
ciascuno, con l'estensione `.yml_test` invece di `.yml`, che li rende inerti
per GitHub Actions (non vengono mai eseguiti, sono solo lì). Qualcuno ha
scritto pipeline complete e poi le ha disattivate con un rename di un
carattere, forse per test, forse per prudenza, e non le ha mai riattivate.
C'è anche una cartella `viral-github-actions/` il cui nome da solo merita
un'archeologia dedicata. Prima di scrivere una CI nuova per questo modulo, la
mossa giusta è aprire questi tre file: potrebbero già contenere il lavoro
che serve, solo bloccato da un'estensione sbagliata.

## 28 marcatori, e i canali mancanti sono elencati da soli

28 occorrenze TODO/FIXME/@phpstan-ignore in `app/`: il numero più alto dei
cinque moduli. Non sono rumore generico: `WhatsAppNotification.php:65` dice
letteralmente "TODO: Implementare WhatsAppChannel quando disponibile",
`TelegramChannel.php:26` e `:34` elencano due metodi non ancora scritti
(`toTelegram`, più `BotTelegramAction`/`TelegramMessageData` mancanti). Il
modulo dichiara nel proprio `composer.json` di supportare Telegram e
WhatsApp, ma il codice sotto dice "non ancora". C'è anche
`HasNotificationRateLimiting.php` marcato `@phpstan-ignore trait.unused` -
un rate limiter dichiarato ma mai collegato, in un modulo che parla con AWS,
Firebase e Telegram senza, a quanto pare, nulla che lo freni se un job va in
loop.

## Priorità concrete

1. Rinominare (o cancellare, dopo lettura) i tre `.yml_test` in `.yml` reali
  : è la scorciatoia più veloce verso una CI funzionante che questo modulo
   abbia mai avuto a un rename di distanza.
2. `require-dev` con larastan/pest: con sei integrazioni esterne, phpstan è
   l'unico modo economico di sapere se un cambio di SDK ha rotto un canale
   prima del deploy.
3. Chiudere davvero i tre TODO su WhatsApp/Telegram o rimuovere le classi
   stub dal namespace pubblico: un canale "supportato" a metà è peggio di
   un canale assente, perché qualcuno ci proverà.
4. Un solo indice (`00-index.md`), i tre fratelli cancellati dopo aver
   verificato cosa contenevano di unico; stesso trattamento per i due
   "completion" gemelli.
5. Capire cosa toccano davvero gli 823 test prima di aggiungerne altri:
   con coverage al 6,3% la maggioranza probabilmente esercita mock/fixture
   invece del codice reale, oppure sono varianti dello stesso scenario
   moltiplicate. Un report `--coverage` con la lista dei file a 0% è il
   punto di partenza, non un'altra sessione di scrittura test alla cieca.

Notify ha l'ambizione giusta: sei canali reali, non promesse: e la
disciplina sbagliata: ogni volta che qualcosa non torna, invece di
sistemarlo scrive un altro documento che dice che è a posto.
