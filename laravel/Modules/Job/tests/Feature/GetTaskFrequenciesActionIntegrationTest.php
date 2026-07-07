<?php

declare(strict_types=1);

use Exception;
use Modules\Job\Actions\GetTaskFrequenciesAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('GetTaskFrequenciesAction Integration', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->action = new GetTaskFrequenciesAction;
    });

    it('returns array when config exists', function () {
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
    });

    it('throws exception when config is not array', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => 'invalid_value']);
        $this->expectApplicationException(Exception::class);
        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $action->execute();
    });

    it('throws exception when config is null', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => null]);
        $this->expectApplicationException(Exception::class);
        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $action->execute();
    });

    it('handles empty array config', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => []]);
        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertCount(0, $result);
    });

    it('can be queued', function () {
        /** @var TestCase $this */
        $action = $this->getAction(GetTaskFrequenciesAction::class);
        Assert::assertTrue(method_exists($action, 'onQueue'));
    });

    it('integrates with Laravel service container', function () {
        $actionFromContainer = app(GetTaskFrequenciesAction::class);
        Assert::assertInstanceOf(GetTaskFrequenciesAction::class, $actionFromContainer);
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

    it('returns string keys and mixed values', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'string_key' => 'string_value',
            'another_key' => ['nested', 'array'],
            'numeric_key' => 123,
            'boolean_key' => true,
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertSame('string_value', $result['string_key']);
        Assert::assertSame(['nested', 'array'], $result['another_key']);
        Assert::assertSame(123, $result['numeric_key']);
        Assert::assertSame(true, $result['boolean_key']);
    });

    it('preserves array key types', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'string_key' => 'value1',
            0 => 'value2',
            1 => 'value3',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertArrayHasKey('string_key', $result);
        Assert::assertArrayHasKey(0, $result);
        Assert::assertArrayHasKey(1, $result);
        Assert::assertSame('value1', $result['string_key']);
        Assert::assertSame('value2', $result[0]);
        Assert::assertSame('value3', $result[1]);
    });

    it('maintains consistency across multiple executions', function () {
        /** @var TestCase $this */
        config(['totem.frequencies' => [
            'consistent_key' => 'Consistent Value',
            'another_key' => 'Another Value',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $results = [];
        for ($i = 0; $i < 3; $i++) {
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
            'everyFiveMinutes' => 'Every Five Minutes',
            'everyTenMinutes' => 'Every Ten Minutes',
            'everyFifteenMinutes' => 'Every Fifteen Minutes',
            'everyThirtyMinutes' => 'Every Thirty Minutes',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
        ]]);

        $action = $this->getAction(GetTaskFrequenciesAction::class);
        $result = $action->execute();

        Assert::assertIsArray($result);
        Assert::assertCount(10, $result);
        Assert::assertSame('Every Minute', $result['everyMinute'] ?? null);
        Assert::assertSame('Hourly', $result['hourly'] ?? null);
        Assert::assertSame('Daily', $result['daily'] ?? null);
        Assert::assertSame('Weekly', $result['weekly'] ?? null);
        Assert::assertSame('Monthly', $result['monthly'] ?? null);
        Assert::assertSame('Yearly', $result['yearly'] ?? null);
    });
});
