<?php

namespace PUPI_SL;

class Plugin
{
    /** @var Plugin */
    private static $instance;

    /** @var string */
    private $pluginId;

    /** @var string */
    private $directory;

    /** @var string */
    private $urlToRoot;

    /** @var Util */
    private $util;

    public function bootstrap($directory, $urlToRoot, $pluginId, $publicDir)
    {
        $this->pluginId = $pluginId;

        $this->directory = $directory;
        $this->urlToRoot = $urlToRoot;

        $this->util = new Util($directory, $urlToRoot, $pluginId, $publicDir);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function getPluginId()
    {
        return $this->pluginId;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function getUrlToRoot()
    {
        return $this->urlToRoot;
    }

    /**
     * @return Util
     */
    public function util()
    {
        return $this->util;
    }
}
