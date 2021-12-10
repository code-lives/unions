<?php
namespace unions\wechat\publics;

use unions\wechat\Publics;

/**
 * 上传素材-媒体素材
 * https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Batch_Sends_and_Originality_Checks.html
 */
class Media extends Publics
{
    // 上传图文消息内的图片获取URL [订阅号与服务号认证后均可用]
    public function upload(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }
}
