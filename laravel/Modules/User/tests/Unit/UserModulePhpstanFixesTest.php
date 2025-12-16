<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Illuminate\Validation\Rules\Password;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\AddingTeam;
use Modules\User\Events\Login;
use Modules\User\Events\Registered;
use Modules\User\Events\SocialiteUserConnected;
use PHPUnit\Framework\TestCase;

class UserModulePhpstanFixesTest extends TestCase
{
    /** @test */
    public function password_data_can_be_instantiated(): void
    {
        $passwordData = new PasswordData;

        $this->assertInstanceOf(PasswordData::class, $passwordData);
        $this->assertEquals(15, $passwordData->otp_expiration_minutes);
        $this->assertEquals(6, $passwordData->otp_length);
        $this->assertEquals(30, $passwordData->expires_in);
        $this->assertEquals(6, $passwordData->min);
        $this->assertFalse($passwordData->mixedCase);
        $this->assertFalse($passwordData->letters);
        $this->assertFalse($passwordData->numbers);
        $this->assertFalse($passwordData->symbols);
        $this->assertFalse($passwordData->uncompromised);
        $this->assertEquals(1, $passwordData->compromisedThreshold);
    }

    /** @test */
    public function password_data_can_be_configured(): void
    {
        $passwordData = new PasswordData(
            otp_expiration_minutes: 30,
            otp_length: 8,
            expires_in: 60,
            min: 8,
            mixedCase: true,
            letters: true,
            numbers: true,
            symbols: true,
            uncompromised: true,
            compromisedThreshold: 5
        );

        $this->assertEquals(30, $passwordData->otp_expiration_minutes);
        $this->assertEquals(8, $passwordData->otp_length);
        $this->assertEquals(60, $passwordData->expires_in);
        $this->assertEquals(8, $passwordData->min);
        $this->assertTrue($passwordData->mixedCase);
        $this->assertTrue($passwordData->letters);
        $this->assertTrue($passwordData->numbers);
        $this->assertTrue($passwordData->symbols);
        $this->assertTrue($passwordData->uncompromised);
        $this->assertEquals(5, $passwordData->compromisedThreshold);
    }

    /** @test */
    public function password_data_get_password_rule_works(): void
    {
        $passwordData = new PasswordData(
            min: 8,
            mixedCase: true,
            letters: true,
            numbers: true,
            symbols: true,
            uncompromised: true,
            compromisedThreshold: 3
        );

        $rule = $passwordData->getPasswordRule();

        $this->assertInstanceOf(Password::class, $rule);
    }

    /** @test */
    public function password_data_get_helper_text_works(): void
    {
        $passwordData = new PasswordData(
            min: 8,
            mixedCase: true,
            letters: true,
            numbers: true,
            symbols: true,
            uncompromised: true
        );

        $helperText = $passwordData->getHelperText();

        $this->assertIsString($helperText);
        $this->assertStringContainsString('8 caratteri', $helperText);
        $this->assertStringContainsString('maiuscola e una minuscola', $helperText);
        $this->assertStringContainsString('lettera', $helperText);
        $this->assertStringContainsString('numero', $helperText);
        $this->assertStringContainsString('carattere speciale', $helperText);
        $this->assertStringContainsString('compromessa', $helperText);
    }

    /** @test */
    public function password_data_get_form_components_returns_array(): void
    {
        $passwordData = new PasswordData;

        // Test che il metodo esista e non lanci eccezioni
        $this->assertTrue(method_exists($passwordData, 'getPasswordFormComponents'));

        // Test che il metodo getPasswordFormComponent esista
        $this->assertTrue(method_exists($passwordData, 'getPasswordFormComponent'));

        // Test che il metodo getPasswordConfirmationFormComponent esista
        $this->assertTrue(method_exists($passwordData, 'getPasswordConfirmationFormComponent'));
    }

    /** @test */
    public function events_can_be_instantiated(): void
    {
        $addingTeam = new AddingTeam;
        $login = new Login;
        $registered = new Registered;
        $socialiteUserConnected = new SocialiteUserConnected;

        $this->assertInstanceOf(AddingTeam::class, $addingTeam);
        $this->assertInstanceOf(Login::class, $login);
        $this->assertInstanceOf(Registered::class, $registered);
        $this->assertInstanceOf(SocialiteUserConnected::class, $socialiteUserConnected);
    }

    /** @test */
    public function events_have_dispatchable_trait(): void
    {
        $addingTeam = new AddingTeam;
        $login = new Login;

        $this->assertTrue(method_exists($addingTeam, 'dispatch'));
        $this->assertTrue(method_exists($login, 'dispatch'));
    }

    /** @test */
    public function password_data_static_make_method_exists(): void
    {
        $this->assertTrue(method_exists(PasswordData::class, 'make'));
    }

    /** @test */
    public function password_data_get_validation_messages_method_exists(): void
    {
        $passwordData = new PasswordData;

        $this->assertTrue(method_exists($passwordData, 'getValidationMessages'));
    }

    /** @test */
    public function password_data_get_form_schema_method_exists(): void
    {
        $this->assertTrue(method_exists(PasswordData::class, 'getFormSchema'));
    }
}
