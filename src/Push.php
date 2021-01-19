<?php


namespace Getui;

use Getui\Message\MessageInterface;
use Getui\Message\NotificationMessage;

/**
 * Class Push
 * @package Getui
 */
class Push
{
    use ApiTrait;

    /**
     * 单推 Client ID
     * @param array $cid
     * @param NotificationMessage $message
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toSingleCid(array $cid, NotificationMessage $message)
    {
        $data = (new HttpRequest())->
        withApi('/push/single/cid')->
        withMethod('POST')->
        withConfig($this->config)->
        withToken($this->auth)->
        withData([
            'request_id' => rand(11111100000, 9999999900009),
            'settings' => [
                'ttl' => 3600000
            ],
            'audience' => [
                'cid' => $cid
            ],
            'push_message' => $message->toArray()
        ])->
        send();
        if (!(isset($data['msg']) && $data['msg'] === 'success' && isset($data['code']) &&$data['code'] === 0)) {
            throw new \Exception(isset($data['msg'])?$data['msg']:'接口错误');
        }
        return $data;
    }

    /**
     * 推送消息到所有用户
     * @param NotificationMessage $message
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toAll(NotificationMessage $message)
    {
        return (new HttpRequest())->
        withApi('/push/all')->
        withMethod('POST')->
        withConfig($this->config)->
        withToken($this->auth)->
        withData([
            'request_id' => rand(11111100000, 9999999900009),
//            'group_name'=>'',
            'settings' => [
                'ttl' => 3600000
            ],
            'audience' => 'all',
            'push_message' => $message->toArray()
        ])->
        send();
    }

    /**
     * 单推 Alias
     * @param array $alias
     * @param NotificationMessage $message
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toSingleAlias(array $alias, NotificationMessage $message)
    {
        return (new HttpRequest())->
        withApi('/push/single/alias')->
        withMethod('POST')->
        withConfig($this->config)->
        withToken($this->auth)->
        withData([
            'audience'=>[
                'alias' => $alias
            ],
            'request_id' => rand(11111100000, 9999999900009),
            'push_message' => $message->toArray()
        ])->
        send();
    }

}