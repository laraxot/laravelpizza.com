# Packages advanced — reference

Packages not covered in `packages-spatie.md`, `packages-laravel-core.md`, `packages-filament-livewire.md`, or `packages-other.md`. All confirmed present in `composer.json` as of February 2026.

---

## Eloquent model patterns

### tightenco/parental 1.5.0

Single Table Inheritance (STI) for Eloquent.

**Where used**: `Modules/User/Models/BaseUser.php`, `BaseProfile.php`, `BaseTeamUser.php`

```php
use Parental\HasChildren;

class BaseUser extends Authenticatable
{
    use HasChildren; // single users table, type discriminator column
}

class Doctor extends BaseUser {}   // same table, type = 'Doctor'
class Patient extends BaseUser {}  // same table, type = 'Patient'
```

`HasChildren` on the parent; child classes need no extra trait. Queries on `Doctor::all()` automatically filter by `type`.

---

### staudenmeir/laravel-adjacency-list 1.25.2

Recursive tree relations using closure table.

**Where used**: `Modules/Xot/Models/BaseTreeModel.php`, `Modules/Cms/Models/Menu.php`, `Modules/Limesurvey/Models/LimeSurvey.php`, `LimeQuestion.php`

```php
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class BaseTreeModel extends BaseModel
{
    use HasRecursiveRelationships;
}

class Menu extends BaseTreeModel {}
```

**Relations**: `ancestors`, `descendants`, `children`, `parent`, `siblings`, `bloodline`

**Scopes**: `::tree()`, `::isRoot()`, `::isLeaf()`, `::hasChildren()`, `::breadthFirst()`, `::depthFirst()`, `->whereDepth($op, $n)`

---

### staudenmeir/laravel-cte 1.12.4

Common Table Expressions (WITH queries) on Eloquent builders.

```php
use Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;

class MyModel extends BaseModel
{
    use QueriesExpressions;
}

MyModel::withExpression('cte', fn($q) => $q->select(...))
    ->from('cte')
    ->get();
```

---

### fidum/laravel-eloquent-morph-to-one 2.5.0

`HasMorphOne` typed relation helper.

**Where used**: `Modules/Xot/Models/Traits/HasExtraTrait.php`, `Modules/User/Models/Traits/HasAuthenticationLogTrait.php`

```php
// Polymorphic one-to-one to the Extra model across all model types
public function extra(): MorphOne
{
    return $this->morphOne($extra_class, 'model');
}
```

---

### anourvalar/eloquent-serialize 1.3.5

Serialize/unserialize Eloquent query builders for caching and queues.

```php
$serialized = $query->serialize();
cache()->put('q', $serialized, 3600);

$query = cache()->get('q')->unserialize();
$results = $query->get();
```

---

### mikebronner/laravel-pivot-events 12.0.0

Fires events when pivot rows are attached, detached, or updated.

**Where used**: User module (attach/detach language assignments)

```php
// Listen in EventServiceProvider
User::attachingLanguage(fn($user, $ids, $attributes) => ...);
User::detachingLanguage(fn($user, $ids) => ...);
```

---

### staudenmeir/eloquent-has-many-deep (already in packages-other.md)

---

## Object hydration

### cuyz/valinor 2.3.2

Strict PHP object hydration with full type validation.

```php
use CuyZ\Valinor\MapperBuilder;

$mapper = (new MapperBuilder())->mapper();
$dto = $mapper->map(MyDto::class, $source); // throws on type mismatch
```

Use instead of `new MyDto(...$data)` when input comes from untrusted sources (API, JSON, DB).

---

## Filament integration

### lara-zeus/spatie-translatable 2.0.0

Filament 5 plugin that adds language-switcher tabs to forms for `spatie/laravel-translatable` fields.

**Where used**: `Modules/Lang/app/Providers/Filament/AdminPanelProvider.php`, `Modules/Notify/app/Providers/Filament/AdminPanelProvider.php`

```php
// Register plugin in panel provider
->plugins([
    \LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin::make(),
])

// Model
class MailTemplate extends SpatieMailTemplate
{
    use HasTranslations;
    /** @var list<string> */
    public array $translatable = ['subject', 'html_template', 'text_template'];
}
```

---

## WYSIWYG

### ueberdosis/tiptap-php 2.1.0

Server-side Tiptap editor content parsing, sanitisation, and conversion.

```php
use Tiptap\Editor;

$editor = new Editor(['content' => $json]);
$html = $editor->getHTML();
$text = $editor->getText();
$json = $editor->getJSON();
```

---

## Cloud storage

### aws/aws-sdk-php 3.371.0

Amazon Web Services SDK. Core client for S3, STS, CloudFront.

**Where used**: `Modules/Media/app/Actions/S3/BaseS3Action.php`, `Modules/Media/app/Filament/Clusters/Test/Pages/AwsTest.php`

```php
use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Aws\Exception\AwsException;

$s3 = new S3Client([
    'region'  => config('media.aws.region', 'us-east-1'),
    'version' => '2006-03-01',
    'credentials' => [
        'key'    => config('media.aws.access_key_id'),
        'secret' => config('media.aws.secret_access_key'),
    ],
]);

// Common operations
$s3->headBucket(['Bucket' => $bucket]);
$s3->listObjectsV2(['Bucket' => $bucket, 'Prefix' => 'path/']);
$s3->putObject(['Bucket' => $bucket, 'Key' => $key, 'Body' => $body]);
$s3->getObject(['Bucket' => $bucket, 'Key' => $key]);
$s3->deleteObject(['Bucket' => $bucket, 'Key' => $key]);

// Verify credentials
$sts = new StsClient(['region' => 'us-east-1', 'version' => 'latest']);
$identity = $sts->getCallerIdentity([]);

try {
    $s3->headBucket(['Bucket' => $bucket]);
} catch (AwsException $e) {
    $code = $e->getAwsErrorCode(); // 'SignatureDoesNotMatch', 'NoSuchBucket', etc.
}
```

**Required env**:
```
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
```

---

### google/cloud-storage 1.49.2 + spatie/laravel-google-cloud-storage 2.3.4

Google Cloud Storage client + Laravel filesystem adapter. Infrastructure for multi-provider storage.

```php
// config/filesystems.php
'gcs' => [
    'driver'     => 'gcs',
    'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
    'key_file'   => env('GOOGLE_CLOUD_KEY_FILE'),
    'bucket'     => env('GOOGLE_CLOUD_BUCKET'),
],

Storage::disk('gcs')->put('file.pdf', $contents);
Storage::disk('gcs')->url('file.pdf');
```

---

## PDF generation

### spipu/html2pdf 5.3.3

HTML-to-PDF conversion. Used throughout the project for report generation.

**Where used**: `Modules/Xot/app/Actions/Pdf/Engine/SpipuPdfByHtmlAction.php`

```php
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'A4', 'it'); // orientation, format, lang
$html2pdf->setTestTdInOnePage(false);
$html2pdf->writeHTML($html);

// Output modes
$html2pdf->output($filePath, 'F'); // save to file
$html2pdf->output($filePath, 'D'); // browser download
$string = $html2pdf->output('', 'S'); // return string
```

Action `SpipuPdfByHtmlAction` wraps this with `QueueableAction`.

---

### tecnickcom/tcpdf 6.10.1

Low-level PHP PDF library. Used internally by `spipu/html2pdf`. JpGraph can also render directly to TCPDF for chart PDF export.

---

## GDPR

### statikbe/laravel-cookie-consent 1.11.4

Cookie consent banner with GDPR compliance.

**Where used**: `Modules/Gdpr/app/Providers/GdprServiceProvider.php`

```php
use Statikbe\CookieConsent\CookieConsentMiddleware;

// GdprServiceProvider::boot()
if (GdprData::make()->cookie_banner_on) {
    $router->pushMiddlewareToGroup('web', CookieConsentMiddleware::class);
}

// Translations live in: Modules/Gdpr/lang/cookie-consent/{locale}/texts.php
// Translation namespace: 'cookie-consent'
```

---

## Authentication

### pragmarx/google2fa 9.0.0

TOTP two-factor authentication.

**Where used**: `Modules/User/` (2FA service, tests)

```php
use PragmaRX\Google2FA\Google2FA;

$g2fa = new Google2FA;

// Setup (store $secret encrypted on user)
$secret = $g2fa->generateSecretKey();
$qrUrl  = $g2fa->getQRCodeUrl($company, $email, $secret);

// Verify
$valid = $g2fa->verifyKey($secret, $userCode);

// Get current OTP (for tests)
$code = $g2fa->getCurrentOtp($secret);
```

**Storage**: `users.two_factor_secret` (encrypted), `users.two_factor_recovery_codes` (encrypted array), `users.two_factor_enabled` (bool)
**Recovery codes**: 10 single-use codes generated on setup.

---

## Push notifications

### kreait/laravel-firebase 7.0.0 + laravel-notification-channels/fcm 6.0.1

Firebase Admin SDK and FCM notification channel.

**Where used**: `Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php`

```php
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageData;

$messageData = MessageData::fromArray([
    'type'  => 'notification',
    'title' => $title,
    'body'  => $body,
    'data'  => json_encode($extra),
]);

$message = CloudMessage::new()
    ->withToken($deviceToken)
    ->withHighestPossiblePriority()
    ->withData($messageData);

/** @var Messaging $messaging */
$messaging = app('firebase.messaging');
$messaging->send($message);
```

**Required env**:
```
FIREBASE_PROJECT_ID=
FIREBASE_API_KEY=
FIREBASE_CREDENTIALS_FILE=
```

**Device token storage**: `device_users.push_notifications_token`, `device_users.push_notifications_enabled`

---

## CSV

### league/csv 9.28.0

Elegant CSV reader/writer.

**Where used**: `Modules/Tenant/app/Models/Traits/SushiToCsv.php` — backs Sushi models with CSV files.

```php
use League\Csv\Reader;
use League\Csv\Writer;

// Read
$reader = Reader::createFromPath($path, 'r');
$reader->setHeaderOffset(0);
$rows   = iterator_to_array($reader->getRecords()); // array of assoc arrays
$header = $reader->getHeader();

// Append
$writer = Writer::createFromPath($path, 'a+');
$writer->insertOne($row);

// Overwrite
$writer = Writer::createFromPath($path, 'w+');
$writer->insertOne($header);
$writer->insertAll($rows);
```

`SushiToCsv` hooks into `creating`, `updating`, `deleting` model events to keep the CSV in sync.

---

## Security

### ezyang/htmlpurifier 4.19.0

HTML sanitisation. Strips dangerous tags/attributes from user-supplied HTML.

```php
use HTMLPurifier;
use HTMLPurifier_Config;

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
$clean = $purifier->purify($untrustedHtml);
```

### defuse/php-encryption 2.4.0

Authenticated symmetric encryption. Used indirectly via `encrypt()` / `decrypt()` helpers (Laravel wraps this).
Used directly for 2FA secrets in `Modules/User`.

---

## Localisation data

### rinvex/countries 9.1.0

Country data: ISO codes, names, currencies, phone prefixes, flags.

```php
use Rinvex\Countries\CountryLoader;

$country = country('IT');
$country->getName();       // 'Italy'
$country->getCurrency();   // 'EUR'
$country->getCallingCode(); // '39'
countries()->pluck('name', 'iso_3166_1_alpha2'); // for select lists
```

---

## Dev tooling

### barryvdh/laravel-debugbar 3.16.5

Debug toolbar for local development. Conditionally enabled via `APP_DEBUG=true`.

```php
// Direct usage (rare)
\Debugbar::addMessage('custom message');
\Debugbar::startMeasure('heavy-op');
// ...
\Debugbar::stopMeasure('heavy-op');
```

Integrated with Artisan in `Modules/Xot/app/Services/Artisan/Handlers/DebugbarCommandHandler.php`.

### barryvdh/laravel-ide-helper 3.6.1

Generates IDE completion files. Produces `@property` docblocks used in every model file.

```bash
php artisan ide-helper:generate     # _ide_helper.php
php artisan ide-helper:models -W    # writes @property to model files
php artisan ide-helper:meta         # PhpStorm meta
```

### cmgmyr/phploc 8.0.6

Static code metrics (lines, classes, methods, complexity).

```bash
./vendor/bin/phploc Modules/
```

### nunomaduro/phpinsights 2.14.0

Code quality analysis: complexity, style, architecture.

```bash
./vendor/bin/phpinsights
./vendor/bin/phpinsights analyse Modules/Xot
```

---

## Summary

| Package | Version | Module | Primary use |
|---------|---------|--------|-------------|
| tightenco/parental | 1.5.0 | User | STI for User/Profile/TeamUser |
| staudenmeir/laravel-adjacency-list | 1.25.2 | Xot, Cms, Limesurvey | Tree/hierarchy |
| staudenmeir/laravel-cte | 1.12.4 | Xot | CTEs |
| fidum/laravel-eloquent-morph-to-one | 2.5.0 | Xot, User | MorphOne typed |
| anourvalar/eloquent-serialize | 1.3.5 | (core) | Query serialisation |
| mikebronner/laravel-pivot-events | 12.0.0 | User | Pivot attach/detach events |
| cuyz/valinor | 2.3.2 | Xot | Strict object hydration |
| lara-zeus/spatie-translatable | 2.0.0 | Lang, Notify | Filament translation tabs |
| ueberdosis/tiptap-php | 2.1.0 | (core) | WYSIWYG server-side |
| aws/aws-sdk-php | 3.371.0 | Media | S3, STS, CloudFront |
| google/cloud-storage | 1.49.2 | (infra) | GCS client |
| spatie/laravel-google-cloud-storage | 2.3.4 | (infra) | GCS filesystem driver |
| spipu/html2pdf | 5.3.3 | Xot, Quaeris | HTML to PDF |
| tecnickcom/tcpdf | 6.10.1 | Chart | PDF engine (used by html2pdf) |
| statikbe/laravel-cookie-consent | 1.11.4 | Gdpr | Cookie banner |
| pragmarx/google2fa | 9.0.0 | User | TOTP 2FA |
| kreait/laravel-firebase | 7.0.0 | Notify | Firebase admin |
| laravel-notification-channels/fcm | 6.0.1 | Notify | FCM push channel |
| league/csv | 9.28.0 | Tenant | CSV-backed Sushi models |
| ezyang/htmlpurifier | 4.19.0 | (global) | HTML sanitisation |
| defuse/php-encryption | 2.4.0 | User | 2FA encryption |
| rinvex/countries | 9.1.0 | Lang | Country data |
| barryvdh/laravel-debugbar | 3.16.5 | Xot (dev) | Debug toolbar |
| barryvdh/laravel-ide-helper | 3.6.1 | All (dev) | IDE completion |
| cmgmyr/phploc | 8.0.6 | (CI) | Code metrics |
| nunomaduro/phpinsights | 2.14.0 | Xot (dev) | Quality analysis |
