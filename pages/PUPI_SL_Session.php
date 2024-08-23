<?php

use PUPI_SL\Config;

class PUPI_SL_Session
{
    function match_request($request)
    {
        return $request === Config::URL_SESSION_PAGE;
    }

    function process_request($request)
    {
        $userid = qa_get_logged_in_userid();

        $action = qa_get('action');

        if ($action === 'logout') {
            if (!isset($userid)) {
                qa_redirect('login');
            }

            require_once pupi_sl()->getDirectory() . 'login/PUPI_SL_ProviderLogin.php';

            PUPI_SL_ProviderLogin::getModuleInstance()->executeLogout();
        }

        qa_redirect('');
    }
}
