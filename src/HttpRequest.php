<?php


namespace Getui;


use GuzzleHttp\Client;

/**
 * Class HttpRequest
 * @package Getui
 */
class HttpRequest
{
    /**
     * @var string
     */
    protected $method = 'GET';
    /**
     * @var array
     */
    protected $headers = [
        'Content-Type' => 'application/json;charset=utf-8'
    ];
    /**
     * @var Client
     */
    protected $client;
    /**
     * 接口网关
     * @var string
     */
    protected $gateway = 'https://restapi.getui.com/v2/';
    /**
     * 配置
     * @var Config
     */
    protected $config;
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var string
     */
    protected $api;
    /**
     * @var Authorization
     */
    protected $authorization;

    /**
     * HttpRequest constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 设置请求方法
     * @param string $method
     * @return $this
     */
    public function withMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function withData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 设置Token
     * @param Authorization $authorization
     * @return $this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function withToken(Authorization $authorization)
    {
        $this->authorization = $authorization;
        return $this;
    }

    /**
     * 设置配置
     * @param Config $config
     * @return $this
     */
    public function withConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param string $api
     * @return $this
     */
    public function withApi(string $api)
    {
        $this->api = $api;
        return $this;
    }

    /**
     * 发起请求
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        try{
            $this->data['appkey'] = $this->config->getAppKey();
            $this->data['timestamp'] = $this->micro_time();
            $this->data['sign'] = hash("sha256", "{$this->config->getAppKey()}{$this->data['timestamp']}{$this->config->getMasterSecret()}");
            if($this->authorization instanceof Authorization && method_exists($this->authorization,'getTokenAsString')){
                $this->headers['token'] = $this->authorization->getTokenAsString();
            }
            return json_decode($this->client->request($this->method, $this->gateway . $this->config->getAppId() . $this->api, [
                'headers' => $this->headers,
                'body' => json_encode($this->data)
            ])->getBody()->getContents(), 1);
        }catch (\GuzzleHttp\Exception\ClientException $exception){
            $data = json_encode($exception->getResponse()->getBody()->getContents(),1);
            if($exception->getResponse()->getStatusCode() == 400 && $data['code'] == 20001){
                $this->authorization->refurbishToken();
                $this->send();
            }
            throw $exception;
        }
    }

    private function micro_time()
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = ($sec . substr($usec, 2, 3));
        return $time;
    }
}