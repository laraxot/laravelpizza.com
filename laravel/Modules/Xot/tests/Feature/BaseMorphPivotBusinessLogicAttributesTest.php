<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Modules\Xot\Tests\Fixtures\Models\TestConcreteMorphPivot;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Base Morph Pivot Business Logic', function (): void {
    test('it can manage tags attributes', function (): void {
        // Arrange
        $tags = ['tag1', 'tag2', 'important'];

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('tags', $tags);

        // Act
        /** @var array<int, string> $pivotTags */
        $pivotTags = $pivot->getAttribute('tags');

        // Assert
        Assert::assertIsArray($pivotTags);
        Assert::assertContains('tag1', $pivotTags);
        Assert::assertContains('tag2', $pivotTags);
        Assert::assertContains('important', $pivotTags);
        Assert::assertCount(3, $pivotTags);
    });

    test('it can manage categories', function (): void {
        // Arrange
        $categories = ['category1', 'category2'];

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('categories', $categories);

        // Act
        /** @var array<int, string> $pivotCategories */
        $pivotCategories = $pivot->getAttribute('categories');

        // Assert
        Assert::assertIsArray($pivotCategories);
        Assert::assertContains('category1', $pivotCategories);
        Assert::assertContains('category2', $pivotCategories);
        Assert::assertCount(2, $pivotCategories);
    });

    test('it can manage permissions', function (): void {
        // Arrange
        $permissions = [
            'read' => true,
            'write' => false,
            'delete' => false,
        ];

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('permissions', $permissions);

        // Act
        /** @var array<string, bool> $pivotPermissions */
        $pivotPermissions = $pivot->getAttribute('permissions');

        // Assert
        Assert::assertIsArray($pivotPermissions);
        Assert::assertTrue($pivotPermissions['read']);
        Assert::assertFalse($pivotPermissions['write']);
        Assert::assertFalse($pivotPermissions['delete']);
    });

    test('it can manage settings', function (): void {
        // Arrange
        $settings = [
            'notifications' => true,
            'auto_save' => false,
            'timeout' => 30,
        ];

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('settings', $settings);

        // Act
        /** @var array<string, mixed> $pivotSettings */
        $pivotSettings = $pivot->getAttribute('settings');

        // Assert
        Assert::assertIsArray($pivotSettings);
        Assert::assertTrue($pivotSettings['notifications']);
        Assert::assertFalse($pivotSettings['auto_save']);
        Assert::assertEquals(30, $pivotSettings['timeout']);
    });

    test('it can manage notes', function (): void {
        // Arrange
        $notes = 'This is a test note for the pivot relationship';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('notes', $notes);

        // Act
        $pivotNotes = $pivot->getAttribute('notes');

        // Assert
        Assert::assertEquals($notes, $pivotNotes);
    });

    test('it can manage description', function (): void {
        // Arrange
        $description = 'Test description for pivot relationship';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('description', $description);

        // Act
        $pivotDescription = $pivot->getAttribute('description');

        // Assert
        Assert::assertEquals($description, $pivotDescription);
    });

    test('it can manage url', function (): void {
        // Arrange
        $url = 'https://example.com/pivot/123';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('url', $url);

        // Act
        $pivotUrl = $pivot->getAttribute('url');

        // Assert
        Assert::assertEquals($url, $pivotUrl);
    });

    test('it can manage image url', function (): void {
        // Arrange
        $imageUrl = 'https://example.com/images/pivot.jpg';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('image_url', $imageUrl);

        // Act
        $pivotImageUrl = $pivot->getAttribute('image_url');

        // Assert
        Assert::assertEquals($imageUrl, $pivotImageUrl);
    });

    test('it can manage external id', function (): void {
        // Arrange
        $externalId = 'ext_12345';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('external_id', $externalId);

        // Act
        $pivotExternalId = $pivot->getAttribute('external_id');

        // Assert
        Assert::assertEquals($externalId, $pivotExternalId);
    });

    test('it can manage source', function (): void {
        // Arrange
        $source = 'api_import';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('source', $source);

        // Act
        $pivotSource = $pivot->getAttribute('source');

        // Assert
        Assert::assertEquals($source, $pivotSource);
    });

    test('it can manage version', function (): void {
        // Arrange
        $version = '1.2.3';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('version', $version);

        // Act
        $pivotVersion = $pivot->getAttribute('version');

        // Assert
        Assert::assertEquals($version, $pivotVersion);
    });

    test('it can manage hash', function (): void {
        // Arrange
        $hash = 'abc123def456';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('hash', $hash);

        // Act
        $pivotHash = $pivot->getAttribute('hash');

        // Assert
        Assert::assertEquals($hash, $pivotHash);
    });

    test('it can manage checksum', function (): void {
        // Arrange
        $checksum = 'sha256:abc123def456';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('checksum', $checksum);

        // Act
        $pivotChecksum = $pivot->getAttribute('checksum');

        // Assert
        Assert::assertEquals($checksum, $pivotChecksum);
    });

    test('it can manage size', function (): void {
        // Arrange
        $size = 1024;

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('size', $size);

        // Act
        /** @var int $pivotSize */
        $pivotSize = $pivot->getAttribute('size');

        // Assert
        Assert::assertEquals($size, $pivotSize);
    });

    test('it can manage mime type', function (): void {
        // Arrange
        $mimeType = 'application/json';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('mime_type', $mimeType);

        // Act
        $pivotMimeType = $pivot->getAttribute('mime_type');

        // Assert
        Assert::assertEquals($mimeType, $pivotMimeType);
    });

    test('it can manage encoding', function (): void {
        // Arrange
        $encoding = 'UTF-8';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('encoding', $encoding);

        // Act
        $pivotEncoding = $pivot->getAttribute('encoding');

        // Assert
        Assert::assertEquals($encoding, $pivotEncoding);
    });

    test('it can manage language', function (): void {
        // Arrange
        $language = 'en';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('language', $language);

        // Act
        $pivotLanguage = $pivot->getAttribute('language');

        // Assert
        Assert::assertEquals($language, $pivotLanguage);
    });

    test('it can manage locale', function (): void {
        // Arrange
        $locale = 'en_US';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('locale', $locale);

        // Act
        $pivotLocale = $pivot->getAttribute('locale');

        // Assert
        Assert::assertEquals($locale, $pivotLocale);
    });

    test('it can manage timezone', function (): void {
        // Arrange
        $timezone = 'Europe/Rome';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('timezone', $timezone);

        // Act
        $pivotTimezone = $pivot->getAttribute('timezone');

        // Assert
        Assert::assertEquals($timezone, $pivotTimezone);
    });

    test('it can manage currency', function (): void {
        // Arrange
        $currency = 'EUR';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('currency', $currency);

        // Act
        $pivotCurrency = $pivot->getAttribute('currency');

        // Assert
        Assert::assertEquals($currency, $pivotCurrency);
    });

    test('it can manage decimal places', function (): void {
        // Arrange
        $decimalPlaces = 2;

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('decimal_places', $decimalPlaces);

        // Act
        /** @var int $pivotDecimalPlaces */
        $pivotDecimalPlaces = $pivot->getAttribute('decimal_places');

        // Assert
        Assert::assertEquals($decimalPlaces, $pivotDecimalPlaces);
    });

    test('it can manage rounding mode', function (): void {
        // Arrange
        $roundingMode = 'half_up';

        $pivot = new TestConcreteMorphPivot;
        $pivot->setAttribute('rounding_mode', $roundingMode);

        // Act
        $pivotRoundingMode = $pivot->getAttribute('rounding_mode');

        // Assert
        Assert::assertEquals($roundingMode, $pivotRoundingMode);
    });
});
