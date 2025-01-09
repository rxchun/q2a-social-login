<?php

use PUPI_SL\Templates\LoginTemplate;
use PUPI_SL\Templates\RegisterTemplate;

class qa_html_theme_layer extends qa_html_theme_base
{
    public function initialize()
    {
        parent::initialize();

        if (!in_array($this->template, ['register', 'login'])) {
            return;
        }

        $this->setupFrontend();

        $this->removeFocusFromInput();

        $registerTemplate = new RegisterTemplate();

        $this->content['custom'] = preg_replace('/^<br>(.*)<br>$/', '$1', $this->content['custom']);

        if(qa_opt('pupi_sl_disable_core_registration') && in_array($this->template, ['register'])) {
            unset($this->content['form']);
            $this->content['custom'] .= '<div class="pupi-sl-note">'.qa_html(pupi_sl()->util()->langHtml('register_note')).'</div>';
        }

        $this->content['custom'] .= $registerTemplate->getOrDivider();

        qa_array_reorder($this->content, ['custom'], 'form');

        $this->content['form']['buttons'][$this->template]['note'] = $this->template === 'register'
            ? $registerTemplate->getAlreadyRegistered()
            : (new LoginTemplate())->getDontHaveAccountRegister();
    }

    /**
     * @return void
     */
    private function setupFrontend()
    {
        pupi_sl()->util()->addCssFileInline($this->content, 'social-login-buttons.min.css');
        pupi_sl()->util()->addCssFileInline($this->content, 'register-login.min.css');
    }

    private function removeFocusFromInput()
    {
        foreach ($this->content['script'] as &$scriptLine) {
            if (preg_match('@\$\(\'#[a-zA-Z0-9]+\'\)\.focus\(\);@', $scriptLine)) {
                $scriptLine = '';
            }
        }
    }
}
