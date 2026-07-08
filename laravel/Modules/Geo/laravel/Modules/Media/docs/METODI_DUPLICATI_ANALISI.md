---
module: Media
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Media

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Media**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Models/Policies/MediaBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `__invoke` (14 occorrenze)

**Moduli coinvolti:** Media, User

**File in Media:**

- `./laravel/Modules/Media/app/Http/Controllers/ConvertController.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getModel` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Notify, Ptv, User, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Services/SubtitleService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeaderWidgets` (13 occorrenze)

**Moduli coinvolti:** Job, Media, Notify, Ptv, UI, User, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Resources/MediaConvertResource/Pages/ListMediaConverts.php`
- `./laravel/Modules/Media/app/Filament/Resources/MediaResource/Pages/ViewMedia.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `get` (11 occorrenze)

**Moduli coinvolti:** Lang, Media, Notify, Seo, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Services/SubtitleService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `trans` (8 occorrenze)

**Moduli coinvolti:** Lang, Media, Tenant, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Actions/AddAttachmentAction.php`
- `./laravel/Modules/Media/app/Filament/Resources/HasMediaResource/Actions/AddAttachmentAction.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `sendEmail` (7 occorrenze)

**Moduli coinvolti:** Media, Notify

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `rules` (6 occorrenze)

**Moduli coinvolti:** Job, Media, Performance, Progressioni, Sigma

**File in Media:**

- `./laravel/Modules/Media/app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getInstance` (6 occorrenze)

**Moduli coinvolti:** Media, Notify, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Services/SubtitleService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `messages` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Media, Progressioni

**File in Media:**

- `./laravel/Modules/Media/app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `message` (4 occorrenze)

**Moduli coinvolti:** Media, Performance, User, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Rules/FileExtensionRule.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getPath` (4 occorrenze)

**Moduli coinvolti:** Media, Notify, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Contracts/PathGenerator.php`
- `./laravel/Modules/Media/app/Support/TemporaryUploadPathGenerator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `begin` (4 occorrenze)

**Moduli coinvolti:** Job, Media, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Resources/MediaResource/Widgets/ConvertWidget.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `passes` (3 occorrenze)

**Moduli coinvolti:** Media, Performance, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Rules/FileExtensionRule.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getContent` (3 occorrenze)

**Moduli coinvolti:** Media, Notify, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Services/SubtitleService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `creator` (3 occorrenze)

**Moduli coinvolti:** Media, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Models/Media.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `test_s3_permissions` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/AwsTest.php`
- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `test_s3_connection` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/AwsTest.php`
- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `supportedMimeTypes` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `./laravel/Modules/Media/app/Conversions/VideoGenerators/Webm.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `supportedExtensions` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `./laravel/Modules/Media/app/Conversions/VideoGenerators/Webm.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `requirementsAreInstalled` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `./laravel/Modules/Media/app/Conversions/VideoGenerators/Webm.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `registerMediaConversions` (2 occorrenze)

**Moduli coinvolti:** Media, Rating

**File in Media:**

- `./laravel/Modules/Media/app/Models/TemporaryUpload.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `image` (2 occorrenze)

**Moduli coinvolti:** Media, Xot

**File in Media:**

- `./laravel/Modules/Media/database/factories/MediaFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getPathForResponsiveImages` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Contracts/PathGenerator.php`
- `./laravel/Modules/Media/app/Support/TemporaryUploadPathGenerator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPathForConversions` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Contracts/PathGenerator.php`
- `./laravel/Modules/Media/app/Support/TemporaryUploadPathGenerator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeight` (2 occorrenze)

**Moduli coinvolti:** Media, Xot

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Infolists/VideoEntry.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDiskName` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Infolists/VideoEntry.php`
- `./laravel/Modules/Media/app/Models/TemporaryUpload.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `from` (2 occorrenze)

**Moduli coinvolti:** Media, Notify

**File in Media:**

- `./laravel/Modules/Media/app/Support/Ffmpeg/MediaExporterResolver.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `formHandlerCallback` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Actions/AddAttachmentAction.php`
- `./laravel/Modules/Media/app/Filament/Resources/HasMediaResource/Actions/AddAttachmentAction.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `convert` (2 occorrenze)

**Moduli coinvolti:** Media

**File in Media:**

- `./laravel/Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `./laravel/Modules/Media/app/Conversions/VideoGenerators/Webm.php`

[Riflessione: Duplicato interno al modulo Media — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `clearResults` (2 occorrenze)

**Moduli coinvolti:** Media, Pdnd

**File in Media:**

- `./laravel/Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Media

- **Totale metodi duplicati che coinvolgono Media:** 32
- **Di cui cross-modulo:** 22
- **Di cui interni al modulo:** 10

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 26 metodi
- **altro:** 6 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 28 metodi in comune
- **User:** 25 metodi in comune
- **Notify:** 14 metodi in comune
- **Job:** 8 metodi in comune
- **Ptv:** 6 metodi in comune
- **Performance:** 6 metodi in comune
- **Lang:** 5 metodi in comune
- **IndennitaResponsabilita:** 4 metodi in comune
- **Sigma:** 3 metodi in comune
- **Progressioni:** 3 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
