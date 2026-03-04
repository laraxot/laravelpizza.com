# SpatieEmail Documentation

## Overview
The `SpatieEmail` class extends Spatie's `TemplateMailable` to provide enhanced email functionality with support for custom attachments, data merging, and multi-channel content generation (email and SMS). It serves as the core email handling component in the notification system.

## Location
`/laravel/Modules/Notify/app/Emails/SpatieEmail.php`

## Class Structure

### Namespace
```php
namespace Modules\Notify\Emails;
```

### Inheritance
Extends `Spatie\MailTemplates\TemplateMailable`

### Dependencies
- `Illuminate\Database\Eloquent\Model` - Base model class
- `Illuminate\Mail\Attachment` - Laravel attachment handling
- `Spatie\MailTemplates\TemplateMailable` - Base template mailable class

## Properties

### Protected Properties
- `protected Model $record` - The model record associated with the email
- `protected string $slug` - Template identifier slug
- `protected array $customAttachments = []` - Array of custom attachment objects

### Public Properties
- `public array $data = []` - Additional data for template rendering

## Methods

### Constructor
Initializes the email with a model record and template slug.

#### Parameters
- `Model $record` - The model record for the email
- `string $slug` - Template identifier

### addAttachments()
Enhanced method to add attachments from various sources (file paths or raw data).

#### Parameters
- `array $attachments` - Array of attachment configurations

#### Return Type
`self` - Returns the email instance for method chaining

#### Implementation Details
```php
public function addAttachments(array $attachments): self
{
    $attachmentObjects = [];
    foreach ($attachments as $item) {
        $attachment = null;
        if (isset($item['path']) && file_exists($item['path'])) {
            $attachment = $this->getAttachmentFromPath($item);
        }
        if($attachment == null && isset($item['data'])){
            $attachment = $this->getAttachmentFromData($item);
        }
        if ($attachment) {
            $attachmentObjects[] = $attachment;
        }
    }
    $this->customAttachments = $attachmentObjects;
    return $this;
}
```

#### Process Flow
1. **Iteration**: Loops through each attachment configuration
2. **Path-based Attachments**: Checks for `path` key and file existence
3. **Data-based Attachments**: Falls back to raw `data` if path not available
4. **Validation**: Only adds valid attachment objects
5. **Storage**: Stores attachments in `customAttachments` property

### attachments()
Returns the array of attachment objects for email sending.

#### Return Type
`array` - Array of Laravel `Attachment` objects

#### Implementation
```php
public function attachments(): array
{
    dddx($this->customAttachments); // Debug output
    return $this->customAttachments;
}
```

**Note**: Contains debug output (`dddx()`) that should be removed in production.

### getAttachmentFromPath()
Creates an attachment object from a file path.

#### Parameters
- `array $item` - Attachment configuration with `path` key

#### Return Type
`Attachment|null` - Laravel attachment object or null if failed

#### Expected Configuration
```php
[
    'path' => '/path/to/file.pdf',
    'as' => 'custom-filename.pdf', // Optional custom name
    'mime' => 'application/pdf'    // Optional MIME type
]
```

### getAttachmentFromData()
Creates an attachment object from raw data.

#### Parameters
- `array $item` - Attachment configuration with `data` key

#### Return Type
`Attachment|null` - Laravel attachment object or null if failed

#### Expected Configuration
```php
[
    'data' => $binaryContent,      // Raw file content
    'as' => 'filename.pdf',        // Required filename
    'mime' => 'application/pdf'    // Optional MIME type
]
```

### mergeData()
Merges additional data into the email's data array.

#### Parameters
- `array $data` - Data to merge

#### Return Type
`self` - Returns the email instance for method chaining

#### Implementation
```php
public function mergeData(array $data): self
{
    $this->data = array_merge($this->data, $data);
    return $this;
}
```

### buildSms()
Generates SMS content from the email template.

#### Return Type
`string` - SMS message content

#### Purpose
Allows reusing email templates for SMS notifications by extracting text content suitable for SMS delivery.

## Attachment Handling

### Supported Attachment Types

#### File Path Attachments
```php
[
    'path' => '/storage/reports/report-123.pdf',
    'as' => 'appointment-report.pdf',
    'mime' => 'application/pdf'
]
```

#### Raw Data Attachments
```php
[
    'data' => $pdfBinaryContent,
    'as' => 'generated-report.pdf',
    'mime' => 'application/pdf'
]
```

### Attachment Processing Logic
1. **Priority**: Path-based attachments are processed first
2. **Fallback**: If path fails, attempts data-based attachment
3. **Validation**: File existence checked for path-based attachments
4. **Error Handling**: Invalid attachments are silently skipped

### Laravel Attachment Integration
The class creates Laravel `Attachment` objects that integrate seamlessly with Laravel's mail system:

```php
// Path-based
Attachment::fromPath($item['path'])
    ->as($item['as'] ?? basename($item['path']))
    ->withMime($item['mime'] ?? null);

// Data-based
Attachment::fromData($item['data'], $item['as'])
    ->withMime($item['mime'] ?? null);
```

## Usage Examples

### Basic Email
```php
$email = new SpatieEmail($appointment, 'appointment-confirmation');
$email->to('patient@example.com');
```

### With Additional Data
```php
$email = new SpatieEmail($appointment, 'appointment-reminder');
$email->mergeData([
    'doctor_name' => $appointment->doctor->name,
    'clinic_address' => $appointment->clinic->address
]);
```

### With File Attachments
```php
$email = new SpatieEmail($appointment, 'report-completed');
$email->addAttachments([
    [
        'path' => '/storage/reports/report-123.pdf',
        'as' => 'medical-report.pdf'
    ]
]);
```

### With Generated PDF Attachments
```php
$email = new SpatieEmail($appointment, 'report-completed');
$email->addAttachments([
    [
        'data' => $generatedPdfContent,
        'as' => 'appointment-report.pdf',
        'mime' => 'application/pdf'
    ]
]);
```

### Method Chaining
```php
$email = (new SpatieEmail($record, 'notification-template'))
    ->mergeData($additionalData)
    ->addAttachments($attachments)
    ->to('recipient@example.com');
```

## Integration with Spatie MailTemplates

### Template Resolution
The class uses Spatie's template system to resolve email templates based on the slug:
- Templates are stored in the database via `MailTemplate` model
- Slug is used to identify the correct template
- Template content is rendered with merged data

### Template Data
Available data in templates:
- `$record` - The model record passed to constructor
- All data from `$this->data` array (merged via `mergeData()`)
- Standard Laravel mail template variables

## Integration with Notification System

### In RecordNotification
```php
public function toMail($notifiable): SpatieEmail
{
    $email = new SpatieEmail($this->record, $this->slug);
    $email = $email->mergeData($this->data);
    $email = $email->addAttachments($this->attachments);
    
    if (method_exists($notifiable, 'routeNotificationFor')) {
        $to = $notifiable->routeNotificationFor('mail');
        $email->to($to);
        if ($to) {
            $email->setRecipient($to);
        }
    }
    
    return $email;
}
```

### In State Transitions
```php
// Generate PDF and attach to email
$attachments = [
    [
        'data' => app(ContentPdfAction::class)->execute(...),
        'as' => 'report.pdf'
    ]
];

$notification = new RecordNotification($record, 'report-completed');
$notification->addAttachments($attachments);
```

## Error Handling

### Current Limitations
1. **Silent Failures**: Invalid attachments are silently skipped
2. **No Validation**: No validation of attachment data structure
3. **Debug Code**: Contains debug output in production code

### Recommended Improvements
```php
public function addAttachments(array $attachments): self
{
    $attachmentObjects = [];
    foreach ($attachments as $item) {
        try {
            $attachment = null;
            
            // Validate attachment structure
            if (!is_array($item)) {
                \Log::warning('Invalid attachment structure', ['item' => $item]);
                continue;
            }
            
            if (isset($item['path']) && file_exists($item['path'])) {
                $attachment = $this->getAttachmentFromPath($item);
            } elseif (isset($item['data'])) {
                $attachment = $this->getAttachmentFromData($item);
            } else {
                \Log::warning('Attachment missing path or data', ['item' => $item]);
                continue;
            }
            
            if ($attachment) {
                $attachmentObjects[] = $attachment;
            }
        } catch (\Exception $e) {
            \Log::error('Failed to process attachment', [
                'item' => $item,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    $this->customAttachments = $attachmentObjects;
    return $this;
}
```

## Performance Considerations

### Memory Usage
- Large attachments are loaded into memory
- Consider streaming for very large files
- Monitor memory usage with multiple attachments

### File System Access
- Path-based attachments require file system access
- Consider caching for frequently accessed files
- Validate file permissions and accessibility

## Security Considerations

### File Path Validation
```php
// Recommended: Validate file paths
private function validateFilePath(string $path): bool
{
    $realPath = realpath($path);
    $allowedBasePath = realpath(storage_path('app'));
    
    return $realPath && 
           strpos($realPath, $allowedBasePath) === 0 && 
           is_readable($realPath);
}
```

### Data Sanitization
- Validate attachment data before processing
- Sanitize filenames to prevent path traversal
- Implement file type validation

## Testing Considerations

### Test Scenarios
1. **Path Attachments**: Test with valid/invalid file paths
2. **Data Attachments**: Test with various data types and sizes
3. **Mixed Attachments**: Test combinations of path and data attachments
4. **Error Handling**: Test with malformed attachment configurations
5. **Memory Limits**: Test with large attachments

### Mock Requirements
- Mock file system for path-based tests
- Mock Laravel Attachment class
- Mock Spatie TemplateMailable functionality

## Related Files
- `RecordNotification.php` - Uses SpatieEmail for notification delivery
- `MailTemplate.php` - Database-stored email templates
- `SmsData.php` - SMS content generation
- `BaseTransition.php` - State transition notification integration

## Future Improvements

### Recommended Enhancements
1. **Error Handling**: Comprehensive error handling and logging
2. **Validation**: Attachment data structure validation
3. **Performance**: Streaming support for large attachments
4. **Security**: File path and type validation
5. **Debugging**: Remove debug code and add proper logging
6. **Caching**: Template and attachment caching
7. **Async Processing**: Background attachment processing for large files

## Notes
- Remove `dddx()` debug output before production deployment
- Consider implementing attachment size limits
- The class bridges Spatie's template system with Laravel's attachment handling
- SMS content generation reuses email templates for consistency
