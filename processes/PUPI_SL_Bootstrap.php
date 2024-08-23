<?php

use PUPI_SL\Config;

class PUPI_SL_Bootstrap
{
    public function load_module($directory, $urlToRoot)
    {
        pupi_sl()->bootstrap($directory, $urlToRoot, Config::PLUGIN_ID, Config::DIR_PUBLIC);
    }
}
