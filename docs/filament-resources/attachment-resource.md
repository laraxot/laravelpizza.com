# Attachment Resource

This document outlines the Filament resource implementation for the `Attachment` model in the CMS module.

## Resource Structure

```plaintext
app/Filament/Resources/
├── AttachmentResource/
│   ├── Pages/
│   │   ├── CreateAttachment.php
│   │   ├── EditAttachment.php
│   │   └── ListAttachments.php
│   └── AttachmentResource.php
```

## Features

- **List View**: Displays attachments in a table with columns for title, slug, and file preview

- **Form Fields**:
  - Title (translatable)
  - Slug (auto-generated from title)
  - File upload (handles multiple file types)

- **Table Actions**:
  - View
  - Edit
  - Delete

- **Bulk Actions**:
  - Delete selected
  - Export selected

## Implementation Notes

### File Uploads

- Uses Spatie Media Library for file handling
- Files are stored in the `attachments` collection
- Supports drag and drop uploads
- Shows file previews in the list view

### Translations

- Title field is translatable
- All UI elements are localized

### Validation

- Title: required, string, max:255
- Slug: required, string, max:255, unique
- File: required, file, max:10240 (10MB)

### Permissions

- View any attachment
- Create attachment
- Update any attachment
- Delete any attachment

## Usage

Register the resource in the panel configuration:

```php
protected function getResources(): array
{
    return array_merge(
        parent::getResources(),
        [
            AttachmentResource::class,
            // other resources...
        ]
    );
}
```
