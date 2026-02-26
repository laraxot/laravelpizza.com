# ContentPdfAction Documentation

## Overview
The `ContentPdfAction` is a QueueableAction class that generates PDF content as binary data, specifically designed for email attachments. Unlike `StreamDownloadPdfAction` which returns a download response, this action returns raw PDF content that can be attached to emails or stored.

## Location
`/laravel/Modules/Xot/app/Actions/Pdf/ContentPdfAction.php`

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

### Properties
- `public PdfEngineEnum $engine` - PDF engine configuration

## Methods

### execute()
Main method that generates PDF content from HTML or Blade views.

#### Parameters
- `?string $html` - Direct HTML content to convert (optional)
- `?string $view` - Blade view name to render (optional)
- `?array $data` - Data to pass to the view (optional)
- `string $filename` - Filename for reference (default: 'my_doc.pdf')

#### Return Type
`string` - Binary PDF content

#### Logic Flow
1. **HTML Generation**: If `$html` is null and `$view` is provided:
   - Validates view existence using `view()->exists()`
   - Renders view with provided data
   - Throws exception if view not found

2. **Content Validation**: 
   - Uses `Assert::string()` to ensure HTML content is available

3. **PDF Configuration**: 
   - Creates Html2Pdf instance with identical settings to StreamDownloadPdfAction:
     - Orientation: Portrait ('P')
     - Format: A4
     - Language: Italian ('it')
     - Unicode: true
     - Encoding: UTF-8
     - Margins: [10, 10, 10, 10]

4. **PDF Generation**:
   - Writes HTML content using `writeHTML()`
   - Returns binary content using `output('', 'S')`

### fromView()
Convenience method for generating PDF from Blade views.

#### Parameters
- `string $view` - Blade view name
- `array $data` - Data to pass to view (default: [])
- `string $filename` - Filename for reference (default: 'document.pdf')

#### Return Type
`string` - Binary PDF content

#### Usage
```php
$pdfContent = app(ContentPdfAction::class)->fromView(
    'reports.appointment',
    ['appointment' => $appointment],
    'appointment-report.pdf'
);
```

### fromHtml()
Convenience method for generating PDF from HTML content.

#### Parameters
- `string $html` - HTML content
- `string $filename` - Filename for reference (default: 'document.pdf')

#### Return Type
`string` - Binary PDF content

#### Usage
```php
$pdfContent = app(ContentPdfAction::class)->fromHtml(
    '<h1>Report</h1><p>Content here</p>',
    'simple-report.pdf'
);
```

## Usage Examples

### In State Transitions
```php
// In ReportPendingToReportCompleted transition
public function getNotificationAttachments(): array
{
    $view = 'pub_theme::appointment.report_pdf';
    $data = ['appointment' => $this->appointment];
    $filename = 'report-' . $this->appointment->id . '.pdf';
    
    $pdfContent = app(ContentPdfAction::class)->execute(
        view: $view,
        data: $data,
        filename: $filename
    );

    return [
        [
            'as' => $filename,
            'data' => $pdfContent,
        ]
    ];
}
```

### Direct HTML Content
```php
$action = new ContentPdfAction();
$pdfContent = $action->execute(
    html: '<h1>Test PDF</h1><p>Content here</p>',
    filename: 'test.pdf'
);

// Use in email attachment
$attachments = [
    [
        'data' => $pdfContent,
        'as' => 'test.pdf',
        'mime' => 'application/pdf'
    ]
];
```

### Using Blade View
```php
$action = new ContentPdfAction();
$pdfContent = $action->execute(
    view: 'reports.appointment',
    data: ['appointment' => $appointment],
    filename: 'appointment-report.pdf'
);
```

## Differences from StreamDownloadPdfAction

| Feature | ContentPdfAction | StreamDownloadPdfAction |
|---------|------------------|-------------------------|
| Return Type | `string` (binary content) | `StreamedResponse` |
| Use Case | Email attachments, storage | Direct download |
| Output Method | `output('', 'S')` | `response()->streamDownload()` |
| Integration | Notification system | Web controllers |

## Integration with Email System

### With SpatieEmail
```php
$pdfContent = app(ContentPdfAction::class)->fromView(
    'reports.medical',
    ['patient' => $patient, 'report' => $report]
);

$email = new SpatieEmail($record, 'medical-report');
$email->addAttachments([
    [
        'data' => $pdfContent,
        'as' => 'medical-report.pdf',
        'mime' => 'application/pdf'
    ]
]);
```

### With RecordNotification
```php
$notification = new RecordNotification($appointment, 'report-completed');
$notification->addAttachments([
    [
        'data' => app(ContentPdfAction::class)->fromView(
            'pub_theme::appointment.report_pdf',
            ['appointment' => $appointment]
        ),
        'as' => 'appointment-report.pdf'
    ]
]);
```

## Error Handling

### Current Implementation
- Throws `\Exception` if specified view doesn't exist
- Uses `Assert::string()` to validate HTML content
- No explicit error handling for PDF generation failures

### Recommended Improvements
```php
public function execute(
    ?string $html = null,
    ?string $view = null,
    ?array $data = null,
    string $filename = 'my_doc.pdf'
): string {
    try {
        // Generate HTML content if view is provided
        if ($html === null && $view !== null) {
            if (!view()->exists($view)) {
                throw new \Exception("View '{$view}' not found");
            }
            if (!is_array($data)) {
                $data = [];
            }
            $html = view($view, $data)->render();
        }
        
        // Validate that we have HTML content
        if (empty($html)) {
            throw new \Exception('HTML content must be provided either directly or via view rendering');
        }
        
        // Create and configure HTML2PDF
        $html2pdf = new Html2Pdf(
            orientation: 'P',
            format: 'A4',
            lang: 'it',
            unicode: true,
            encoding: 'UTF-8',
            margins: [10, 10, 10, 10]
        );
        
        // Generate PDF
        $html2pdf->writeHTML($html);
        return $html2pdf->output('', 'S');
        
    } catch (\Exception $e) {
        \Log::error('PDF generation failed', [
            'view' => $view,
            'filename' => $filename,
            'error' => $e->getMessage()
        ]);
        throw new \Exception("Failed to generate PDF: " . $e->getMessage(), 0, $e);
    }
}
```

## Performance Considerations

### Memory Usage
- PDF content is loaded entirely into memory
- Consider memory limits for large documents
- Monitor memory usage with complex HTML content

### Processing Time
- PDF generation is synchronous
- Complex HTML layouts increase processing time
- Consider background processing for large reports

### Optimization Tips
1. **Simplify HTML**: Use table-based layouts for better performance
2. **Limit Images**: Minimize image usage and optimize sizes
3. **Cache Templates**: Cache rendered HTML for repeated generation
4. **Background Processing**: Use queues for large PDF generation

## HTML2PDF Configuration

### Current Settings
- **Orientation**: Portrait ('P')
- **Format**: A4
- **Language**: Italian ('it')
- **Unicode**: Enabled
- **Encoding**: UTF-8
- **Margins**: 10mm on all sides

### Customization Options
The configuration matches StreamDownloadPdfAction for consistency. Future enhancements could include:
- Dynamic orientation selection
- Multiple format support
- Language detection from locale
- Configurable margins

## Best Practices

### Template Design
1. **Use Tables**: Table-based layouts work better than CSS positioning
2. **Avoid Complex CSS**: Stick to basic CSS properties
3. **Test Output**: Always test PDF output with real data
4. **Optimize Images**: Use appropriate image sizes and formats

### Data Handling
1. **Validate Data**: Ensure all required data is available
2. **Sanitize Content**: Clean user input before rendering
3. **Handle Null Values**: Provide defaults for missing data
4. **Escape Content**: Properly escape HTML content

### Error Management
1. **Log Errors**: Comprehensive error logging
2. **Graceful Degradation**: Handle failures gracefully
3. **User Feedback**: Provide meaningful error messages
4. **Monitoring**: Monitor PDF generation success rates

## Testing

### Unit Tests
```php
public function test_generates_pdf_from_html()
{
    $action = new ContentPdfAction();
    $html = '<h1>Test</h1><p>Content</p>';
    
    $result = $action->fromHtml($html, 'test.pdf');
    
    $this->assertIsString($result);
    $this->assertStringStartsWith('%PDF', $result); // PDF header
}

public function test_generates_pdf_from_view()
{
    $action = new ContentPdfAction();
    
    $result = $action->fromView('test.pdf-template', ['title' => 'Test']);
    
    $this->assertIsString($result);
    $this->assertStringStartsWith('%PDF', $result);
}

public function test_throws_exception_for_missing_view()
{
    $action = new ContentPdfAction();
    
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('View non-existent-view not found');
    
    $action->fromView('non-existent-view');
}
```

### Integration Tests
```php
public function test_pdf_content_works_with_email_attachments()
{
    $pdfContent = app(ContentPdfAction::class)->fromHtml('<h1>Test</h1>');
    
    $email = new SpatieEmail($this->record, 'test-template');
    $email->addAttachments([
        [
            'data' => $pdfContent,
            'as' => 'test.pdf'
        ]
    ]);
    
    $attachments = $email->attachments();
    $this->assertCount(1, $attachments);
}
```

## Related Files
- `StreamDownloadPdfAction.php` - Similar action for direct downloads
- `SpatieEmail.php` - Email class that uses PDF attachments
- `RecordNotification.php` - Notification class for email delivery
- `ReportPendingToReportCompleted.php` - Example usage in state transitions

## Future Enhancements

### Recommended Improvements
1. **Configuration**: Make PDF settings configurable
2. **Caching**: Implement PDF content caching
3. **Async Processing**: Support for background PDF generation
4. **Multiple Formats**: Support for different output formats
5. **Template Validation**: Validate templates before rendering
6. **Performance Monitoring**: Track generation times and memory usage
7. **Error Recovery**: Implement retry mechanisms for failed generations

## Notes
- Binary content returned is suitable for email attachments
- Uses identical HTML2PDF configuration as StreamDownloadPdfAction
- Designed specifically for integration with the notification system
- Memory usage scales with document complexity and size
