<?php
namespace unions\wechat\publics;

use unions\library\Curl;
use unions\wechat\Publics;

// 群发接口和原创校验-图文素材管理[订阅号与服务号认证后均可用]
class GraphicMaterial extends Publics
{
    // 上传图文消息素材[订阅号与服务号认证后均可用]
    public function upload(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }
}
