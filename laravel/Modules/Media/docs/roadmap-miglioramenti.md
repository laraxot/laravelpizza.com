---
title: "roadmap miglioramenti"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "roadmap miglioramenti"
issues: []
discussions: []
---

# Roadmap — Media, il modulo con un dump-and-die ancora vivo dentro un generatore video

> Numeri misurati: [`docs/cosa-migliorare.md`](cosa-migliorare.md) (80,
> 2026-09-01) — PHPStan 0, PHPMD app/ 171, Code 91.8, Arch 100 (massimo dei
> cinque moduli qui analizzati), 314 casi test, coverage non riportata.
> L'Arch a 100 stona con quello che segue: un'architettura "perfetta" per lo
> strumento che la misura convive con un `dddx()` attivo che lo stesso
> strumento non vede, perché non è un problema architetturale — è un
> comportamento a runtime.

Vado dritto al punto più urgente perché è l'unico dei cinque moduli
analizzati oggi con un `dddx()` **non commentato, non rimosso, tuttora
attivo**: `app/Conversions/VideoGenerators/Webm.php:16`. Non è un residuo
storico da archeologia — è codice che gira ogni volta che il generatore Webm
viene invocato, e che oggi dumpa e muore invece di generare il video. È
gemello dello stesso bug già trovato e corretto poche ore fa in
`Modules/Performance/app/Models/BaseIndividualeModel.php` — stesso pattern,
stessa causa probabile (debug lasciato durante uno sviluppo, mai rimosso
prima del commit), stessa urgenza. Va sistemato prima di qualunque roadmap
filosofica, non dopo.

## Il file che si è clonato — di nuovo

`app/Actions/Stream/SubtitleService.php` e `app/Services/SubtitleService.php`
esistono entrambi, **stessa riga 155, stesso `dddx()` commentato
identico carattere per carattere**:
```php
// dddx([$start,$this->secondsToHms($start),$end,$this->secondsToHms($end)]);
```
Questo non è un caso — è la prova che uno dei due file è una copia
dell'altro fatta durante una migrazione `Services/` → `Actions/` (o
viceversa) mai completata. E per chiudere il cerchio: esiste anche
**`app/Services/SubtitleService.php.bak`**, stesso contenuto, estensione
`.bak`, committato nel repository come se fosse codice sorgente. Un file
`.bak` in `app/` è un file che qualcuno ha salvato "per sicurezza" e poi si
è dimenticato di cancellare o di aggiungere a `.gitignore` — tre copie dello
stesso servizio, e nessuna sa con certezza di essere quella vera finché non
si guardano i consumer con `grep -rn SubtitleService app`.

## Due archivi, un solo passato

`docs/archive/` e `docs/archived/` coesistono — due cartelle con lo stesso
scopo dichiarato e un carattere di differenza nel nome. Stessa dinamica di
`bad-practices.md`/`best-practices.md` (qui NON duplicati per case, a
differenza di Rating — un punto a favore di Media), ma la stessa disciplina
mancata: nessuno ha deciso quale fosse il nome canonico prima di crearne un
secondo.

## Un modulo che sa già misurarsi (a metà)

`phpstan.neon.dist` esiste ed è configurato (47 righe) — Media è fra i
pochi moduli di questo lotto con una configurazione phpstan propria pronta
per essere usata standalone. Manca solo l'ultimo miglio: `require-dev: []`
significa che quella configurazione non ha ancora nulla da eseguire in CI.
`docs/coverage.md` esiste già, segno che il modulo ha un'abitudine alla
misura — va solo ricollegata a un `require-dev` reale (larastan, pest) per
smettere di essere un documento aggiornato a mano e diventare un numero
verificato da una pipeline.

## Priorità concrete, in ordine di rischio

1. **Subito**: rimuovere il `dddx()` attivo in `Webm.php:16` e ripristinare
   la generazione video reale — è un bug in produzione, non debito tecnico.
2. Decidere quale `SubtitleService.php` è quello vero (`Actions/` o
   `Services/`, verificare gli import reali), cancellare l'altro e il
   `.bak`.
3. `require-dev` con larastan/pest, appoggiandosi al `phpstan.neon.dist` già
   pronto — qui il lavoro di configurazione è già fatto, manca solo di
   accenderlo.
4. Fondere `docs/archive/` in `docs/archived/` (o viceversa, dopo aver letto
   entrambi), un solo nome canonico.

Media è il modulo più vicino, fra i cinque, ad avere già l'infrastruttura di
qualità pronta (phpstan.neon.dist, coverage.md) — gli manca solo di smettere
di generare video con un dump di debug al posto della logica.
