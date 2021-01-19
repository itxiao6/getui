<?php


namespace Getui;

/**
 * Class User
 * @package Getui
 */
class User
{
    use ApiTrait;

    /**
     * 绑定别名
     * @param array $data_list
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aliasBind(array $data_list = [])
    {
        return (new HttpRequest())->
        withApi('/user/alias')->
        withMethod('POST')->
        withConfig($this->config)->
        withToken($this->auth)->
        withData([
            'data_list' => $data_list
        ])->
        send();
    }

    /**
     * 通过ClientId 获取别名
     * @param string $client_id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAliasByClientId(string $client_id)
    {
        return (new HttpRequest())->
        withApi('/user/alias/cid/'.$client_id)->
        withMethod('GET')->
        withConfig($this->config)->
        withToken($this->auth)->
        withData([])->
        send();
    }
}