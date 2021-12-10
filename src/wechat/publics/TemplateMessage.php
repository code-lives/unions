<?php
namespace unions\wechat\publics;

use unions\library\Curl;use unions\wechat\Publics;

/**
 * 基础消息能力-模版消息
 * https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Template_Message_Interface.html
 */
class TemplateMessage extends Publics
{
    // 设置所属行业
    public function setIndustry(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 获取设置的行业信息
    public function getIndustry(string $accessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=%s', $accessToken);

        return Curl::instance()->get($url)->result($this->responseParse());
    }

    // 获得模板ID[根据短模版ID获取长模版ID]
    public function getTemplateID(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 获取模板列表
    public function templates(string $accessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=%s', $accessToken);

        return Curl::instance()->get($url)->result($this->responseParse());
    }

    // 删除模板[根据长模版ID删除模版]
    public function deleteTemplate(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }

    // 发送模板消息
    public function sendTemplate(string $accessToken, array $data)
    {
        $url = sprintf('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s', $accessToken);

        return Curl::instance()->data(json_encode($data))->post($url)->result($this->responseParse());
    }
}
