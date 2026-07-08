---
module: Pdnd
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Pdnd

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Pdnd**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Clusters/Test/Pages/GuzzleProxyPage.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDescription` (12 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Notify, Pdnd, Seo, UI, Xot

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Models/Enums/ServizioAnprEnum.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Models/Enums/SessoEnum.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Models/Enums/TipoErroreEnum.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `validate` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Pdnd, Progressioni, UI, User

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Contracts/AnprRequestInterface.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/TipoDatiRichiestaE002.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `perCodiceFiscale` (8 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/TipoCriteriRicercaE002.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `pdndForm` (8 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoIdUnicoNazionalePage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoIdUnicoNazionalePagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getPdndFormActions` (8 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoIdUnicoNazionalePage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoIdUnicoNazionalePagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralitaPROD.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `canAccess` (7 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Clusters/Test/Pages/GuzzleProxyPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoIdUnicoNazionalePage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoIdUnicoNazionalePagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `perIdAnpr` (6 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoCriteriRicercaE002.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isValidDataFormat` (6 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoDatiRichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoInfoSoggettoEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoDatiRichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoInfoSoggettoEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoDatiRichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoInfoSoggettoEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isValid` (5 occorrenze)

**Moduli coinvolti:** Pdnd, User

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoIdentificativi.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoIdentificativi.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoIdentificativi.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/TipoIdentificativi.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasSoggetti` (5 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/TipoListaSoggetti.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStatus` (5 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`
- `./laravel/Modules/Pdnd/app/Services/Client/PdndClient.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `generateOperationId` (5 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Models/Base/BaseRequest.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `count` (5 occorrenze)

**Moduli coinvolti:** Pdnd, Xot

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/TipoListaSoggetti.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `processSuccessResponse` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `processErrorResponse` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `processE002Response` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `perDatiAnagrafici` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/TipoCriteriRicercaE002.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isSuccessResponse` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasErrori` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/RispostaKO.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasAnomalie` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/RispostaE002OK.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPrimoSoggetto` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/TipoListaSoggetti.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPrimoErrore` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/RispostaKO.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPdndClient` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Traits/HasPdndClient.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNumeroSoggetti` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/RispostaE002OK.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNumeroErrori` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/RispostaKO.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `extractSoggettiData` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `extractErroriData` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `extractAnomalieData` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `cercaPerCodiceFiscale` (4 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/AnprServiceOrchestrator.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Contracts/AnprServiceInterface.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `validateCodiceFiscale` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `resetRisultato` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `notifySuccess` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `notifyError` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `hasVerifica` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/RichiestaE002.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasValore` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoInfoSoggettoEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoInfoSoggettoEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoInfoSoggettoEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasValidCriteria` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoCriteriRicercaE002.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasInfo` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoDatiSoggettiEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasGeneralita` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoVerificaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoVerificaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoVerificaE002.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasElements` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoListaSoggetti.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getValorePerChiave` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoDatiSoggettiEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getValoreEffettivo` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoInfoSoggettoEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoInfoSoggettoEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoInfoSoggettoEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTipoRicerca` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoCriteriRicercaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoCriteriRicercaE002.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTipoCriterio` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/RichiestaE002.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNumeroAnomalie` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaE002OK.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaE002OK.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getInfoPerChiave` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoDatiSoggettiEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getIdOperazione` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Contracts/AnprRequestInterface.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Request/RichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Models/Base/BaseRequest.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCodiciErrore` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/RispostaKO.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/RispostaKO.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAllSoggetti` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoListaSoggetti.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoListaSoggetti.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAllInfo` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoDatiSoggettiEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `fromString` (3 occorrenze)

**Moduli coinvolti:** Pdnd, Rating, Xot

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Models/Enums/SessoEnum.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `formatErrorBody` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichEsistenzaVitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `extractInfoSoggettoEnte` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `createFromBasicData` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Common/TipoGeneralita.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Common/TipoGeneralita.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Common/TipoGeneralita.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `countInfo` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Response/TipoDatiSoggettiEnte.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Response/TipoDatiSoggettiEnte.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `consultazioneE002` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `conGeneralita` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/Models/Request/TipoVerificaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoVerificaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoVerificaE002.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `accertamentoGeneralita` (3 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/C015Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `verificaPerDatiAnagrafici` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `verificaPerCodiceFiscale` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `verificaDichiarazioneE002` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `verificaDichiarazioneCompleta` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `verificaConCriteriAvanzati` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `toJson` (2 occorrenze)

**Moduli coinvolti:** Pdnd, Xot

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Shared/Traits/HasArrayConversion.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `testConnettivita` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `recuperaIdAnprDaC030` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `notifyWarning` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isC007` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/Models/Request/TipoDatiRichiestaE002.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C015/Models/Request/TipoDatiRichiestaE002.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isAccertamentoSuccessful` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `handleAccertamentoSuccessful` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `handleAccertamentoFailed` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getStatistiche` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getIdAnpr` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/Models/Response/TipoDatiSoggettiEnte.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getApiUrl` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Client/PdndClient.php`
- `./laravel/Modules/Pdnd/app/Services/PdndClientService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `extractVerificationResult` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `executeTest` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Clusters/Test/Pages/CurlProxyPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Clusters/Test/Pages/GuzzleProxyPage.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `createGeneralitaObject` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralita.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioVerificaDichGeneralitaPROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `createC015Service` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPage.php`
- `./laravel/Modules/Pdnd/app/Filament/Pages/ServizioAccertamentoGeneralitaPagePROD.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `creaRichiestaVerificaRapida` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C003/C003Service.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C007/C007Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `config` (2 occorrenze)

**Moduli coinvolti:** Pdnd, Tenant

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Client/PdndClient.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `clearResults` (2 occorrenze)

**Moduli coinvolti:** Media, Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Filament/Clusters/Test/Pages/CurlProxyPage.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `cercaPerDatiAnagrafici` (2 occorrenze)

**Moduli coinvolti:** Pdnd

**File in Pdnd:**

- `./laravel/Modules/Pdnd/app/Services/Anpr/Contracts/AnprServiceInterface.php`
- `./laravel/Modules/Pdnd/app/Services/Anpr/Services/C030/C030Service.php`

[Riflessione: Duplicato interno al modulo Pdnd — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per Pdnd

- **Totale metodi duplicati che coinvolgono Pdnd:** 82
- **Di cui cross-modulo:** 9
- **Di cui interni al modulo:** 73

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 78 metodi
- **altro:** 4 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 8 metodi in comune
- **User:** 7 metodi in comune
- **UI:** 4 metodi in comune
- **IndennitaResponsabilita:** 2 metodi in comune
- **Media:** 2 metodi in comune
- **Ptv:** 2 metodi in comune
- **Seo:** 2 metodi in comune
- **Sigma:** 1 metodi in comune
- **MobilitaVolontaria:** 1 metodi in comune
- **Notify:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
