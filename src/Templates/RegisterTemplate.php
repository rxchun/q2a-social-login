<?php

namespace PUPI_SL\Templates;

use PUPI_SL\Config;

class RegisterTemplate
{
    public function getAlmostReadyTitle($htmlText)
    {
        $html = '<div class="pupi_sl_almost-ready-title">';
        $html .= $htmlText;
        $html .= '</div>';

        return $html;
    }

    public function getOrDivider()
    {
        $html = '<div class="pupi_sl_text-divider-container">';
        $html .= '<hr data-content="or" class="pupi_sl_text-divider">';
        $html .= '</div>';

        return $html;
    }

    public function getAlreadyRegistered()
    {
        return pupi_sl()->util()->langHtml(Config::LANG_ID_ALREADY_REGISTERED_LOGIN, [
            sprintf('<a href="%s">', qa_path('login')),
            '</a>',
        ]);
    }
}
