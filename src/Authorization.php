<?php


namespace Getui;

use Doctrine\Common\Cache\Cache;

/**
 * Class Authorization
 * @package Getui
 */
class Authorization
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Cache
     */
    protected $cache;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * 设置缓存驱动
     * @param Cache $cache
     * @return $this
     */
    public function withCacheDriver(Cache $cache):self
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * 获取个推Token
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTokenAsString(): string
    {
        $key = 'cache:getui:token';
        if($this->cache instanceof Cache && $this->cache->contains($key)){
            return $this->cache->fetch($key);
        }
        $res = (new HttpRequest())->withConfig($this->config)->withData([
        ])->withApi('/auth')->withMethod('POST')->send();
        if(isset($res['code']) && $res['code'] === 0){
            $expire_time = intval($res['data']['expire_time']/1000);
            $token = $res['data']['token'];
            if($this->cache instanceof Cache){
                $this->cache->save($key,$token,$expire_time-time());
            }
            return $token;
        }
        throw new \Exception('个推Token 获取失败');
    }

    /**
     * 刷新Token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refurbishToken()
    {
        $key = 'cache:getui:token';
        $res = (new HttpRequest())->withConfig($this->config)->withData([
        ])->withApi('/auth')->withMethod('POST')->send();
        if(isset($res['code']) && $res['code'] === 0){
            $expire_time = intval($res['data']['expire_time']/1000);
            $token = $res['data']['token'];
            if($this->cache instanceof Cache){
                $this->cache->save($key,$token,$expire_time-time());
            }
            return $token;
        }
    }
}