CONTRIBUTING: Redundancy reduction checklist

Purpose
- Help contributors avoid creating duplicate docs, translations and assets across modules and themes.

Checklist (before adding docs/assets)
- Search laravel/Modules and laravel/Themes for an existing doc or asset with the same topic.
- If a canonical doc exists, link to it instead of copying. Create a short stub with canonical link if local context needed.
- If adding a translation, add keys to laravel/resources/lang/shared/ and reference it from module lang loader.
- Avoid committing files with suffixes like .old, .backup, ~. If legacy copies are required, place them under docs/archive/legacy/.
- Add YAML front-matter to every new doc with keys: module, topic, canonical, tags, author.

Maintenance
- Run the duplication scan script (maintainers) monthly: scripts/tools/redundancy-scan.sh (TBD)
- When consolidating, open a single PR that moves files to shared/ and replaces originals with stubs.

Example stub content
---
module: ModuleName
topic: Forms
canonical: ../../docs/shared/forms.md
---
See canonical forms documentation: ../../docs/shared/forms.md
