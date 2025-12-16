<?php

declare(strict_types=1);

namespace Modules\Gdpr\Enums;

use Illuminate\Support\Collection;
use Modules\Xot\Filament\Traits\TransTrait;
//use Modules\Core\Traits\EnumTrait;
use Illuminate\Support\Arr;
use Filament\Support\Contracts\HasIcon;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;


/**
 * Enum ConsentType
 * 
 * Defines all available consent types in the application.
 * Each consent type must have a corresponding translation key in the language files.
 */
enum ConsentType: string implements HasLabel, HasIcon, HasColor
{
    //use EnumTrait;
    use TransTrait;

    // Marketing communications
    case MARKETING_EMAIL = 'marketing_email';
    case MARKETING_SMS = 'marketing_sms';
    case MARKETING_PHONE = 'marketing_phone';
    
    // Privacy and data processing
    case PRIVACY_POLICY = 'privacy_policy';
    case COOKIES = 'cookies';
    case ANALYTICS = 'analytics';
    case PERSONALIZATION = 'personalization';
    
    // Data sharing
    case THIRD_PARTY_SHARING = 'third_party_sharing';
    case DATA_TRANSFER = 'data_transfer';
    
    // Account related
    case TERMS_AND_CONDITIONS = 'terms_and_conditions';
    case AGE_VERIFICATION = 'age_verification';
    
    // Special consents
    case RESEARCH = 'research';
    case PROFILING = 'profiling';
    case AUTOMATED_DECISION_MAKING = 'automated_decision_making';

    public function getLabel(): string
    {
        return $this->transClass(self::class,$this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class,$this->value.'.color');

    }

    public function getIcon(): string
    {
        return $this->transClass(self::class,$this->value.'.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class,$this->value.'.description');
    }

    /**
     * Check if this consent type is required for using the service.
     * 
     * @return bool
     */
    public function isRequired(): bool
    {
        return in_array($this, [
            self::PRIVACY_POLICY,
            self::TERMS_AND_CONDITIONS,
            self::AGE_VERIFICATION,
        ]);
    }

    /**
     * Get all required consent types.
     * 
     * @return array<string>
     */
    public static function getRequiredConsentTypes(): array
    {
        return array_map(
            fn (self $type) => $type->value,
            array_filter(self::cases(), fn (self $type) => $type->isRequired())
        );
    }

    /**
     * Get all optional consent types.
     * 
     * @return array<string>
     */
    public static function getOptionalConsentTypes(): array
    {
        return array_map(
            fn (self $type) => $type->value,
            array_filter(self::cases(), fn (self $type) => !$type->isRequired())
        );
    }

    /*
     * Get consent types grouped by category.
     * 
     * @return array<string, array<string, string>>
     
    public static function groupedByCategory(): array
    {
        return [
            'marketing' => [
                self::MARKETING_EMAIL->value => self::MARKETING_EMAIL->label(),
                self::MARKETING_SMS->value => self::MARKETING_SMS->label(),
                self::MARKETING_PHONE->value => self::MARKETING_PHONE->label(),
            ],
            'privacy' => [
                self::PRIVACY_POLICY->value => self::PRIVACY_POLICY->label(),
                self::COOKIES->value => self::COOKIES->label(),
                self::ANALYTICS->value => self::ANALYTICS->label(),
                self::PERSONALIZATION->value => self::PERSONALIZATION->label(),
            ],
            'data_sharing' => [
                self::THIRD_PARTY_SHARING->value => self::THIRD_PARTY_SHARING->label(),
                self::DATA_TRANSFER->value => self::DATA_TRANSFER->label(),
            ],
            'account' => [
                self::TERMS_AND_CONDITIONS->value => self::TERMS_AND_CONDITIONS->label(),
                self::AGE_VERIFICATION->value => self::AGE_VERIFICATION->label(),
            ],
            'special' => [
                self::RESEARCH->value => self::RESEARCH->label(),
                self::PROFILING->value => self::PROFILING->label(),
                self::AUTOMATED_DECISION_MAKING->value => self::AUTOMATED_DECISION_MAKING->label(),
            ],
        ];
    }
    */
    /*
     * Get consent types as a flattened array for forms.
     * 
     * @return array<string, string>
     
    public static function forFormSelect(): array
    {
        $result = [];
        
        foreach (self::groupedByCategory() as $category => $types) {
            $result[__("gdpr::consent.categories.$category")] = $types;
        }
        
        return $result;
    }
        */
}
