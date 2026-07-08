# Architecture: Related Records Refactor

Following the Laraxot evolution guidelines, this module will adopt the new "Master-Detail" pattern for managing related records.

## Goal
Improve the UI/UX of the related records management pages by providing high-level context (Infolist) of the parent record and ensuring a unified form experience.

## Key Changes
1.  **Switch to `XotBaseManageRelatedRecords`**: Ensure all related record management pages extend the base wrapper.
2.  **Header Infolist**: Implement `getMasterInfolistSchema()` to show key metadata of the parent entity (e.g., Year, Employee Name, Status) at the top of the list.
3.  **Unified Form Pattern**: Standardize `getFormSchema()` to ensure consistency between creation modals and potential full-page edits.
4.  **Type-Safe Record Access**: Use `instanceof` narrowing for parent record access.

## Planned Pages
-   **ValutazioneResource/Pages/ManageCriteri**: Will show the Valutazione summary before listing criteria.
-   **IncaricoResource/Pages/ManageIndennita**: Will show Incarico details before listing calculated allowances.

## Guidelines
-   Always use `static::trans()` for labels.
-   Maintain 100% PHPStan Level 10 compliance during refactor.
