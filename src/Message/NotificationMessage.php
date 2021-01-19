<?php


namespace Getui\Message;

use Getui\Message\MessageInterface;

/**
 * Class NotificationMessage
 * @package Getui\Message
 */
class NotificationMessage implements MessageInterface
{
    public function toArray():array
    {
        $data = $this->data;
        $data['payload'] = json_encode($data['payload']);
        return ['notification'=>$data];
    }
    protected $data = [];
    public function setTitle(string $title)
    {
        $this->data['payload']['title'] = $title;
        $this->data['title'] = $title;
        return $this;
    }
    public function setBody(string $body)
    {
        $this->data['payload']['body'] = $body;
        $this->data['body'] = $body;
        return $this;
    }

    /**
     * @param string $clickType
     * @return $this
     */
    public function setClickType(string $clickType)
    {
        $this->data['click_type'] = $clickType;
        return $this;
    }

    /**
     * 设置自定义消息内容
     * @param array $payload
     * @return $this
     */
    public function setPayload(array $payload)
    {
        $this->data['payload'] = array_merge($this->data['payload'],$payload);
        return $this;
    }
}