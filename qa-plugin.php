<?php

if (!defined('QA_VERSION')) {
    header('Location: ../../');
    exit;
}

if (!QA_FINAL_EXTERNAL_USERS) {
    require_once 'vendor/autoload.php';

    qa_register_plugin_module('process', 'processes/PUPI_SL_Bootstrap.php', 'PUPI_SL_Bootstrap', 'PUPI_SL Bootstrap');
    qa_register_plugin_module('process', 'processes/PUPI_SL_Admin.php', 'PUPI_SL_Admin', 'PUPI_SL Admin');

    qa_register_plugin_module('login', 'login/PUPI_SL_ProviderLogin.php', 'PUPI_SL_ProviderLogin', 'PUPI_SL Provider Login');

    qa_register_plugin_module('page', 'pages/PUPI_SL_Session.php', 'PUPI_SL_Session', 'PUPI_SL Logout');

    qa_register_plugin_overrides('overrides/PUPI_SL_Overrides.php');

    qa_register_plugin_layer('layers/PUPI_SL_ProcessLoginRegisterPage.php', 'PUPI_SL Process Login Register Page');

    qa_register_plugin_phrases(PUPI_SL\Config::DIR_LANG . DIRECTORY_SEPARATOR . PUPI_SL\Config::PLUGIN_ID . '_*.php', PUPI_SL\Config::PLUGIN_ID);

    /**
     * @return PUPI_SL\Plugin
     */
    function pupi_sl()
    {
        return PUPI_SL\Plugin::getInstance();
    }
}
