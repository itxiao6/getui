<?php


namespace Getui;

/**
 * Trait ApiTrait
 * @package Getui
 */
trait ApiTrait
{
    /**
     * @var HttpRequest
     */
    protected $request;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Authorization
     */
    protected $auth;

    /**
     * 设置配置
     * @param Config $config
     * @return $this
     */
    public function withConfig(Config $config): self
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param Authorization $authorization
     * @return $this
     */
    public function withAuth(Authorization $authorization): self
    {
        $this->auth = $authorization;
        return $this;
    }
}