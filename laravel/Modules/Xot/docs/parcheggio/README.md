---
qmd: "xot parcheggio readme md"
title: "File parcheggiati — Xot"
document_type: index
category: documentation
module: Xot
status: active
updated_at: '2026-11-18'
---

# File parcheggiati

File `.wip` spostati qui da `app/` il 2026-11-12
([module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61)).

## Perche' non stavano in `app/`

In `app/` sta solo codice che gira. Un `.wip` accanto al file vivo e' ambiguo
per chi legge: due versioni affiancate, e la piu' piccola sembra la "nuova".
E' esattamente il guasto di
[#30](https://github.com/laraxot/module_quaeris_fila5/issues/30), dove un
`XotBaseManageRelatedRecords.php.wip` con la classe ridotta a un guscio ha
fatto credere per mesi che le azioni di riga fossero state tolte di proposito.

## Perche' non sono stati cancellati

Perche' **non sono residui di un salvataggio**: ognuno contiene righe che nella
versione viva non ci sono. Cancellarli butterebbe lavoro scritto da qualcuno.

| File | Righe che il vivo non ha | Cosa c'e' dentro |
|---|---|---|
| `SecurityMiddleware.php.wip` | **135** | `validateInputs()`, `enhanceCSRFProtection()`, e un'eccezione per le rotte Debugbar in locale, cosi' gli header di sicurezza non rompono la toolbar. Vedi la nota sotto |
| `PerformanceMonitoringMiddleware.php.wip` | 56 | Rilevazione delle richieste lente con soglia |
| `FilamentMemoryMonitorMiddleware.php.wip` | 3 | Differenze minime: il vivo e' piu' avanti |

## Nota sul `SecurityMiddleware`

Le 135 righe parcheggiate non sono bozze incomplete: sono due controlli
(validazione degli input e irrobustimento CSRF) che oggi **non girano**. Non le
ho attivate perche' un middleware di sicurezza che valida gli input puo'
rifiutare richieste legittime, e la suite non gira
([#62](https://github.com/laraxot/module_quaeris_fila5/issues/62)): si attiva
con i test verdi e un giro di prova, non di sfuggita.

Il `FilamentMemoryMonitorMiddleware` e' legato a
[#45](https://github.com/laraxot/module_quaeris_fila5/issues/45), il boot che
consuma ~125MB: la versione viva c'e' gia' ed e' piu' avanti di questa.

## Se riprendi uno di questi

Confronta col file vivo prima di copiare: `diff docs/parcheggio/<file> app/<percorso>/<file senza .wip>`.
Quando il lavoro e' finito, cancella il `.wip` — non lasciarlo accanto al vivo.

---

## Aggiunti il 2026-11-18 — estensioni finte sotto `app/`

I file qui sopra sono `.wip`. Il 2026-11-18 ne sono arrivati altri con
estensioni diverse — `.up`, `.test`, `.disabled`, `.boh`, `.to_migra` — trovati
cercando **tutte** le estensioni finte sotto `app/`, non solo `.wip`: erano 64
in dodici moduli. Un'estensione finta non tiene un file fuori dal codice, lo
rende invisibile a chi cerca e vivo per chi lo trova.

Per questi il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove venivano.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Console/Commands/DatabaseSchemaExporterCommand.to_migra` | 10832 |
| `app/Console/Commands/GenerateDbDocumentationCommand.to_migra` | 11711 |

`DatabaseSchemaExporterCommand` e `GenerateDbDocumentationCommand` stanno
**identici anche in DbForge**: l'unica differenza fra le due copie e' la riga
del namespace.

```
< namespace Modules\DbForge\Console\Commands;
> namespace Modules\Xot\Console\Commands;
```

Il nome dice "da migrare": qualcuno stava spostandoli da un modulo all'altro e
si e' fermato a meta', lasciando due copie parcheggiate e **nessuna viva**. Se
si riprendono, la casa giusta e' DbForge — e' il modulo per gli strumenti sul
database — e questa copia va cancellata, non tenuta come riserva.

**Questi non sono stati esaminati riga per riga**, a differenza dei `.wip` qui
sopra: sono stati spostati, non giudicati. Prima di copiarne uno nel codice
vivo, confrontalo con quello che c'e' adesso.

