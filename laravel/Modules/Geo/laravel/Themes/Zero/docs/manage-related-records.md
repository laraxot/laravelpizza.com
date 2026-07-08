# ManageRelatedRecords Styling - Zero Theme

## Focus
The 'Zero' theme provides the clean, standard foundations for the Laraxot ecosystem. For related record pages, it focuses on clarity, readability, and semantic structure.

## Layout Guidelines
- **Master-Detail Pattern**: Related record pages SHOULD optionally render a "Master Context Infolist" at the top. This provides the user with the necessary context of the parent record without navigating away.
- **Header**: Large title with a clear relation to the parent record, positioned below the Master Infolist.
- **Table**: Striped rows with a primary color border on the active row.
- **Actions**: Simple icon + text buttons for header actions, icon-only buttons for record actions.

## Master Context Infolist
- **Background**: Light gray (`gray-50` or `gray-100`) to separate from the table.
- **Columns**: 3 or 4 columns for desktop, stacking on mobile.
- **Border**: subtle bottom border to transition into the main table.
- **Entries**: Use `TextEntry` with clear, bolded labels.

## Default Tokens
- **Table Striping**: `gray-50` background for even rows.
- **Header Action Color**: `primary-600` for the Create button.
- **Empty State**: Gray-scale icon with a prompt to add the first related record.

## Accessibility
- All table column headers use `aria-sort` when applicable.
- Buttons have clear `aria-label` derived from the automatic translation keys.
