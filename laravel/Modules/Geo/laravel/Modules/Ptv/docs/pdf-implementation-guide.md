# PDF Implementation Guide - Ptv Module

> **Purpose**: Standardize PDF generation for PTV project using `Xot` core actions.

## 🚀 Quick Start

To generate a PDF for a record in the Ptv module (e.g., `Scheda`):

1.  **Create the View**
    Path: `Modules/Ptv/resources/views/scheda/show/pdf.blade.php`
    Naming Convention: `module::model-kebab.show.pdf`

2.  **Use the Action**
    ```php
    use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
    
    $record = Scheda::find(1);
    $pdfBinary = app(GetPdfContentByRecordAction::class)->execute($record);
    ```

## 📄 Template Structure (Blade)

We use `spipu/html2pdf` which requires specific HTML structure. **Do not use modern CSS (Flex/Grid).**

```blade
<page backtop="10mm" backbottom="10mm">
    <page_header>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left; width: 50%">PTV System</td>
                <td style="text-align: right; width: 50%">{{ date('d/m/Y') }}</td>
            </tr>
        </table>
    </page_header>
    
    <page_footer>
        <div style="text-align: center;">
            Page [[page_cu]]/[[page_nb]]
        </div>
    </page_footer>

    <h1>Scheda: {{ $row->id }}</h1>
    
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black; padding: 5px;">Field</td>
            <td style="border: 1px solid black; padding: 5px;">Value</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">Name</td>
            <td style="border: 1px solid black;">{{ $row->name }}</td>
        </tr>
    </table>
</page>
```

## 📧 Sending via Email

Use `RecordNotification` logic (see `Modules/Notify`).

```php
// Example in Action
$attachments = [
    [
        'data' => $pdfBinary,
        'as' => 'scheda_' . $record->id . '.pdf',
        'mime' => 'application/pdf',
    ]
];

$notification = new RecordNotification($record, 'template_name');
$notification->addAttachments($attachments);
```

## ⚠️ Common Pitfalls

-   **Images**: Use Base64 or absolute paths. Relative paths often fail.
-   **CSS**: No external CSS files. Inline styles only.
-   **Tables**: Use `width: 100%` on tables and defined widths on `td` to avoid layout breaks.
-   **Page Breaks**: Use `<page>` tags for explicit control.

---
**See Also**: [Xot PDF Technical Overview](../../Xot/docs/actions/pdf-actions-overview.md)
