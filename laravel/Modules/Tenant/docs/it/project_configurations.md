---
title: Configurazione progetti
description: Configurazione progetti
extends: _layouts.documentation
section: content
---

# Configurazione progetti {#configurazione-progetti}

Con lo stessa struttura è possibile avere varie configurazioni per gestire più progetti.

## Cartella config {#cartella-config}

Dentro la cartella laravel\config ci sono tutte le configurazioni, organizzate in base all'url utilizzato.

L'organizzazione delle cartelle segue l'ordine del dominio, esempio:

se volessi configurare il dominio https://mio_dominio.com/, dentro la cartella laravel\config dovrei creare:

una cartella nominata **com**,

dentro la cartella com un altra cartella nominata **mio_dominio**.

quindi tutti i file di configurazione che interessano al progetto che verrà pubblicato a dominio https://mio_dominio.com/ si troveranno dentro la cartella **laravel/config/com/mio_dominio"**