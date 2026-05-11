# Design Comuni Batch Parity

## Scopo

Documento di coordinamento Cms per l'audit batch delle pagine Design Comuni servite da `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` e dai JSON `config/local/fixcity/database/content/pages/tests.<slug>.json`.

Il report dettagliato vive nel tema, perche' e' il tema il punto dove convergono parity HTML del body, screenshot e successivi fix CSS/JS.

## Report attivo

- [../../../Themes/Sixteen/docs/design-comuni/batch-body-parity-2026-04-03.md](../../../Themes/Sixteen/docs/design-comuni/batch-body-parity-2026-04-03.md)
- [../../../Themes/Sixteen/docs/design-comuni/batch-body-parity](../../../Themes/Sixteen/docs/design-comuni/batch-body-parity)

## Script correlato

- [../../../bashscripts/design-comuni/batch-body-parity.sh](../../../bashscripts/design-comuni/batch-body-parity.sh)
- [../../../bashscripts/docs/design-comuni-batch-body-parity.md](../../../bashscripts/docs/design-comuni-batch-body-parity.md)

## Regola operativa

- Se una pagina risulta `READY_FOR_CSS_JS`, il lavoro successivo va nel tema Sixteen.
- Se una pagina risulta `HTML_DELTA`, prima va riallineata la struttura o il JSON Cms.
- Se una pagina risulta `LOCAL_500`, la priorita' e' sbloccare il rendering locale prima di parlare di parity visiva.
