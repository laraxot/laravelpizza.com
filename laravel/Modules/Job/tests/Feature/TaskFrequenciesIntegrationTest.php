<?php

declare(strict_types=1);

uses(\Modules\Job\Tests\TestCase::class);

use Modules\Job\Actions\GetTaskFrequenciesAction;

describe('TaskFrequencies Integration', function () {
    beforeEach(function () {
        $this->action = new GetTaskFrequenciesAction();
    });

    it('integrates with Laravel config system', function () {
        // Set up realistic frequency configuration
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

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and(count($result))
            ->toBe(15)
            ->and($result)
            ->toHaveKeys([
                'everyMinute',
                'everyFiveMinutes',
                'everyTenMinutes',
                'everyFifteenMinutes',
                'everyThirtyMinutes',
                'hourly',
                'everyTwoHours',
                'everyThreeHours',
                'everySixHours',
                'everyTwelveHours',
                'daily',
                'weekly',
                'monthly',
                'quarterly',
                'yearly',
            ]);
    });

    it('handles real-world frequency configurations', function () {
        // Test with configuration that might be used in production
        config(['totem.frequencies' => [
            'everyMinute' => 'Every Minute',
            'everyFiveMinutes' => 'Every 5 Minutes',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and($result['everyMinute'])
            ->toBe('Every Minute')
            ->and($result['hourly'])
            ->toBe('Hourly')
            ->and($result['daily'])
            ->toBe('Daily')
            ->and($result['weekly'])
            ->toBe('Weekly')
            ->and($result['monthly'])
            ->toBe('Monthly');
    });

    it('can be used in queue context', function () {
        // Test queueable functionality
        config(['totem.frequencies' => ['test' => 'Test Frequency']]);

        // Test that it can be dispatched (basic queue test)
        expect(method_exists($this->action, 'onQueue'))->toBeTrue();
    });

    it('handles configuration changes dynamically', function () {
        // Test with initial config
        config(['totem.frequencies' => ['initial' => 'Initial Value']]);
        $result1 = $this->action->execute();

        // Change config
        config(['totem.frequencies' => ['changed' => 'Changed Value']]);
        $result2 = $this->action->execute();

        expect($result1)
            ->toHaveKey('initial')
            ->and($result1['initial'])
            ->toBe('Initial Value')
            ->and($result2)
            ->toHaveKey('changed')
            ->and($result2['changed'])
            ->toBe('Changed Value')
            ->and($result2)
            ->not->toHaveKey('initial');
    });

    it('validates configuration file structure', function () {
        // Test that the action works with nested configuration
        config(['totem.frequencies' => [
            'simple' => 'Simple Value',
            'complex' => [
                'label' => 'Complex Label',
                'value' => 'complex_value',
                'description' => 'Complex Description',
            ],
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and($result['simple'])
            ->toBe('Simple Value')
            ->and($result['complex'])
            ->toBeArray()
            ->and($result['complex']['label'])
            ->toBe('Complex Label');
    });

    it('handles empty configuration gracefully', function () {
        config(['totem.frequencies' => []]);

        $result = $this->action->execute();

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('works with string and numeric keys', function () {
        config(['totem.frequencies' => [
            'string_key' => 'String Value',
            0 => 'Numeric Key Value',
            1 => 'Another Numeric',
            'mixed_123' => 'Mixed Key Value',
        ]]);

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and($result['string_key'])
            ->toBe('String Value')
            ->and($result[0])
            ->toBe('Numeric Key Value')
            ->and($result[1])
            ->toBe('Another Numeric')
            ->and($result['mixed_123'])
            ->toBe('Mixed Key Value');
    });

    it('integrates with Laravel service container', function () {
        // Test that the action can be resolved from container
        $actionFromContainer = app(GetTaskFrequenciesAction::class);

        expect($actionFromContainer)->toBeInstanceOf(GetTaskFrequenciesAction::class);
    });

    it('handles concurrent access correctly', function () {
        config(['totem.frequencies' => ['concurrent' => 'Concurrent Value']]);

        // Simulate multiple calls
        $result1 = $this->action->execute();
        $result2 = $this->action->execute();
        $result3 = $this->action->execute();

        expect($result1)
            ->toBe($result2)
            ->and($result2)
            ->toBe($result3)
            ->and($result1['concurrent'])
            ->toBe('Concurrent Value');
    });

    it('validates error handling in production scenario', function () {
        // Test various invalid configurations that might occur
        $invalidConfigs = [
            'string_value',
            123,
            true,
            false,
            null,
            new stdClass(),
        ];

        foreach ($invalidConfigs as $invalidConfig) {
            config(['totem.frequencies' => $invalidConfig]);

            expect($this->action->execute(...))->toThrow(Exception::class);
        }
    });

    it('maintains consistency across multiple executions', function () {
        config(['totem.frequencies' => [
            'consistent_key' => 'Consistent Value',
            'another_key' => 'Another Value',
        ]]);

        $results = [];
        for ($i = 0; $i < 5; $i++) {
            $results[] = $this->action->execute();
        }

        // All results should be identical
        foreach ($results as $result) {
            expect($result)->toBe($results[0]);
        }
    });

    it('works with realistic totem configuration', function () {
        // Test with configuration that would be realistic for Laravel Totem
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

        $result = $this->action->execute();

        expect($result)
            ->toBeArray()
            ->and(count($result))
            ->toBe(26)
            ->and($result['everyMinute'])
            ->toBe('Every Minute')
            ->and($result['hourly'])
            ->toBe('Hourly')
            ->and($result['daily'])
            ->toBe('Daily')
            ->and($result['weekly'])
            ->toBe('Weekly')
            ->and($result['monthly'])
            ->toBe('Monthly')
            ->and($result['yearly'])
            ->toBe('Yearly');
    });
});
