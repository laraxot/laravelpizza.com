# StreamDownloadPdfAction Documentation

## Overview
The `StreamDownloadPdfAction` is a QueueableAction class that generates PDF documents from HTML content and provides them as streamable downloads. It uses the Spipu\Html2Pdf library for PDF generation.

## Location
`/laravel/Modules/Xot/app/Actions/Pdf/StreamDownloadPdfAction.php`

## Class Structure

### Namespace
```php
namespace Modules\Xot\Actions\Pdf;
```

### Dependencies
- `Spipu\Html2Pdf\Html2Pdf` - PDF generation engine
- `Webmozart\Assert\Assert` - Assertion library for validation
- `Modules\Xot\Datas\PdfData` - PDF data structure
- `Illuminate\Support\Facades\Storage` - Laravel storage facade
- `Spatie\QueueableAction\QueueableAction` - Queueable action trait
- `Symfony\Component\HttpFoundation\BinaryFileResponse` - HTTP response handling

### Properties
- `public PdfEngineEnum $engine` - PDF engine configuration

## Methods

### execute()
Generates a PDF from HTML content and returns a streamable download response.

#### Parameters
- `?string $html` - Direct HTML content to convert (optional)
- `?string $view` - Blade view name to render (optional)
- `?array $data` - Data to pass to the view (optional)
- `string $filename` - Output filename (default: 'my_doc.pdf')

#### Return Type
`\Symfony\Component\HttpFoundation\StreamedResponse`

#### Logic Flow
1. **HTML Generation**: If `$html` is null and `$view` is provided:
   - Validates view existence using `view()->exists()`
   - Renders view with provided data
   - Throws exception if view not found

2. **PDF Configuration**: 
   - Creates Html2Pdf instance with:
     - Orientation: Portrait ('P')
     - Format: A4
     - Language: Italian ('it')
     - Unicode: true
     - Encoding: UTF-8
     - Margins: [10, 10, 10, 10]

3. **PDF Generation**:
   - Writes HTML content to PDF using `writeHTML()`
   - Returns StreamedResponse with PDF output
   - Filename prefixed with 'report-'

## Usage Examples

### Direct HTML Content
```php
$action = new StreamDownloadPdfAction();
$response = $action->execute(
    html: '<h1>Test PDF</h1><p>Content here</p>',
    filename: 'test.pdf'
);
```

### Using Blade View
```php
$action = new StreamDownloadPdfAction();
$response = $action->execute(
    view: 'reports.appointment',
    data: ['appointment' => $appointment],
    filename: 'appointment-report.pdf'
);
```

## Configuration Details

### PDF Settings
- **Page Size**: A4
- **Orientation**: Portrait
- **Language**: Italian
- **Encoding**: UTF-8
- **Margins**: 10mm on all sides
- **Unicode Support**: Enabled

### Error Handling
- Throws exception if specified view doesn't exist
- Uses `Assert::string($html)` to validate HTML content

## Integration Points

### With Notification System
This action is designed to work with the notification system to generate PDF attachments:

```php
// In transition classes
$data = app(ContentPdfAction::class)->execute(
    view: 'pub_theme::appointment.report_pdf',
    data: ['appointment' => $this->appointment],
    filename: 'report-' . $this->appointment->id . '.pdf'
);
```

### With Email Attachments
Generated PDF data can be attached to emails through the notification system.

## Best Practices

1. **View Validation**: Always ensure views exist before rendering
2. **Data Sanitization**: Validate and sanitize data passed to views
3. **Filename Convention**: Use descriptive filenames with appropriate prefixes
4. **Error Handling**: Implement proper exception handling for view and PDF generation errors
5. **Memory Management**: Consider memory usage for large HTML content

## HTML2PDF Limitations

### Supported HTML Tags
- Basic structure: `<page>`, `<table>`, `<tr>`, `<td>`, `<div>`, `<br>`, `<p>`, `<span>`
- Formatting: `<b>`, `<i>`, `<u>`, `<strong>`, `<em>`
- Images: `<img>` (with limitations)
- Lists: `<ul>`, `<ol>`, `<li>`

### Supported CSS Properties
- Basic properties: `color`, `background-color`, `font-size`, `font-family`, `text-align`
- Border and padding (with limitations)
- **NOT supported**: flexbox, grid, advanced positioning, gradients, shadows, transforms

### Best Practices for PDF Templates
1. Use tables for layout instead of CSS positioning
2. Avoid complex visual effects
3. Test PDF output thoroughly
4. Use `<page>` tags for page control
5. Minimize nested structures
6. Limit font variety for performance

## Related Files
- `ContentPdfAction.php` - Content-specific PDF generation action
- `Modules\Notify\Emails\SpatieEmail.php` - Email attachment handling
- `Modules\<nome progetto>\States\Appointment\Transitions\ReportPendingToReportCompleted.php` - Usage example

## Notes
- The action uses QueueableAction trait, making it suitable for background processing
- PDF generation is synchronous within the action execution
- The Italian language setting affects date formatting and text direction
- UTF-8 encoding ensures proper handling of international characters
