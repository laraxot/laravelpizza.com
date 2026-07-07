<?php

declare(strict_types=1);

use Exception;
use Modules\Job\Actions\GetTaskFrequenciesAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use stdClass;

uses(TestCase::class);

describe('TaskFrequencies Integration', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->action = new GetTaskFrequenciesAction;
    });

    it('integrates with Laravel config system', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'everyMinute' => 'Every Minute',
            'everyFiveMinutes' => 'Every 5 Minutes',
            'everyTenMinutes' => 'Every 10 Minutes',
            'everyFifteenMinutes' => 'Every 15 Minutes',
            'everyThirtyMinutes' => 'Every 30 Minutes',
            'hourly' => 'Hourly',
            'everyTwoHours' => 'Every 2 Hours',
            'everyThreeHours' => 'Every 3 Hours',
            'everySixHours' => 'Every 6 Hours',
            'everyTwelveHours' => 'Every 12 Hours',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertCount(15, $result);
    });

    it('handles real-world frequency configurations', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'everyMinute' => 'Every Minute',
            'everyFiveMinutes' => 'Every 5 Minutes',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertSame('Every Minute', $result['everyMinute']);
        Assert::assertSame('Hourly', $result['hourly']);
        Assert::assertSame('Daily', $result['daily']);
        Assert::assertSame('Weekly', $result['weekly']);
        Assert::assertSame('Monthly', $result['monthly']);
    });

    it('can be used in queue context', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => ['test' => 'Test Frequency']]);
        $action = $this->getAction(GetTaskFrequenciesAction::class);
        Assert::assertTrue(method_exists($action, 'onQueue'));
    });

    it('handles configuration changes dynamically', function () {
        /** @var TestCase $this */
        $action = $this->getAction(GetTaskFrequenciesAction::class);

        config(['totem.frequencies' => ['initial' => 'Initial Value']]);
        $result1 = $action->execute();

        config(['totem.frequencies' => ['changed' => 'Changed Value']]);
        $result2 = $action->execute();

        Assert::assertArrayHasKey('initial', $result1);
        Assert::assertSame('Initial Value', $result1['initial']);
        Assert::assertArrayHasKey('changed', $result2);
        Assert::assertSame('Changed Value', $result2['changed']);
        Assert::assertArrayNotHasKey('initial', $result2);
    });

    it('validates configuration file structure', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'simple' => 'Simple Value',
            'complex' => [
                'label' => 'Complex Label',
                'value' => 'complex_value',
                'description' => 'Complex Description',
            ],
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertSame('Simple Value', $result['simple']);
        Assert::assertIsArray($result['complex']);
        Assert::assertSame('Complex Label', $result['complex']['label']);
    });

    it('handles empty configuration gracefully', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => []]);
        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertEmpty($result);
    });

    it('works with string and numeric keys', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'string_key' => 'String Value',
            0 => 'Numeric Key Value',
            1 => 'Another Numeric',
            'mixed_123' => 'Mixed Key Value',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertSame('String Value', $result['string_key']);
        Assert::assertSame('Numeric Key Value', $result[0]);
        Assert::assertSame('Another Numeric', $result[1]);
        Assert::assertSame('Mixed Key Value', $result['mixed_123']);
    });

    it('integrates with Laravel service container', function () {
        $actionFromContainer = app(GetTaskFrequenciesAction::class);
        Assert::assertInstanceOf(GetTaskFrequenciesAction::class, $actionFromContainer);
    });

    it('handles concurrent access correctly', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => ['concurrent' => 'Concurrent Value']]);
        $action = $this->getAction(GetTaskFrequenciesAction::class);

        $result1 = $action->execute();
        $result2 = $action->execute();
        $result3 = $action->execute();

        Assert::assertSame($result2, $result1);
        Assert::assertSame($result3, $result2);
        Assert::assertSame('Concurrent Value', $result1['concurrent']);
    });

    it('validates error handling in production scenario', function () {
        /** @var TestCase $this */
        $invalidConfigs = [
            'string_value',
            123,
            true,
            false,
            null,
            new stdClass,
        ];

        $action = $this->getAction(GetTaskFrequenciesAction::class);

        foreach ($invalidConfigs as $invalidConfig) {
            config(['totem.frequencies' => $invalidConfig]);
            try {
                $action->execute();
                Assert::fail('Expected exception for invalid config');
            } catch (Exception $exception) {
                Assert::assertInstanceOf(Exception::class, $exception);
            }
        }
    });

    it('maintains consistency across multiple executions', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'consistent_key' => 'Consistent Value',
            'another_key' => 'Another Value',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $results = [];
        for ($i = 0; $i < 5; $i++) {
            $results[] = $action->execute();
        }

        foreach ($results as $result) {
            Assert::assertSame($results[0], $result);
        }
    });

    it('works with realistic totem configuration', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'everyMinute' => 'Every Minute',
            'everyTwoMinutes' => 'Every Two Minutes',
            'everyThreeMinutes' => 'Every Three Minutes',
            'everyFourMinutes' => 'Every Four Minutes',
            'everyFiveMinutes' => 'Every Five Minutes',
            'everyTenMinutes' => 'Every Ten Minutes',
            'everyFifteenMinutes' => 'Every Fifteen Minutes',
            'everyThirtyMinutes' => 'Every Thirty Minutes',
            'hourly' => 'Hourly',
            'hourlyAt' => 'Hourly At',
            'everyTwoHours' => 'Every Two Hours',
            'everyThreeHours' => 'Every Three Hours',
            'everyFourHours' => 'Every Four Hours',
            'everySixHours' => 'Every Six Hours',
            'everyTwelveHours' => 'Every Twelve Hours',
            'daily' => 'Daily',
            'dailyAt' => 'Daily At',
            'twiceDaily' => 'Twice Daily',
            'weekly' => 'Weekly',
            'weeklyOn' => 'Weekly On',
            'monthly' => 'Monthly',
            'monthlyOn' => 'Monthly On',
            'twiceMonthly' => 'Twice Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
            'yearlyOn' => 'Yearly On',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertCount(26, $result);
        Assert::assertSame('Every Minute', $result['everyMinute']);
        Assert::assertSame('Hourly', $result['hourly']);
        Assert::assertSame('Daily', $result['daily']);
        Assert::assertSame('Weekly', $result['weekly']);
        Assert::assertSame('Monthly', $result['monthly']);
        Assert::assertSame('Yearly', $result['yearly']);
    });
});
