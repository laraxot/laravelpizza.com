# Metriche Modulo Activity

| Metrica | Obiettivo | Verifica |
|--------|-----------|----------|
| PHPStan Level 10 | 0 errori | `./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1` |
| Copertura test Pest | > 90% (target moduli core) | `php artisan test --filter=Activity` + coverage |
| Documentazione | Centralizzata in docs/, link aggiornati | Review roadmap e Xot migrazioni |
| File obsoleti | Inventario e piano di rimozione | Documento cleanup o issue tracker |
| Migrazioni | Allineate XotBaseMigration | Riferimento a Xot/docs |
