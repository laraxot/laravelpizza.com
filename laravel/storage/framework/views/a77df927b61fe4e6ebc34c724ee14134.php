<?php
    $locale = $app->getLocale();
?>

<div
    role="dialog"
    aria-labelledby="lcc-modal-alert-label"
    aria-describedby="lcc-modal-alert-desc"
    aria-modal="true"
    class="lcc-modal lcc-modal--alert js-lcc-modal js-lcc-modal-alert"
    style="display: none"
    data-cookie-key="<?php echo e(config('cookie-consent.cookie_key')); ?>"
    data-cookie-value-analytics="<?php echo e(config('cookie-consent.cookie_value_analytics')); ?>"
    data-cookie-value-marketing="<?php echo e(config('cookie-consent.cookie_value_marketing')); ?>"
    data-cookie-value-both="<?php echo e(config('cookie-consent.cookie_value_both')); ?>"
    data-cookie-value-none="<?php echo e(config('cookie-consent.cookie_value_none')); ?>"
    data-cookie-expiration-days="<?php echo e(config('cookie-consent.cookie_expiration_days')); ?>"
    data-gtm-event="<?php echo e(config('cookie-consent.gtm_event')); ?>"
    data-ignored-paths="<?php echo e(implode(',', config('cookie-consent.ignored_paths', []))); ?>"
    data-session-domain="<?php echo e(config('session.domain', '')); ?>"
    data-cookie-secure="<?php echo e(config('cookie-consent.cookie_secure', false)); ?>"
>
    <div class="lcc-modal__content">
        <h2 id="lcc-modal-alert-label" class="lcc-modal__title">
            <?php echo app('translator')->get('cookie-consent::texts.alert_title'); ?>
        </h2>
        <p id="lcc-modal-alert-desc" class="lcc-text">
            <?php echo trans('cookie-consent::texts.alert_text'); ?>

        </p>
    </div>
    <div class="lcc-modal__actions">
        <button type="button" class="lcc-button js-lcc-accept">
            <?php echo app('translator')->get('cookie-consent::texts.alert_accept'); ?>
        </button>
        <button type="button" class="lcc-button js-lcc-essentials">
            <?php echo app('translator')->get('cookie-consent::texts.alert_essential_only'); ?>
        </button>
        <button type="button" class="lcc-button lcc-button--ghost js-lcc-settings-toggle">
            <?php echo app('translator')->get('cookie-consent::texts.alert_settings'); ?>
        </button>
    </div>
</div>

<div
    role="dialog"
    aria-labelledby="lcc-modal-settings-label"
    aria-describedby="lcc-modal-settings-desc"
    aria-modal="true"
    class="lcc-modal lcc-modal--settings js-lcc-modal js-lcc-modal-settings"
    style="display: none"
>
    <button class="lcc-modal__close js-lcc-settings-toggle" type="button">
        <span class="lcc-u-sr-only">
            <?php echo app('translator')->get('cookie-consent::texts.settings_close'); ?>
        </span>
        &times;
    </button>
    <div class="lcc-modal__content">
        <div class="lcc-modal__content">
            <h2 id="lcc-modal-settings-label" class="lcc-modal__title">
                <?php echo app('translator')->get('cookie-consent::texts.settings_title'); ?>
            </h2>
            <p id="lcc-modal-settings-desc" class="lcc-text">
                <?php echo trans('cookie-consent::texts.settings_text', ['policyUrl' => config("cookie-consent.policy_url_$locale")]); ?>

            </p>
            <div class="lcc-modal__section lcc-u-text-center">
                <button type="button" class="lcc-button js-lcc-accept">
                    <?php echo app('translator')->get('cookie-consent::texts.settings_accept_all'); ?>
                </button>
            </div>
            <div class="lcc-modal__section">
                <label for="lcc-checkbox-essential" class="lcc-label">
                    <input type="checkbox" id="lcc-checkbox-essential" disabled="disabled" checked="checked" />
                    <span><?php echo app('translator')->get('cookie-consent::texts.setting_essential'); ?></span>
                </label>
                <p class="lcc-text">
                    <?php echo app('translator')->get('cookie-consent::texts.setting_essential_text'); ?>
                </p>
            </div>
            <div class="lcc-modal__section">
                <label for="lcc-checkbox-functional" class="lcc-label">
                    <input type="checkbox" id="lcc-checkbox-functional" disabled="disabled" checked="checked" />
                    <span><?php echo app('translator')->get('cookie-consent::texts.setting_functional'); ?></span>
                </label>
                <p class="lcc-text">
                    <?php echo app('translator')->get('cookie-consent::texts.setting_functional_text'); ?>
                </p>
            </div>
            <div class="lcc-modal__section">
                <label for="lcc-checkbox-analytics" class="lcc-label">
                    <input type="checkbox" id="lcc-checkbox-analytics" />
                    <span><?php echo app('translator')->get('cookie-consent::texts.setting_analytics'); ?></span>
                </label>
                <p class="lcc-text">
                    <?php echo app('translator')->get('cookie-consent::texts.setting_analytics_text'); ?>
                </p>
            </div>
            <div class="lcc-modal__section">
                <label for="lcc-checkbox-marketing" class="lcc-label">
                    <input type="checkbox" id="lcc-checkbox-marketing" />
                    <span><?php echo app('translator')->get('cookie-consent::texts.setting_marketing'); ?></span>
                </label>
                <p class="lcc-text">
                    <?php echo app('translator')->get('cookie-consent::texts.setting_marketing_text'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="lcc-modal__actions lcc-modal__actions-center">
        <button type="button" class="lcc-button js-lcc-settings-save">
            <?php echo app('translator')->get('cookie-consent::texts.settings_save'); ?>
        </button>
    </div>
</div>

<div class="lcc-backdrop js-lcc-backdrop" style="display: none"></div>
<script type="text/javascript" src="<?php echo e(asset('vendor/cookie-consent/js/cookie-consent.js')); ?>"></script>
<?php /**PATH /var/www/_bases/base_laravelpizza/laravel/vendor/statikbe/laravel-cookie-consent/src/../resources/views/index.blade.php ENDPATH**/ ?>