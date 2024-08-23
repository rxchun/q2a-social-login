<?php

use PUPI_SL\Config;

return [

    /* All ^X, where X is an integer number greater than or equal to 1, are replaced with the appropriate parameter
     * documented before the constant.
     * All ^X:Y:Z:, where X is the same as above and Y and Z are anything but colons (:) sequences of characters.
     * They are replaced applying the following algorithm: If X is equal to 1 then display Y, otherwise display Z.
     */

    Config::LANG_ID_ADMIN_HTML_BEFORE_RESITER_TITLE_LABEL => 'HTML before register title', // Label of the HTML before register title field in the admin settings

    /**
     * ^1: Provider name
     */
    Config::LANG_ID_CONTINUE_WITH_PROVIDER => 'Continue with ^1', // Text to display in the login provider buttons

    /**
     * ^1: Provider name
     */
    Config::LANG_ID_ADMIN_LABEL_PROVIDER_ENABLED => '^1 enabled',
    /**
     * ^1: Provider name
     */
    Config::LANG_ID_ADMIN_LABEL_PROVIDER_APP_KEY => '^1 app key',
    /**
     * ^1: Provider name
     */
    Config::LANG_ID_ADMIN_LABEL_PROVIDER_APP_SECRET => '^1 app secret',

    /**
     * ^1: Start of log in anchor
     * ^2: End of log in anchor
     */
    Config::LANG_ID_ALREADY_REGISTERED_LOGIN => 'Already registered? ^1Log in^2.',

    /**
     * ^1: Start of register anchor
     * ^2: End of register anchor
     */
    Config::LANG_ID_DONT_HAVE_ACCOUNT_REGISTER => 'You don\'t have an account? ^1Register^2.',
];
