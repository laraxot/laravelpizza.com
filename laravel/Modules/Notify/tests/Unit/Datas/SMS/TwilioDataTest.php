<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas\SMS;

use Modules\Notify\Datas\SMS\TwilioData;

describe('TwilioData', function () {
    it('has default auth type', function () {
        $data = new TwilioData;

        expect($data->auth_type)->toBe('basic');
    });

    it('has default timeout', function () {
        $data = new TwilioData;

        expect($data->timeout)->toBe(30);
    });

    it('can set account sid', function () {
        $data = new TwilioData;
        $data->account_sid = 'AC1234567890';

        expect($data->account_sid)->toBe('AC1234567890');
    });

    it('can set auth token', function () {
        $data = new TwilioData;
        $data->auth_token = 'auth_token_123';

        expect($data->auth_token)->toBe('auth_token_123');
    });

    it('can set base url', function () {
        $data = new TwilioData;
        $data->base_url = 'https://custom.twilio.com';

        expect($data->base_url)->toBe('https://custom.twilio.com');
    });

    it('can get base url with default', function () {
        $data = new TwilioData;

        $baseUrl = $data->getBaseUrl();

        expect($baseUrl)->toBe('https://api.twilio.com');
    });

    it('can get custom base url', function () {
        $data = new TwilioData;
        $data->base_url = 'https://custom.twilio.com';

        $baseUrl = $data->getBaseUrl();

        expect($baseUrl)->toBe('https://custom.twilio.com');
    });

    it('can get timeout', function () {
        $data = new TwilioData;
        $data->timeout = 60;

        $timeout = $data->getTimeout();

        expect($timeout)->toBe(60);
    });

    it('can generate auth headers', function () {
        $data = new TwilioData;
        $data->account_sid = 'AC1234567890';
        $data->auth_token = 'auth_token_123';

        $headers = $data->getAuthHeaders();

        expect($headers)->toBeArray();
        expect($headers)->toHaveKey('Authorization');
        expect($headers)->toHaveKey('Content-Type');
        expect($headers['Authorization'])->toStartWith('Basic ');
    });

    it('has from method (inherited from Spatie Data)', function () {
        expect(method_exists(TwilioData::class, 'from'))->toBeTrue();
    });

    it('has make static method', function () {
        expect(method_exists(TwilioData::class, 'make'))->toBeTrue();
    });
});
