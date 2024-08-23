<?php

namespace PUPI_SL\Templates;

use PUPI_SL\Config;
use PUPI_SL\Models\ProviderModel;

class ProvidersTemplate
{
    public function getLoginButtons(array $providers)
    {
        $html = '<div class="pupi_sl-login-buttons-container">';

        foreach ($providers as $provider) {
            $html .= $this->getLoginButtonsForProvider($provider);
        }

        $html .= '</div>'; // pupi_sl-login-buttons-container

        return $html;
    }

    public function getLoginButtonsForProvider($provider)
    {
        $url = qa_path('', array('action' => 'login', 'provider' => $provider['id']), qa_path_to_root());

        $html = sprintf('<a class="pupi_sl-login-button" href="%s">', $url);

        $html .= '<div class="pupi_sl-login-button-image">';
        $html .= sprintf('<img alt="%s" src="%s"/>', $provider['id'], pupi_sl()->util()->getPublicUrlToRoot() . 'provider-images/' . $provider['image']);
        $html .= '</div>'; // pupi_sl-login-button-image

        $html .= '<div class="pupi_sl-login-button-text">';
        $html .= pupi_sl()->util()->langHtml(Config::LANG_ID_CONTINUE_WITH_PROVIDER, $provider['name']);
        $html .= '</div>'; // pupi_sl-login-button-text

        $html .= '</a>'; // pupi_sl-provider-login-button

        return $html;
    }

    public function getLogoutButton()
    {
        return sprintf(
            '<a href="%s" class="qa-nav-user-link">%s</a>',
            qa_path_absolute(Config::URL_SESSION_PAGE, array('action' => 'logout')),
            qa_lang_html('main/nav_logout')
        );
    }
}
