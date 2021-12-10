<?php
namespace unions\wechat\publics;

use unions\library\Curl;
use unions\wechat\Publics;

/**
 * 群发接口和原创校验-群发 [订阅号与服务号认证后均可用]
 * https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Batch_Sends_and_Originality_Checks.html#1
 */
class GroupSend extends Publics
{
    // 根据标签进行群发 [订阅号与服务号认证后均可用]
    public function sendToTag(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 根据OpenID列表群发 [订阅号不可用，服务号认证后可用]
    public function sendToOpenIDs(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 删除群发 [订阅号与服务号认证后均可用]
    public function deleteSended(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 预览接口-将预览页发送到指定用户openid [订阅号与服务号认证后均可用]
    public function sendPreviewToUser(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 查询群发新靠西发送状态 [订阅号与服务号认证后均可用]
    public function getSendState(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 获取群发速度
    public function getSendSpeed(string $accessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=%s', $accessToken);

        return Curl::instance()->post($url)->result($this->responseParse());
    }

    // 设置群发速度
    public function setSendSpeed(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/mass/speed/set?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }
}
