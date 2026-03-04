# FullCalendar Scheduler License Key

## Overview
The `schedulerLicenseKey` setting is essential for enabling premium features in FullCalendar. It requires a valid license key which you must enter into your calendar configuration.

### Example Usage
```javascript
// a premium plugin
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: '<YOUR-LICENSE-KEY-GOES-HERE>',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

## Common Issues

### Outdated License Key
- **Cause**: License key warnings often occur when upgrading FullCalendar versions due to the expiration of the 1-year free upgrade policy.
- **Solutions**:
  1. Downgrade to a previous version.
  2. Purchase an additional year of support via email notification or by contacting [sales@fullcalendar.io](mailto:sales@fullcalendar.io).

### Invalid License Key
- **Cause**: Incorrect text pasted into the `schedulerLicenseKey` setting.
- **Solution**: Ensure the key is entered exactly as provided in your email or invoice. It should follow the format `XXXXXXXXXX-XXX-XXXXXXXXXX`.

## Additional Information
For further assistance or to renew your license, visit [FullCalendar Pricing](https://fullcalendar.io/pricing) or contact their support team.