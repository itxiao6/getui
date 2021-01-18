<?php


namespace Getui;

/**
 * Class Push
 * @package Getui
 */
class Push
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
    public function withConfig(Config $config):self
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param Authorization $authorization
     * @return $this
     */
    public function withAuth(Authorization $authorization):self
    {
        $this->auth = $authorization;
        return $this;
    }

    /**
     * 单推
     * @param array $cid
     * @param $message
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toSingle(array $cid,$message)
    {
        $data = (new HttpRequest())->
        withApi('/push/single/cid')->
        withMethod('POST')->
        withConfig($this->config)->
        withToken($this->auth)->
        withData([
            'request_id'=>rand(11111100000,9999999900009),
            'settings'=>[
                'ttl'=>3600000
            ],
            'audience'=>[
                'cid'=>$cid
            ],
            'push_message'=>$message
        ])->
        send();
        var_dump($data);
    }
}