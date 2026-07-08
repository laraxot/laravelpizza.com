---
title: Event Sourcing
description: Event Sourcing
extends: _layouts.documentation
section: content
---

# Video
https://www.youtube.com/watch?v=_8daXQAlzd4

# Aggregato {#aggregato}

Cluster di oggetti gestiti dall'app come un unica entità logica a livello di business,   
con uno stato che varia nel tempo.  
(Esempio un ordine di ecommerce, formato da un indirizzo, da degli item acquistabili, dallo stato del conto dell'utente)

# Comandi diventano Eventi {#comando-diventano-eventi}

...cioè diventano qualcosa che è già successo.  
Prima di diventare un evento ci può essere un controllo che il comando sia andato a buon fine oppure rigettato (validazione),  
eventualmente dividere il comando il più eventi (se questo ci rende la vita più facile dopo).

Si può anche generare un altro evento (magari di correzione), nel caso qualcosa sia andato storto.

# Event Sourcing {#event-sourcing}
Noi non aggiorniamo mai i dati cambiando quindi lo stato di esso, noi accodiamo tutto quello che succede (anche cose sbagliate).  


Grazie a questo filosofia, abbiamo:  
la storia di tutto ciò che è successo in passato, quindi si può interrogare  
quindi si può ricostruire uno stato delle cose ad un certo punto nel tempo  
avere un controllo su un eventuale corruzione dei dati (bug, malicius, errore umano), in modo da poter correggere
