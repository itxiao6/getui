<?php


namespace Getui;

/**
 * Class Config
 * @package Getui
 */
class Config
{
    protected $config = [];

    public function setAppId(string $appid): Config
    {
        $this->config['app_id'] = $appid;
        return $this;
    }

    /**
     * @param $app_key
     * @return $this
     */
    public function setAppKey(string $app_key): Config
    {
        $this->config['app_key'] = $app_key;
        return $this;
    }

    /**
     * @param string $master_secret
     * @return $this
     */
    public function setMasterSecret(string $master_secret):Config
    {
        $this->config['master_secret'] = $master_secret;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMasterSecret()
    {
        return isset($this->config['master_secret'])?$this->config['master_secret']:null;
    }


    /**
     * @return string|null
     */
    public function getAppKey()
    {
        return isset($this->config['app_key']) ? $this->config['app_key'] : null;
    }

    /**
     * @return string|null
     */
    public function getAppId()
    {
        return isset($this->config['app_id']) ? $this->config['app_id'] : null;
    }
}