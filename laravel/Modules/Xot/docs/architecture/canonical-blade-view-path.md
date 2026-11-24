---
title: "Percorso canonico delle viste Blade Xot"
type: standard
module: Xot
qmd: "canonical blade view path xot resources/views legacy app/Resources/views"
---

# Percorso canonico delle viste Blade Xot

Il percorso canonico delle viste di un modulo è:

```text
Modules/<Modulo>/resources/views
```

Per Xot il provider registra esclusivamente `resources/views` tramite il
namespace `xot::` (`XotBaseServiceProvider::registerViews`). `app/Resources/views`
è un residuo legacy non registrato dal provider e non deve ricevere nuove viste.

I file legacy esistenti restano intatti per compatibilità e per consentire una
migrazione successiva, owner-localizzata e verificata. Non si devono creare
copie parallele né cancellare automaticamente il percorso legacy.

Il test `CanonicalBladeViewPathTest` mantiene questa frontiera:

- `resources/views` esiste e contiene almeno `index.blade.php`
- l'elenco dei `.blade.php` sotto `app/Resources/views` è congelato (freeze list)
- ogni path legacy è relativo, termina con `.blade.php`, senza `..`, e il file esiste
- nessuno dei residui legacy è duplicato sotto il path canonico

Evita `assertIsString()` su valori già tipizzati `string` (PHPStan
`staticMethod.alreadyNarrowedType`): usa assertion sul *contenuto* del path.

