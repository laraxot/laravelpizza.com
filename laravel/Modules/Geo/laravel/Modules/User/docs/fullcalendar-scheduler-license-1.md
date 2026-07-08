# FullCalendar Scheduler License Configuration

## License Key Overview

FullCalendar Scheduler requires a valid license key for use in production environments. The Scheduler is a premium add-on to FullCalendar that provides resource views and timeline functionality.

## License Types

1. **Development License**
   - Free for development and testing
   - Shows a red banner with "LICENSE NEEDED" message
   - Not suitable for production use

2. **Commercial License**
   - Required for production use
   - Removes the red banner
   - Available for purchase from [FullCalendar's pricing page](https://fullcalendar.io/pricing/)

## Configuration in <nome progetto>

### Setting the License Key

1. **Environment Configuration**
   Add your license key to your `.env` file:
   ```
   FULLCALENDAR_SCHEDULER_LICENSE=your-license-key-here
   ```

2. **Publish Configuration**
   Publish the FullCalendar configuration file:
   ```bash
   php artisan vendor:publish --tag=fullcalendar-config
   ```

3. **Update Config**
   In `config/fullcalendar.php`:
   ```php
   'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE'),
   ```

### Usage in Code

In your PanelProvider or where you configure FullCalendar:

```php
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

// ...

$calendarPlugin = FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
    // other configurations...
```

## Common Issues

### Invalid License Key

If you see a red banner with "LICENSE NEEDED", it means:
- No license key is set, or
- The provided license key is invalid

### Development Mode

In development, you can use the Scheduler without a license key, but you'll see a red banner. This is normal and expected behavior.

## Compliance

- Always ensure you have a valid license for production use
- Do not share or expose your license key in version control
- Purchase the appropriate license based on your deployment needs

## Support

For license-related issues, contact FullCalendar support:
- [FullCalendar Support](https://fullcalendar.io/support/)
- [License FAQ](https://fullcalendar.io/license/faq/)

## Version Compatibility

Ensure your license key is compatible with the version of FullCalendar Scheduler you're using. Check the [changelog](https://fullcalendar.io/changelog/) for version-specific requirements.
