# Task: Lang PHPStan Level 10

## 📋 Obiettivo
Portare il modulo Lang dal Livello 9 al Livello 10 di PHPStan, eliminando ogni incertezza residua sui tipi, specialmente nelle azioni di manipolazione dei file di traduzione.

## 🚨 Azioni Richieste
- Analizzare gli errori segnalati al Livello 10.
- Risolvere i problemi di covarianza nelle Collection.
- Tipizzare rigorosamente gli array di traduzione estratti dai file.
- Verificare le signature dei metodi che estendono pacchetti esterni (`mcamara`, `spatie`).

## ✅ Checklist
- [ ] Eseguire `vendor/bin/phpstan analyse Modules/Lang --level=10`.
- [ ] Risolvere errori in `Providers/LangServiceProvider.php`.
- [ ] Risolvere errori nelle Actions di lettura/scrittura file.
- [ ] Verificare conformità totale senza l'uso di `mixed`.

## 🔗 Riferimenti
- [Roadmap Lang](../roadmap.md)
- [PHPStan Journey](../../../../../docs/phpstan_journey.md)
