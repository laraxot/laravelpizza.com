# Story: PHPStan fix Notify: NotificationsTable columns/filters

## Status
done: 2026-09-30

## Contesto
`phpstan analyse Modules` segnalava 2 errori in `tests/Unit/Filament/Resources/NotifyFilamentResourcesCoverageTest.php`: chiamate a metodi statici inesistenti `ListNotifications::notificationTableColumns()/notificationTableFilters()`. Il commit `1328c19601 (.)` (rigenerazione automatica rotta delle List pages) aveva eliminato quei metodi e ridotto `ListNotifications` a subclass bare di `XotBaseListRecords`.

## Fix
- `NotifyFilamentResourcesCoverageTest.php`: rimosso `use ...\Pages\ListNotifications;`, aggiunto `use ...\Tables\NotificationsTable;`.
- Chiamate sostituite col pattern instance-based gia' usato in riga 206:
  `app(NotificationsTable::class)->getTableColumns()` e `->getTableFilters()`.
- Le asserzioni esistenti (colonne id/type TextColumn, filtri read/unread/type) combaciano con `NotificationsTable`.

## Verifica
- PHPStan `Modules/Notify Modules/Performance` → `[OK] No errors`.
- Test "list notifications page exposes expected columns and filters" → **passa**.

## Note
- 5 test rossi preesistenti NON correlati (BindingResolutionException: Target class [translator] does not exist, via `__()` in PreviewNotificationTemplate): fuori scope, documentati solo in sprint-status.
- Refactor sitster di ListImports/ListJobManagers/ListTemporaryUploads/ListNotifications/ListIndividualeAdms/ListSchedas/ListSsoProviders (commit 1328c19601): le header actions vivono nelle Table class (`getTableHeaderActions`), quindi i List page sono subtag bare.

## References
- `control: NotificationsTable::getTableColumns()/getTableFilters()`
- Pattern instance-based: `app(NotificationLogsTable::class)->getTableColumns()`