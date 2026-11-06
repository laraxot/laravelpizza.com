---
title: "Relazioni Eloquent nei trait dei modelli User"
type: concept
module: User
status: active
created: 2026-11-05
updated: 2026-11-05
tags: [user, eloquent, relationships, traits, architecture]
qmd: "User relazioni Eloquent trait per modello override firma pivot chiavi"
related:
  - ../index.md
  - ../../bmad/stories/user-model-relationships-to-traits.story.md
  - ../../bmad/architecture.md
---

# Relazioni Eloquent nei trait dei modelli User

Le relazioni dichiarate dai modelli User vivono in trait specifici del modello
sotto `app/Models/Traits/`. I nomi e i contratti restano quelli del modello:
return type Eloquent, PHPDoc generico, `#[Override]`, foreign key, pivot e filtri
non cambiano durante lo spostamento.

Gli helper di risoluzione strettamente usati da una relazione vanno nel suo trait;
gli helper condivisi restano nel trait comune che li possiede. I comportamenti
riutilizzabili di `BaseUser` e dei trait `Has*` già esistenti mantengono i loro
owner attuali. Prima di comporre un trait va verificata la precedenza rispetto a
parent class e trait importati; collisioni reali richiedono un adaptation block
esplicito con `insteadof`/alias e test sul metodo effettivamente risolto.

Inventario e stato dei lock sono nella story
[user-model-relationships-to-traits](../../bmad/stories/user-model-relationships-to-traits.story.md).
