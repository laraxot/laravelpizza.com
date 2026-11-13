---
title: "Sei accessor nei moduli condivisi scrivono a database quando vengono letti"
type: story
status: ready-for-dev
priority: P2
created: 2026-11-10
module: User
related:
  - "../../../Quaeris/docs/stories/2026-11-05-token-failure-silently-breaks-invite-chain.story.md"
tags: [bmad, eloquent, performance, moduli-condivisi]
---

# Sei accessor nei moduli condivisi scrivono a database quando vengono letti

Fase BMAD: Analisi fatta, sviluppo **non** iniziato di proposito. Vedi "Perche'
non e' stato corretto subito".

## Scopo

Un accessor Eloquent (`get...Attribute`) e' una lettura. Quando dentro ci sta
una `update()`, leggere una proprieta' scrive a database: una query in piu' per
ogni riga disegnata in una tabella, per ogni elemento di una collection, per
ogni contatto dentro un job.

Il difetto e' gia' stato trovato e corretto due volte nel modulo Quaeris:

- `Contact::getSurveyIdAttribute()`, il 2026-11-05 — scattava dentro il job del
  token, una UPDATE per contatto;
- `Contact::getDuplicateCountAttribute()`, il 2026-11-10 — scattava dentro
  `SendInviteAction` e su ogni riga di `ContactsTable`, una COUNT piu' una
  UPDATE per contatto.

Lo stesso difetto e' presente in sei punti dei moduli condivisi, trovati dal
controllo automatico `.github/check-convenzioni.php` (regola
`scrittura-in-accessor`).

## Stato misurato

```bash
php .github/check-convenzioni.php --solo=eloquent
```

| File | Riga | Cosa scrive |
|---|---|---|
| `Modules/Lang/app/Models/Traits/Mutators/PostMutators.php` | 32 | `title` |
| `Modules/Lang/app/Models/Traits/Mutators/PostMutators.php` | 48 | idem, secondo accessor |
| `Modules/User/app/Models/Traits/BaseUserMutators.php` | 47 | `name` |
| `Modules/User/app/Models/Traits/BaseUserUniqueNameAttribute.php` | 30 | `name` |
| `Modules/User/app/Models/Traits/IsProfileTrait.php` | 114 | `first_name` |
| `Modules/User/app/Models/Traits/IsProfileTrait.php` | 151 | `last_name` |

Due dettagli che rendono i casi `name` piu' insidiosi degli altri: la `update()`
sta dentro un `try { } catch (\Throwable) { }`, quindi se la scrittura fallisce
non lo sa nessuno; e il valore viene **anche** assegnato a
`$this->attributes['name']` nel ramo precedente, percio' esistono due percorsi
che fanno cose diverse a seconda che il model sia gia' salvato.

## Perche' non e' stato corretto subito

`User` e `Lang` sono moduli base della piattaforma Laraxot, usati da altri
progetti oltre a Quaeris. Un accessor che persiste puo' essere load-bearing
altrove: `getUniqueNameAttribute` genera un nome univoco, e se qualcuno conta
sul fatto che dopo la prima lettura quel nome sia scritto a database, togliere
la scrittura cambia il comportamento senza che nessun test di questo repository
se ne accorga — la suite e' ferma (vedi `docs/audit/RISK_REGISTER.md`, TEST-01).

Correggere alla cieca sei accessor in moduli condivisi, senza test che girano e
senza sapere chi altro li usa, e' piu' rischioso del difetto. Per questo la
story e' aperta e il lavoro va coordinato, non fatto di nascosto.

## Lavoro da fare

Per ciascuno dei sei, nell'ordine:

1. Cercare chi legge quella proprieta' (`rg "->name\b"`, `->title`,
   `->first_name`, `->last_name`) e stabilire se qualcuno conta sulla
   persistenza.
2. Se nessuno ci conta: accessor di sola lettura, come fatto in
   `Contact::getDuplicateCountAttribute()`.
3. Se qualcuno ci conta: spostare la scrittura dove il dato nasce (un observer
   `creating`/`saving`, o l'azione che crea il record), non nel getter.
4. Nei due casi `name`: togliere il `catch (\Throwable) {}` muto. Se la
   scrittura puo' fallire, il fallimento va almeno registrato.
5. Un test per ciascuno, che legga la proprieta' e verifichi che **non** parta
   nessuna query di scrittura (`DB::listen` oppure `expectsDatabaseQueryCount`).

## Acceptance criteria

- [ ] `php .github/check-convenzioni.php --solo=eloquent` restituisce 0
      violazioni bloccanti.
- [ ] Per ogni accessor toccato esiste un test che dimostra che la lettura non
      scrive.
- [ ] Nessun `catch (\Throwable) {}` muto resta nei due accessor `name`.

## Prerequisiti

Suite Pest sbloccata (TEST-01). Senza test che girano, questa story non e'
verificabile e non va iniziata.

## Nota per gli altri agenti

Su questo repository lavorano piu' agenti in parallelo. Se prendi in carico
questa story, dichiaralo qui cambiando `status` e lavora un modulo alla volta:
`Lang` e `User` sono indipendenti fra loro e si possono dividere.
