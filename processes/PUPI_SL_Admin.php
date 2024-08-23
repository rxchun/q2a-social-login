<?php

use PUPI_SL\Models\ProviderModel;

class PUPI_SL_Admin
{
    const SAVE_BUTTON = 'save_button';

    /** @var array */
    private $errors = [];

    public function option_default($option)
    {
        $unprefixedOption = pupi_sl()->util()->removePrefix($option);
        if ($option !== $unprefixedOption) {
            $providerModel = new ProviderModel();
            if ($providerModel->isValidSetting($unprefixedOption)) {
                return '';
            }
            //            switch ($unprefixedOption) {
            //                default:
            //            }
        }

        return null;
    }

    public function admin_form(&$qa_content)
    {
        $ok = null;
        $saveButtonClicked = qa_clicked(pupi_sl()->util()->addPrefix(self::SAVE_BUTTON));

        if ($saveButtonClicked) {
            $this->saveSettingsProviders();

            if (empty($this->errors)) {
                $ok = qa_lang_html('admin/options_saved');
            }
        }

        $fields = $this->getFieldsProviders();

        return [
            'ok' => $ok,
            'style' => 'tall',
            'fields' => $fields,
            'buttons' => $this->getButtons(),
        ];
    }

    private function getButtons()
    {
        return [
            'save' => [
                'tags' => sprintf('name="%s"', pupi_sl()->util()->addPrefix(self::SAVE_BUTTON)),
                'label' => qa_lang_html('main/save_button'),
            ],
        ];
    }

    // Generic fields

    /**
     * @param string $setting
     * @param string $langId
     * @param int $rows
     *
     * @return array
     */
    private function getStringField($setting, $langId, $rows = 1)
    {
        return [
            'label' => pupi_sl()->util()->langHtml($langId),
            'tags' => 'name="' . qa_html(pupi_sl()->util()->addPrefix($setting)) . '"',
            'value' => qa_html(pupi_sl()->util()->getSetting($setting)),
            'rows' => $rows,
        ];
    }

    /**
     * @param string $setting
     * @param string $langId
     *
     * @return array
     */
    private function getBooleanField($setting, $langId)
    {
        $field = $this->getStringField($setting, $langId);
        $field['type'] = 'checkbox';
        $field['value'] = (bool)pupi_sl()->util()->getSetting($setting);

        return $field;
    }

    /**
     * @param string $setting
     * @param string $langId
     *
     * @return array
     */
    private function getIntegerField($setting, $langId)
    {
        $field = $this->getStringField($setting, $langId);
        $field['type'] = 'number';

        return $field;
    }

    /**
     * @param array $options
     * @param string $selectedKey
     * @param string $fieldSetting
     * @param string $fieldSettingLangId
     *
     * @return array
     */
    private function getComboboxField($options, $selectedKey, $fieldSetting, $fieldSettingLangId)
    {
        return [
            'type' => 'select',
            'style' => 'tall',
            'label' => pupi_sl()->util()->langHtml($fieldSettingLangId),
            'tags' => 'name="' . pupi_sl()->util()->addPrefix($fieldSetting) . '"',
            'options' => $options,
            'value' => isset($options[$selectedKey]) ? $options[$selectedKey] : null,
        ];
    }

    // Concrete fields

    /**
     * @return array
     */
    private function getFieldsProviders()
    {
        $result = [];

        $providerModel = new ProviderModel();
        foreach (ProviderModel::PROVIDERS as $provider) {
            foreach (ProviderModel::SETTING_IDS as $settingId) {
                $providerSetting = $providerModel->getSettingIdForProvider($settingId, $provider['id']);
                $providerLangId = $providerModel->getLangIdForSettingProvider('admin_label_provider', $settingId);
                switch ($settingId) {
                    case 'enabled':
                        $field = $this->getBooleanField($providerSetting, $providerLangId);
                        break;
                    case 'app_key':
                    case 'app_secret':
                        $field = $this->getStringField($providerSetting, $providerLangId);
                        break;
                    default:
                        $field = $this->getStringField($providerSetting, $providerLangId);
                }

                $field['label'] = pupi_sl()->util()->langHtml($providerLangId, [$provider['name']]);
                $result[] = $field;
            }
        }

        return $result;
    }

    // Generic save methods

    private function saveStringSetting($setting, $value = null)
    {
        if (is_null($value)) {
            $value = qa_post_text(pupi_sl()->util()->addPrefix($setting));
        }
        pupi_sl()->util()->setSetting($setting, $value);
    }

    private function saveIntegerSetting($setting, $value = null, $minValue = null, $maxValue = null)
    {
        if (is_null($value)) {
            $value = (int)qa_post_text(pupi_sl()->util()->addPrefix($setting));
        }

        if (isset($minValue)) {
            $value = max($value, $minValue);
        }

        if (isset($maxValue)) {
            $value = min($value, $maxValue);
        }

        pupi_sl()->util()->setSetting($setting, $value);
    }

    private function saveBooleanSetting($setting, $value = null)
    {
        if (is_null($value)) {
            $value = (int)qa_post_text(pupi_sl()->util()->addPrefix($setting));
        }

        $this->saveIntegerSetting($setting, (int)$value);
    }

    private function saveComboboxSetting($setting, $options, $settingDefault)
    {
        $value = qa_html(qa_post_text(pupi_sl()->util()->addPrefix($setting)));
        $value = isset($options[$value]) ? $value : $settingDefault;
        pupi_sl()->util()->setSetting($setting, $value);
    }

    // Concrete save methods

    private function saveSettingsProviders()
    {
        $providerModel = new ProviderModel();
        foreach (ProviderModel::PROVIDERS as $provider) {
            foreach (ProviderModel::SETTING_IDS as $settingId) {
                $providerSetting = $providerModel->getSettingIdForProvider($settingId, $provider['id']);
                switch ($settingId) {
                    case 'enabled':
                        $this->saveIntegerSetting($providerSetting);
                        break;
                    case 'app_key':
                    case 'app_secret':
                        $this->saveStringSetting($providerSetting);
                        break;
                    default:
                        $this->saveStringSetting($providerSetting);
                }
            }
        }
    }
}
