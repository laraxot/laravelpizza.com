---
id: rating-story-5-93-rating-contract
slug: 5-93-rating-contract-al-posto-di-baserating
title: "5.93: RatingContract al posto di BaseRating: un'astrazione sola o nessuna"
description: "Tipizzare la riga di rating su un'interfaccia invece che sulla classe astratta. La direzione e' giusta e coerente con Xot; il rischio e' fermarsi a meta' e lasciare due vocabolari per la stessa cosa in 56 file."
type: story
document_type: story
category: architecture
status: in-progress
version: 1.0.0
language: it-IT
module: Rating
epic: 5
story: 93
scope: [modules]
audience: [ai-agents, developers, architects]
tags: [contract, baserating, tipizzazione, astrazione, hasratingstrait, phpstan-generics]
created: 2026-09-09
updated: 2026-09-09
qmd: "RatingContract BaseRating interfaccia contratto tipizzare riga rating HasRatingContract host side generics morphToMany Assert subclassOf due vocabolari"
issues:
  - "https://github.com/provtv/module_rating_fila5/issues/27"
discussions:
  - "https://github.com/provtv/module_rating_fila5/discussions/25"
related:
  - ../wiki/concepts/dove-vive-un-contratto.md
  - ./0048-get-ratings-form-schema-nel-trait.story.md
  - ../../app/Models/Traits/HasRatingsTrait.php
  - ../../app/Contracts/RatingsFormCallerContract.php
  - ../../app/Models/Contracts/HasRatingContract.php
  - ../wiki/troubleshooting/phpstan-generic-limitation-morphtomany.md
maintainer: Laraxot
license: project-internal
---
# Story 5.93: `RatingContract` al posto di `BaseRating`

## Context and Problem Statement

1. **La cultura del repo e' questa.** `Modules/Xot/app/Contracts/` ha una ventina di
   contratti di model: `ProfileContract`, `ModelContract`, `StateContract`: e la regola
   di progetto per User/Profile impone di tipizzare sul contratto, non sulla classe.
   `BaseRating` e' l'eccezione, non la norma.
2. **Il confine fra moduli.** Oggi `IndennitaResponsabilita` importa
   `Modules\Rating\Models\BaseRating`: un model di un altro modulo: dentro una pagina
   Filament. Con un contratto importerebbe un'astrazione, che e' quello che la regola di
   modularita' chiede.
3. **`RatingsFormCallerContract` e' nuovo.** E' un'interfaccia pubblica destinata a essere
   implementata da host di **altri** moduli, e nella firma nomina una classe concreta di
   Rating. E' il punto con meno peso storico e quello dove il contratto conviene di piu'.
4. **I test.** Un rating finto che implementa l'interfaccia non ha bisogno di essere un
   model Eloquent. Oggi ogni test sullo schema deve costruire record veri.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Da dove nasce

Domanda dell'utente il 2026-09-09, sul codice appena scritto in 5.92:

> al posto di `BaseRating $rating` forse era meglio `RatingContract $rating`

> **Aggiornamento del 2026-09-09, ore 13:10.** Mentre scrivevo questa story un'altra
> sessione ha creato `RatingContract`: anzi, ne ha creati **due**, in due cartelle
> diverse. La parte «non esiste» qui sotto e' quindi la fotografia di due ore fa, e resta
> come cronologia. Lo stato attuale e' nella sezione «Dev» in fondo.

## Il fatto, misurato (fotografia delle 12:40)

`RatingContract` **non esisteva**. Quello che esiste e' l'altra meta':

| interfaccia | dove | che cosa descrive |
|---|---|---|
| `HasRatingContract` | `Modules/Rating/app/Models/Contracts/` | il model **host**, quello che *possiede* rating (`ratings(): Relation`) |
|: |: | la **riga di rating** in se': nessuna interfaccia |

Il tipo della riga e' oggi la classe astratta `BaseRating`, e la sua superficie non e'
piccola:

| | |
|---|---:|
| file di codice che nominano `BaseRating` | **56** |
| occorrenze | **168** |
| moduli coinvolti | 7: Rating 18, Progressioni 10, Performance 9, IndennitaResponsabilita 9, IndennitaCondizioniLavoro 5, Ptv 3, Xot 2 |
| model che estendono `BaseRating` | **12** (`Rating` e `RatingMorph` in 6 moduli) |

## Perche' la direzione e' giusta

1. **La cultura del repo e' questa.** `Modules/Xot/app/Contracts/` ha una ventina di
   contratti di model: `ProfileContract`, `ModelContract`, `StateContract`: e la regola
   di progetto per User/Profile impone di tipizzare sul contratto, non sulla classe.
   `BaseRating` e' l'eccezione, non la norma.
2. **Il confine fra moduli.** Oggi `IndennitaResponsabilita` importa
   `Modules\Rating\Models\BaseRating`: un model di un altro modulo: dentro una pagina
   Filament. Con un contratto importerebbe un'astrazione, che e' quello che la regola di
   modularita' chiede.
3. **`RatingsFormCallerContract` e' nuovo.** E' un'interfaccia pubblica destinata a essere
   implementata da host di **altri** moduli, e nella firma nomina una classe concreta di
   Rating. E' il punto con meno peso storico e quello dove il contratto conviene di piu'.
4. **I test.** Un rating finto che implementa l'interfaccia non ha bisogno di essere un
   model Eloquent. Oggi ogni test sullo schema deve costruire record veri.

## Perche' non e' stata fatta dentro 5.92

Perche' mezza conversione e' peggio di nessuna: lascerebbe **due vocabolari per la stessa
cosa nello stesso file**. `HasRatingsTrait` nomina `BaseRating` in `ratings()`,
`ratingObjectives()`, `myRatings()`, `syncRatingsWhere()`, in tre `Assert::subclassOf()` e
in tutti i generics `MorphToMany<BaseRating, ...>`. Convertire solo i tre metodi nuovi
significa che il lettore successivo non sa quale dei due sia quello giusto.

E i generics non sono neutri: il modulo ha gia' una pagina di troubleshooting sui limiti
di PHPStan con `MorphToMany` (`docs/wiki/troubleshooting/phpstan-generic-limitation-morphtomany.md`).
Cambiare il parametro di tipo di quella relazione e' la parte rischiosa, non la firma di
un metodo.

## La superficie da progettare, gia' misurata

Membri di una riga di rating usati dal codice di 5.92:

| membro | uso |
|---|---|
| `getKey()` | nome del campo `ratings.{id}.pivot.value`, chiave delle opzioni |
| `getLabel()` | etichetta di una voce figlia (gia' su `BaseRating`, richiesto da `HasRecursiveRelationshipsContract`) |
| `is_readonly` | decide `TextEntry` vs campo modificabile |
| `rule` | regola di validazione (`RuleEnum`) |
| `children` | le voci del `Select` |
| `txt`, `title` | etichetta, usata dall'host in `decorateRatingField()` |

Nota di progettazione: `is_readonly`, `rule`, `children`, `txt`, `title` sono **proprieta'**,
e un'interfaccia PHP non le dichiara. Servono `@property` in docblock: come fanno gia' i
contratti di Xot: oppure dei metodi (`isReadonly()`, `getRule()`, `getChildren()`), che e'
la forma piu' onesta ma che tocca tutti i chiamanti. **Questa e' la decisione da prendere
prima di scrivere il file.**

## Acceptance criteria

- [ ] `RatingContract` esiste in `Modules/Rating/app/Models/Contracts/`, accanto a
      `HasRatingContract`, e la relazione fra i due e' scritta: uno e' l'host, l'altro la riga
- [ ] `BaseRating implements RatingContract`
- [ ] La conversione e' **coerente**: nessun file nomina i due tipi per la stessa cosa
- [ ] I generics `MorphToMany<...>` sono convertiti o **esplicitamente** lasciati indietro con
      il motivo scritto, non dimenticati
- [ ] `Assert::subclassOf(..., BaseRating::class)` diventa un controllo sull'interfaccia
- [ ] PHPStan **0 errori** sul modulo intero, non solo sui file toccati
- [ ] Nessun `mixed` introdotto per far tacere i generics

## Cosa NON fa questa story

Non tocca `RuleEnum`, non tocca `rating_morph`, non cambia comportamento a runtime. E' una
riscrittura di tipi: se qualcosa cambia a runtime, e' un errore.

## Claim

| task | chi | stato |
|---|---|---|
| forma dell'interfaccia (proprieta' o metodi) | vuoto | **attende decisione**: bloccante |
| conversione | vuoto | bloccata dalla precedente |

## GitHub (tracciamento)

Issue **da creare**, comando nel frontmatter. La discussion di riferimento e' la #25 di
`provtv/module_rating_fila5`, dove sta la discussione sul contratto nata con 5.92.

---

## Dev: la duplicazione e la sua risoluzione (sessione `f54b0755`, 2026-09-09 13:10)

### Cosa e' successo

`RatingContract` e' stato creato **due volte**, da sessioni diverse, in due cartelle:

| percorso | forma | consumatori |
|---|---|---:|
| `app/Contracts/RatingContract.php` | `extends HasRecursiveRelationshipsContract`, dichiara `getLabel()` | **0** |
| `app/Models/Contracts/RatingContract.php` | marker con `@property`, `@phpstan-require-extends Model` | 1 (`BaseRating`) |

Namespace diversi: nessun errore, nessun test rosso. Il danno e' che `use ...\RatingContract`
completato dall'IDE prendeva l'uno o l'altro a caso, con membri diversi.

### Cosa e' stato fatto

Su decisione dell'utente e' rimasto **solo** quello in `app/Models/Contracts/`, dopo avergli
portato dentro cio' che l'altro aveva di buono: `extends HasRecursiveRelationshipsContract`
(che porta `children` e `id`) e la dichiarazione `getLabel(): string`. Il file in
`app/Contracts/` e' stato rimosso: zero consumatori, verificato con `grep` prima di toccarlo.

Il perche', la convenzione e le sue eccezioni stanno in
[`docs/wiki/concepts/dove-vive-un-contratto.md`](../wiki/concepts/dove-vive-un-contratto.md).

### La misura che smentisce la motivazione facile

Sarebbe stato comodo scrivere «i contratti di model stanno in `app/Models/Contracts/`, e'
la convenzione». **Non e' vero**, e il codice lo dice:

| | |
|---|---:|
| interfacce in `Modules/*/app/Contracts/` | 75 |
| interfacce in `Modules/*/app/Models/Contracts/` | 9 |
| interfacce in `app/Contracts/` con `@phpstan-require-extends Model` | **38** |

Fra i 38 ci sono `ProfileContract`, `UserContract` e `ModelContract` di Xot. La direzione
scelta e' giusta, ma oggi e' minoritaria: applicarla al repo significa spostare 38 file, ed
e' una decisione di repo con la sua story, non un effetto collaterale di questa.

L'argomento che regge **davvero** per Rating e' un altro, ed e' locale: `HasRatingContract`
stava gia' in `app/Models/Contracts/`, e i due contratti descrivono le due facce della
stessa relazione.

### Duplicati della stessa specie, trovati e non risolti

| contratto | copia 1 | copia 2 |
|---|---|---|
| `StabiDirigenteContract` | `Ptv/app/Contracts/` | `Ptv/app/Models/Contracts/` |
| `ActivityRecorderContract` | `Activity/app/Contracts/` | `Activity/app/Models/Contracts/` |

Non sono materia di questa story: sono di `Ptv` e `Activity`, e la story va aperta nel
modulo owner.

### Cosa resta aperto

Il codice del trait tipizza ancora su `BaseRating`. Ora che il contratto dichiara
`getLabel()` e `children`, la conversione e' **possibile**; resta da fare in un passaggio
coerente su tutto il file: inclusi i generics `MorphToMany<BaseRating, ...>`: e non su
tre metodi soli.

### Gate

`php -l` pulito, `pint` passed, `phpstan analyse Modules/Rating` **0 errori** dopo la
rimozione.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
