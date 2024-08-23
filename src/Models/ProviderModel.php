<?php

namespace PUPI_SL\Models;

class ProviderModel
{
    // These have to be HybridAuth IDs
    const FACEBOOK_ID = 'facebook';
    const GOOGLE_ID = 'google';
    const X_ID = 'twitter';
    const LINKEDIN_ID = 'linkedinopenid';

    const PROVIDERS = [
        self::FACEBOOK_ID => [
            'id' => self::FACEBOOK_ID,
            'name' => 'Facebook',
            'source' => 'pupi_sl_facebook',
            'image' => self::FACEBOOK_ID . '.png',
            'setting' => self::FACEBOOK_ID,
        ],
        self::GOOGLE_ID => [
            'id' => self::GOOGLE_ID,
            'name' => 'Google',
            'source' => 'pupi_sl_google',
            'image' => self::GOOGLE_ID . '.png',
            'setting' => self::GOOGLE_ID,
        ],
        self::X_ID => [
            'id' => self::X_ID,
            'name' => 'X',
            'source' => 'pupi_sl_x',
            'image' => 'x.png',
            'setting' => 'x',
        ],
        self::LINKEDIN_ID => [
            'id' => self::LINKEDIN_ID,
            'name' => 'LinkedIn',
            'source' => 'pupi_sl_linkedin',
            'image' => 'linkedin.png',
            'setting' => 'linkedin',
        ],
    ];

    const SETTING_IDS = [
        'enabled',
        'app_key',
        'app_secret',
    ];

    const LANG_IDS = [
        'admin_label_provider',
    ];

    /**
     * @param string $settingId One of 'enabled', 'app_key' or 'app_secret'
     * @param string $providerId
     *
     * @return string E.G.: app_key_facebook
     */
    public function getSettingIdForProvider($settingId, $providerId)
    {
        if (!in_array($settingId, self::SETTING_IDS)) {
            throw Exception('Invalid setting: ' . $settingId);
        }

        return sprintf('%s_%s', $settingId, self::PROVIDERS[$providerId]['setting']);
    }

    /**
     * @param string $lang One of 'admin_label_provider'
     * @param string $settingId One of 'enabled', 'app_key', 'app_secret'
     *
     * @return string E.G.: admin_label_provider_app_key
     */
    public function getLangIdForSettingProvider($lang, $settingId)
    {
        if (!in_array($lang, self::LANG_IDS)) {
            throw Exception('Invalid language string: ' . $lang);
        }

        return sprintf('%s_%s', $lang, $settingId);
    }

    /**
     * @param string $testSetting
     *
     * @return bool
     */
    public function isValidSetting($testSetting)
    {
        foreach (self::SETTING_IDS as $settingId) {
            foreach (self::PROVIDERS as $provider) {
                $possibleSetting = $this->getSettingIdForProvider($settingId, $provider['id']);
                if ($possibleSetting === $testSetting) {
                    return true;
                }
            }
        }

        return false;
    }

}
