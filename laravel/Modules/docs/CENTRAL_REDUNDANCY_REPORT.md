Central Redundancy Report — 2026-05-25

Overview
- Automated scan across laravel/Modules and laravel/Themes identified many duplicate files, duplicate documentation pages, and repeated assets/snippets.
- Duplicate types: exact copies (backup/old/legacy copies), identical docs in multiple modules, repeated language/translation files, repeated view components across themes.

Key findings (summary)
- Many modules contain legacy copies (filename.old, backup files) and duplicate documentation pages (e.g., *_1.md vs _*.md).
- Several common docs (html2pdf styling, filament resources, phpstan fixes, naming conventions) are copied across modules.
- Shared assets/views exist in both Modules and Themes (e.g., admin dashboard blade, components/button.blade.php) causing maintenance burden.
- Translations (validation.php, auth.php, messages.php) are duplicated across modules.

Immediate recommendations
1. Create a single source-of-truth area:
   - laravel/Modules/docs/shared/  (for common docs like html2pdf/styling.md, naming-conventions, phpstan guidance)
   - laravel/resources/lang/shared/ (for shared translations)
   - laravel/themes/shared-components/ or a Modules/Shared module for common views/components
2. Replace duplicate files with short canonical stubs containing a link to the shared canonical doc.
3. Remove or archive legacy backup files (filename.old, backup timestamps) from repo; keep one canonical copy in an "archive/legacy" folder if needed.
4. Add YAML front-matter to docs with metadata (module, topic, canonical_path, tags) to enable automated indexing by the second brain.
5. Add a CONTRIBUTING-REDUNDANCY.md checklist in laravel/Modules/docs/ to guide maintainers when adding docs.

Automation artifacts
- Detailed duplicate groups and function-name duplication lists were produced during analysis and saved to the workspace (/tmp/dup_groups.txt and /tmp/dup_functions.txt). Use them to drive a cleanup PR.

Next steps for maintainers
- Approve creation of shared folders and canonicalization policy.
- Run a cleanup PR: replace duplicate docs with short redirect stubs and move one canonical copy to shared.
- Consolidate translations into laravel/resources/lang/shared and update module lang loaders to fallback to shared when missing.

Confidence
- High: exact-file duplication and many identical docs were automatically detected.
- Medium: function-name duplication requires manual review — some duplicates are legitimate framework conventions.

Author: Copilot CLI
