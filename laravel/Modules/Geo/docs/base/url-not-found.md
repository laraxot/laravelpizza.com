---
title: Url Not Found
description: Url Not Found
extends: _layouts.documentation
section: content
---

# Url Not Found {#url-not-found}

###  Errore

#### Not Found
The requested URL was not found on this server.
Apache/2.4.54 (Ubuntu) Server at virtualhost.local Port 80


###  Soluzione

Abilitare **rewrite** nei Modulo della configurazione globale di Apache Webserver su Webmin  

### Altra possibile soluzione  

Se si verifica in locale, dopo aver creato la giunzione, è possibile che la giunzione punti alla cartella public e non a public_html  

La soluzione è andare nella cartella dove è si trovano tutte le configurazioni delle giunzioni di laragon  

"laragon\etc\apache2\sites-enabled"

aprire il file .conf relativo alla giunzione non funzionante e modificare la riga che definisce la ROOT, facendola puntare a public_html  

esempio:  
da  
define ROOT "C:/var/www/nome_giunzione/public"  
a  
define ROOT "C:/var/www/nome_giunzione/public_html"  

**NB**: dopo aver fatto questa modifica, riavviare laragon