---
issues: []
discussions: []
title: "Dove vive un contratto: app/Contracts o app/Models/Contracts"
type: concept
status: active
language: it-IT
module: Rating
created: 2026-09-09
updated: 2026-09-09
tags: [contracts, convenzione, namespace, modelli, architettura, duplicati]
qmd: "contratto app/Contracts app/Models/Contracts dove sta interfaccia modello RatingContract HasRatingContract RatingsFormCallerContract duplicato namespace due file stesso nome"
related:
  - ../../stories/5.93.rating-contract-al-posto-di-baserating.story.md
  - ../../../app/Models/Contracts/RatingContract.php
  - ../../../app/Models/Contracts/HasRatingContract.php
  - ../../../app/Contracts/RatingsFormCallerContract.php
---

# Dove vive un contratto

## La decisione presa in Rating

**In `Rating`, il contratto che descrive la riga di rating sta in
`app/Models/Contracts/RatingContract.php`.** Il gemello che era comparso in
`app/Contracts/` e' stato rimosso dopo aver preso da lui cio' che aveva di buono.

Questa e' una decisione, presa dall'utente il 2026-09-09 con una motivazione precisa: un
contratto che **solo un model puo' implementare** appartiene alla cartella dei model. Non
e' la deduzione di una convenzione gia' in vigore nel repo, ed e' importante non
raccontarla come tale: vedi «Cosa dice davvero il codice».

## Il fatto che l'ha resa necessaria

Per qualche ora nel modulo sono esistiti **due** file `RatingContract.php`:

| percorso | namespace | forma | consumatori |
|---|---|---|---:|
| `app/Contracts/RatingContract.php` | `Modules\Rating\Contracts` | `extends HasRecursiveRelationshipsContract`, dichiara `getLabel()` | **0** |
| `app/Models/Contracts/RatingContract.php` | `Modules\Rating\Models\Contracts` | marker con `@property`, `@phpstan-require-extends Model` | 1 (`BaseRating`) |

Namespace diversi, quindi **nessun errore**: l'autoload li carica entrambi, PHPStan non
protesta, i test passano. Il danno e' l'altro: chi scrive `use ...\RatingContract` e lascia
completare l'IDE prende quello sbagliato con la stessa probabilita' di quello giusto, e
ottiene un'interfaccia con membri diversi. E' la stessa famiglia di guasto delle classi che
differiscono solo per il case: silenzioso, e si manifesta lontano da dove e' nato.

**Non si e' tenuto un file intero e buttato l'altro.** Il conto dei consumatori diceva 1 a
0, ma la versione con zero consumatori dichiarava `getLabel()` e l'ereditarieta' da
`HasRecursiveRelationshipsContract`: cioe' `children` e `id`: che sono esattamente cio'
che serve a chi costruisce un `Select` dai figli di un criterio. Si e' tenuto **il file
giusto con il contenuto migliore dei due**.

## Cosa dice davvero il codice

Qui la verifica smentisce la regola, e va scritto.

| | |
|---|---:|
| interfacce in `Modules/*/app/Contracts/` | **75** |
| interfacce in `Modules/*/app/Models/Contracts/` | **9** |
| interfacce in `app/Contracts/` con `@phpstan-require-extends Model` | **38** |

Fra quei 38 ci sono `Xot\Contracts\ProfileContract`, `Xot\Contracts\UserContract`,
`Xot\Contracts\ModelContract`: cioe' proprio i contratti che le regole di progetto
impongono di usare al posto delle classi concrete. **La collocazione maggioritaria per un
contratto di model, oggi, e' `app/Contracts/`.**

Quindi: la regola «i contratti di model stanno in `app/Models/Contracts/`» **non e' la
convenzione in vigore**. E' la direzione scelta, e applicarla al repo intero significa
spostare 38 file e i loro `use`. Dichiararla qui come se fosse gia' vera renderebbe fuori
norma quei 38 file senza che nessuno lo abbia deciso.

### L'argomento che regge davvero, per Rating

`HasRatingContract` era **gia'** in `app/Models/Contracts/` prima di tutto questo. Mettere
`RatingContract` altrove avrebbe separato due contratti che descrivono le due facce della
stessa relazione. La coerenza dentro il modulo e' un argomento vero e verificabile; la
convenzione globale, oggi, non lo e'.

### La prova del contrario, nello stesso modulo

`RatingsFormCallerContract` sta in `app/Contracts/` **e ci sta bene**: lo implementa una
pagina Filament, non un model. Con la regola «per implementarlo devi essere un model» non
e' un'eccezione da giustificare: e' l'altro ramo.

### Le tre facce, che non vanno confuse

| contratto | chi lo implementa | dove |
|---|---|---|
| `RatingContract` | **la riga** di rating (`BaseRating`) | `app/Models/Contracts/` |
| `HasRatingContract` | il model **host** che possiede rating | `app/Models/Contracts/` |
| `RatingsFormCallerContract` | la **pagina** che chiede lo schema | `app/Contracts/` |

Il nome quasi uguale dei primi due e' il motivo per cui vale la pena che stiano vicini: la
vicinanza rende visibile la differenza.

## Altri duplicati, misurati e non risolti qui

Lo stesso guasto esiste fuori da Rating, e non e' materia di questa story:

| contratto | copia 1 | copia 2 |
|---|---|---|
| `StabiDirigenteContract` | `Ptv/app/Contracts/` | `Ptv/app/Models/Contracts/` |
| `ActivityRecorderContract` | `Activity/app/Contracts/` | `Activity/app/Models/Contracts/` |

(`SchedaContract` compare in `Sigma/app/Contracts/` e `Ptv/app/Models/Contracts/`: moduli
diversi, quindi va verificato se sono la stessa cosa o due concetti omonimi.
`ModelContract` e `UserContract` esistono in `Xot` e in `User`: quelli sono il pattern
noto contratto-base/contratto-di-modulo, non un duplicato.)

## Lo zen

Una cartella non e' un contenitore, e' un'affermazione. Se due file con lo stesso nome
stanno in due cartelle, il progetto sta affermando due cose e non se n'e' accorto: e non
se ne accorgera', perche' entrambe funzionano.

E la seconda meta': quando si sceglie fra due affermazioni, si conta. Se il conto dice il
contrario di quello che si sta per scrivere, si scrive il conto: non la regola che si
sperava di trovare.

## Come si verifica

```bash
# contratti omonimi dentro lo stesso modulo
find Modules -name '*Contract.php' -not -path '*/vendor/*' \
  | sed 's|Modules/\([^/]*\)/.*/\(.*\)|\1 \2|' | sort | uniq -d

# quanti contratti di model stanno ancora in app/Contracts (oggi: 38)
grep -rl 'phpstan-require-extends Model' Modules/*/app/Contracts/ | wc -l
```

Il primo comando deve restituire vuoto. Il secondo e' il **debito**, non un errore: scende
solo se e quando la direzione scelta in Rating diventa una decisione di repo, con la sua
story.
