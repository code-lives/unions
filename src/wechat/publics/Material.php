<?php
namespace unions\wechat\publics;

use unions\library\Curl;
use unions\wechat\Publics;

/**
 * 素材管理
 * https://developers.weixin.qq.com/doc/offiaccount/Shopping_Guide/model-account/shopping-guide.setGuideCardMaterial.html
 */
class Material extends Publics
{
    // 添加小程序卡片素材
    public function addMiniCard(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/setguidecardmaterial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 查询小程序卡片素材
    public function queryMiniCard(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/getguidecardmaterial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 删除小程序卡片素材
    public function deleteMiniCard(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/delguidecardmaterial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 添加图片素材
    public function addImgMaterial(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/setguideimagematerial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 查询图片素材
    public function queryImgMaterial(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/getguideimagematerial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 删除图片素材
    public function deleteImgMaterial(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/delguideimagematerial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 添加文字素材
    public function addTextMaterial(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/setguidewordmaterial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 查询文字素材
    public function queryTextMaterial(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/getguidewordmaterial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 删除文字素材
    public function deleteTextMaterial(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/guide/delguidewordmaterial?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }
}
