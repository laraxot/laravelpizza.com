---
title: "Segnalibro: cache HTTP con ETag e Redis"
type: archive
tags: [archivio, cache, http, redis]
created: 2026-11-20
updated: 2026-11-20
qmd: "segnalibro cache HTTP ETag If-None-Match Redis Laravel"
issues: [247]
discussions: []
---

# Segnalibro: cache HTTP con ETag e Redis

Questo file stava in `Modules/Xot/app/Services/`, cioe' in una cartella di
codice, dove un `.md` non ha niente da fare — ed era il solo motivo per cui
quella cartella sopravviveva alla cancellazione delle classi
(base_quaeris_fila5#247).

Il contenuto era, ed e', un solo URL senza una riga di testo attorno:

<https://tasb00429.medium.com/laravel-%E4%BD%BF%E7%94%A8-http-cache-etag-if-none-match-%E8%88%87-redis-%E6%87%89%E7%94%A8-9cd89a21b4fa>

Un articolo (in cinese) sull'uso di `ETag` / `If-None-Match` con Redis in
Laravel. Nessuna classe `CacheService` esiste in questo repository: il nome del
file non descrive niente che ci sia. E' quindi un segnalibro di qualcuno, tenuto
qui invece di essere cancellato perche' costa niente e un link perso non si
recupera.

Chi vuole farne qualcosa: la cache HTTP condizionale non e' implementata da
nessuna parte nel progetto, quindi questo e' un'idea aperta, non una descrizione
di come funzionano le cose.
