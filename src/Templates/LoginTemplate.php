<?php

namespace PUPI_SL\Templates;

use PUPI_SL\Config;

class LoginTemplate
{
    public function getDontHaveAccountRegister()
    {
        return pupi_sl()->util()->langHtml(Config::LANG_ID_DONT_HAVE_ACCOUNT_REGISTER, [
            sprintf('<a href="%s">', qa_path('register')),
            '</a>',
        ]);
    }
}
