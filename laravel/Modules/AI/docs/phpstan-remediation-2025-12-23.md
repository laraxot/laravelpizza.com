# PHPStan Remediation Plan – 2025-12-23

## Contesto attuale

- `./vendor/bin/phpstan analyse Modules/AI` fallisce con `No files found to analyse`.
- Il modulo espone solo `docs/` e `tests/` vuoti: mancano classi/caricamento PSR-4, quindi PHPStan non ha target.
- Lo storico dei report in `docs_master_index.md` dichiara erroneamente “full compliance”.

## Piano di correzione

1. **Allineare l’autoload**  
   - Creare `Modules/AI/app/Providers` con almeno un service provider vuoto (`AiServiceProvider`) registrato in `composer.json` (`"Modules\\AI\\": "Modules/AI"`).  
   - Aggiungere `declare(strict_types=1);` e tipizzazione rigorosa.
2. **Stabilire il dominio minimo**  
   - Creare una `Modules\AI\Datas\AiProviderConfigData` (basata su `Spatie\LaravelData`) per descrivere provider/chatbot supportati.  
   - Documentare il contratto nelle `docs/`.
3. **Aggiornare la documentazione**  
   - Annotare in `README.md` che il modulo è ancora “skeleton” finché non vengono introdotti provider concreti.  
   - Inserire checklist per quando aggiungeremo Actions/Services (Webmozart Assert, uso di XotBase*).
4. **Quality gate**  
   - Dopo aver creato i file di base, rieseguire PHPStan, poi PHPMD e PHP Insights su `Modules/AI`.

## Da migliorare (DRY + KISS)

- Consolidare le regole di naming dei provider AI riutilizzando i pattern già descritti in `Modules/Xot/docs/service-provider-best-practices.md`.
- Evitare duplicati tra `docs/README.md` e nuovi documenti: mantenere una singola fonte per roadmap e qualità.
- Automatizzare il controllo “moduli senza sorgente PHP” nello script `bashscripts/quality/check_modules.php` per prevenire regressioni simili.
