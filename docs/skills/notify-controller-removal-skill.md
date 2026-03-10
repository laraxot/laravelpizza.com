# Skill: Notify Controller Removal

## Trigger
Quando compare un controller legacy nel modulo Notify.

## Passi
1. verificare referenze con `rg`;
2. capire se il problema e' di responsabilita' architetturale, non solo di percorso file;
3. aggiornare docs modulo + tema + regola + memory;
4. trattare `Modules/Notify/app/Http/Controllers/NotificationTrackingController.php` come regressione architetturale esplicita;
5. rimuovere il file controller o sostituirlo con action/service piu' piccoli;
5. eseguire quality checks e test correlati.
