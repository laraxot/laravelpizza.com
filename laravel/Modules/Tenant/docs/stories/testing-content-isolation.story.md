---
title: "Isolamento dei contenuti tenant nei test"
status: active
---

# Isolamento dei contenuti tenant nei test

`GetTenantFilePathAction` usa una copia sotto `storage/framework/testing/tenant-content` per i JSON CMS quando l'applicazione gira in test. La copia viene inizializzata alla prima lettura dal contenuto versionato di `config/<tenant>/database/content`; le scritture dei test restano quindi fuori dal repository.

Questo mantiene `Section::getBlocksBySlug()` fedele alla produzione anche nei test che avviano direttamente `<x-section>`, evitando falsi verdi con header/footer privi di blocchi.

Verifica: i contratti Sixteen di header/footer passano con 21 test e 218 assertion.
