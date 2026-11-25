---
title: "ADR — Upload temporanei con percorso scoping e policy"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
module: Media
qmd: "0001 upload temporanei percorso scopato policy"
---

# ADR: upload temporanei con percorso scoped e policy

## Contesto

Gli upload temporanei possono esistere prima dell'associazione definitiva a
un modello e possono avere originale, conversione e versione responsive. Il
percorso non deve collidere tra media e non deve confondere il file originale
con i derivati; l'accesso ai record deve restare governato da policy.

## Driver

- Separare i tre scopi di storage senza duplicare la logica del percorso.
- Rendere il percorso deterministico rispetto all'identità del media, non al
  nome fornito dal client.
- Applicare permessi espliciti sia a `media.*` sia a `temporary_upload.*`.

## Alternative scartate

- Usare il nome originale o una cartella pubblica: collisioni e maggiore
  esposizione del contenuto.
- Mettere originali e derivati nella stessa posizione: impossibile distinguere
  chiaramente i cicli di elaborazione.
- Affidarsi soltanto a controlli nella UI Filament: le policy devono coprire
  anche chiamate e risorse non originate dalla UI.

## Decisione

`GenerateTemporaryUploadPathAction` genera percorsi sotto `tmp/` usando
`media->uuid` e id, con suffissi distinti per `original`, `conversion` e
`responsive`. `MediaPolicy` e `TemporaryUploadPolicy` autorizzano le azioni
tramite i rispettivi permessi CRUD; `super-admin` e `media::admin` hanno il
bypass previsto dalla policy base. La validazione degli upload diretti richiede
UUID, chiave, bucket, nome, tipo MIME e dimensione.

## Conseguenze

- Buono: percorsi separati e riproducibili riducono collisioni e ambiguità tra
  file e conversioni.
- Buono: l'autorizzazione è applicata al modello, non solo al pannello.
- Cattivo: il percorso dipende dalla stabilità dell'identità del media e i
  temporanei richiedono una pulizia esplicita.
- Cattivo: il client deve fornire tutti i metadati richiesti per l'upload
  diretto.

## Conferma

- `app/Actions/GenerateTemporaryUploadPathAction.php:11-49` deve mantenere
  base `tmp/` e separazione per scopo.
- `app/Models/Policies/MediaPolicy.php:13-67` e
  `app/Models/Policies/TemporaryUploadPolicy.php:15-65` devono mantenere i
  permessi espliciti.
- `app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php:12-29`
  deve mantenere la validazione dei metadati.
- Verificare `tests/Unit/Support/TemporaryUploadPathGeneratorTest.php` e
  `tests/Unit/MediaPolicyBehaviorTest.php`.
