<?php

/**
 * @see https://github.com/foothing/laravel-gdpr-consent
 */

declare(strict_types=1);

return [
    'treatments' => [
        [
            // A logical name for your treatment.
            'name' => 'gdpr.privacy',
            // You can specify which document
            // describes the treatment type
            // with a document version and url.
            // This part is optional.
            'documentVersion' => '1.0',
            'documentUrl' => env('PRIVACY_POLICY'),
            // Whether this treatment is active or not.
            // The reason why this flag is here is to
            // allow for progressive modifications, so you
            // can keep track of what the end user gave
            // consent to. So if you are upgrading or
            // changing the treatment the recommended
            // process is to deactivate the current one
            // then add a new record.
            'active' => true,
            // Set if this treatment is mandatory or optional.
            'required' => true,
            // A description text to be shown near a checkbox
            // or anywhere in your UI.
            'description' => 'gdpr.privacy.text',
            // UI weight, use this to choose what should be
            // listed first.
            'weight' => 0,
        ],
        [
            'name' => 'gdpr.marketing',
            'documentVersion' => '1.0',
            'documentUrl' => env('PRIVACY_POLICY'),
            'active' => true,
            'required' => false,
            'description' => 'gdpr.marketing.text',
            'weight' => 1,
        ],
    ],
];
