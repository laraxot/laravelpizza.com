# SmsFactorData Class Documentation

## Overview

The `SmsFactorData` class is a Spatie Laravel Data object that manages configuration and authentication for the SMSFactor SMS provider. It follows the same pattern as `AgiletelecomData` and provides a centralized way to handle SMSFactor-specific configuration.

## Class Structure

```php
namespace Modules\Notify\Datas\SMS;

use Spatie\LaravelData\Data;

class SmsFactorData extends Data
{
    public ?string $token;
    public ?string $base_url;
    public string $auth_type = 'bearer';
    public int $timeout = 30;
}
```

## Properties

### `$token`
- **Type**: `?string`
- **Description**: The authentication token for SMSFactor API
- **Configuration**: Set via `SMSFACTOR_TOKEN` environment variable
- **Required**: Yes

### `$base_url`
- **Type**: `?string`
- **Description**: The base URL for SMSFactor API endpoints
- **Configuration**: Set via `SMSFACTOR_BASE_URL` environment variable
- **Default**: `https://api.smsfactor.com`

### `$auth_type`
- **Type**: `string`
- **Description**: The authentication type used for API requests
- **Default**: `bearer`
- **Supported Values**: `bearer`

### `$timeout`
- **Type**: `int`
- **Description**: HTTP request timeout in seconds
- **Default**: `30`

## Methods

### `make(): self`
Static factory method that creates a singleton instance of `SmsFactorData` using configuration from `config('sms.drivers.smsfactor')`.

```php
$smsFactorData = SmsFactorData::make();
```

### `getAuthHeaders(): array`
Returns the authentication headers required for SMSFactor API requests.

```php
$headers = $smsFactorData->getAuthHeaders();
// Returns:
// [
//     'Authorization' => 'Bearer {token}',
//     'Content-Type' => 'application/json',
//     'Cache-Control' => 'no-cache'
// ]
```

### `getBaseUrl(): string`
Returns the base URL for SMSFactor API endpoints.

```php
$baseUrl = $smsFactorData->getBaseUrl();
// Returns: 'https://api.smsfactor.com'
```

### `getTimeout(): int`
Returns the HTTP request timeout value.

```php
$timeout = $smsFactorData->getTimeout();
// Returns: 30
```

## Configuration

The class reads configuration from the `sms.drivers.smsfactor` configuration array:

```php
// config/sms.php
'drivers' => [
    'smsfactor' => [
        'token' => env('SMSFACTOR_TOKEN'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
],
```

## Environment Variables

```env
SMSFACTOR_TOKEN=your_smsfactor_api_token
SMSFACTOR_BASE_URL=https://api.smsfactor.com
```

## Usage in Actions

The `SmsFactorData` class is used by `SendSmsFactorSMSAction` to handle configuration and authentication:

```php
class SendSmsFactorSMSAction implements SmsActionContract
{
    private SmsFactorData $smsFactorData;

    public function __construct()
    {
        $this->smsFactorData = SmsFactorData::make();
        
        if (!$this->smsFactorData->token) {
            throw new Exception('Token SMSFactor non configurato in sms.php');
        }
    }

    public function execute(SmsData $smsData): array
    {
        $headers = $this->smsFactorData->getAuthHeaders();
        $client = new Client([
            'timeout' => $this->smsFactorData->getTimeout(),
            'headers' => $headers
        ]);
        
        $response = $client->post(
            $this->smsFactorData->getBaseUrl() . '/messages', 
            ['json' => $body]
        );
    }
}
```

## Singleton Pattern

The class implements a singleton pattern through the `make()` method to ensure configuration is loaded only once per request:

```php
private static ?self $instance = null;

public static function make(): self
{
    if (! self::$instance instanceof SmsFactorData) {
        $data = Config::array('sms.drivers.smsfactor');
        self::$instance = self::from($data);
    }

    return self::$instance;
}
```

## Best Practices

1. **Always use the `make()` method** to create instances instead of direct instantiation
2. **Validate token presence** before using the data object for API calls
3. **Use the provided helper methods** (`getAuthHeaders()`, `getBaseUrl()`, `getTimeout()`) instead of accessing properties directly
4. **Configure environment variables** properly in production environments

## Related Classes

- `AgiletelecomData`: Similar data class for Agiletelecom SMS provider
- `SendSmsFactorSMSAction`: Action class that uses this data object
- `SmsData`: Data transfer object for SMS message data

## Migration from Direct Configuration

Before the introduction of `SmsFactorData`, the `SendSmsFactorSMSAction` accessed configuration directly:

```php
// Old approach (deprecated)
$config = config('sms.drivers.smsfactor');
$token = $config['token'] ?? null;
$baseUrl = $config['base_url'] ?? 'https://api.smsfactor.com';

// New approach (recommended)
$smsFactorData = SmsFactorData::make();
$token = $smsFactorData->token;
$baseUrl = $smsFactorData->getBaseUrl();
```

## Testing

When testing, you can create test instances with specific configuration:

```php
$testData = SmsFactorData::from([
    'token' => 'test_token',
    'base_url' => 'https://test.smsfactor.com',
    'timeout' => 10
]);
```
