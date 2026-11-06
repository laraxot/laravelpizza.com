<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Modules\AI\Actions\PredictionDraftFallbackTemplatesAction;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('PredictionDraftFallbackTemplates Action', function (): void {
    test('_returns_expected_template_categories', function (): void {
        $action = new PredictionDraftFallbackTemplatesAction;
        $result = $action->execute();

        Assert::assertNotEmpty($result);

        Assert::assertEqualsCanonicalizing(
            ['category', 'title', 'subtitle', 'description', 'analysis', 'tags', 'options'],
            array_keys($result[0]),
        );

        // Verify that we have multiple categories
        $categories = array_unique(array_column($result, 'category'));
        Assert::assertGreaterThanOrEqual(5, count($categories));

        // Verify required fields for each template
        foreach ($result as $template) {
            Assert::assertNotEmpty($template['category']);
            Assert::assertNotEmpty($template['title']);
            Assert::assertNotEmpty($template['subtitle']);
            Assert::assertNotEmpty($template['description']);
            Assert::assertNotEmpty($template['analysis']);
            Assert::assertIsArray($template['tags']);
            Assert::assertIsArray($template['options']);
        }
    });

    test('_has_expected_categories_present', function (): void {
        $action = new PredictionDraftFallbackTemplatesAction;
        $result = $action->execute();

        $categories = array_column($result, 'category');

        Assert::assertContains('Sport', $categories);
        Assert::assertContains('Crypto', $categories);
        Assert::assertContains('Politica', $categories);
        Assert::assertContains('Tecnologia', $categories);
        Assert::assertContains('Economia', $categories);
    });

    test('_templates_contain_options', function (): void {
        $action = new PredictionDraftFallbackTemplatesAction;
        $result = $action->execute();

        foreach ($result as $template) {
            if ($template['category'] === 'Economia') {
                Assert::assertContains('0.25%', $template['options']);
                Assert::assertContains('0.50%', $template['options']);
                Assert::assertContains('Mantenimento', $template['options']);
                Assert::assertContains('Altro', $template['options']);
            } else {
                Assert::assertContains('Sì', $template['options']);
                Assert::assertContains('No', $template['options']);
            }
        }
    });

    test('_templates_have_tags', function (): void {
        $action = new PredictionDraftFallbackTemplatesAction;
        $result = $action->execute();

        foreach ($result as $template) {
            Assert::assertNotEmpty($template['tags']);
            Assert::assertIsArray($template['tags']);
            Assert::assertNotEmpty(current($template['tags']));
        }
    });

    test('_template_structure_matches_expectation', function (): void {
        $action = new PredictionDraftFallbackTemplatesAction;
        $result = $action->execute();

        Assert::assertNotEmpty($result);

        // Verify the first template has all expected structure
        $firstTemplate = $result[0];
        $expectedKeys = ['category', 'title', 'subtitle', 'description', 'analysis', 'tags', 'options'];

        foreach ($expectedKeys as $key) {
            Assert::assertArrayHasKey($key, $firstTemplate);
        }

        // Verify data types
        Assert::assertIsString($firstTemplate['category']);
        Assert::assertIsString($firstTemplate['title']);
        Assert::assertIsString($firstTemplate['subtitle']);
        Assert::assertIsString($firstTemplate['description']);
        Assert::assertIsString($firstTemplate['analysis']);
        Assert::assertIsArray($firstTemplate['tags']);
        Assert::assertIsArray($firstTemplate['options']);
    });
});
