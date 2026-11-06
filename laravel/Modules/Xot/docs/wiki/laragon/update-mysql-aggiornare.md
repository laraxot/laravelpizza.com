---
title: "Aggiornare MySQL a 8.0 su Laragon"
description: "Passare un Laragon su Windows a MySQL 8.0.30 portatile, senza reinstallare Laragon."
type: how-to
status: draft
module: Xot
created: 2026-09-26
updated: 2026-11-06
tags: [laragon, mysql, windows, how-to]
qmd: "aggiornare mysql 8.0 laragon windows mysqld initialize-insecure heidisql 8.0.30"
related:
  - ../../laragon/update-mysql.md
  - ../../laragon/update-mysql-aggiornare.md
---

# Aggiornare MySQL a 8.0 su Laragon

Laragon e' l'ambiente di sviluppo Windows. Se la sua copia di MySQL e' precedente alla 8.0, questa procedura aggiunge
MySQL 8.0.30 portatile accanto a quella esistente e lo seleziona da Laragon, senza reinstallare nulla. Sulle macchine
Linux di sviluppo non serve.

Articolo di riferimento: <https://gist.github.com/meorajrul/b57803bf1b4ddfd2f93e6ad37c3ac5f2>.
La procedura non e' stata riverificata in questa revisione (per questo lo stato e' `draft`).

## Passi

1. Scarica `mysql-8.0.30-winx64.zip` dall'archivio MySQL:
   <https://downloads.mysql.com/archives/get/p/23/file/mysql-8.0.30-winx64.zip>.
2. Decomprimi il file in `C:\laragon\bin\mysql`: nasce la cartella `C:\laragon\bin\mysql\mysql-8.0.30-winx64`.
3. Apri il terminale di Laragon e vai in `C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin`.
4. Inizializza la cartella dei dati:

   ```bat
   mysqld --initialize-insecure
   ```

   `--initialize-insecure` crea l'utente `root` senza password: impostane una subito se la macchina non e' solo locale.
5. Clic destro sull'icona di Laragon nella tray, poi MySQL, e scegli la versione 8.*.
6. Avvia i servizi.
7. Apri HeidiSQL (o un altro client SQL) e collegati per accedere alle tabelle.

## Copie di questo documento

Il testo era in quattro copie identiche piu' un alias; questa e' l'unica canonica. [`laragon/update-mysql.md`](../../laragon/update-mysql.md)
e [`laragon/update-mysql-aggiornare.md`](../../laragon/update-mysql-aggiornare.md) sono alias che rimandano qui,
[`update-mysql.md`](./update-mysql.md) (in questa cartella) e' gia' marcata `superseded`, e `laragon/update-mysql-8.md`
(il "8" era la versione di MySQL, non un suffisso di copia) e' stato ritirato come `.md.old`.
