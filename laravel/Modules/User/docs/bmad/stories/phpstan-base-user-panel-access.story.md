---
title: "PHPStan: accesso pannello BaseUser e account cancellati"
qmd: "phpstan user baseuser can access panel deleted at account gdpr"
status: review
---

# Story BMAD — Accesso pannello BaseUser

## Scopo

`BaseUser` non usa `SoftDeletes`: la cancellazione GDPR valorizza direttamente
`deleted_at`. `canAccessPanel()` deve quindi negare un account cancellato
leggendo l'attributo reale, senza interrogare il metodo `trashed()` di un trait
non presente.

## Implementazione

- sostituito il controllo `method_exists()/trashed()` con il controllo tipizzato
  dell'attributo `deleted_at`;
- mantenuta la compatibilità con valori stringa e oggetti `DateTimeInterface`;
- preservato il flusso di autorizzazione dei pannelli non cancellati.

## Verifica

- PHPStan mirato `BaseUser.php`: 0 errori;
- PHPStan globale `Modules`: 0 errori.

## Gate Pest

Il test owner è stato avviato in ambiente `testing`, ma è rimasto senza output
per contention con processi Pest concorrenti ed è stato interrotto. La story
resta `review` finché il gate non è verde o formalmente saltato.
